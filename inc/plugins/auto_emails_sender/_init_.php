<?php

use MR4Web\Models\Invoice;
use MR4Web\Models\Plan;
use MR4Web\Models\Item;
use MR4Web\Models\Customer;
use MR4Web\Models\PDOModel;
use MR4Web\Models\Transaction;
use MR4Web\Models\Product;

use MR4Web\Utils\EmailTpl;
use MR4Web\Utils\Total;
use MR4Web\Utils\Coupon;
use MR4Web\Utils\View;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "common.php";

// send an invoice email.
function purchaseNotification(Invoice $invoice)
{
	$plan = $invoice->getPlan();
	$product = $plan->getProduct();
	$transaction = $invoice->getTransaction();
	$customer = $invoice->getCustomer();

	$coupon = $invoice->getCoupon();
	$total = new Total();
	$total->setPlan($plan);
	if (is_object($coupon))
	{
		$total->forceApplyCoupon($coupon);
	}
	$total->calculate();

	$title = "Payment Has Been Successfully Done.";
	
	$data['TITLE'] = $title;
	$data['USERNAME'] = $customer->fname .' '. $customer->lname;
	$data['PRODUCT_NAME'] = $product->name . " (".$product->version.")";
	$data['PLAN_NAME'] = $plan->name;
	$data['PRICE'] = $total->getTotalPrice();
	$data['INVOICE_ID'] = $invoice->invoice_id;
	if ($transaction instanceof Transaction)
		$data['TR_TIME'] = substr($transaction->created, 0, strlen($transaction->created)-3);
	else
		$data['TR_TIME'] = $invoice->created;

	$body = EmailTpl::render('purchase_notification', $data);
	
	/*
	// for debug. 
	exit($body);
	*/
	try
	{
		sendEmail($customer->email, $title, $body);
		return true;
	} catch (\Exception $e){
		die($e->getMessage());
	}
	return false;
}

// send an product informations email.
function sendProductToCustomer(Invoice $invoice)
{
	$plan = $invoice->getPlan();
	$product = $plan->getProduct();
	$file = $product->getFiles()[0]; // we just send the first file.
	//$transaction = $invoice->getTransaction();
	$customer = $invoice->getCustomer();

	$title = "[Download] {$product->name} v{$product->version}.";
	$data['TITLE'] = $title;
	$data['USERNAME'] = $customer->fname .' '. $customer->lname;
	$data['PRODUCT_NAME'] = $product->name . " v{$product->version}";
	$data['PLAN_NAME'] = $plan->name;
	$data['DOWNLOAD_LINK'] = $file->getDownloadLink($plan, $customer);
	$data['PRODUCT_EMAIL_SUPPORT'] = $product->email_support;

	$body = EmailTpl::render('download_product', $data);
	
	try {
		//exit($body);
		sendEmail($customer->email, $title, $body);
		return true;
	} catch (\Exception $e){
		//die($e->getMessage());
	}
	return false;
}

// sending product to JVZoo customer
function JVzooIPN($plan)
{
	$req = "";
	foreach ($_POST as $k => $v)
		$req .= $k.': '.$v."\n\r";
	$req .= "-------------------------------------\n";
	logFile($req);

	//JVZIPN_verification(getConfig('JVZoo_IPN_KEY'));

	$data = [];
	$product = $plan->getProduct();
	// check the information
	
	// create new customer
	// create new invoice
	// send an email to the customer
	
	if (!isset($_POST['ctransaction']) || !JVZIPN_verification(getConfig('JVZoo_IPN_KEY')))
	{
		// redirect to somewhere else.
		header('HTTP/1.1 401 Unauthorized');
		//header('location: failed.php');
		exit('
			<h1>Access denied to this page!</h1>
			<div>
				if you think this is just an error, please contact us at: <b>'.$product->email_support.'</b>
			</div>
			');
	}
	else if ($_POST['ctransaction'] == 'SALE')
	{
		PDOModel::getPDO()->beginTransaction();
		try {
			// recieve the information from JVZoo IPN
			$JV_customerName 	= _addslashes(strip_tags($_POST['ccustname']));
			$JV_email 			= _addslashes(strip_tags($_POST['ccustemail']));
			$JV_productTitle 	= _addslashes(strip_tags($_POST['cprodtitle']));
			$JV_transactionID	= _addslashes(strip_tags($_POST['ctransreceipt']));

			/*
			// Just for testing
			$JV_customerName 	= 'Jone smeeth';
			$JV_email 			= 'jone@moakt.ws';
			$JV_productTitle 	= 'ADLinker v1.2 from JVZoo';
			$JV_transactionID	= 'TR-54656546';
			*/

			$customer = Customer::getBy(['email' => $JV_email]);
			$invoice = null;
			$isOurCustomer = true;
			$allReadyPaid = false; // true: just show the product info

			// let's create a new Customer if it's not found.
			if (!$customer instanceof Customer)
			{
				$splitedName = explode(' ', $JV_customerName);
				$customer = new Customer();
				$customer->fname = $splitedName[0];
				$customer->lname = isset($splitedName[1])? $splitedName[1] : "";
				$customer->email = $JV_email;
				$customer->token = hash('sha256', $JV_email.'-'.time());

				if ($customer->save())
					$isOurCustomer = false;
				// refresh the customer information class.
				$customer = Customer::get(Customer::getLastInsertId());
			}

			if ($isOurCustomer)
			{
				$allCustomerInvoices = $customer->getInvoices();
				
				foreach ($allCustomerInvoices as $invoice)
				{
					if ($JV_transactionID == $invoice->transactions_id)
					{
						$allReadyPaid = true;
						break;
					}
				}
			}


			if (!$allReadyPaid)
			{
				// register a new Invoice for our customer
				$invoice = new Invoice();
				$invoice->invoice_id = '#'.time();
				$invoice->customers_id = $customer->id;
				$invoice->plans_id = $plan->id;
				$invoice->transactions_id = $JV_transactionID;
				
				// coupon not used*/
	/*			if ($coupon instanceof Coupon)
					$invoice->coupons_id = $coupon->id;
	*/			
				$invoice->save();
				$invoice = Invoice::get(Invoice::getLastInsertId());

				# create items for this invoice
				$item = new Item();
				$item->title 		= $product->name.' v'.$product->version.' ('.$plan->name.')';
				$item->quantity 	= 1; // the deafult
				$item->price 		= $plan->price;
				$item->invoices_id 	= $invoice->id;

				$item->save();
			}
			else
			{
				$invoice = Invoice::getBy(['transactions_id' => $JV_transactionID]);
			}

			PDOModel::getPDO()->commit();
		
		} catch (\PDOException $e) {
			die($e->getMessage());
			PDOModel::getPDO()->rollBack();
		}

		/*// get some more extra information.
		$data['productName'] = $product->name." v{$product->version}";
		$file = $product->getFiles()[0];
		$data['downloadLink'] = $file->getDownloadLink($plan, $customer);
		$data['product_email_support'] = $product->email_support;

		$data['title'] = 'Download Page';
		$data['product'] = $product;
		$data['customer'] = $customer;
		$data['invoice'] = $invoice;
		$data['plan'] = $plan;

		View::render('header', $data);
		View::render('download_page', $data);
		View::render('footer', $data);*/

		// Send an Email.
		if (!$allReadyPaid)
		{
			do_action('after_payment_done_successfully', $invoice);
		}

		header('HTTP/1.1 200 ok');
		exit('<h1>Done Successfully!</h1>');
	}

	header('HTTP/1.1 400 Bad Raquest');
	//header('location: failed.php');
	exit;
}

function showProductOnDownloadPage(Plan $plan)
{
	if (isset($_GET['cbreceipt'], $_GET['cemail']))
	{
		$trID = _addslashes(strip_tags($_GET['cbreceipt']));
		$email = _addslashes(strip_tags($_GET['cemail']));
		$customer = Customer::getBy(['email' => $email]);
		$invoice = Invoice::getBy(['transactions_id' => $trID]);
		$product = $plan->getProduct();

		if ($customer instanceof Customer && $invoice instanceof Invoice && $product instanceof Product)
		{
			if ($plan->id == $invoice->getPlan()->id)
			{
				// get some more extra information.
				$data['productName'] = $product->name." v{$product->version}";
				$file = $product->getFiles()[0];
				$data['downloadLink'] = $file->getDownloadLink($plan, $customer);
				$data['product_email_support'] = $product->email_support;

				$data['title'] = 'Download Page';
				$data['product'] = $product;
				$data['customer'] = $customer;
				$data['invoice'] = $invoice;
				$data['plan'] = $plan;

				View::render('header', $data);
				//View::render('JVZooIPN_thanksPage', $data);
				View::render('download_page', $data);
				View::render('footer', $data);
				exit;
			}
		}
	}

	// redirect to somewhere else.
	header('HTTP/1.1 401 Unauthorized');
/*	exit('
		<h1>Access denied to this page!</h1>
		<div>
			if you think this is just an error, please contact us at: <b>'.$product->email_support.'</b>
		</div>
		');*/
	$data['title'] = "Access denied to this page!";
	$data['message'] = '
		if you have just purchased this item, Please <b class="text-success">wait from 5 to 15 minutes</b> to activate your access permission to this page to download your item (keep refreshing this page), Or <b class="text-success">check out your email inbox</b> to get the all informations about your item.<br>
		For any issues please contact us at: <b><a href="mailto:'.$product->email_support.'">'.$product->email_support.'</a></b>
	';
	View::render('header', $data);
	View::render('errors', $data);
	View::render('footer', $data);
	exit;
}


// send an invoice email.
//add_action('after_payment_done_successfully', 'purchaseNotification');

// send an product informations email.
add_action('after_payment_done_successfully', 'sendProductToCustomer');

// show products on downloadpage
add_action('jvzoo_ipn_before', 'JVzooIPN');
add_action('downloadPage_before', 'showProductOnDownloadPage');



/*------ just for test -------*/

/*$i = Invoice::get(40);
do_action('after_payment_done_successfully', $i);
exit;
*/

?>