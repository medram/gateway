<?php
require_once "dashboard_init.php";

use MR4Web\Models\Payer;

use MR4Web\Utils\View;
use MR4Web\Utils\Dashboard;

$payers = Payer::getAll(['id', 'DESC']);
$resultNumber = count($payers);

if (is_array($payers))
	$data['payers'] = $payers;
else
	$data['payers'] = [];

$data['dash_title'] = "Payers <small>({$resultNumber})</small>";
Dashboard::Render('payers', $data);

?>
