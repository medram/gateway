<?php

namespace MR4Web\Models;

use MR4Web\Models\PDOModel;
use MR4Web\Models\Customer;
use MR4Web\Models\Plan;
use MR4Web\Models\User;
use MR4Web\Models\Update;

class Product extends PDOModel {

	public function __construct($data = NULL)
	{
		$schema = [
			'id'			=> \PDO::PARAM_INT,
			'users_id'		=> \PDO::PARAM_INT,
			'name'			=> \PDO::PARAM_STR,
			'version'		=> \PDO::PARAM_STR,
			'small_desc'	=> \PDO::PARAM_STR,
			'email_support' => \PDO::PARAM_STR,	
			'created'		=> \PDO::PARAM_STR	
		];
		parent::__construct($schema, $data);
	}
	
	public function getPlans()
	{
		return Plan::getAllBy(['products_id' => $this->id]);		
	}

	public function getPlansWhere($where)
	{
		if (is_string($where))
			return Plan::getAllBy($where." AND `products_id`={$this->id}");
		return [];
	}

	public static function deleteProduct($id)
	{
		// delete plans_coupons & plans
		$product = Product::get($id);

		if ($product instanceof Product)
		{
			// delete Plans of this product.
			foreach ($product->getPlans() as $plan)
			{
				Plan::deletePlan($plan->id);
			}

			// delete files.
			self::deleteFiles($id);

			// delete data product from database.
			if ($product->delete())
				return true;
		}
		
		return false;
	}

	// delete old files from Database & HDD
	public static function deleteFiles($id)
	{
		$id = intval($id);
		$oldFiles = File::getAllBy(['products_id' => $id]);
		$status = true;

		if (count($oldFiles) && is_object($oldFiles[0]))
		{
			foreach ($oldFiles as $oFile)
			{
				// delete file from HDD & delete file from database
				if (!$oFile->deleteFileHDD(User::getUser()) || !$oFile->delete())
				{
					$status = false;
				}
			}
		}

		return $status;
	}

	public function getFiles()
	{
		return File::getAllBy(['products_id' => $this->id]);
	}

	public function getUser()
	{
		return User::get($this->users_id);
	}

	public function getUpdates()
	{
		return Update::getAllBy(['products_id' => $this->id], ['id', 'DESC']);
	}

	public function getLastUpdate()
	{
		$updates = $this->getUpdates();
		return count($updates)? $updates[0] : NULL;
	}

	public function getNews()
	{
		return News::getAllBy(['products_id' => $this->id]);
	}
}

?>