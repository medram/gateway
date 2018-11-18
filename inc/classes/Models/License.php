<?php

namespace MR4Web\Models;

use MR4Web\Models\PDOModel;
use MR4Web\Models\Domain;
use MR4Web\Models\Product;
use MR4Web\Models\Customer;
use MR4Web\Models\Plan;

class License extends PDOModel {

	public function __construct($data = NULL)
	{
		$schema = [
			'id'			=> \PDO::PARAM_INT,
			'license_code'	=> \PDO::PARAM_STR,
			'activation_num'=> \PDO::PARAM_INT,
			'activation_max'=> \PDO::PARAM_INT,
			'banned'		=> \PDO::PARAM_INT,
			'license_type'	=> \PDO::PARAM_STR,
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

	public static function createLicense(Customer $customer, Plan $plan)
	{
		$product = $plan->getProduct();

		$license = new License();
		$license->license_code = self::generateLicenseCode($customer, $product);
		$license->activation_num = 0;
		$license->activation_max = ; // depends on Plan.
		$license->banned = 0;
		$license->license_type = ''; // depends on Plan.
		$license->products_id = $product->id;
		$license->customers_id = $customer->id;

		$license->save();
		
		return $license;
	}

	public static function generateLicenseCode(Product &$product, Customer &$customer)
	{
		$code = '';

		do {
			$code = sha1($customer->token.'-'.$product->id.'-'.time());
		}
		while (License::getBy(['license_code' => $code]) instanceof License);

		return $code;
	}
}

?>