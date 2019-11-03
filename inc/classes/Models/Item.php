<?php

namespace MR4Web\Models;

use MR4Web\Models\PDOModel;
use MR4Web\Models\Invoice;

class Item extends PDOModel {

	public function __construct($data = NULL)
	{
		$schema = [
			'id'				=> \PDO::PARAM_INT,
			'title'				=> \PDO::PARAM_STR,
			'quantity'			=> \PDO::PARAM_INT,
			'price'				=> \PDO::PARAM_STR,
			'invoices_id'		=> \PDO::PARAM_INT
		];
		parent::__construct($schema, $data);
	}

	public function getInvoice()
	{
		return Invoice::get($this->invoice_id);
	}
}

?>