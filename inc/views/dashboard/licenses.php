<div class="row mb-3">
	<div class="col-sm-12">
		<a href="?page=add" class="btn btn-success pull-right"><i class="fa fa-fw fa-plus"></i> Generate License</a>
	</div>
</div>
<?php
if (count($licenses) == 0)
{
	echo "<div class='alert alert-primary'>No Licenses for Now (°-°)</div>";
} else { ?>
<table class="table table-sm table-striped table-hover">
	<thead>
		<tr>
			<th>ID</th>
			<th>License Code</th>
			<th>Used/Total Activation</th>
			<th>Status</th>
			<th>Created</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
 		<?php foreach ($licenses as $license): ?>
		<tr>
			<td><?php echo $license->id ?></td>
			<td><?php echo '<code class="text-primary">'.$license->license_code.'</code>' ?></td>
			<td><?php echo $license->activation_num.'/'.$license->activation_max ?></td>
			<td><?php echo $license->banned ? "<span class='badge badge-danger'>Banned</span>" : "<span class='badge badge-success'>Active</span>" ?></td>
			<td><?php echo $license->created ?></td>
			<td>
				<a href="?page=edit&l_id=<?php echo $license->id ?>" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
				<a href="?a=delete&l_id=<?php echo $license->id ?>" class="btn btn-danger btn-sm action-delete"><i class="fa fa-trash-o"></i></a>
			</td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>
<?php } ?>