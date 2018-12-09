<?php
if (count($transactions) == 0)
{
	echo "<div class='alert alert-primary'>No Transactions (°-°)</div>";
} else { ?>
<table class="table table-sm table-striped table-hover">
	<thead>
		<tr>
			<th>ID</th>
			<th>Transaction ID</th>
			<th>Amount</th>
			<th>Fee</th>
			<th>Quantity</th>
			<th>Status</th>
			<th>Created</th>
		</tr>
	</thead>
	<tbody>
 		<?php foreach ($transactions as $tr): ?>
		<tr>
			<td><?php echo $tr->id ?></td>
			<td><?php echo $tr->Tr_ID ?></td>
			<td><?php echo $tr->amount.' <small>'.$tr->currency.'</small>' ?></td>
			<td><?php echo $tr->Tr_fee.' <small>'.$tr->currency.'</small>' ?></td>
			<td><?php echo $tr->quantity ?></td>
			<td><?php echo $tr->state ?></td>
			<td><?php echo $tr->created ?></td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>
<?php } ?>