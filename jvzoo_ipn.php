<?php
require_once "init.php";

use MR4Web\Models\Plan;
use MR4Web\Utils\View;

$pl = isset($_GET['pl'])? intval($_GET['pl']): 0;
$plan = Plan::get($pl);

if (!$plan instanceof Plan)
{
	header('HTTP/1.1 404 Not Found');
	
	$data['title'] = 'Product Not Found!';
	$data['message'] = 'This product not found or not available for now!<br>Please check later or contact us.';
	View::render('header', $data);
	View::render('errors', $data);
	View::render('footer', $data);
	exit;
}

// hooks for download page
do_action('jvzoo_ipn_before', $plan);

do_action('jvzoo_ipn_after', $plan);

?>