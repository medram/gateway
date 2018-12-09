<?php

require_once "dashboard_init.php";

use MR4Web\Utils\Dashboard;

$data['dash_title'] = 'Users & Roles';

Dashboard::Render('users', $data);

?>