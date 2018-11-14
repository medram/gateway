<?php
require_once "dashboard_init.php";

use MR4Web\Models\Customer;

use MR4Web\Utils\View;
use MR4Web\Utils\Dashboard;

$customers = Customer::getAll(['id', 'DESC']);
$resultNumber = count($customers);

if (is_array($customers))
	$data['customers'] = $customers;
else
	$data['customers'] = [];

$data['dash_title'] = "Customers <small>({$resultNumber})</small>";
Dashboard::Render('customers', $data);

?>
