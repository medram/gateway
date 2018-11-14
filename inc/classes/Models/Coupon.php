<?php

namespace MR4Web\Models;

use MR4Web\Models\PDOModel;
use MR4Web\Models\Transaction;

class Coupon extends PDOModel {

	public function __construct($data = NULL)
	{
		$schema = [
			'id'		=> \PDO::PARAM_INT,
			'code'		=> \PDO::PARAM_STR,
			'value'		=> \PDO::PARAM_STR,
			'type'		=> \PDO::PARAM_STR,
			'total_valid_time'=> \PDO::PARAM_INT,
			'valid_time'=> \PDO::PARAM_INT,
			'status'	=> \PDO::PARAM_INT,
			'expired'	=> \PDO::PARAM_INT,
			'created'	=> \PDO::PARAM_STR
		];
		parent::__construct($schema, $data);
	}

	public function getTransactions()
	{
		return Transaction::getAllBy(['coupons_id' => $this->id]);
	}

	public static function deleteCoupon($id)
	{
		return Plans_Coupon::deleteBy(['coupons_id' => $id]) && Coupon::deleteBy(['id' => $id]);
	}

	public function isActive()
	{
		return (bool)$this->status;
	}

	public function isExpired()
	{
		return (bool)$this->expired;
	}

	public function isValidToUse()
	{
		return $this->isActive() && !$this->isExpired();
	}
}

?>