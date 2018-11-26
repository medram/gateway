<?php
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
<table class="table table-sm table-striped table-hover">
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
 		<?php foreach ($invoices as $invoice): ?>
		<tr>
			<td><?php echo $invoice->id ?></td>
			<td><?php echo '<code class="text-primary">'.$invoice->invoice_id.'</code>' ?></td>
			<td><?php echo $invoice->transactions_id ?></td>
			<td><?php echo $invoice->plans_id ?></td>
			<td><?php echo $invoice->coupons_id == ''? '---' : $invoice->coupons_id ?></td>
			<td><?php echo $invoice->created ?></td>
			<td>
				<a href="send-to-customer.php?a=sendEmail&cu=<?php echo $customer->id ?>&incoice=<?php echo $invoice->id ?>" class="btn btn-warning btn-sm"><i class="fa fa-paper-plane"></i> Resend License(s) email</a>
			</td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>
<?php endif; ?>