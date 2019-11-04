<div class="row mb-3">
	<div class="col-sm-12">
		<a href="?page=add" class="btn btn-success pull-right"><i class="fa fa-fw fa-plus"></i> Add New Customer</a>
	</div>
</div>
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
			<th>Status</th>
			<th>Created</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
 		<?php foreach ($customers as $customer): ?>
		<tr>
			<td><small><?php echo $customer->id ?></small></td>
			<td>
				<small><?php echo $customer->fname ?></small>
				<!-- Edit customer -->
				<span class="hiddenBox">
					<a href="customers.php?page=edit&cu=<?php echo $customer->id ?>" class="btn btn-sm btn-link"><i class="fa fa-pencil fa-fw"></i></a>
				</span>
			</td>
			<td><small><?php echo $customer->lname ?></small></td>
			<td><small><?php echo $customer->email ?></small></td>
			<td><?php echo printGenderGraph($customer->gender) ?></td>
			<td>
				<?php
				if ($customer->active)
					echo "<span class='badge badge-success'>Active</span>";
				else
					echo "<span class='badge badge-danger'>Inactive</span>";
				?>		
			</td>
			<td><small><?php echo $customer->created ?></small></td>
			<?php
			$products = $customer->getProducts();
			$pDisabled = count($products)? '' : 'disabled' ;
			
			?>
			<td>
				<!-- Products -->
				<?php if (!$pDisabled) { ?>
					<a href="products.php?cu=<?php echo $customer->id ?>" title="Products" class="btn btn-primary btn-sm"><i class="fa fa-fw fa-cube"></i> (<?php echo count($products) ?>)</a>
				<?php } ?>

				<!-- Invoices -->
				<?php if (!$pDisabled) { ?>
					<a href="invoices.php?cu=<?php echo $customer->id ?>" title="invoices" class="btn btn-warning btn-sm"><i class="fa fa-file-text-o"></i> (<?php echo count($customer->getInvoices()) ?>)</a>
				<?php } ?>
			</td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>
<?php } ?>