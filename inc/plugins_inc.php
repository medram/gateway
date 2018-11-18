<?php

/*
	Available action for now:
	- before_dashboard_start
	- before_payment
	- after_payment
	- after_payment_done_successfully (Invoice)
	- after_payment_failed
	- before_user_logged_in (email, password)
	- after_user_logged_in (email, password)
	- before_user_logged_out
	- after_user_logged_out
	-

*/

use MR4Web\Models\Invoice;
use MR4Web\Utils\EmailTpl;
use MR4Web\Utils\Total;
use MR4Web\Utils\Coupon;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function purchaseNotification(Invoice $invoice)
{
	/*
		get information.
		send email.
	*/
	$plan = $invoice->getPlan();
	$product = $plan->getProduct();
	$transaction = $invoice->getTransaction();
	$customer = $transaction->getCustomer();

	$coupon = $invoice->getCoupon();
	$total = new Total();
	$total->setPlan($plan);
	if (is_object($coupon))
	{
		$total->forceApplyCoupon($coupon);
	}
	$total->calculate();

/*	$data['invoice'] = $invoice;
	$data['plan'] = $plan;
	$data['product'] = $product;
	$data['transation'] = $transaction;
	$data['customer'] = $customer;
*/

	$title = getConfig('site_name').': Payment Has Successfully Done.';
	
	$data['TITLE'] = $title;
	$data['USERNAME'] = $customer->fname .' '. $customer->lname;
	$data['PRODUCT_NAME'] = $product->name . " ({$product->version})";
	$data['PLAN_NAME'] = $plan->name;
	$data['PRICE'] = $total->getTotalPrice();
	$data['INVOICE_ID'] = $invoice->invoice_id;
	$data['TR_TIME'] = substr($transaction->created, 0, strlen($transaction->created)-3);

	$body = EmailTpl::render('purchase_notification', $data);
	
	/*
	// for debug. 
	exit($body);
	*/

	return sendEmail($customer->email, $title, $body);
}

function sendProductToCustomer(Invoice $invoice, $createLicense = true)
{
	$plan = $invoice->getPlan();
	$product = $plan->getProduct();
	$transaction = $invoice->getTransaction();
	$customer = $transaction->getCustomer();
	$file = $plan->getFiles()[0]; // we just are sending the first file.
	$licenses = []; // licenses classes
	$licenses_codes = [];

	if ($createLicense)
	{
		for ($i = 0; $i < $plan->max_licenses; ++$i)
		{
			$licenses[] = License::createLicense($customer, $plan);
		}
	}
	else
	{
		$licenses = $customer->getLicenses();
	}
	
	for ($licenses as $license)
	{
		$licenses_codes[] = $license->license_code;
	}

	$data['TITLE'] = getConfig('site_name').': [Download] {$product->name}.';
	$data['USERNAME'] = $customer->fname .' '. $customer->lname;
	$data['PRODUCT_NAME'] = $product->name . " ({$product->version})";
	$data['PLAN_NAME'] = $plan->name;
	$data['DOWNLOAD_LINK'] = $file->getDownloadLink($plan, $customer);
	$data['LICENSES'] = implode('<br>', $licenses_codes); //sdf57df54gdf5g65df4g6sdf7g6d5f4gdf

	$body = EmailTpl::render('download_product', $data);
	
	exit($body);


	//return sendEmail($customer->email, $title, $body);
}

//add_action('after_payment_done_successfully', 'purchaseNotification');
add_action('after_payment_done_successfully', 'sendProductToCustomer');

/*------ just for test -------*/
$i = Invoice::get(34);
do_action('after_payment_done_successfully', $i);

?>