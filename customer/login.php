<?php

require_once "../init.php";

use MR4Web\Utils\View;
use MR4Web\Models\Customer;

$msg = [];

if (isset($_GET['action']) && $_GET['action'] == 'logout')
{
	Customer::logout();
	header('location: login.php');
	exit();
}
else if (Customer::isLogin())
{
	// redirect to Customer dashboard
	header('location: index.php');
	exit();
}

$step = isset($_GET['step'])? intval($_GET['step']) : 0;

if (($step == 1 or $step == 2) and !isset($_SESSION['login_email']))
{
	# redirect to set an email.
	header('location: login.php');
}

if ($step != 1 and $step != 2)
{
	unset($_SESSION['login_email']);
}


if (isset($_POST['submitEmail']))
{
	$email = _addslashes(strip_tags($_POST['email']));

	if (!filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		$msg['err'] = "Oops! Invalid Email.";
	}
	else
	{
		$_SESSION['login_email'] = $email;

		$customer = Customer::getBy(['email' => $email]);

		if ($customer instanceof Customer)
		{
			if ($customer->password)
			{
				# redirect to set current password
				header('location: ?step=2');
				exit();
			}
			else
			{
				# redirect to set new password
				header('location: ?step=1');
				exit();
			}
		}
		else
		{
			$msg['err'] = 'Oops!, There is no customer with this email!';
		}
	}

	// save Email on a session
	// check for old password
	//  - ask for new pasword -> redirect to step 1
	//  - ask for old password -> redirect to step 2



}
else if (isset($_POST['submitPassword']))
{
	$email 		= _addslashes(strip_tags($_SESSION['login_email']));
	$password 	= _addslashes(strip_tags($_POST['password']));

	if (Customer::login($email, $password))
	{
		$customer = Customer::getBy(['email' => $email]);
		
		if (!$customer->isBanned())
		{
			// redirect to dashboard
			header('location: index.php');
			exit();
		}
		else
		{
			$msg['err'] = 'Oops! This Account has been deactivated!';
		}
	}
	else
		$msg['err'] = 'Oops! Email Address or Password is not correct!';
}
else if (isset($_POST['submitNewPassword']))
{
	$email 			= _addslashes(strip_tags($_SESSION['login_email']));
	$password 		= _addslashes(strip_tags($_POST['password']));
	$confPassword 	= _addslashes(strip_tags($_POST['confirm-password']));

	$customer = Customer::getBy(['email' => $email]);

	if ($customer instanceof Customer)
	{
		if ($password != $confPassword)
		{
			$msg['err'] = 'Oops! The Passwords doesn\'t matched.';
		}
		else 
		{
			# saving new password.
			$customer->saveNewPassword($password);
			if (Customer::login($email, $password))
			{
				header('location: index.php');
				exit();
			}
		}
	}
	else
	{
		header('location: login.php');
		exit();
	}
}

$data['msg'] = $msg;
$data['dash_title'] = "Customer's Area";
view::render('customer/tpls/head', $data);
view::render('customer/login', $data);
view::render('customer/tpls/footer', $data);

?>