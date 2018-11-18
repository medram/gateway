<?php

namespace MR4Web\Models;

use MR4Web\Models\PDOModel;
use MR4Web\Models\Transaction;
use MR4Web\Models\License;

class Customer extends PDOModel {

	public function __construct($data = NULL)
	{
		$schema = [
			'id'		=> \PDO::PARAM_INT,
			'fname'		=> \PDO::PARAM_STR,
			'lname'		=> \PDO::PARAM_STR,
			'email'		=> \PDO::PARAM_STR,
			'gender'	=> \PDO::PARAM_STR,
			'password'	=> \PDO::PARAM_STR,
			'token'		=> \PDO::PARAM_STR,
			'created'	=> \PDO::PARAM_STR
		];
		parent::__construct($schema, $data);
	}

	public function getTransactions()
	{
		return Transaction::getAllBy(['customers_id' => $this->id]);
	}
	
	public function getLicenses()
	{
		return License::getAllBy(['customers_id' => $this->id]);
	}
}

?>