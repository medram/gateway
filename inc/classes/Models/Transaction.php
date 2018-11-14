<?php

namespace MR4Web\Models;

use MR4Web\Models\PDOModel;
use MR4Web\Models\Customer;
use MR4Web\Models\Payment_method;
use MR4Web\Models\Coupon;
use MR4Web\Models\Plan;
use MR4Web\Models\Invoice;

class Transaction extends PDOModel {

	public function __construct($data = NULL)
	{
		$schema = [
			'id' 		=> \PDO::PARAM_INT,
			'PM_id' 	=> \PDO::PARAM_INT,
			'customers_id' 	=> \PDO::PARAM_INT,
			'payers_id' 	=> \PDO::PARAM_INT,
			'Tr_ID' 	=> \PDO::PARAM_STR,
			'Tr_fee' 	=> \PDO::PARAM_STR,
			'amount'	=> \PDO::PARAM_STR,
			'quantity'	=> \PDO::PARAM_INT,
			'currency'	=> \PDO::PARAM_STR,
			'state'		=> \PDO::PARAM_STR,
			'created'	=> \PDO::PARAM_STR
		];
		parent::__construct($schema, $data);
	}

/*	public static function getAllTransactions(PDOModel $model)
	{
		return self::getAll($model->id);
	}*/

	public function getCustomer()
	{
		return Customer::get($this->customers_id);
	}

	public function getPaymentMethod()
	{
		return Payment_method::get($this->PM_id);
	}

	public function getInvoice()
	{
		return Invoice::getBy(['transactions_id' => $this->id]);
	}	
}

?>