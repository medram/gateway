<?php

namespace MR4Web\Pattern;

use MR4Web\Pattern\AbstractGateway;

class StripeGateway extends AbstractGateway
{
	private $_handle;

	public function __construct()
	{
		// prepare a connection with a paypal app
		$this->_handle = '';
	}

	public function getHandle()
	{
		return $this->_handle;
	}

	public function createPayment()
	{
		// prepere & execute the payment

	}
}

?>