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
			<th>Created</th>
			<th>All Customer's (Products/Licenses...)</th>
		</tr>
	</thead>
	<tbody>
 		<?php foreach ($customers as $customer): ?>
		<tr>
			<td><?php echo $customer->id ?></td>
			<td>
				<?php echo $customer->fname ?>
				<!-- Edit customer -->
				<span class="hiddenBox">
					<a href="customers.php?page=edit&cu=<?php echo $customer->id ?>" class="btn btn-sm btn-link"><i class="fa fa-pencil fa-fw"></i></a>
				</span>
			</td>
			<td><?php echo $customer->lname ?></td>
			<td><?php echo $customer->email ?></td>
			<td><?php echo printGenderGraph($customer->gender) ?></td>
			<td><?php echo $customer->created ?></td>
			<?php
			$products = $customer->getProducts();
			$pDisabled = count($products)? '' : 'disabled' ;
			
			$licenses = $customer->getLicenses();
			$lDisabled = count($licenses)? '' : 'disabled' ;
			?>
			<td>
				<!-- Products -->
				<?php if (!$pDisabled) { ?>
					<a href="products.php?cu=<?php echo $customer->id ?>" title="Products" class="btn btn-primary btn-sm"><i class="fa fa-fw fa-cube"></i> (<?php echo count($products) ?>)</a>
				<?php } ?>
				
				<!-- Licenses -->
				<?php if (!$lDisabled) { ?>
					<a href="licenses.php?cu=<?php echo $customer->id ?>" title="licenses" class="btn btn-success btn-sm"><i class="fa fa-key"></i> (<?php echo count($licenses) ?>)</a>
				<?php } ?>

				<!-- Invoices -->
				<?php if (!$pDisabled) { ?>
					<a href="invoices.php?cu=<?php echo $customer->id ?>" title="invoices" class="btn btn-warning btn-sm"><i class="fa fa-file-text-o"></i> (<?php echo count($customer->getInvoices()) ?>)</a>
				<?php } ?>
				<!-- Create License -->
				<a href="licenses.php?page=add&cu=<?php echo $customer->id ?>" title="Create license" class="btn btn-info btn-sm"><i class="fa fa-key"></i> Create license</a>
			</td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>
<?php } ?>