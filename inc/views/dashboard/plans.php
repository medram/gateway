<div class="row mb-3">
	<div class="col-sm-12">
		<a href="products.php" class="btn btn-primary pull-right"><i class="fa fa-fw fa-arrow-left"></i> Go Back</a>
		<a href="?page=add&p_id=<?php echo $p_id ?>" class="btn btn-success pull-right mr-2"><i class="fa fa-fw fa-plus"></i> Add Plan</a>
	</div>
</div>
<?php
if (count($plans) == 0)
{
	echo "<div class='alert alert-primary'>No Plans for this product (°-°)</div>";
} else { ?>
<table class="table table-sm table-striped table-hover">
	<thead>
		<tr>
			<th>ID</th>
			<th>Plan Name</th>
			<th>Description</th>
			<th>Price</th>
			<th>Old Price</th>
			<th>Payment Type</th>
			<th>Created</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
	<?php
/*	echo '<pre>';
	print_r($plans);
	echo '</pre>';*/
	?>
 	<?php foreach ($plans as $plan): ?>
		<tr>
			<td><?php echo $plan->id ?></td>
			<td><?php echo $plan->name ?></td>
			<td><?php echo $plan->desc ?></td>
			<td><?php echo '$'.$plan->price ?></td>
			<td><?php echo '<del>$'.$plan->old_price.'</del>' ?></td>
			<td><?php echo $plan->paymentType() ?></td>
			<td><?php echo $plan->created ?></td>
			<td>
				<a href="<?php echo '?page=edit&plan_id='.$plan->id.'&p_id='.$p_id ?>" class="btn btn-primary btn-sm" ><i class="fa fa-pencil"></i></a>
				<a href="<?php echo '?a=delete&plan_id='.$plan->id.'&p_id='.$p_id ?>" class="btn btn-danger btn-sm action-delete"><i class="fa fa-trash-o"></i></a>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php } ?>