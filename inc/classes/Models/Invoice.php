<?php

namespace MR4Web\Models;

use MR4Web\Models\PDOModel;
use MR4Web\Models\Coupon;
use MR4Web\Models\Transaction;
use MR4Web\Models\Plan;
use MR4Web\Models\Item;

class Invoice extends PDOModel {

	public function __construct($data = NULL)
	{
		$schema = [
			'id'				=> \PDO::PARAM_INT,
			'invoice_id'		=> \PDO::PARAM_STR,
			'transactions_id'	=> \PDO::PARAM_STR,
			'customers_id'		=> \PDO::PARAM_INT,
			'plans_id'			=> \PDO::PARAM_INT,
			'coupons_id'		=> \PDO::PARAM_INT,
			'created'			=> \PDO::PARAM_STR
		];
		parent::__construct($schema, $data);
	}

	public function getTransaction()
	{
		return Transaction::get($this->transactions_id);
	}
	
	public function getPlan()
	{
		return Plan::get($this->plans_id);
	}

	public function getCoupon()
	{
		return Coupon::get($this->coupons_id);
	}

	public function getCustomer()
	{
		return Customer::get($this->customers_id);
	}

	public function getItems()
	{
		return Item::getAllBy(['invoices_id' => $this->id]);
	}
}

?>