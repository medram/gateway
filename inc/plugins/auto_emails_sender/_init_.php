<?php

use MR4Web\Models\Invoice;
use MR4Web\Models\License;
use MR4Web\Models\Plan;
use MR4Web\Models\Customer;
use MR4Web\Models\PDOModel;

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

	$title = getConfig('site_name').": Payment Has Been Successfully Done.";
	
	$data['TITLE'] = $title;
	$data['USERNAME'] = $customer->fname .' '. $customer->lname;
	$data['PRODUCT_NAME'] = $product->name . " (".$product->version.")";
	$data['PLAN_NAME'] = $plan->name;
	$data['PRICE'] = $total->getTotalPrice();
	$data['INVOICE_ID'] = $invoice->invoice_id;
	if ($transaction instanceof Transaction)
		$data['TR_TIME'] = substr($transaction->created, 0, strlen($transaction->created)-3);

	$body = EmailTpl::render('purchase_notification', $data);
	
	/*
	// for debug. 
	exit($body);
	*/
	try
	{
		sendEmail($customer->email, $title, $body);
	} catch (PDOException $e){
		die($e->getMessage());
	}
}

// send an product informations email.
function sendProductToCustomer(Invoice $invoice)
{
	$plan = $invoice->getPlan();
	$product = $plan->getProduct();
	$file = $product->getFiles()[0]; // we just send the first file.
	//$transaction = $invoice->getTransaction();
	$customer = $invoice->getCustomer();
	$licenses = []; // licenses classes
	$licenses_codes = [];

	// get the licenses if it's found.
	$licenses = $plan->getLicenses($customer);

	// create new licenses for the first time & DON'T RECREATE LICENSES AGAIN.
	if (!count($licenses))
	{
		for ($i = 0; $i < $plan->max_licenses; ++$i)
		{
			$licenses[] = License::createLicense($customer, $plan);
		}
	}
	
	// collect licenses code in one array
	if (count($licenses))
	{
		foreach ($licenses as $license)
		{
			$licenses_codes[] = $license->license_code;
		}
	}

	$title = getConfig('site_name').": [Download] {$product->name} v{$product->version}.";
	$data['TITLE'] = $title;
	$data['USERNAME'] = $customer->fname .' '. $customer->lname;
	$data['PRODUCT_NAME'] = $product->name . " v{$product->version}";
	$data['PLAN_NAME'] = $plan->name;
	$data['DOWNLOAD_LINK'] = $file->getDownloadLink($plan, $customer);
	$data['LICENSES'] = implode('<br><br>', $licenses_codes); //sdf57df54gdf5g65df4g6sdf7g6d5f4gdf
	$data['PRODUCT_EMAIL_SUPPORT'] = $product->email_support;

	$body = EmailTpl::render('download_product', $data);
	
	try {
		//exit($body);
		sendEmail($customer->email, $title, $body);
	} catch (PDOException $e){
		die($e->getMessage());
	}
}

// sending product to JVZoo customer
function showProductOnDownloadPage($plan)
{
	$data = [];
	$product = $plan->getProduct();
	// check the information
	
	// create new customer
	// generate new licenses
	// create new invoice
	// send an email to the customer
	
	if (!isset($_POST['ctransaction']) || !JVZIPN_verification(getConfig('JVZoo_IPN_KEY')))
	{
		// redirect to somewhere else.
		header('HTTP/1.1 403 forbidden');
		//header('location: failed.php');
		exit;
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
			Just for testing
			$JV_customerName 	= 'Jone smeeth';
			$JV_email 			= 'jone@moakt.ws';
			$JV_productTitle 	= 'ADLinker v1.2 from JVZoo';
			$JV_transactionID	= 'TR-54656546';
			*/

			$customer = Customer::getBy(['email' => $JV_email]);
			$licenses = [];
			$licenses_codes = [];
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
				// create new licenses for the first time & DON'T RECREATE LICENSES AGAIN.
				for ($i = 0; $i < $plan->max_licenses; ++$i)
				{
					$licenses[] = License::createLicense($customer, $plan, $invoice);
				}
			}
			else
			{
				$invoice = Invoice::getBy(['transactions_id' => $JV_transactionID]);
			}

			// We could register a new transaction here.
			$licenses = $invoice->getLicenses();

			// collect licenses code in one array
			if (count($licenses))
			{
				foreach ($licenses as $license)
				{
					$licenses_codes[] = $license->license_code;
				}
			}

			PDOModel::getPDO()->commit();
		
		} catch (\PDOException $e) {
			die($e->getMessage());
			PDOModel::getPDO()->rollBack();
		}

		// get some more extra information.
		$data['productName'] = $product->name." v{$product->version}";
		$file = $product->getFiles()[0];
		$data['downloadLink'] = $file->getDownloadLink($plan, $customer);
		$data['licenses'] = implode('<br><br>', $licenses_codes);
		$data['product_email_support'] = $product->email_support;

		$data['title'] = 'Download Page';
		$data['product'] = $product;
		$data['customer'] = $customer;
		$data['invoice'] = $invoice;
		$data['plan'] = $plan;

		View::render('header', $data);
		View::render('download_page', $data);
		View::render('footer', $data);

		// should be the last to don't inturapt the script
		if (!$allReadyPaid)
		{
			//do_action('after_payment_done_successfully', $invoice);
		}
	}
	else
	{
		header('HTTP/1.1 403 forbidden');
		//header('location: failed.php');
		exit;
	}
}


// send an invoice email.
add_action('after_payment_done_successfully', 'purchaseNotification');

// send an product informations email.
add_action('after_payment_done_successfully', 'sendProductToCustomer');

// show products on downloadpage
add_action('downloadPage_before', 'showProductOnDownloadPage');


/*------ just for test -------*/

/*$i = Invoice::get(40);
do_action('after_payment_done_successfully', $i);
exit;
*/

?>