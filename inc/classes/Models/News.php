<?php

namespace MR4Web\Models;

use MR4Web\Models\Product;

class News extends PDOModel {

	public function __construct($data = NULL)
	{
		$schema = [
			'id'			=> \PDO::PARAM_INT,
			'title'			=> \PDO::PARAM_STR,
			'description'	=> \PDO::PARAM_STR,
			'image_URL'		=> \PDO::PARAM_STR,
			'news_URL'		=> \PDO::PARAM_STR,
			'products_id'	=> \PDO::PARAM_INT,
			'created'		=> \PDO::PARAM_STR
		];
		parent::__construct($schema, $data);
	}

	public function getProduct()
	{
		return Product::get($this->products_id);
	}
}

?>