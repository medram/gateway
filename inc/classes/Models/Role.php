<?php

namespace MR4Web\Models;

use MR4Web\Models\PDOModel;

class Role extends PDOModel {

	public function __construct($data = NULL)
	{
		$schema = [
			'id'	=> \PDO::PARAM_INT,
			'name'	=> \PDO::PARAM_STR
		];
		parent::__construct($schema, $data);
	}

	public function getUsers()
	{
		return User::getAllBy(['roles_id' => $this->id]);
	}
}

?>