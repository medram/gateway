<?php
if (count($customers) == 0)
{
	echo "<div class='alert alert-primary'>No customers (°-°)</div>";
} else { ?>
<table class="table table-sm table-striped table-hover">
	<thead>
		<tr>
			<th>ID</th>
			<th>First name</th>
			<th>Last name</th>
			<th>Email</th>
			<th>Gender</th>
			<th>Created</th>
		</tr>
	</thead>
	<tbody>
 		<?php foreach ($customers as $customer): ?>
		<tr>
			<td><?php echo $customer->id ?></td>
			<td><?php echo $customer->fname ?></td>
			<td><?php echo $customer->lname ?></td>
			<td><?php echo $customer->email ?></td>
			<td><?php echo printGenderGraph($customer->gender) ?></td>
			<td><?php echo $customer->created ?></td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>
<?php } ?>