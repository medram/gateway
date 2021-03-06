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

use PayPal\Api\Presentation;
use PayPal\Api\WebProfile;
use PayPal\Api\InputFields;

use PayPal\Exception\PayPalConnectionException;


class PaypalGateway extends AbstractGateway
{
	private $_handle;
	private $profileID;

	public function __construct()
	{
		// prepare a connection with a paypal app
		if ((bool)getConfig('sandbox'))
		{
			$this->_handle = new ApiContext(new OAuthTokenCredential(
					getConfig('paypal_sandbox_public_key'),
					getConfig('paypal_sandbox_secret_key')
				));
            $this->_handle->setConfig([
                'mode' => 'sandbox'
            ]);
        }
		else
		{
			$this->_handle = new ApiContext(new OAuthTokenCredential(
						getConfig('paypal_public_key'),
						getConfig('paypal_secret_key')
					));
            $this->_handle->setConfig([
                'mode' => 'live'
            ]);
		}
	}

	public function getHandle()
	{
		return $this->_handle;
	}

	public function createWebProfile()
	{
		// Create the WebProfile
		$presentation = new Presentation();
		$presentation->setBrandName(getConfig('site_name'))
			#->setLogoImage("http://www.yeowza.com/favico.ico")
		    ->setLocaleCode("US");
		$inputFields = new InputFields();
		$inputFields->setAllowNote(true)
		    ->setNoShipping(1)
		    ->setAddressOverride(0);
		$webProfile = new WebProfile();
		$webProfile->setName(getConfig('site_name') .'_'. uniqid())
		    ->setPresentation($presentation)
		    ->setInputFields($inputFields);
		try {
		    $createdProfile = $webProfile->create($this->_handle);
		    $createdProfileID = json_decode($createdProfile);
		    $profileid = $createdProfileID->id;
		    $this->profileID = $profileid;
		    return $profileid;
		} catch(PayPalConnectionException $pce) {
		    if (DEBUG)
		    {
		    	echo '<pre>',print_r(json_decode($pce->getData())),"</pre>";
		    	exit;
		    }
		}
	}

	public function createPayment()
	{
		# create a custom profile id.
		$this->createWebProfile();

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
			->setDescription('Your Items:')
			->setInvoiceNumber($this->_product->getInvoiceId());

		$RedirectUrls = new RedirectUrls();
		$RedirectUrls->setReturnUrl($this->_returnUrl)
			->setCancelUrl($this->_cancelUrl);

		$payment = new Payment();
		$payment->setExperienceProfileId($this->profileID)
			->setIntent('sale')
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
		catch (PayPalConnectionException $e)
		{
			if (DEBUG)
			{
		    	echo '<pre>',print_r(json_decode($pce->getData())),"</pre>";
		    	exit;
			}
		}
	}
}

?>
