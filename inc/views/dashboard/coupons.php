<div class="row mb-3">
	<div class="col-sm-12">
		<a href="?page=add" class="btn btn-success pull-right"><i class="fa fa-fw fa-plus"></i> Add Coupon</a>
	</div>
</div>
<?php
if (count($coupons) == 0)
{
	echo "<div class='alert alert-primary'>No Coupons (°-°)</div>";
} else { ?>
<table class="table table-sm table-striped table-hover">
	<thead>
		<tr>
			<th>ID</th>
			<th>Coupon Code</th>
			<th>Value</th>
			<th>Used / Total Times</th>
			<th>Status</th>
			<th>Expired</th>
			<th>Created</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
 		<?php foreach ($coupons as $coupon): ?>
		<tr>
			<td><?php echo $coupon->id ?></td>
			<td><?php echo '<code>'.$coupon->code.'</code>' ?></td>
			<td><?php echo '-'.$coupon->value.$coupon->type ?></td>
			<td><?php echo $coupon->valid_time.'/'.$coupon->total_valid_time ?></td>
			<td><?php echo $coupon->status ? "<span class='badge badge-success'>Active</span>" : "<span class='badge badge-danger'>Inactive</span>" ?></td>
			<td><?php echo $coupon->expired ? "<span class='badge badge-danger'>Expired</span>" : "<span class='badge badge-success'>Not expired</span>" ?></td>
			<td><?php echo $coupon->created ?></td>
			<td>
				<a href="?page=edit&coupon_id=<?php echo $coupon->id ?>" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
				<?php if (!$coupon->valid_time){ ?>
				<a href="?a=delete&coupon_id=<?php echo $coupon->id ?>" class="btn btn-danger btn-sm action-delete"><i class="fa fa-trash-o"></i></a>
				<?php } ?>
			</td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>
<?php } ?>