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

/*if (!$customer instanceof Customer)
{
	exit;
}*/

// get the invoice to resend licenses to the customer
if ($action == 'resendEmail')
{
	$invoiceID = isset($_GET['invoice'])? intval($_GET['invoice']) : 0;
	$invoice = Invoice::get($invoiceID);

	if ($invoice instanceof Invoice)
	{
		if (function_exists('sendProductToCustomer') && is_callable('sendProductToCustomer'))
		{
			//purchaseNotification($invoice);
			if (sendProductToCustomer($invoice))
			{
				header("HTTP/1.1 200 OK");
				$res['message'] = "The email has been sent successfully.";
			}
			else
			{
				header("HTTP/1.1 500 Server Error");
				$res['message'] = 'Something went wrong!';
			}
		}
	}
	else
	{
		header("HTTP/1.1 404 Not Found");
		$res['error'] = true;
		$res['message'] = "Invoice Not Found.";
	}
}
else if ($action == 'editSetting')
{
	$name = isset($_POST['id'])? _addslashes(strip_tags($_POST['id'])) : '';
	
	if ($name != '')
	{
		$res['data']['name'] = $name;
		$res['data']['value'] = getConfig($name);
	}
	else
	{
		$res['error'] = true;
	}
}
else if ($action == 'saveSetting')
{
	$name = isset($_POST['id'])? trim(_addslashes(strip_tags($_POST['id']))) : '';
	$value = isset($_POST['value'])? trim(_addslashes($_POST['value'])) : '';

	if (setConfig($name, $value))
		$res['saved'] = true;
	else
		$res['error'] = true;
}

header("Content-Type: application/json; charset=UTF-8");
echo json_encode($res);

?>