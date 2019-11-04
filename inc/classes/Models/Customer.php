<?php

namespace MR4Web\Models;

use MR4Web\Models\PDOModel;
use MR4Web\Models\Transaction;
use MR4Web\Models\Invoice;
use MR4Web\Models\plan;

class Customer extends PDOModel {

	public static $_currentCustomer = null;

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
			'banned'	=> \PDO::PARAM_INT,
			'created'	=> \PDO::PARAM_STR
		];
		parent::__construct($schema, $data);
	}

	public function getTransactions()
	{
		return Transaction::getAllBy(['customers_id' => $this->id]);
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
		return Invoice::getAllBy(['customers_id' => $this->id], ['id', 'DESC']);
	}

	public static function currentCustomer()
	{
		if (self::$_currentCustomer instanceof Customer)
			return self::$_currentCustomer;
		return NULL;
	}

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


	public function saveNewPassword($password)
	{
		$pass = hash('sha256', ENCRYPTION_KEY.$password);

		$customer = self::getBy([
			'email' => $this->email
		]);

		if ($customer instanceof Customer)
		{
			$customer->password = $pass;
			$customer->save();
		}
	} 

	public static function login($email, $password)
	{
		$pass = hash('sha256', ENCRYPTION_KEY.$password);
		
		$customer = self::getBy([
			'email' => $email,
			'password' => $pass
		]);

		if ($customer instanceof Customer)
		{
			self::$_currentCustomer = $customer;
			// make a session.
			$_SESSION['customer_login']['status'] = true;
			$_SESSION['customer_login']['token'] = $customer->token;
			$_SESSION['customer_login']['ip'] = get_client_ip();
			$_SESSION['customer_login']['agent'] = $_SERVER['HTTP_USER_AGENT'];

			return true;
		}

		return false;
	}

	public static function logout()
	{
		unset($_SESSION['customer_login']);
	}

	public static function isLogin()
	{
		$browser = isset($_SESSION['customer_login'])? $_SESSION['customer_login'] : [];
		
		if (count($browser) && $browser['status'] == true && $browser['ip'] == get_client_ip() && $browser['agent'] == $_SERVER['HTTP_USER_AGENT'])
		{
			$customer = Customer::getBy(['token' => $browser['token']]);
			if ($customer instanceof Customer)
			{
				self::$_currentCustomer = $customer;
				return true;
			}
		}

		return false;
	}

	public function isBanned()
	{
		return (bool)$this->banned;
	}
}

?>