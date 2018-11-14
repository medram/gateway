<?php

require_once "init.php";

use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;

use MR4Web\Models\Customer;
use MR4Web\Models\Coupon;
use MR4Web\Models\Plan;
use MR4Web\Models\Payer;
use MR4Web\Models\Invoice;
use MR4Web\Models\PDOModel;
use MR4Web\Models\Transaction;

if (!isset($_GET['cu'], $_GET['pl']) || $_GET['cu'] == '' || $_GET['pl'] == '')
{
	// redirect the page
	exit;
}
if (!isset($_GET['success'], $_GET['paymentId'], $_GET['PayerID'], $_GET['pm']) or $_GET['success'] == false)
{
	// redirect to somewhere else.
	echo 'the payment wasn\'t complated!';
	exit;
}

do_action('before_payment');

$paypalGateway = new MR4Web\Pattern\PaypalGateway();
$paypal = $paypalGateway->getHandle();

$paymentId = $_GET['paymentId'];
$payerId = $_GET['PayerID'];

$payment = Payment::get($paymentId, $paypal);

$execute = new PaymentExecution();
$execute->setPayerId($payerId);

try {
	$result = $payment->execute($execute, $paypal);
} catch(\Exeption $e) {
	//die($e->getData());
}

do_action('after_payment');

//print_r($result);
/*
	transaction:
	- transaction_id
	- payer_id
	- amount
	- quantity
	- transaction_fee

	payer:
	- fname
	- lname
	- email
	- payer_id
	- country_code

*/

// Check if the Payment Done.
if ($payment->getState() === 'approved')
{	
	PDOModel::getPDO()->beginTransaction();
	try {

		$co = isset($_GET['co'])? _addslashes(strip_tags(base64_decode($_GET['co']))) : '' ; // coupon id
		$cu = intval($_GET['cu']); // customer id
		$pl = intval($_GET['pl']); // plan id
		$pm = intval($_GET['pm']); // payment method

		$coupon = Coupon::getBy(['code' => $co]);
		$plan = Plan::get($pl);
		$customer = Customer::get($cu);

		// expire the coupon if exists.
		if ($coupon instanceof Coupon)
		{
			if ($coupon->expired != 1)
			{		
				$coupon->valid_time++;
				
				// expire the coupon here.
				if ($coupon->total_valid_time == $coupon->valid_time)
				{
					$coupon->expired = 1;
					$coupon->status = 0;
				}
				
				$coupon->save();
			}
			unset($_SESSION['coupon']);
		}

		$oldPayer = Payer::getBy(['email' => $payment->getPayer()->payer_info->email]);
		$payer = ($oldPayer instanceof Payer)? $oldPayer : new Payer();
		$payer->fname = $payment->getPayer()->payer_info->first_name;
		$payer->lname = $payment->getPayer()->payer_info->last_name;
		$payer->email = $payment->getPayer()->payer_info->email;
		$payer->payer_id = $payment->getPayer()->payer_info->payer_id;
		$payer->country_code = $payment->getPayer()->payer_info->country_code;

		$payer->save();

		$tr = new Transaction();
		$tr->PM_id = $pm;

		$tr->customers_id = $customer->id; //$customer->id
		$tr->payers_id = ($oldPayer instanceof Payer)? $payer->id : $payer::getLastInsertId();
		$tr->Tr_ID = $payment->getId();
		$tr->Tr_fee = $payment->getTransactions()[0]->related_resources[0]->sale->transaction_fee->value;
		$tr->amount = $payment->getTransactions()[0]->amount->total;
		$tr->quantity = $payment->getTransactions()[0]->item_list->items[0]->quantity; // quantity just for the first product / service
		$tr->currency = $payment->getTransactions()[0]->amount->currency;
		$tr->state = $payment->getTransactions()[0]->related_resources[0]->sale->state;

		$tr->save();

		$invoice = new Invoice();
		$invoice->invoice_id = _addslashes(strip_tages($_SESSION['invoiceId']));
		$invoice->transactions_id = $tr::getLastInsertId();
		$invoice->customers_id = $customer->id;
		$invoice->plans_id = $plan->id;

		// coupon not used*/
		if ($coupon instanceof Coupon)
			$invoice->coupons_id = $coupon->id;
		
		$invoice->save();

		PDOModel::getPDO()->commit();
	} catch (\PDOException $e) {
		//die($e->getMessage());
		PDOModel::getPDO()->rollBack();
	}

	do_action('after_payment_done_successfully', $invoice);

	$_SESSION['invoice_id'] = $invoice::getLastInsertId();

	// redirect to "thank you" page.
	//echo 'Payment done successfully';
	header('location: thank-you.php');
	exit;
}
else
{
	do_action('after_payment_failed');
	// Payment not done.
	// redirect
}


/*echo $payment->getId().'<br>';
echo $payment->getState().'<br>';
echo $payment->getPayer()->status.'<br>';
echo '---------------------------------------------------------------------';
print_r($payment);
echo '</pre>';
*/
?>