<?php

/*
	Available action for now:
	- before_dashboard_start
	- before_payment
	- after_payment
	- after_payment_done_successfully (Invoice)
	- after_payment_failed
	- before_user_logged_in (email, password)
	- after_user_logged_in (User class)
	- before_user_logged_out
	- after_user_logged_out
	-
*/

use MR4Web\Models\Invoice;
use MR4Web\Models\License;

use MR4Web\Utils\EmailTpl;
use MR4Web\Utils\Total;
use MR4Web\Utils\Coupon;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// send an invoice email.
function purchaseNotification(Invoice $invoice)
{
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

	$title = getConfig('site_name').": Payment Has Been Successfully Done.";
	
	$data['TITLE'] = $title;
	$data['USERNAME'] = $customer->fname .' '. $customer->lname;
	$data['PRODUCT_NAME'] = $product->name . " (".$product->version.")";
	$data['PLAN_NAME'] = $plan->name;
	$data['PRICE'] = $total->getTotalPrice();
	$data['INVOICE_ID'] = $invoice->invoice_id;
	$data['TR_TIME'] = substr($transaction->created, 0, strlen($transaction->created)-3);

	$body = EmailTpl::render('purchase_notification', $data);
	
	/*
	// for debug. 
	exit($body);
	*/

	sendEmail($customer->email, $title, $body);
}

// send an product informations email.
function sendProductToCustomer(Invoice $invoice)
{
	$plan = $invoice->getPlan();
	$product = $plan->getProduct();
	$file = $product->getFiles()[0]; // we just send the first file.
	$transaction = $invoice->getTransaction();
	$customer = $transaction->getCustomer();
	$licenses = []; // licenses classes
	$licenses_codes = [];

	// create new licenses for the first time.
	// get the licenses if it's found.
	$licenses = $customer->getLicenses();

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
	
	//exit($body);

	sendEmail($customer->email, $title, $body);
}


// send an invoice email.
add_action('after_payment_done_successfully', 'purchaseNotification');

// send an product informations email.
add_action('after_payment_done_successfully', 'sendProductToCustomer');

/*------ just for test -------*/

/*$i = Invoice::get(40);
do_action('after_payment_done_successfully', $i);
exit;
*/


?>