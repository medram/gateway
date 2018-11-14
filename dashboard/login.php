<?php

require_once "../init.php";

use MR4Web\Utils\View;
use MR4Web\Models\User;

$msg = [];

if (isset($_GET['action']) && $_GET['action'] == 'logout')
{
	User::logout();
	header('location: login.php');
	exit();
}
else if (User::isLogin())
{
	// redirect to dashboard
	header('location: ./index.php');
	exit();
}

if (isset($_POST['email'], $_POST['password']))
{
	$email = _addslashes(strip_tags($_POST['email']));
	$password = _addslashes(strip_tags($_POST['password']));

	if (User::login($email, $password))
	{
		// redirect to dashboard
		header('location: ./index.php');
		exit();
	}
	else
		$msg['err'] = 'Oops! Email Address or Password is not correct!';
}

$data['msg'] = $msg;
view::render('dashboard/login', $data);

?>