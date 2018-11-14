<?php
require_once "init.php";


use MR4Web\Utils\View;

$data['title'] = 'Payment failed!';

View::render('header', $data);
View::render('failed', $data);
View::render('footer', $data);

?>