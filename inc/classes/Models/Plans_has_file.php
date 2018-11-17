<?php

namespace MR4Web\Models;

use MR4Web\Models\PDOModel;

class Plans_has_file extends PDOModel {

	public function __construct($data = NULL)
	{
		$schema = [
			'id'		=> \PDO::PARAM_INT,
			'files_id'	=> \PDO::PARAM_INT,
			'plans_id'	=> \PDO::PARAM_INT
		];
		parent::__construct($schema, $data);
	}



}

?>