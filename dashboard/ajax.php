<?php
require_once "dashboard_init.php";

use MR4Web\Models\Invoice;
use MR4Web\Models\Customer;
use MR4Web\Models\Product;

// response
$res = [
	'error' 	=> false,
	'message'	=> ''
];

// Allow just the XMLHttpRequest 
if (!isAjaxRequest())
{
	header("HTTP/1.1 403 Forbiden");
	exit;
}

$action 	= isset($_GET['a'])? $_GET['a'] : '';
$customerID = isset($_GET['cu'])? intval($_GET['cu']) : 0;
$customer 	= Customer::get($customerID);

if (!$customer instanceof Customer)
{
	exit;
}

// get the invoice to resend licenses to the customer
if ($action == 'resendEmail')
{
	$invoiceID = isset($_GET['invoice'])? intval($_GET['invoice']) : 0;
	$invoice = Invoice::get($invoiceID);

	if ($invoice instanceof Invoice)
	{
		if (function_exists('sendProductToCustomer') && is_callable('sendProductToCustomer'))
		{
			purchaseNotification($invoice);
			sendProductToCustomer($invoice);
			
			header("HTTP/1.1 200 OK");
			$res['message'] = "The email has been sent successfully.";
		}
	}
	else
	{
		header("HTTP/1.1 404 Not Found");
		$res['error'] = true;
		$res['message'] = "Invoice Not Found.";
	}
}

header("Content-Type: application/json; charset=UTF-8");
echo json_encode($res);

?>