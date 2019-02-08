<?php
require_once "dashboard_init.php";

use MR4Web\Utils\View;
use MR4Web\Utils\Dashboard;
use MR4Web\Models\Setting;

$settings = Setting::getAll();

/*echo '<pre>';
var_dump($settings);
echo '</pre>';*/
$data['settings'] = $settings;
$data['dash_title'] = "Settings";
Dashboard::Render('settings', $data);

?>
