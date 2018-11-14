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

	$data['invoice'] = $invoice;
	$data['plan'] = $plan;
	$data['product'] = $product;
	$data['transation'] = $transaction;
	$data['customer'] = $customer;

	$body = EmailTpl::render('purchase_notification', $data);
	
	return sendEmail($customer->email,
		getConfig('site_name').': Payment Has Been Successfully Done.', 
		$body);
}

add_action('after_payment_done_successfully', 'purchaseNotification');

?>