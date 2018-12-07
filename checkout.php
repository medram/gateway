<?php

include_once "init.php";

use MR4Web\Models\Plan;
use MR4Web\Models\Coupon;
use MR4Web\Models\Payment_method;
use MR4Web\Models\PDOModel;
use MR4Web\Models\Customer;

use MR4Web\Utils\View;
use MR4Web\Utils\Total;

use MR4Web\Pattern\PaypalGateway;
use MR4Web\Pattern\ProductGateway;


if (!isset($_GET['pl']) && !isset($_GET['pr']))
{
	// redirect to the home page or die
	exit;
}
else if (isset($_GET['redeem']) && $_GET['redeem'] == 1)
{
	unset($_SESSION['coupon']);
	$url = str_replace('&redeem=1', '', $_SERVER['REQUEST_URI']);
	header("location: ".$url);
}

$plan_id = intval($_GET['pl']);
$couponCode = '';
$msg = [];

if (isset($_POST['coupon-code']))
{
	$couponCode = _addslashes(trim($_POST['coupon-code']));
}
else if (isset($_SESSION['coupon']))
{
	$couponCode = _addslashes(filter_var($_SESSION['coupon'], FILTER_SANITIZE_STRING));
}

$plan = Plan::get($plan_id);
$paymentMethods = Payment_method::getAll();
$coupon = Coupon::getBy(['code' => $couponCode, 'expired' => 0]);

/*echo '<pre>';
var_dump($coupon);
echo '</pre>';*/
if (!$plan instanceof Plan || $plan->status == 0)
{
	header('HTTP/1.1 404 Not Found');
	
	$data['title'] = 'Not Found';
	View::render('header', $data);
	View::render('errors', $data);
	View::render('footer', $data);
	exit();
}

$total = new Total();
$total->setPlan($plan);

// append the coupon to the calcualtion
if ($coupon instanceof Coupon && $total->setCoupon($coupon))
	$_SESSION['coupon'] = $couponCode;
else if (!empty($couponCode))
	$msg['coupon']['err'] = "Oops, Maybe This Coupon code has been expired or is invalid for this product/offer.";


$total->calculate();

// --------------------- send a request ---------------------

if (isset($_POST['submit']) && $_POST['submit'] == 'pay')
{
	$input = filter_var_array($_POST, FILTER_SANITIZE_STRING);
/*	echo "<pre>";
	var_dump($input);
	echo "</pre>";*/
	$firstName = _addslashes($input['firstName']);
	$lastName = _addslashes($input['lastName']);
	$email = strtolower($input['email']);
	$gender = (intval($input['gender']) == 1) ? 'M' : 'F' ;
	$paymentMethod = intval($input['paymentMethod']);
	
	if (empty($firstName) || empty($lastName) || empty($email) || empty($gender) || empty($paymentMethod))
	{
		$msg['validation']['err'] = 'Please fill the all fields below.';
	}
	else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		$msg['validation']['err'] = 'Please put a valid email.';
	}
	else
	{
		/*
			- save a new customer.
			- save new transaction.
			- expire the coupon if exists.
			- send email to the customer with license & Download link.
		*/
		$oldCustomer = Customer::getBy(['email' => $email]);
		$customer = ($oldCustomer instanceof Customer)? $oldCustomer : new Customer();
		$customer->fname = $firstName;
		$customer->lname = $lastName;
		$customer->gender = $gender;

		if (!$oldCustomer instanceof Customer)
		{
			$customer->token = hash('sha256', $email.'-'.time());
			$customer->email = $email;
		}
		
		$customer->save();
		
		if ($oldCustomer instanceof Customer) // define the customer id.
			$customerID = $oldCustomer->id; 
		else
			$customerID = $customer::getLastInsertId();		

		if ($paymentMethod == 1) // paypal
		{
			//$invoiceId = '#'.$plan->id.'-'.$customerID.'-'.time();
			$invoiceId = '#'.time();

			$productGateway = new ProductGateway();
			$productGateway->setName($total->getPlan()->getProduct()->name .' - '.$total->getPlan()->name);
			$productGateway->setPrice($total->getTotalPrice());
			$productGateway->setInvoiceId($invoiceId);

			$_SESSION['invoiceId'] = $invoiceId;

			$gateway = new PaypalGateway();
			$gateway->setProduct($productGateway);
			$redirectTo = BASE_URL.'pay.php?success=true&pl='.$plan->id.'&cu='.$customerID.'&pm='.$paymentMethod;

			if ($coupon instanceof Coupon)
				$redirectTo .= '&co='.base64_encode($coupon->code);
			
			//exit($redirectTo);
			$gateway->setReturnUrl($redirectTo);
			// pay.php?success=false
			$gateway->setCancelUrl(BASE_URL.'checkout.php?pl='.$plan->id);
			$gateway->createPayment();
		}
	}
}
// --------------------- / send a request -------------------

$data['plan'] = $plan;
$data['product'] = $plan->getProduct();
$data['total'] = $total;
$data['msg'] = $msg;
$data['paymentMethods'] = $paymentMethods;

$data['title'] = 'Checkout';
View::render('header', $data);
View::render('checkout', $data);
View::render('footer', $data);

?>
