<?php

namespace MR4Web\Utils;

use MR4Web\Models\Plan;
use MR4Web\Models\Coupon;

class Total {

	private $_prices;
	private $_dicount;
	private $_totalPrice = 0;
	private $_totalOldPrice = 0;
	private $_savedMoney = 0;
	private $_usedCoupon = FALSE;
	private $_coupon;
	private $_plan;

	public function __construct()
	{
		$this->_prices = array();
		$this->_dicount = array('value' => 0, 'type' => ''); // types are $, %
	}

	public function setPlan(Plan &$plan)
	{
		$this->_prices[] = [$plan->price, $plan->old_price];
		$this->_plan = $plan;
	}

	public function getPlan()
	{
		return $this->_plan;
	}

	public function setCoupon(Coupon &$coupon, $force = false)
	{
		if (!$force)
		{
			if (!$coupon->isValidToUse() || !$this->_plan->supportCoupon($coupon))
				return false;
		} else if (!$this->_plan->supportCoupon($coupon))
			return false;
		
		$this->_coupon = $coupon;
		$this->_usedCoupon = TRUE;
		$this->_dicount['value'] = $coupon->value;
		$this->_dicount['type'] = $coupon->type;
		return true;
	}

	public function forceApplyCoupon(Coupon $coupon)
	{
		// we set true to force the plan to use the coupon, even was expired.
		return $this->setCoupon($coupon, true);
	}

	public function calculate()
	{
		//print_r($this->_prices);
		foreach ($this->_prices as $price)
		{
			$this->_totalPrice += $price[0];
			$this->_totalOldPrice += $price[1];
		}

		if ($this->_totalOldPrice)
			$price = $this->_totalOldPrice;
		else
			$price = $this->_totalPrice;

		if ($this->_dicount['type'] === '$')
		{
			$this->_totalPrice = $price - $this->_dicount['value'];
			//echo $price.' - '.$this->_dicount['value'];
		}
		else if ($this->_dicount['type'] === '%')
		{
			$this->_totalPrice = $price - $price * $this->_dicount['value'] / 100;
			//echo $price.' - '.$price.' * '.$this->_dicount['value'].' / 100';
		}

		// saved money
		if ($this->_totalOldPrice)
			$this->_savedMoney = $this->_totalOldPrice - $this->_totalPrice;
		else
			$this->_savedMoney = $price * $this->_dicount['value'] / 100;
	}

	public function getTotalPrice()
	{
		return roundPrice($this->_totalPrice);
	}

	public function getTotalOldPrice()
	{
		return roundPrice($this->_totalOldPrice);
	}

	public function getSavedMoney()
	{
		return roundPrice($this->_savedMoney);
	}

	public function usedCoupon()
	{
		return $this->_usedCoupon;
	}

	public function getCoupon()
	{
		return $this->_coupon;
	}
}

?>