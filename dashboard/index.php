<?php
require_once "dashboard_init.php";

use MR4Web\Utils\View;
use MR4Web\Utils\Dashboard;

use MR4Web\Models\Transaction;
use MR4Web\Models\Customer;
use MR4Web\Models\Coupon;
use MR4Web\Models\License;
use MR4Web\Models\Product;

/*
	- show data per days/weeks/months
	- Money: paypal fee/gross/earned 
	- All Customers/Transactions
	- Coupons: Used/All
	- Licenses: Used/All
	
*/
 
// time : all/week/month/day

$time = isset($_GET['time']) ? $_GET['time'] : 'all'; 


// --------- calculate: fee/earned/gross ---------
if ($time == "today")
	$transactions = Transaction::getAllBy(" WHERE `created` > \"".date('Y-m-d H:i:s', time()-86400)."\""); // today
else if ($time == 'last-week')
	$transactions = Transaction::getAllBy(" WHERE `created` > \"".date('Y-m-d H:i:s', time()-604800)."\""); // last 7 days
else if ($time == 'last-month')
	$transactions = Transaction::getAllBy(" WHERE `created` > \"".date('Y-m-d H:i:s', time()-2592000)."\""); // last 30 days
else
	$transactions = Transaction::getAll();

$fee = 0;
$earned = 0;
$gross = 0;

if (count($transactions))
{
	foreach ($transactions as $tr)
	{
		$fee += $tr->Tr_fee;
		$earned += ($tr->amount - $tr->Tr_fee);
		$gross += $tr->amount;
	}
}

$data['tr_total'] = count($transactions);
$data['tr_fee'] = $fee;
$data['tr_earned'] = $earned;
$data['tr_gross'] = $gross;

// --------- Total customers ---------
if ($time == "today")
	$customers = Customer::getAllBy(" WHERE `created` > \"".date('Y-m-d H:i:s', time()-86400)."\"");
else if ($time == "last-week")
	$customers = Customer::getAllBy(" WHERE `created` > \"".date('Y-m-d H:i:s', time()-604800)."\"");
else if ($time == "last-month")
	$customers = Customer::getAllBy(" WHERE `created` > \"".date('Y-m-d H:i:s', time()-2592000)."\"");
else
	$customers = Customer::getAll();

$totalCustomers = 0;

if (count($customers))
	$totalCustomers = count($customers);

$data['customers_total'] = $totalCustomers;

// --------- Licenses ---------
if ($time == "today")
	$licenses = License::getAllBy(" WHERE `created` > \"".date('Y-m-d H:i:s', time()-86400)."\"");
else if ($time == "last-week")
	$licenses = License::getAllBy(" WHERE `created` > \"".date('Y-m-d H:i:s', time()-604800)."\"");
else if ($time == "last-month")
	$licenses = License::getAllBy(" WHERE `created` > \"".date('Y-m-d H:i:s', time()-2592000)."\"");
else
	$licenses = License::getAll();

$used = 0;
$max = 0;
$totalLicenses = 0;
$banned = 0;

if (count($licenses))
{
	$totalLicenses = count($licenses);
	foreach ($licenses as $license)
	{
		$used += $license->activation_num;
		$max += $license->activation_max;
		$banned += $license->banned;
	}

	$data['licenses_used'] = $used;
	$data['licenses_max'] = $max;
	$data['licenses_banned'] = $banned;
}
$data['licenses_total'] = $totalLicenses;

// --------- Coupons ---------
if ($time == "today")
	$coupons = Coupon::getAllBy(" WHERE `created` > \"".date('Y-m-d H:i:s', time()-86400)."\"");
else if ($time == "last-week")
	$coupons = Coupon::getAllBy(" WHERE `created` > \"".date('Y-m-d H:i:s', time()-604800)."\"");
else if ($time == "last-month")
	$coupons = Coupon::getAllBy(" WHERE `created` > \"".date('Y-m-d H:i:s', time()-2592000)."\"");
else
	$coupons = Coupon::getAll();

$total = 0;
$active = 0;
$inactive = 0;
$expired = 0;

$validTime = 0;
$totalValidTime = 0; 

if (count($coupons))
{
	$total = count($coupons);
	foreach ($coupons as $coupon)
	{
		if ($coupon->status)
			++$active;
		else
			++$inactive;

		if ($coupon->expired)
			++$expired;
		
		$totalValidTime += $coupon->total_valid_time;
		$validTime += $coupon->valid_time;
	}

	$data['coupon_active'] = $active;
	$data['coupon_inactive'] = $inactive;
	$data['coupon_expired'] = $expired;
	$data['coupon_valid_time'] = $validTime;
	$data['coupon_total_valid_time'] = $totalValidTime;
}
$data['coupon_total'] = $total;

// -------- Products --------
if ($time == "today")
	$products = Product::getAllBy(" WHERE `created` > \"".date('Y-m-d H:i:s', time()-86400)."\"", ['id', 'DESC']);
else if ($time == "last-week")
	$products = Product::getAllBy(" WHERE `created` > \"".date('Y-m-d H:i:s', time()-604800)."\"", ['id', 'DESC']);
else if ($time == "last-month")
	$products = Product::getAllBy(" WHERE `created` > \"".date('Y-m-d H:i:s', time()-2592000)."\"", ['id', 'DESC']);
else
	$products = Product::getAll(['id', 'DESC']);

// to show all products
//$products = Product::getAll(['id', 'DESC']);

$totalProducts = 0;
$totalPlans = 0;
$data['products'] = [];

if (count($products))
{
	$totalProducts = count($products);

	foreach ($products as $product)
	{
		// set product
		$pr = array(
			'name' => $product->name,
			'version' => $product->version,
			'email_support' => $product->email_support,
			'created' => $product->created,
			);

		// calculate licenses
		if ($time == "today")
			$licenses = $product->getLicensesWhere(" WHERE `created` > \"".date('Y-m-d H:i:s', time()-86400)."\"");
		else if ($time == "last-week")
			$licenses = $product->getLicensesWhere(" WHERE `created` > \"".date('Y-m-d H:i:s', time()-604800)."\"");
		else if ($time == "last-month")
			$licenses = $product->getLicensesWhere(" WHERE `created` > \"".date('Y-m-d H:i:s', time()-2592000)."\"");
		else
			$licenses = $product->getLicenses();

		$l = [];
		$used = 0;
		$banned = 0;
		
		if (count($licenses))
		{
			foreach ($licenses as $license)
			{
				// just count the used licenses
				if ($license->activation_num)
					++$used;
				if ($license->banned)
					++$banned;
			}
		}

		$l = array(
			'total' => count($licenses),
			'used' => $used,
			'banned' => $banned,
		);

		// calculate profit/product 
		if ($time == "today")
			$plans = $product->getPlansWhere(" WHERE `created` > \"".date('Y-m-d H:i:s', time()-86400)."\"");
		else if ($time == "last-week")
			$plans = $product->getPlansWhere(" WHERE `created` > \"".date('Y-m-d H:i:s', time()-604800)."\"");
		else if ($time == "last-month")
			$plans = $product->getPlansWhere(" WHERE `created` > \"".date('Y-m-d H:i:s', time()-2592000)."\"");
		else
			$plans = $product->getPlans();
		
		$transactions = [];
		$profit = 0;
		$gross = 0;

		if (count($plans))
		{
			$totalPlans += count($plans);
			foreach ($plans as $plan)
			{
				foreach ($plan->getInvoices() as $invoice)
				{
					// merge the transaction to the array.
					$transaction = $invoice->getTransaction();
					if ($transaction instanceof Transaction)
						$transactions[] = $transaction;
				}
			}
		}

		if (count($transactions))
		{
			foreach ($transactions as $tr)
			{
				//$fee += $tr->Tr_fee;
				$profit += ($tr->amount - $tr->Tr_fee);
				$gross += $tr->amount;
			}
		}

		$data['products_rows'][] = ['product' => $pr,'licenses' => $l, 'gross' => $gross, 'profit' => $profit];
	}


}

$data['products_total'] = $totalProducts;
$data['plans_total'] = $totalPlans;

$data['dash_title'] = 'Dashboard';
Dashboard::Render('index', $data);

?>