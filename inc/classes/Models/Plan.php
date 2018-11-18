<?php

namespace MR4Web\Models;

use MR4Web\Models\PDOModel;
use MR4Web\Models\Transaction;
use MR4Web\Models\Product;
use MR4Web\Models\Plans_Coupon;

class Plan extends PDOModel {

	private static $_planType = [
		'M' => 'Monthly',
		'Y'	=> 'Yearly',
		'L'	=> 'Lifetime'
	];

	public function __construct($data = NULL)
	{
		$schema = [
			'id'			=> \PDO::PARAM_INT,
			'products_id'	=> \PDO::PARAM_INT,
			'name'			=> \PDO::PARAM_STR,
			'desc'			=> \PDO::PARAM_STR,
			'price'			=> \PDO::PARAM_STR,
			'old_price'		=> \PDO::PARAM_STR,
			'plan_type'		=> \PDO::PARAM_STR,
			'max_license'	=> \PDO::PARAM_INT,
			'created'		=> \PDO::PARAM_STR
		];
		parent::__construct($schema, $data);
	}

	public function getTransactions()
	{
		return Transaction::getAllBy(['plans_id' => $this->id]);
	}

	public function getProduct()
	{
		return Product::get($this->products_id);
	}

	public function supportCoupon(Coupon &$coupon)
	{
		$couponsList = Plans_Coupon::getCouponsByPlan($this);
		foreach ($couponsList as $c)
		{
			if ($coupon->id == $c->id)
				return true;
		}
		return false;
	}

	public function planType()
	{
		return $this->plan_type != ''? self::$_planType[$this->plan_type] : '' ;
	}

	public static function getPaymentsType()
	{
		return self::$_planType;
	}

	public static function deletePlan($id)
	{
		$plan = Plan::get($id);
		if ($plan instanceof Plan)
			if (Plans_Coupon::deleteBy(['plans_id' => $plan->id]) && 
				Plans_has_file::deleteBy(['plans_id' => $plan->id]) && 
				$plan->delete())
				return true;

		return false;
	}

	public function getFiles()
	{
		$plans_has_file = Plans_has_file::getAllBy(['plans_id' => $this->id]);
		$result = [];
		foreach ($plans_has_file as $pf)
		{
			$result[] = File::get($pf->files_id);
		}
		return $result;
	}
}

?>