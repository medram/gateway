<?php

require_once "../init.php";

use MR4Web\Models\User;
use MR4Web\Models\Invoice;

if (!User::isLogin())
{
	header("location: login.php");
	exit;
}

do_action('before_dashboard_start', User::getUser());

// Just for testing
sendProductToCustomer(Invoice::get(49));

?>