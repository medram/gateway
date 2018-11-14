<?php
if (count($payers) == 0)
{
	echo "<div class='alert alert-primary'>No payers (°-°)</div>";
} else { ?>
<table class="table table-sm table-striped table-hover">
	<thead>
		<tr>
			<th>ID</th>
			<th>First name</th>
			<th>Last name</th>
			<th>Email</th>
			<th>Country Code</th>
			<th>Created</th>
		</tr>
	</thead>
	<tbody>
 		<?php foreach ($payers as $payer): ?>
		<tr>
			<td><?php echo $payer->id ?></td>
			<td><?php echo $payer->fname ?></td>
			<td><?php echo $payer->lname ?></td>
			<td><?php echo $payer->email ?></td>
			<td><?php echo $payer->country_code ?></td>
			<td><?php echo $payer->created ?></td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>
<?php } ?>