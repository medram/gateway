<?php
require_once "init.php";


use MR4Web\Utils\View;

$data = [];

View::render('header', $data);
View::render('thank_you', $data);
View::render('footer', $data);

?>