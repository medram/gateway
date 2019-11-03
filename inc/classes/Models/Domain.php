<?php

namespace MR4Web\Models;

use MR4Web\Models\PDOModel;

class Domain extends PDOModel {

	public function __construct($data = NULL)
	{
		$schema = [
			'id'			=> \PDO::PARAM_INT,
			'licenses_id'	=> \PDO::PARAM_INT,
			'IP'			=> \PDO::PARAM_STR,
			'domain_name'	=> \PDO::PARAM_STR,
			'product_version'	=> \PDO::PARAM_STR,
			'active'		=> \PDO::PARAM_INT,
			'total_checks'	=> \PDO::PARAM_INT,
			'created'		=> \PDO::PARAM_STR,
			'modified'		=> \PDO::PARAM_STR
		];
		parent::__construct($schema, $data);
	}

	public function isActive()
	{
		return (bool)$this->active;
	}

	public function activate()
	{
		$this->active = 1;
		$this->modified = NULL;
		return $this->save();
	}

	public function deactivate()
	{
		$this->active = '0';
		$this->modified = NULL;
		return $this->save();
	}
}

?>