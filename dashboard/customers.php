<?php
require_once "dashboard_init.php";

use MR4Web\Models\Customer;
use MR4Web\Utils\View;
use MR4Web\Utils\Dashboard;

$page = isset($_GET['page']) ? $_GET['page'] : '';
$customerID = isset($_GET['cu'])? intval($_GET['cu']) : 0;
$msg = "";

// get the customer if it's available
$customer = Customer::get($customerID);

// add a new product
if ($page == 'add')
{
	if (isset($_POST['saveCustomer']))
	{
		$fname = _addslashes(strip_tags($_POST['fname']));
		$lname = _addslashes(strip_tags($_POST['lname']));
		$email = _addslashes(strip_tags($_POST['customer-email']));
		$gender = _addslashes(strip_tags($_POST['gender']));

		$customer = new Customer();
		$customer->fname = $fname;
		$customer->lname = $lname;
		$customer->email = $email;
		$customer->gender = $gender;
		$customer->token = hash('sha256', $email.'-'.time());

		try {

			if ($customer->save())
			{
				header("location: customers.php");
				exit;
			}
			else
				$msg['err'] = "Something went wrong!";
		} catch (\PDOException $e) {
			die($e->getMessage());
		}

	}

	$data['msg'] = $msg;
	$data['dash_title'] = "Add New Customer";
	Dashboard::Render('add_customer', $data);
}
else if ($page == 'edit' && $customerID != 0)
{
	if ($customer instanceof Customer)
	{
		$data['customer'] = $customer;
	}

	if (isset($_POST['saveCustomer']))
	{
		$fname = _addslashes(strip_tags($_POST['fname']));
		$lname = _addslashes(strip_tags($_POST['lname']));
		$email = _addslashes(strip_tags($_POST['customer-email']));
		$gender = _addslashes(strip_tags($_POST['gender']));

		$customer->fname = $fname;
		$customer->lname = $lname;
		$customer->email = $email;
		$customer->gender = $gender;

		if ($customer->save())
		{
			header("location: customers.php");
			exit;
		}
		else
			$msg['err'] = "Something went wrong!";
	}

	$data['msg'] = $msg;
	$data['dash_title'] = "Edit Customer ($customerID)";
	Dashboard::Render('add_customer', $data);
}
else
{
	$customers = Customer::getAll(['id', 'DESC']);
	$resultNumber = count($customers);

	if (is_array($customers))
		$data['customers'] = $customers;
	else
		$data['customers'] = [];

	$data['dash_title'] = "Customers ({$resultNumber})";
	Dashboard::Render('customers', $data);
}

?>
