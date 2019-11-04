<?php

require_once "../init.php";

use MR4Web\Models\User;
use MR4Web\Models\Customer;

if (!Customer::isLogin())
{
	header('location: login.php');
	exit();
}

$customer = Customer::currentCustomer();

if ($customer->isBanned())
{
	$customer->logout();
	header('location: login.php');
	exit();	
}

//do_action('before_customer_area_start', User::getUser());

// Just for testing
//sendProductToCustomer(Invoice::get(49));

?>