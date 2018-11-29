<?php
use MR4Web\Models\Transaction;
use MR4Web\Models\Plan;
use MR4Web\Models\Coupon;

if (isset($msg['err']))
{
	echo "<div class='alert alert-warning'>".$msg['err']."</div>";
}
else if (isset($msg['ok']))
{
	echo "<div class='alert alert-success'>".$msg['err']."</div>";
}
?>

<?php if (isset($invoices)): ?>
<table class="table table-sm table-striped table-hover resendEmail" data-customer="<?php echo $customer->id ?>">
	<thead>
		<tr>
			<th>ID</th>
			<th>Invoice Code</th>
			<th>Transaction ID</th>
			<th>Plan ID</th>
			<th>Coupon ID</th>
			<th>Created</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
 		<?php foreach ($invoices as $invoice):
 			$transaction = Transaction::get($invoice->transactions_id);
 			$coupon = Coupon::get($invoice->coupons_id);
 			$plan = Plan::get($invoice->plans_id);
 		?>
		<tr>
			<td><?php echo $invoice->id ?></td>
			<td><?php echo '<code class="text-primary">'.$invoice->invoice_id.'</code>' ?></td>
			<td><?php echo $invoice->transactions_id ?></td>
			<td><?php echo $plan->id.' <small>('.$plan->name.')</small>' ?></td>
			<td><?php echo $coupon instanceof Coupon? $coupon->id." (".$coupon->code.")" : '---' ?></td>
			<td><?php echo $invoice->created ?></td>
			<td>
				<button class="btn btn-warning btn-sm send" data-invoice="<?php echo $invoice->id ?>"><i class="fa fa-paper-plane"></i> Resend Product via email</button>
			</td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>
<?php endif; ?>