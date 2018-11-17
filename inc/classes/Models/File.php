<?php

namespace MR4Web\Models;

use MR4Web\Models\PDOModel;
use MR4Web\Models\Customer;
use MR4Web\Models\Plan;

class File extends PDOModel {

	private static $_path = UPLOADS_DIR'products/';

	public function __construct($data = NULL)
	{
		$schema = [
			'id'		=> \PDO::PARAM_INT,
			'name'		=> \PDO::PARAM_STR,
			'path'		=> \PDO::PARAM_STR,
			'created'	=> \PDO::PARAM_STR
		];
		parent::__construct($schema, $data);
	}

	public function getDownloadLink(Plan $plan, Customer $customer)
	{
		$exts = ['rar', 'zip'];
		$found = false;
		// generate a valid URL to download the file.
		foreach ($exts as $ext)
		{
			if (file_exists(self::$_path.$this->getFileName()))
			{
				$found = true;
				break;
			}
		}

		return BASE_URL."download.php?p={$plan->id}&t={$customer->token}";
	}

	public function getFileName()
	{
		static $name = '';
		if ($name == '')
			$name = preg_replace("/[^a-z0-9_\\.-]+/i", '_', $this->name);
		return $name;
	}
}

?>