<?php

namespace MR4Web\Models;

use MR4Web\Models\PDOModel;
use MR4Web\Models\Transaction;
use MR4Web\Models\License;
use MR4Web\Models\Invoice;
use MR4Web\Models\plan;

class Customer extends PDOModel {

	public function __construct($data = NULL)
	{
		$schema = [
			'id'		=> \PDO::PARAM_INT,
			'fname'		=> \PDO::PARAM_STR,
			'lname'		=> \PDO::PARAM_STR,
			'email'		=> \PDO::PARAM_STR,
			'gender'	=> \PDO::PARAM_STR,
			'password'	=> \PDO::PARAM_STR,
			'token'		=> \PDO::PARAM_STR,
			'created'	=> \PDO::PARAM_STR
		];
		parent::__construct($schema, $data);
	}

	public function getTransactions()
	{
		return Transaction::getAllBy(['customers_id' => $this->id]);
	}
	
	public function getLicenses()
	{
		return License::getAllBy(['customers_id' => $this->id]);
	}

	public function getProducts()
	{
		$products = [];
		$plans = $this->getPlans(false);
		$tmpProduct;
		foreach ($plans as $plan)
		{
			$tmpProduct	= $plan->getProduct();

			if (!count($products))
			{
				// initial value to start the loop.
				$products[] = $tmpProduct;
			}
			else
			{
				$found = false;
				// check if the current product found in the products list 
				foreach ($products as $product)
				{
					if ($tmpProduct->id == $product->id)
					{
						$found = true;
						break;
					}
				}
	
				// add to the list
				if (!$found)
					$products[] = $tmpProduct;
			}
		}
		return $products;
	}

	public function getInvoices()
	{
		return Invoice::getAllBy(['customers_id' => $this->id]);
	}

	/*public function getInvoice(Plan $plan)
	{
		foreach ($this->getInvoices() as $invoice)
		{
			if ($plan->id == $invoice->getPlan()->id)
				return $invoice;
		}

		return NULL;
	}*/

	public function getPlans($repetation = true)
	{
		$plans = [];
		$currentPlan;
		foreach ($this->getInvoices() as $invoice)
		{
			$currentPlan = $invoice->getPlan();
			if ($repetation)
			{
				$plans[] = $currentPlan;
			}
			else
			{
				if (!count($plans))
					$plans[] = $currentPlan;
				else
				{
					$found = false;
					foreach ($plans as $plan)
					{
						if ($plan->id == $currentPlan->id)
						{	
							$found = true;
							break;
						}
					}
					
					if (!$found)
						$plans[] = $currentPlan;
				}
			}
		}
		return $plans;
	}
}

?>