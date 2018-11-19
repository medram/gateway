<?php

require_once "../init.php";

use MR4Web\Models\User;

if (!User::isLogin())
{
	header("location: login.php");
	exit;
}

do_action('before_dashboard_start', User::getUser());

?>