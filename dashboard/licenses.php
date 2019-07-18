<?php
require_once "dashboard_init.php";

use MR4Web\Models\License;
use MR4Web\Models\Customer;
use MR4Web\Models\Invoice;
use MR4Web\Models\Plan;

use MR4Web\Utils\View;
use MR4Web\Utils\Dashboard;

$msg = [];

$page = isset($_GET['page'])? $_GET['page'] : '';
$action = isset($_GET['a'])? $_GET['a'] : '';
$customerID = isset($_GET['cu'])? intval($_GET['cu']) : 0;
$productID = isset($_GET['pr'])? intval($_GET['pr']) : 0;


if ($action == 'delete')
{
	if (License::deleteBy(['id' => intval($_GET['l_id'])]))
	{
		header('location: licenses.php');
		exit;
	}
}

// add a new product
if ($page == 'add')
{
	if (isset($_POST['saveLicense']))
	{
		$plan = Plan::get(intval($_POST['plan-id']));

		if ($_POST['max'] == '' || $_POST['customer-id'] == '' || $_POST['plan-id'] == '')
		{
			$msg['err'] = 'Please fill out all fields below!';
		}
		else if (!Customer::get(intval($_POST['customer-id'])) instanceof Customer)
		{
			$msg['err'] = 'Oops! There is no customer with this ID : '.intval($_POST['customer-id']);
		}
		else if (!Plan::get(intval($_POST['plan-id'])) instanceof Plan)
		{
			$msg['err'] = 'Oops! There is no plan with this ID : '.intval($_POST['plan-id']);
		}
		else if (!$plan instanceof Plan)
		{
			$msg['err'] = 'Oops! The plan that you choosed is not valid';
		}
		else
		{
			$max 			= intval($_POST['max']);
			$customer_id	= intval($_POST['customer-id']);

			$license = new License();
			$license->license_code = sha1($plan->id.'-'.$customer_id.'-'.time());
			$license->activation_max = $max;
			$license->banned = 0;
			$license->products_id = $plan->getProduct()->id;
			$license->customers_id = $customer_id;
			$license->plans_id = $plan->id;
			$license->license_type = $plan->plan_type;

			$invoice = new Invoice();
			$invoice->invoice_id = "#".time();
			$invoice->transactions_id = 0;
			$invoice->customers_id = $customer_id;
			$invoice->plans_id = $plan->id;

			if ($license->save() && $invoice->save())
			{
				// redirect to products list
				header("location: licenses.php");
				exit;
			}
			else
				$msg['err'] = 'Something wrong!';
		}
	}

	$data['msg'] = $msg;
	$data['dash_title'] = "Generate License";
	Dashboard::Render('add_license', $data);
}
else if ($page == 'edit')
{
	$license_id = intval($_GET['l_id']);
	$license = License::get($license_id);

	if (isset($_POST['saveLicense']))
	{
		$plan = Plan::get(intval($_POST['plan-id']));

		if (!$license instanceof License)
		{
			// redirect
			header('location: licenses.php');
			exit;
		}
		
		if ($_POST['max'] == '' || $_POST['customer-id'] == '' || $_POST['status'] == '')
		{
			$msg['err'] = 'Please fill out all fields below!';
		}
		else if (!Customer::get(intval($_POST['customer-id'])) instanceof Customer)
		{
			$msg['err'] = 'Oops! There is no customer with this ID : '.intval($_POST['customer-id']);
		}
		else if (!$plan instanceof Plan)
		{
			$msg['err'] = 'Oops! The plan that you choosed is not valid';
		}
		else
		{
			$max 			= intval($_POST['max']);
			$customer_id	= intval($_POST['customer-id']);
			$banned			= (string)intval($_POST['status']);

			$license->activation_max = $max;
			$license->banned = $banned;
			$license->products_id = $product_id;
			$license->customers_id = $customer_id;
			$license->plans_id = $plan->id;
			$license->license_type = $plan->plan_type;

			if ($license->save())
			{
				// redirect
				header('location: licenses.php');
				exit;
			}
			else
				$msg['err'] = 'Something was wrong, please try again!';
		}		
	}

	$data['msg'] = $msg;
	$data['license'] = $license;
	$data['dash_title'] = "Edit License";
	Dashboard::Render('add_license', $data);
}
else
{
	$licenses = [];

	if ($customerID && $productID)
	{
		$licenses = License::getAllBy(['customers_id' => $customerID, 'products_id' => $productID], ['id', 'DESC']);
		if (!count($licenses))
			$msg['err'] = "No licenses for this customer & product!";
	}
	else if ($customerID)
	{
		$licenses = License::getAllBy(['customers_id' => $customerID], ['id', 'DESC']);
		if (!count($licenses))
			$msg['err'] = "No licenses for this customer!";
	}
	else
		$licenses = License::getAll(['id', 'DESC']);

	
	$resultNumber = count($licenses);

	if (is_array($licenses))
		$data['licenses'] = $licenses;
	else
		$data['licenses'] = [];

	$data['msg'] = $msg;
	$data['dash_title'] = "Licenses ({$resultNumber})";
	Dashboard::Render('licenses', $data);
}

?>
