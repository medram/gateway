<?php

namespace MR4Web\Models;

use MR4Web\Models\PDOModel;
use MR4Web\Models\License;

class Domain extends PDOModel {

	public function __construct($data = NULL)
	{
		$schema = [
			'id'			=> \PDO::PARAM_INT,
			'licenses_id'	=> \PDO::PARAM_INT,
			'IP'			=> \PDO::PARAM_STR,
			'domain_name'	=> \PDO::PARAM_STR,
			'listener'		=> \PDO::PARAM_STR,
			'product_version'	=> \PDO::PARAM_STR,
			'active'		=> \PDO::PARAM_INT,
			'created'		=> \PDO::PARAM_STR,
			'modified'		=> \PDO::PARAM_STR,
			'total_checks'	=> \PDO::PARAM_INT
		];
		parent::__construct($schema, $data);
	}

	public function getLicense()
	{
		return License::get($this->licenses_id);
	}
}

?>