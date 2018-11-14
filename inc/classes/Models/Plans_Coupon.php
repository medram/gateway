<?php

namespace MR4Web\Models;

use MR4Web\Models\PDOModel;
use MR4Web\Models\Coupon;

class Plans_Coupon extends PDOModel {

	public function __construct($data = NULL)
	{
		$schema = [
			'id'		=> \PDO::PARAM_INT,
			'plans_id'	=> \PDO::PARAM_INT,
			'coupons_id'=> \PDO::PARAM_INT
		];
		parent::__construct($schema, $data);
	}

	public static function getPlansByCoupon(Coupon &$coupon)
	{
		$plansList = [];
		$PList = Plans_Coupon::getAllBy(['plans_id' => $coupon->id]);
		
		foreach ($PList as $plan)
			$plansList[] = Plan::get($plan->plans_id);
		return $plansList; 
	}

	public static function getCouponsByPlan(Plan &$plan)
	{
		$couponsList = [];
		$PCList = Plans_Coupon::getAllBy(['plans_id' => $plan->id]);
		
		foreach ($PCList as $PC)
			$couponsList[] = Coupon::get($PC->coupons_id);
		return $couponsList; 
	}

}

?>