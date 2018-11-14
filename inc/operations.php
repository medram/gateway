<?php

use MR4Web_API\Connections\DB;
use MR4Web_API\Configs\Config;
use MR4Web_API\Markets\Envato;
use MR4Web_API\Utils\License;
use MR4Web_API\Utils\Customer;
use MR4Web_API\Utils\Product;
use MR4Web_API\Utils\Domain;
use MR4Web_API\Utils\Res;


function activate_operation()
{
	// connect to the database.
	$db = &DB::getInstance();
	
	/*
		URL : http://api.mr4web.com/v1/license.php?action=activate&code=***&domain=***&c_name=***&c_email=***&p_name=***&p_version=***
		check the database using the purchase code.
		return data.
	*/

	// check all GET / POST parameters
	$keys = array('code', 'domain', 'ip', 'c_name', 'c_email', 'p_name', 'p_version', 'listener');
	
	if (!checkParams($keys))
	{
		Res::appendInvalidParams();
	}
	else
	{
		// create vars & instances (customer/product/...)
		$code = strip_tags(_addslashes($_POST['code']));
		$c_name = strip_tags(_addslashes($_POST['c_name']));
		$c_email = strip_tags(_addslashes($_POST['c_email']));
		$p_name = strip_tags(_addslashes($_POST['p_name']));
		$p_version = strip_tags(_addslashes($_POST['p_version']));
		$domain = strip_tags(_addslashes($_POST['domain']));
		$ip = strip_tags(_addslashes($_POST['ip']));
		$listener = strip_tags(_addslashes($_POST['listener']));

		if (!filter_var($c_email, FILTER_VALIDATE_EMAIL) || 
			!filter_var($ip, FILTER_VALIDATE_IP) || 
			!filter_var($domain, FILTER_VALIDATE_URL) ||
			!filter_var($listener, FILTER_VALIDATE_URL))
		{
			Res::appendInvalidParams();
		}
		else
		{
			Res::appendValidParams();

			try {
				$db->beginTransaction();

				$license = new License($code);
				$domain = new Domain($license, $ip, $domain, $listener);
				$product = new Product($p_name, $p_version);
				$customer = new Customer($license, $c_name, $c_email);

				if ($license->isBanned())
				{
					Res::add('activate', 0);
					Res::add('message', 'This license code (purchase code) was banned!, if you think that was wrong please contact us.');
/*					$msg['purchase_code']['activate'] = 0;
					$msg['purchase_code']['message'] = '';*/
				}
				// for new license
				else if (!$license->isOnDatabase())
				{
					logger("code isn't on the database!\n");
					
					if ($license->checkPurchaseCodeFromMarket())
					{
						/*
						*	We have to register the customer then the license then the domain.
						*/
						if ($customer->isNew())
							$customer->register();
						else
							$customer->update();

						$license->register($product, $customer);

						if ($domain->isNewIP())
							$domain->register($product);

						$license->activate($domain);
						//$domain->updateInfo($license, $product);
						Res::appendSuccessPurchase();
					}
					else
					{
						Res::add('activate', 0);
						Res::add('message', 'This purchase code is not valid.');
					}
				}
				else // for old license.
				{
					logger("code is on the database!\n");
					// check if its license is valid for this domain
					if ($domain->isNewIP())
					{
						logger("new IP!\n");
						
						// activate license code for the new Domain.
						if ($license->isValidToUsed())
						{
							$domain->register($product);
							if ($license->activate($domain))
							{
								$customer->update();
								//$domain->updateInfo($license, $product);
								Res::appendSuccessPurchase();
							}
						}
						else
						{
							Res::add('activate', 0);
							Res::add('message', 'This purchase code is not able to activate more products!');
						}
					}
					else
					{
						logger("old IP\n");
						/*
							- old active
								- show success.
							- old inactive
								- isValidToUsed
									- activating
									- show success.
						*/
						if ($domain->isActive())
						{
							// increase the checks number & last check & update a product version.
							$domain->updateInfo($product);
							$customer->update();
							Res::appendSuccessPurchase();
						}
						else if ($license->isValidToUsed())
						{
							if ($license->activate($domain))
							{
								$customer->update();
								//$domain->updateInfo($license, $product);
								Res::appendSuccessPurchase();
							}
						}
						else
						{
							Res::add('activate', 0);
							Res::add('message', 'This purchase code is not able to activate more products!');
						}
					}
				}

				$db->commit();

			} catch (Exception $e){
				$db->rollBack();
				logger($e->getMessage()."\n");
			}
		}

	}

}


function deactivate_operation()
{
	// connect to the database.
	$db = &DB::getInstance();

	
	// check all GET / POST parameters
	$keys = array('code', 'ip');
	
	if (!checkParams($keys))
	{
		Res::appendInvalidParams();
	}
	else
	{
		Res::appendValidParams();
	
		/*
		*	check the IP & delete it using license code.
		*/
		
		$code = strip_tags(_addslashes($_POST['code']));
		$ip = strip_tags(_addslashes($_POST['ip']));
		
		try {
			$db->beginTransaction();

			$license = new License($code);
			$domain = new Domain($license, $ip);

			if ($license->isBanned())
			{
				Res::add('deactivate', 0);
				Res::add('message', 'This purchase code was banned!');
			}
			else if ($domain->isNewIP())
			{
				Res::add('deactivate', 0);
				Res::add('message', 'The purchase code is not valid for this IP (host address)!');
			}
			else if (!$domain->isActive())
			{
				Res::add('deactivate', 0);
				Res::add('message', 'The purchase code is not active yet on this IP (host address)!');	
			}
			else if ($license->deactivate($domain))
			{
				Res::add('deactivate', 1);
				Res::add('message', 'The purchase code was deactivated successfully.');
			}
			else
			{
				Res::add('deactivate', 0);
				Res::add('message', 'Somthing wrong! please try again or later!');
			}
			
			$db->commit();
		} catch (PDOException $e) {
			logger($e->getMessage());
			exit;
		}
	}

/*	if ($license->isOnDatabase() && $license->deactivate())
	{
		$msg['purchase_code']['deactivate'] = 1;
	}
	else
	{
		$msg['purchase_code']['deactivate'] = 0;
	}*/
}

?>