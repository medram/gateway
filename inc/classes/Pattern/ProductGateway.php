<?php

namespace MR4Web\Pattern;

class ProductGateway
{
	protected $_name;
	protected $_desc;
	protected $_price = 0;
	protected $_quantity = 1;
	protected $_shipping = 0;
	protected $_tax = 0;
	protected $_getInvoiceId = '';

	public final function setName($name)
	{
		$this->_name = $name;
	}

	public function getName()
	{
		return $this->_name;
	}

	public final function setDesc($desc)
	{
		$this->_desc = $desc;
	}

	public function getDesc()
	{
		return $this->_desc;
	}

	public final function setPrice($price)
	{
		if (is_numeric($price))
			$this->_price = $price;
	}

	public function getPrice()
	{
		return $this->_price;
	}

	public final function setShipping($shipping)
	{
		if (is_numeric($shipping))
			$this->_shipping = $shipping;
	}

	public function getShipping()
	{
		return $this->_shipping;
	}

	public final function setTax($tax)
	{
		if (is_numeric($tax))
			$this->_tax = $tax;
	}

	public function getTax()
	{
		return $this->_tax;
	}

	public function setQuantity($quantity)
	{
		if (is_numeric($quantity))
			$this->_quantity = $quantity;
	}

	public function getQuantity()
	{
		return $this->_quantity;
	}	

	public function getSubTotal()
	{
		return $this->_price * $this->_quantity;
	}

	public function getTotal()
	{
		return $this->getSubTotal() + $this->_tax + $this->_shipping;
	}

	public function setInvoiceId($id)
	{
		return $this->_getInvoiceId = $id;
	}

	public function getInvoiceId()
	{
		return $this->_getInvoiceId;
	}
}

?>