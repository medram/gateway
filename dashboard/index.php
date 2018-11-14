<?php
require_once "dashboard_init.php";

use MR4Web\Utils\View;
use MR4Web\Utils\Dashboard;

$data['dash_title'] = 'Dashboard';
Dashboard::Render('index', $data);

?>