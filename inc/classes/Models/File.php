<?php

namespace MR4Web\Models;

use MR4Web\Models\PDOModel;
use MR4Web\Models\Customer;
use MR4Web\Models\Plan;

class File extends PDOModel {

	private static $_uploadsPath = UPLOADS_DIR;

	public function __construct($data = NULL)
	{
		$schema = [
			'id'		=> \PDO::PARAM_INT,
			'name'		=> \PDO::PARAM_STR,
			'size'		=> \PDO::PARAM_INT,
			'path'		=> \PDO::PARAM_STR,
			'products_id'	=> \PDO::PARAM_INT,
			'created'	=> \PDO::PARAM_STR
		];
		parent::__construct($schema, $data);
	}

	public function getDownloadLink(Plan $plan, Customer $customer)
	{
		$product = $plan->getProduct();
		$user = $product->getUser();

		$path = self::$_uploadsPath.'users/ID_'.$user->id.'/products/'.$this->getFileName();
		// generate a valid URL to download the file.
		if (file_exists($path))
		{
			return BASE_URL."download.php?p={$plan->id}&t={$customer->token}";
		}

		return NULL;
	}

	public function getFileName()
	{
		return $this->name;
		/*static $name = '';
		if ($name == '')
			$name = preg_replace("/[^a-z0-9_\.\-\(\)]+/i", '_', $this->name);
		return $name;*/
	}

	public function deleteFileHDD(User $user)
	{
		$path = self::$_uploadsPath.'users/ID_'.$user->id.'/products/'.$this->name;
		//die("Deleting... " . $path);
		if (file_exists($path) && is_writable($path))
		{
			// delete the file.
			return @unlink($path);
		}
		return false;
	}
}

?>