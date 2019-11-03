<?php
require_once "customer_init.php";

use MR4Web\Models\Customer;
use MR4Web\Models\Invoice;
use MR4Web\Utils\View;
use MR4Web\Utils\CustomerArea;

$customer = Customer::currentCustomer();

$data['dash_title'] = "<i class='fa fa-cubes'></i> My Products";
$data['customer'] = $customer;
$data['invoices'] = $customer->getInvoices();
$data['plans'] = [];

if (count($data['invoices']) && $data['invoices'][0] instanceof invoice)
{
	foreach ($data['invoices'] as $invoice)
	{
		$data['plans'][] = $invoice->getPlan();
	}
}

CustomerArea::Render('index', $data);

?>
