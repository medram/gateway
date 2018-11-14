<?php
require_once "init.php";

use MR4Web\Utils\View;
use MR4Web\Models\Invoice;

if (!isset($_SESSION['invoiceId']))
{
	//header('location: checkout.php');
	exit;
}

$invoice_id = _addslashes(strip_tags($_SESSION['invoiceId']));
unset($_SESSION['invoiceId']);
//echo $_SESSION['invoiceId'];
$invoice = Invoice::getBy(['invoice_id' => $invoice_id]);

if (!$invoice instanceof Invoice)
	exit; // kill the page.

$plan = $invoice->getPlan();
$product = $plan->getProduct();
$transaction = $invoice->getTransaction();
$customer = $transaction->getCustomer();

$data['invoice'] = $invoice;
$data['plan'] = $plan;
$data['product'] = $product;
$data['transation'] = $transaction;
$data['customer'] = $customer;

$data['title'] = 'Thank you page!';

View::render('header', $data);
View::render('thank_you', $data);
View::render('footer', $data);

?>