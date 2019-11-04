<?php
@error_reporting(0);

require_once "init.php";

use MR4Web\Models\Customer;
use MR4Web\Models\Plan;
use MR4Web\Models\file;

$planID = isset($_GET['pl'])? intval($_GET['pl']) : 0;
$customerToken = isset($_GET['t'])? $_GET['t'] : 0;
$product = '';

$plan = Plan::get($planID);
$customer = Customer::getBy(['token' => $customerToken]);

if (!$plan instanceof Plan || !$customer instanceof Customer)
{
	header($_SERVER['SERVER_PROTOCOL']." 400 Bad Request");
	exit;
}

$product = $plan->getProduct();
$files = $product->getFiles();

// just send the first file to the customer
$file = count($files)? $files[0] : NULL;

// check if the file has been found
if (!$file instanceof File || !file_exists($file->path))
{
	header($_SERVER['SERVER_PROTOCOL']." 404 Not Found");
	exit;
}

// start streaming a file (product) to a client.
streamFile($file->path);

?>