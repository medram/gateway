<?php
require_once "dashboard_init.php";

use MR4Web\Models\Invoice;
use MR4Web\Models\Customer;
use MR4Web\Models\Product;

$action 	= isset($_GET['a'])? $_GET['a'] : '';
$customerID = isset($_GET['cu'])? intval($_GET['cu']) : 0;

$customer 	= Customer::get($customerID);

if (!$customer instanceof Customer)
{
	exit;
}

// get the invoice to resend licenses to the customer
if ($action == 'sendEmail')
{
	$productID = isset($_GET['pr'])? intval($_GET['pr']) : 0;
	$product = Product::get($productID);

	if ($product instanceof Product)
	{
		$plan = $product->getPlan();
		$transactions = $customer->getTransactions();
		$neededInvoice;

		// Look for specific transaction.
		foreach ($transactions as $tr)
		{
			$invoice = $tr->getIncoice();
			if ($invoice->getPlan()->id == $plan->id)
				$neededInvoice = $invoice;
		}

		if ($neededInvoice instanceof Invoice && function_exists('sendProductToCustomer') && is_callable('sendProductToCustomer'))
		{
			sendProductToCustomer($neededInvoice);
		}
	}
}

?>