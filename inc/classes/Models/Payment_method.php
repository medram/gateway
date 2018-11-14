<?php

namespace MR4Web\Models;

use MR4Web\Models\PDOModel;
use MR4Web\Models\Transaction;

class Payment_method extends PDOModel {

	public function __construct($data = NULL)
	{
		$schema = [
			'id' 			=> \PDO::PARAM_INT,
			'name' 			=> \PDO::PARAM_STR,
			'image_url' 	=> \PDO::PARAM_STR,
			'description' 	=> \PDO::PARAM_STR,
			'created' 	=> \PDO::PARAM_STR
		];
		parent::__construct($schema, $data);
	}

	public static function getTransactions()
	{
		return Transaction::getAllBy(['PM_id' => $this->id]);
	}
}

?>