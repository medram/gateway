<?php
use MR4Web\Models\Plan;

echo "<!-- Analytics Code -->";
echo getConfig('thanks_page_analytics_code');

if (isset($plan) && $plan instanceof Plan)
{
	echo $plan->thanks_page_analytics_code;
}
?>
<div class="row py-5">
	<div class="col-md-12 text-center text-success">
		<span><i class="fa fa-check fa-5x"></i></span>
		<h1>Thank you for purchasing!</h1>
	</div>
</div>
<div class="row">
	<div class="container text-center">
		<span>The payment has been successfully done, And your invoice ID is :</span><br>
		<h2><code class="text-primary" style="border: 2px dashed #007bff; padding: 4px 9px; border-radius: 5px;"><?php echo $invoice->invoice_id ?></code></h2>
		<span>Please check your email inbox, if you received your product.</span><br>
		<span>For more information about the product, you could contact the product owner using this email :<br> <a href="mailto:<?php echo $product->email_support ?>"><?php echo $product->email_support ?></a></span><br>
		<span>If you get any issue like about receiving your product or payment, please feel free to contact us at:<br>
		<a href="mailto:<?php echo getConfig('email_sales_support'); ?>"><?php echo getConfig('email_sales_support'); ?></a></span>
	</div>
</div>
