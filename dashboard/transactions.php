<?php
require_once "dashboard_init.php";

use MR4Web\Models\Transaction;

use MR4Web\Utils\View;
use MR4Web\Utils\Dashboard;

$transactions = Transaction::getAll(['id', 'DESC']);
$tr_result = count($transactions);

if (is_array($transactions))
	$data['transactions'] = $transactions;
else
	$data['transactions'] = [];

$data['dash_title'] = "Transactions <small>({$tr_result})</small>";
Dashboard::Render('transactions', $data);

?>
