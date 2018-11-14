<?php
require_once "dashboard_init.php";

use MR4Web\Models\Coupon;
use MR4Web\Models\Plans_Coupon;

use MR4Web\Utils\View;
use MR4Web\Utils\Dashboard;

$msg = [];

$page = isset($_GET['page'])? $_GET['page'] : '';
$action = isset($_GET['a'])? $_GET['a'] : '';

if ($action == 'delete')
{
	if (Coupon::deleteCoupon(intval($_GET['coupon_id'])))
	{
		header('location: coupons.php');
		exit;
	}
}

// add a new product
if ($page == 'add')
{
	if (isset($_POST['saveCoupon']))
	{
		$c = Coupon::getBy(['code' => _addslashes(strip_tags($_POST['code']))]);

		if ($_POST['code'] == '' || $_POST['value'] == '' || $_POST['type'] == '' || $_POST['total-usage'] == '' || $_POST['plans'] == '')
		{
			$msg['err'] = 'Please fill out all fields below!';
		}
		else if ($c instanceof Coupon)
		{
			$msg['err'] = 'Oops, This Coupon is already used before!';
		}
		else
		{
			$code 		= _addslashes(strip_tags($_POST['code']));
			$value 		= _addslashes(strip_tags($_POST['value']));
			$type 		= $_POST['type'] == '%'? '%' : '$' ;
			$totalUsage = intval($_POST['total-usage']);
			$plans 		= is_array($_POST['plans'])? $_POST['plans'] : [];

			$coupon = new Coupon();
			$coupon->code = $code;
			$coupon->value = $value;
			$coupon->type = $type;
			$coupon->total_valid_time = $totalUsage;
			$coupon->valid_time = 0;
			$coupon->status = 1;
			$coupon->expired = 0;

			if ($coupon->save())
			{
				$coupon_id = Coupon::getLastInsertId();
				foreach ($plans as $plan_id)
				{
					$PC = new Plans_Coupon();
					$PC->plans_id = $plan_id;
					$PC->coupons_id = $coupon_id;
					$PC->save();
				}
				// redirect to products list
				header("location: coupons.php");
				exit;
			}
			else
				$msg['err'] = 'Something wrong!';
		}
	}

	$data['msg'] = $msg;
	$data['dash_title'] = "Add Coupon";
	Dashboard::Render('add_coupon', $data);
}
else if ($page == 'edit')
{
	$coupon_id = intval($_GET['coupon_id']);
	$coupon = Coupon::get($coupon_id);

	if (isset($_POST['saveCoupon']))
	{
		$code 		= _addslashes(strip_tags($_POST['code']));
		$value 		= _addslashes(strip_tags($_POST['value']));
		$type 		= $_POST['type'] == '%'? '%' : '$' ;
		$totalUsage = intval($_POST['total-usage']);
		$plans 		= is_array($_POST['plans'])? $_POST['plans'] : [];
		$status 	= intval($_POST['status']);
		
		if (!$coupon instanceof Coupon)
		{
			// redirect
			header('location: coupons.php');
			exit;
		}
		else if ($_POST['code'] == '' || $_POST['value'] == '' || $_POST['type'] == '' || $_POST['total-usage'] == '' || $_POST['plans'] == '')
		{
			$msg['err'] = 'Please fill out all fields below!';
		}
		else if ($coupon->code != $code && Coupon::getBy(['code' => $code]) instanceof Coupon)
		{
			$msg['err'] = 'Oops, This Coupon is already used before!';
		}
		else
		{
			if ($coupon->total_valid_time < $totalUsage)
				$coupon->expired = '0';

			$coupon->code = $code;
			$coupon->value = $value;
			$coupon->type = $type;
			$coupon->total_valid_time = $totalUsage;
			$coupon->status = (string)$status;
			

			if ($coupon->save())
			{
				Plans_Coupon::deleteBy(['coupons_id' => $coupon_id]);
				
				foreach ($plans as $plan_id)
				{
					$PC = new Plans_Coupon();
					$PC->plans_id = $plan_id;
					$PC->coupons_id = $coupon_id;
					$PC->save();
				}

				// redirect
				header('location: coupons.php');
				exit;
			}
			else
				$msg['err'] = 'Something was wrong, please try again!';
		}		
	}

	$data['msg'] = $msg;
	$data['coupon'] = $coupon;
	$data['dash_title'] = "Edit Coupon";
	Dashboard::Render('add_coupon', $data);
}
else
{
	$coupons = Coupon::getAll(['id', 'DESC']);
	$resultNumber = count($coupons);

	if (is_array($coupons))
		$data['coupons'] = $coupons;
	else
		$data['coupons'] = [];

	$data['dash_title'] = "Coupons ({$resultNumber})";
	Dashboard::Render('coupons', $data);
}

?>
