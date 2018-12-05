<?php

namespace MR4Web\Models;

use MR4Web\Models\Update;

class Feature extends PDOModel {

	public function __construct($data = NULL)
	{
		$schema = [
			'id'		=> \PDO::PARAM_INT,
			'updates_id'=> \PDO::PARAM_INT,
			'desc'		=> \PDO::PARAM_STR
		];
		parent::__construct($schema, $data);
	}

	public function getUpdate()
	{
		return Update::get($this->updates_id);
	}
}

?>