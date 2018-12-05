<?php

require_once "api_init.php";

use MR4Web\Models\License;
use MR4Web\Models\Product;
use MR4Web\Models\Feature;
use MR4Web\Models\Update;

/*
// we will resceive this
{
	"check": "update/news/all",
	"license": "54sdf4dfg5dsf4cxgv87sdf132d1cvf3sd21",
	"IP": "192.168.1.1",
	"product_version": ""
}
*/

/*
// we will send this
{
	"status": true,
	"news": [
		{"id": 3, "title": "this is a title"...},
		{}
	],
	"software": {
		"updates": {

			"id": 11,
			"paid": false,
			"download_url": "http://...",
		},
		"features": {...}
		"product": {
			
		}
	}
}
*/

$check = isset($_POST['check'])? strtolower($_POST['check']) : '';
$res = [];

if ($check == 'all')
{
	$licenseCode = isset($_POST['license'])? $_POST['license'] : 0;
	$license = License::getBy(['license_code' => $licenseCode]);
	$IP = isset($_POST['IP'])? $_POST['IP'] : '';
	$version = isset($_POST['p_version'])? $_POST['p_version'] : 0;

	if (!$license instanceof License || $license->isBanned())
	{
		header('HTTP/1.1 400 Bad Request');
		exit;
	}
	else
	{
		$product = $license->getProduct();

		if (version_compare($product->version, $version, '<='))
		{
			header("HTTP/1.1 404 Not Found");
		}
		else
		{
			$update = $product->getLastUpdate();
			$news = $product->getNews();

			// set status connection.
			$res['status'] = 1;

			// set news here
			foreach ($news as $n)
			{
				$res['news'][] = [
					'id' 			=> $n->id,
					'title' 		=> $n->title,
					'description' 	=> $n->description,
					'image_URL' 	=> $n->image_URL,
					'news_URL' 		=> $n->news_URL,
					'created' 		=> $n->created,
					'products_id' 	=> $n->products_id
				];
			}

			$res['software']['product'] = [
				'id' 			=> $product->id,
				'name' 			=> $product->name,
				'version' 		=> $product->version,
				'small_desc'	=> $product->small_desc,
				'email_support' => $product->email_support,
				'created' 		=> $product->created
			];

			if ($update instanceof Update)
			{
				// set software.
				$res['software']['update'] = [
					'id' 			=> $update->id,
					'paid' 			=> $update->paid,
					'download_url' 	=> $update->download_url,
					'created' 		=> $update->created,
					'products_id' 	=> $update->products_id,
					'plans_id' 		=> $update->plans_id,
				];
		
				$features = $update->getFeatures();
				$featuresFormat = [];

				if (count($features) && $features[0] instanceof Feature)
				{
					foreach ($features as $f)
					{
						//$featuresFormat[]['desc'] = $f->desc; 
						$res['software']['features'][] = ['desc' => $f->desc];
					}
				}
			}
		}
	}
}
else
{
	header('HTTP/1.1 400 Bad Request');
	exit;
}

header("Content-Type: application/json");
echo json_encode($res);

//logFile(print_r($_POST, 1));

?>