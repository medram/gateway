<?php
require_once "dashboard_init.php";

use MR4Web\Models\Product;
use MR4Web\Models\Customer;
use MR4Web\Models\User;
use MR4Web\Models\File;
use MR4Web\Models\PDOModel;

use MR4Web\Utils\View;
use MR4Web\Utils\Uploader;
use MR4Web\Utils\Uploader as Up;
use MR4Web\Utils\Dashboard;

$page = isset($_GET['page'])? $_GET['page'] : '';
$action = isset($_GET['a'])? $_GET['a'] : '';
$customerID = isset($_GET['cu'])? $_GET['cu'] : '';
$msg = [];

if ($action == 'delete')
{
	if (Product::deleteProduct(intval($_GET['id'])))
	{
		header('location: products.php');
		exit;
	}
}

// add a new product
if ($page == 'add')
{
	/**
	* @TODO :  this section will be available for edit just for the User or the Admin
	*/


	if (isset($_POST['saveProduct']))
	{
		if ($_POST['name'] == '' || $_POST['version'] == '' || $_POST['desc'] == '' || 
			$_POST['email_support'] == '')
		{
			$msg['err'] = 'Please fill out all fields below!';
		}
		else if (!filter_var($_POST['email_support'], FILTER_VALIDATE_EMAIL))
		{
			$msg['err'] = 'Oops! Email Support is not valid!';
		}
		else if (!isset($_FILES['product-file']['name']) || 
			($_FILES['product-file']['name'] == '' || $_FILES['product-file']['name'][0] == ''))
		{
			$msg['err'] = 'Please choose product file(s) to upload!';
		}
		else
		{
			$p_name 	= _addslashes(strip_tags($_POST['name']));
			$p_version 	= _addslashes(strip_tags($_POST['version']));
			$p_desc 	= _addslashes(strip_tags($_POST['desc']));
			$email_support 	= strtolower(_addslashes(strip_tags($_POST['email_support'])));

			$product = new Product();
			$product->users_id = User::getUser()->id;
			$product->name = $p_name;
			$product->version = $p_version;
			$product->small_desc = $p_desc;
			$product->email_support = $email_support;

			try {
				PDOModel::getPDO()->beginTransaction();
				
				$uploader = new Uploader([
					'fieldName'		=> 'product-file',
					'uploadsDir'	=> User::getUser()->getUserProductsPath(),
					'maxSize'		=> getConfig('plan_files_max_size'), // Default size 200MB.
					'allowedTypes' 	=> explode(',', getConfig('plan_files_allowed_type')),
				]);
				
				if ($uploader->doUpload())
				{
					$infos = $uploader->getInfo(); // array of info
					/*
					echo '<pre>';
					print_r($infos);
					echo '</pre>';
					*/
					
					if ($product->save())
					{
						$productID = Product::getLastInsertId();
						foreach ($infos as $info)
						{
							$file = new File();
							//$file->name = $product->name.'_'.$product->version;
							$file->name = Up\File::filterName($info['fileName']);
							$file->path = $info['path'];
							$file->size = $info['size'];
							$file->products_id = $productID;
							$file->save();
						}
					}
					else
					{
						$msg['err'] = 'Something wrong!';
					}
				}
				PDOModel::getPDO()->commit();
				//$msg['ok'] = 'Added Successfully.';
				// redirect to products list
				header("location: products.php");
				exit;
			} catch (Uploader\Exception $e) {
				PDOModel::getPDO()->rollBack();
				//if (DEBUG)
				$msg['err'] = substr($e->getMessage(), strpos($e->getMessage(), ':')+1);
			}
		}
	}

	$data['msg'] = $msg;
	$data['dash_title'] = "Add Product";
	Dashboard::Render('add_product', $data);
}
else if ($page == 'edit')
{
	$id = intval($_GET['id']);

	$product = Product::get($id);

	if (!$product instanceof Product)
	{
		// redirect
		header('location: products.php');
		exit;
	}

	if (isset($_POST['saveProduct']))
	{
		if ($_POST['name'] == '' || $_POST['version'] == '' || $_POST['desc'] == '' || $_POST['email_support'] == '')
		{
			$msg['err'] = 'Please fill out all fields below!';
		}
		else if (!filter_var($_POST['email_support'], FILTER_VALIDATE_EMAIL))
		{
			$msg['err'] = 'Oops! Email Support is not valid!';
		}
		else
		{
			$p_name 	= _addslashes(strip_tags($_POST['name']));
			$p_version 	= _addslashes(strip_tags($_POST['version']));
			$p_desc 	= _addslashes(strip_tags($_POST['desc']));
			$email_support 	= strtolower(_addslashes(strip_tags($_POST['email_support'])));

			$product->name = $p_name;
			$product->users_id = User::getUser()->id;
			$product->version = $p_version;
			$product->small_desc = $p_desc;
			$product->email_support = $email_support;
			
			try {
				PDOModel::getPDO()->beginTransaction();
					
				if ($product->save())
				{
					if (isset($_FILES['product-file']['name']) && 
						((!is_array($_FILES['product-file']['name']) && $_FILES['product-file']['name'] != '') || $_FILES['product-file']['name'][0] != ''))
					{
						$uploader = new Uploader([
							'fieldName'		=> 'product-file',
							'uploadsDir'	=> User::getUser()->getUserProductsPath(),
							'maxSize'		=> getConfig('plan_files_max_size'), // Default size 200MB.
							'allowedTypes' 	=> explode(',', getConfig('plan_files_allowed_type')),
						]);

						if ($uploader->doUpload())
						{
							$infos = $uploader->getInfo(); // array of info
							
							/*
							echo '<pre>';
							print_r($infos);
							echo '</pre>';
							*/
							
							$productID = $product->id;

							// delete old files from Database & HDD
							$product->deleteFiles($productID);

							// insert new files to database & HDD
							foreach ($infos as $info)
							{
								$file = new File();
								//$file->name = $product->name.'_'.$product->version;
								$file->name = Up\File::filterName($info['fileName']);
								$file->path = $info['path'];
								$file->size = $info['size'];
								$file->products_id = $productID;
								$file->save();
							}
						}
						else
						{
							$msg['err'] = 'Something wrong, please try again later!';
						}
					}
				}
				else
				{
					$msg['err'] = 'Something was wrong, please try again!';
				}

				PDOModel::getPDO()->commit();
				//$msg['ok'] = 'Added Successfully.';
				// redirect to products list
				header("location: products.php");
				exit;
			} catch (Uploader\Exception $e) {
				PDOModel::getPDO()->rollBack();
				//if (DEBUG)
				$msg['err'] = substr($e->getMessage(), strpos($e->getMessage(), ':')+1);
			}
		}
	}

	$data['msg'] = $msg;
	$data['product'] = $product;
	$data['dash_title'] = "Edit Product";
	Dashboard::Render('add_product', $data);	
}
else
{
	$products = [];
	$customer = Customer::get($customerID);
	$mode = 0;

	if ($customerID && $customer instanceof Customer)
	{
		$data['customer'] = $customer;
		$products = $customer->getProducts();
		$mode = 1;
		if (!count($products))
			$msg['err'] = "No products for this customer!";
	}
	else
		$products = Product::getAllBy(['users_id' => User::getUser()->id], ['id', 'DESC']);

	$resultNumber = count($products);

	if (is_array($products))
		$data['products'] = $products;
	else
		$data['products'] = [];

	$data['mode'] = $mode;
	if ($mode == 0)
		$data['dash_title'] = "Products ({$resultNumber})";
	else
		$data['dash_title'] = "Customer's Products ({$resultNumber})";

	Dashboard::Render('products', $data);
}

?>
