<?php

namespace MR4Web\Pattern;

use MR4Web\Pattern\ProductGateway;

abstract class AbstractGateway
{
	protected $_product;
	protected $_returnUrl;
	protected $_cancelUrl;

	public final function setProduct(ProductGateway $product)
	{
		$this->_product = $product;
	}

	public final function setReturnUrl($url)
	{
		$this->_returnUrl = $url;
	}

	public final function setCancelUrl($url)
	{
		$this->_cancelUrl = $url;
	}

	abstract function createPayment();
}

?>