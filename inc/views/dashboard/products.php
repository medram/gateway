<div class="row mb-3">
	<div class="col-sm-12">
		<a href="?page=add" class="btn btn-success pull-right"><i class="fa fa-fw fa-plus"></i> Add Product</a>
	</div>
</div>
<?php
if (count($products) == 0)
{
	echo "<div class='alert alert-primary'>No products (°-°)</div>";
} else { ?>
<table class="table table-sm table-striped table-hover">
	<thead>
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Version</th>
			<th>Desc</th>
			<th>Price</th>
			<th>Created</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
 		<?php foreach ($products as $product): ?>
		<tr>
			<td><?php echo $product->id ?></td>
			<td><?php echo stripslashes($product->name) ?></td>
			<td><?php echo $product->version ?></td>
			<td><?php echo stripslashes($product->small_desc) ?></td>
			<td><?php echo $product->email_support ?></td>
			<td><?php echo $product->created ?></td>
			<td>
				<a href="?page=edit&id=<?php echo $product->id ?>" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
				<a href="?a=delete&id=<?php echo $product->id ?>" class="btn btn-danger btn-sm action-delete"><i class="fa fa-trash-o"></i></a>
				<a href="plans.php?p_id=<?php echo $product->id ?>" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Plans (<?php echo count($product->getPlans()) ?>)</a>
			</td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>
<?php } ?>