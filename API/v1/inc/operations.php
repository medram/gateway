<?php

use MR4Web\Models\PDOModel;
use MR4Web\Models\License;
use MR4Web\Models\Customer;
use MR4Web\Models\Domain;

function activate_operation()
{
	/*
		URL : http://api.mr4web.com/v1/license.php?action=activate&code=***&domain=***&c_name=***&c_email=***&p_name=***&p_version=***
		check the database using the purchase code.
		return data.
	*/

	// check all GET / POST parameters
	$keys = array('code', 'domain', 'ip', 'p_version', 'listener');
	
	if (!checkParams($keys))
	{
		Res::appendInvalidParams();
	}
	else
	{
		// create vars & instances (customer/product/...)
		$code = strip_tags(_addslashes($_POST['code']));
		//$c_name = strip_tags(_addslashes($_POST['c_name']));
		//$c_email = strip_tags(_addslashes($_POST['c_email']));
		//$p_name = strip_tags(_addslashes($_POST['p_name']));
		$p_version = strip_tags(_addslashes($_POST['p_version']));
		$c_domain = strip_tags(_addslashes($_POST['domain']));
		$ip = strip_tags(_addslashes($_POST['ip']));
		$listener = strip_tags(_addslashes($_POST['listener']));

		if (!filter_var($ip, FILTER_VALIDATE_IP) || 
			!filter_var($c_domain, FILTER_VALIDATE_URL) ||
			!filter_var($listener, FILTER_VALIDATE_URL))
		{
			Res::appendInvalidParams();
		}
		else
		{
			Res::appendValidParams();

			try {
				PDOModel::getPDO()->beginTransaction();

				$license = License::getBy(['license_code' => $code]);

				if (!$license instanceof License)
				{
					Res::add('activate', 0);
					Res::add('message', 'This license code is not valid');
				}
				else if ($license->isBanned())
				{
					Res::add('activate', 0);
					Res::add('message', 'This license code has been banned!, if you think that was wrong please contact us.');
/*					$msg['purchase_code']['activate'] = 0;
					$msg['purchase_code']['message'] = '';*/
				}
				else // license found on database and isn't banned.
				{
					logger("license code found on the database!\n");
				
					$domain = Domain::getBy(['IP' => $ip, 'domain_name' => $c_domain]);
					$product = $license->getProduct();
					//$customer = $license->getCustomer();

					/*
						- activate license code.
						- if Domain not found:
							- register new domain information.
						- if Domain found: 
							- 
					*/

					if ($ip == "127.0.0.1" || $ip == '::1' || $c_domain == 'localhost')
					{
						Res::appendSuccessPurchase($product->name);
					}
					// check if client license is valid for this domain
					else if (!$domain instanceof Domain)
					{
						logger("new IP/Domain!\n");
						
						// activate license code for the new Domain.
						if ($license->isValidToUsed())
						{
							$domain = new Domain();
							$domain->licenses_id = $license->id;
							$domain->IP = $ip;
							$domain->domain_name = $c_domain;
							$domain->product_version = $p_version;
							$domain->active = 1; // domain activation is here
							$domain->total_checks = 1;

							// the license activation create save domain to the database if not found. 
							if ($license->activate($domain))
							{
								//$customer->update();
								//$domain->updateInfo($license, $product);
								Res::appendSuccessPurchase($product->name);
							}
						}
						else
						{
							Res::add('activate', 0);
							Res::add('message', 'This license is not able to activate more products!');
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
							// increase the checks rate & last check & update a product version.
							$domain->total_checks++;
							$domain->product_version = $p_version;
							$domain->modified = NULL;
							$domain->save();

							//$customer->update();
							Res::appendSuccessPurchase($product->name);
						}
						else if ($license->isValidToUsed())
						{
							if ($license->activate($domain))
							{
								//$customer->update();
								//$domain->updateInfo($license, $product);
								Res::appendSuccessPurchase($product->name);
							}
						}
						else
						{
							Res::add('activate', 0);
							Res::add('message', 'This License is not able to activate more products!');
						}
					}
				}

				PDOModel::getPDO()->commit();

			} catch (\Exception $e){
				PDOModel::getPDO()->rollBack();
				logger($e->getMessage()."\n");
			}
		}

	}

} // function end


function deactivate_operation()
{	
	// check all GET / POST parameters
	$keys = array('code', 'ip', 'domain');
	
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
		
		$code 		= strip_tags(_addslashes($_POST['code']));
		$ip 		= strip_tags(_addslashes($_POST['ip']));
		$c_domain 	= strip_tags(_addslashes($_POST['domain']));

		$license = License::getBy(['license_code' => $code]);

		if (!filter_var($ip, FILTER_VALIDATE_IP) || 
			!filter_var($c_domain, FILTER_VALIDATE_URL))
		{
			Res::appendInvalidParams();
		}
		else if (!$license instanceof License)
		{
			Res::add('deactivate', 0);
			Res::add('message', 'This License code is not valid');
		}
		else
		{	
			try {
				PDOModel::getPDO()->beginTransaction();

				// check the domain using IP & Domain name.
				$domain = Domain::getBy(['IP' => $ip, 'domain_name' => $c_domain]);
				// check domain using just IP.
				//$domain = Domain::getBy(['IP' => $ip]);

				if ($license->isBanned())
				{
					Res::add('deactivate', 0);
					Res::add('message', 'This License code has been banned!');
				}
				else if ($ip == "127.0.0.1" || $ip == '::1' || $c_domain == 'localhost')
				{
					Res::add('deactivate', 1);
					Res::add('message', 'The License code has been deactivated successfully for this IP/domain.');
				}
				else if (!$domain instanceof Domain)
				{
					$product = $license->getProduct();
					$message = "You can't deactivate this license from this host IP/domain, Please try the deactivation from the last activation place from the some host IP & domain";
					
					if (is_object($product))
						$message .= ', if you can\'t please contact '.$product->name.' support at '.$product->email_support;

					Res::add('deactivate', 0);
					Res::add('message', $message);
					
				}
				else if (!$domain->isActive())
				{
					Res::add('deactivate', 0);
					Res::add('message', 'The License code is not active yet on this IP/domain!');	
				}
				else if ($license->deactivate($domain))
				{
					Res::add('deactivate', 1);
					Res::add('message', 'The License code has been deactivated successfully for this IP/domain.');
				}
				else
				{
					Res::add('deactivate', 0);
					Res::add('message', 'Somthing wrong! please try again or later!');
				}
				
				PDOModel::getPDO()->commit();
			} catch (\PDOException $e) {
				logger($e->getMessage());
				exit;
			}
		}
	}
}

?>