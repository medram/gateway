<?php

namespace MR4Web\Models;

use MR4Web\Models\PDOModel;

class Payer extends PDOModel {

	public function __construct($data = NULL)
	{
		$schema = [
			'id'			=> \PDO::PARAM_INT,
			'fname'			=> \PDO::PARAM_STR,
			'lname'			=> \PDO::PARAM_STR,
			'email'			=> \PDO::PARAM_STR,
			'payer_id'		=> \PDO::PARAM_STR,
			'country_code' 	=> \PDO::PARAM_STR,
			'created'		=> \PDO::PARAM_STR
		];
		parent::__construct($schema, $data);
	}

	public function getTransactions()
	{
		return Transaction::getAllBy(['payers_id' => $this->id]);
	}
	
}

?>