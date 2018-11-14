<?php

namespace MR4Web\Models;

use MR4Web\Models\PDOModel;
use MR4Web\Models\Domain;
use MR4Web\Models\Product;
use MR4Web\Models\Customer;

class License extends PDOModel {

	public function __construct($data = NULL)
	{
		$schema = [
			'id'			=> \PDO::PARAM_INT,
			'license_code'	=> \PDO::PARAM_STR,
			'activation_num'=> \PDO::PARAM_INT,
			'activation_max'=> \PDO::PARAM_INT,
			'banned'		=> \PDO::PARAM_INT,
			'created'		=> \PDO::PARAM_STR,
			'products_id'	=> \PDO::PARAM_INT,
			'customers_id'	=> \PDO::PARAM_INT
		];
		parent::__construct($schema, $data);
	}

	public function getDomains()
	{
		return Domain::getAllBy(['licenses_id' => $this->id]);
	}

	public function getProduct()
	{
		return Product::get($this->products_id);
	}

	public function getCustomer()
	{
		return Customer::get($this->customers_id);
	}
}

?>