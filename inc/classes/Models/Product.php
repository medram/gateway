<?php

namespace MR4Web\Models;

use MR4Web\Models\PDOModel;
use MR4Web\Models\License;
use MR4Web\Models\Plan;

class Product extends PDOModel {

	public function __construct($data = NULL)
	{
		$schema = [
			'id'			=> \PDO::PARAM_INT,
			'name'			=> \PDO::PARAM_STR,
			'version'		=> \PDO::PARAM_STR,
			'small_desc'	=> \PDO::PARAM_STR,
			'email_support' => \PDO::PARAM_STR,	
			'created'		=> \PDO::PARAM_STR	
		];
		parent::__construct($schema, $data);
	}

	public function getPlans()
	{
		return Plan::getAllBy(['products_id' => $this->id]);
	}
	
	public function getLicenses()
	{
		return License::getAllBy(['products_id' => $this->id]);
	}

	public static function deleteProduct($id)
	{
		// delete plans_coupons & plans
		$product = Product::get($id);

		if ($product instanceof Product)
		{
			foreach ($product->getPlans() as $plan)
			{
				Plan::deletePlan($plan->id);
			}
			if ($product->delete())
				return true;
		}
		
		return false;
	}
}

?>