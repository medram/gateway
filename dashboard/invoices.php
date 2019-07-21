<?php
require_once "dashboard_init.php";

use MR4Web\Models\Customer;
use MR4Web\Models\Invoice;

use MR4Web\Utils\View;
use MR4Web\Utils\Dashboard;

$msg = [];
$customerID = isset($_GET['cu'])? intval($_GET['cu']) : 0;
$customer = Customer::get($customerID);
$resultNumber = 0;

if (!$customer instanceof Customer)
{
	$msg['err'] = "Oops, This customer not found!";
}
else
{
	$data['customer'] = $customer;
	$invoices = Invoice::getAllBy(['customers_id' => $customer->id], ['id', 'DESC']);
	$resultNumber = count($invoices);

	if (is_array($invoices))
		$data['invoices'] = $invoices;
	else
		$data['invoices'] = [];
}

$data['msg'] = $msg;
$data['dash_title'] = "Invoices ({$resultNumber})";
Dashboard::Render('invoices', $data);

?>