<?php
require_once "dashboard_init.php";

use MR4Web\Models\Plan;
use MR4Web\Models\Product;

use MR4Web\Utils\View;
use MR4Web\Utils\Dashboard;

$msg = [];

$page = isset($_GET['page'])? $_GET['page'] : '';
$action = isset($_GET['a'])? $_GET['a'] : '';
$p_id = isset($_GET['p_id'])? intval($_GET['p_id']) : 0;
$plan_id = isset($_GET['plan_id'])? intval($_GET['plan_id']) : 0;

$product = Product::get($p_id);

if ($p_id == 0 or !$product instanceof Product)
{
	header('location: products.php');
	exit;	
}

$data['p_id'] = $p_id;

if ($action == 'delete')
{
	if (Plan::deletePlan(intval($plan_id)))
	{
		header('location: plans.php?p_id='.$p_id);
		exit;
	}
}

// add a new product
if ($page == 'add')
{
	if (isset($_POST['savePlan']))
	{
		if ($_POST['name'] == '' || $_POST['desc'] == '' || $_POST['price'] == '' || $_POST['old-price'] == '' || $_POST['payment-type'] == '')
		{
			$msg['err'] = 'Please fill out all fields below!';
		}
		else if (!array_key_exists($_POST['payment-type'], Plan::getPaymentsType()))
		{
			$msg['err'] = 'Oops! The payment type is invalid!';
		}
		else
		{
			$name 			= _addslashes(strip_tags($_POST['name']));
			$desc 			= _addslashes(strip_tags($_POST['desc']));
			$price 			= intval($_POST['price']);
			$oldPrice 		= intval($_POST['old-price']);
			$paymentType	= _addslashes(strip_tags($_POST['payment-type']));

			$plan = new Plan();
			$plan->products_id = $p_id;
			$plan->name = $name;
			$plan->desc = $desc;
			$plan->price = $price;
			$plan->old_price = $oldPrice;
			$plan->payment_type = $paymentType;
			if ($plan->save())
			{
				// redirect to plans list
				header("location: plans.php?p_id=$p_id");
				exit;
			}
			else
				$msg['err'] = 'Something wrong!';
		}
	}

	$data['msg'] = $msg;
	$data['dash_title'] = "Add Plan";
	Dashboard::Render('add_plan', $data);
}
else if ($page == 'edit')
{

	$plan = plan::get($plan_id);

	if (!$plan instanceof plan)
	{
		// redirect
		header('location: plans.php?p_id='.$p_id);
		exit;
	}

	if (isset($_POST['savePlan']))
	{
		if ($_POST['name'] == '' || $_POST['desc'] == '' || $_POST['price'] == '' || $_POST['old-price'] == '' || $_POST['payment-type'] == '')
		{
			$msg['err'] = 'Please fill out all fields below!';
		}
		else if (!array_key_exists($_POST['payment-type'], Plan::getPaymentsType()))
		{
			$msg['err'] = 'Oops! The payment type is invalid!';
		}
		else
		{
			$name 			= _addslashes(strip_tags($_POST['name']));
			$desc 			= _addslashes(strip_tags($_POST['desc']));
			$price 			= intval($_POST['price']);
			$oldPrice 		= intval($_POST['old-price']);
			$paymentType	= _addslashes(strip_tags($_POST['payment-type']));

			$plan = Plan::get($plan_id);
			$plan->products_id = $p_id;
			$plan->name = $name;
			$plan->desc = $desc;
			$plan->price = $price;
			$plan->old_price = $oldPrice;
			$plan->payment_type = $paymentType;
			
			if ($plan->save())
			{
				// redirect
				header('location: plans.php?p_id='.$p_id);
				exit;
			}
			else
				$msg['err'] = 'Something was wrong, please try again!';
		}
		
	}

	$data['msg'] = $msg;
	$data['plan'] = $plan;
	$data['dash_title'] = "Edit Plan for Product ($p_id)";
	Dashboard::Render('add_plan', $data);
}
else
{
	$plans = Plan::getAllBy(['products_id' => $p_id]);
	$resultNumber = count($plans);

	if (is_array($plans))
		$data['plans'] = $plans;
	else
		$data['plans'] = [];

	$data['dash_title'] = "Plans ({$resultNumber})";
	Dashboard::Render('plans', $data);
}

?>
