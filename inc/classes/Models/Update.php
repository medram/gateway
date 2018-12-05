<?php

namespace MR4Web\Models;

use MR4Web\Models\Product;
use MR4Web\Models\Plan;
use MR4Web\Models\Feature;

class Update extends PDOModel {

	public function __construct($data = NULL)
	{
		$schema = [
			'id'			=> \PDO::PARAM_INT,
			'paid'			=> \PDO::PARAM_INT,
			'douwnload_url'	=> \PDO::PARAM_STR,
			'products_id'	=> \PDO::PARAM_INT,
			'plans_id'		=> \PDO::PARAM_INT,
			'created'		=> \PDO::PARAM_STR
		];
		parent::__construct($schema, $data);
	}

	public function getProduct()
	{
		return Product::get($this->products_id);
	}

	public function getPlan()
	{
		return Product::get($this->plans_id);
	}

	public function getFeatures()
	{
		return Feature::getAllBy(['updates_id' => $this->id]);
	}
}

?>