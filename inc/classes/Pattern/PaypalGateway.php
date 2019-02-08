<?php

namespace MR4Web\Pattern;

use MR4Web\Pattern\AbstractGateway;

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Details;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;

class PaypalGateway extends AbstractGateway
{
	private $_handle;

	public function __construct()
	{
		// prepare a connection with a paypal app
		if ((bool)getConfig('sandbox'))
		{	
			$this->_handle = new ApiContext(new OAuthTokenCredential(
					getConfig('paypal_sandbox_public_key'),
					getConfig('paypal_sandbox_secret_key')
				));
		}
		else
		{
			$this->_handle = new ApiContext(new OAuthTokenCredential(
						getConfig('paypal_public_key'),
						getConfig('paypal_secret_key')
					));
		}
	}

	public function getHandle()
	{
		return $this->_handle;
	}

	public function createPayment()
	{
		// prepere & execute the payment
		$payer = new Payer();
		$payer->setPaymentMethod('paypal');

		$item = new Item();
		$item->setName($this->_product->getName())
			->setCurrency('USD')
			->setQuantity($this->_product->getQuantity())
			->setPrice($this->_product->getPrice());

		/*
		$item2 = new Item();
		$item2->setName($product2)
			->setCurrency('USD')
			->setQuantity($quant2)
			->setPrice($price2);
		*/
		$itemList = new ItemList();
		$itemList->setItems(array($item));
		//$itemList->setItems([$item1, $item2, $item3]);

		$details = new Details();
		$details->setSubTotal($this->_product->getSubTotal());
		/*$details->setShipping($this->_product->getShipping())
			->setTax($this->_product->getTax());
		*/

		$amount = new Amount();
		$amount->setCurrency('USD')
			->setDetails($details)
			->setTotal($this->_product->getTotal());

/*		echo $this->_product->getPrice().'<br>';
		echo $this->_product->getSubTotal().'<br>';
		echo $this->_product->getTotal().'<br>';*/

		$Transaction = new Transaction();
		$Transaction->setAmount($amount)
			->setItemList($itemList)
			->setDescription('Take Action NOW!')
			->setInvoiceNumber($this->_product->getInvoiceId());

		$RedirectUrls = new RedirectUrls();
		$RedirectUrls->setReturnUrl($this->_returnUrl)
			->setCancelUrl($this->_cancelUrl);

		$payment = new Payment();
		$payment->setIntent('sale')
			->setPayer($payer)
			->setRedirectUrls($RedirectUrls)
			->setTransactions(array($Transaction));

		try {
			$payment->create($this->_handle);
			$approvalUrl = $payment->getApprovalLink();
			//exit($approvalUrl);
			header("location: ".$approvalUrl);
			exit();
		}
		catch (\Exception $e)
		{
			echo '<pre>';
			echo $e->getMessage().'<br>';
			print_r($e->getData());
			echo '</pre>';
		}
	}
}

?>