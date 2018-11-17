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
	$data['USERNAME'] = $customer->fname .' '. $customer->lname;
	$data['PRODUCT_NAME'] = $product->name . " ({$product->version})";
	$data['PLAN_NAME'] = $plan->name;
	$data['PRICE'] = $total->getTotalPrice();
	$data['INVOICE_ID'] = $invoice->invoice_id;
	$data['TR_TIME'] = substr($transaction->created, 0, strlen($transaction->created)-3);

	$body = EmailTpl::render('purchase_notification', $data);
	
	echo $body;

	return sendEmail($customer->email,
		getConfig('site_name').': Payment Has Successfully Done.', 
		$body);
}

function sendProductToCustomer(Invoice $invoice)
{
	$plan = $invoice->getPlan();
	$product = $plan->getProduct();
	$transaction = $invoice->getTransaction();
	$customer = $transaction->getCustomer();
	$data = [];

/*	$data['invoice'] = $invoice;
	$data['plan'] = $plan;
	$data['file'] = $plan->getFiles()[0]; // get just the first file as an attachment
	$data['product'] = $product;
	$data['transation'] = $transaction;
	$data['customer'] = $customer;*/

	$body = EmailTpl::render('download_product', $data);
	
	return sendEmail($customer->email,
		getConfig('site_name').': [Download] {$product->name}.',
		$body);
}

add_action('after_payment_done_successfully', 'purchaseNotification');
//add_action('after_payment_done_successfully', 'sendProductToCustomer');

/*------ just for test -------*/
$i = Invoice::get(37);
do_action('after_payment_done_successfully', $i);
exit;
?>