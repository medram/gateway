<?php
require_once "dashboard_init.php";

use MR4Web\Models\Product;
use MR4Web\Models\User;

use MR4Web\Utils\View;
use MR4Web\Utils\Uploader;
use MR4Web\Utils\Dashboard;

$page = isset($_GET['page'])? $_GET['page'] : '';
$action = isset($_GET['a'])? $_GET['a'] : '';

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

			$product = new Product();
			$product->name = $p_name;
			$product->version = $p_version;
			$product->small_desc = $p_desc;
			$product->email_support = $email_support;
			
			try {
				$uploader = new Uploader([
					'fieldName'		=> 'product-file',
					'uploadsDir'	=> User::getUser()->getUserProductsPath(),
					'maxSize'		=> 200*1024, // 200MB.
					'allowedTypes' 	=> ['jpg', 'rar', 'zip'],
				]);
				
				if ($uploader->doUpload())
				{
					$info = $uploader->getInfo(); // array of info
					echo '<pre>';
					print_r($info);
					echo '</pre>';
				}
			} catch (Uploader\Exception $e) {
				die($e->getMessage());
			}

			if ($product->save())
			{
				// redirect to products list
				//header("location: products.php");
				exit;
			}
			else
				$msg['err'] = 'Something wrong!';
		}
	}

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
			$product->version = $p_version;
			$product->small_desc = $p_desc;
			$product->email_support = $email_support;
			
			if ($product->save())
			{
				// redirect
				header('location: products.php');
				exit;
			}
			else
				$msg['err'] = 'Something was wrong, please try again!';
		}
	}

	$data['product'] = $product;
	$data['dash_title'] = "Edit Product";
	Dashboard::Render('add_product', $data);	
}
else
{
	$products = Product::getAll(['id', 'DESC']);
	$resultNumber = count($products);

	if (is_array($products))
		$data['products'] = $products;
	else
		$data['products'] = [];

	$data['dash_title'] = "Products ({$resultNumber})";
	Dashboard::Render('products', $data);
}

?>
