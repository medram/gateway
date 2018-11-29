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
			<th>All Customer's (Products/Licenses)</th>
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
			<?php
			$products = $customer->getProducts();
			$pDisabled = count($products)? '' : 'disabled' ;
			
			$licenses = $customer->getLicenses();
			$disabled = count($licenses)? '' : 'disabled' ;
			?>
			<td>
				<a href="products.php?cu=<?php echo $customer->id ?>" title="Products" class="btn btn-primary btn-sm <?php echo $pDisabled ?>"><i class="fa fa-fw fa-cube"></i> Products (<?php echo count($products) ?>)</a>
				<a href="licenses.php?cu=<?php echo $customer->id ?>" title="licenses" class="btn btn-success btn-sm <?php echo $disabled ?>"><i class="fa fa-key"></i> Licenses (<?php echo count($licenses) ?>)</a>
				
				<a href="invoices.php?cu=<?php echo $customer->id ?>" title="invoices" class="btn btn-warning btn-sm <?php echo $pDisabled ?>"><i class="fa fa-file-text-o"></i> Invoices (<?php echo count($customer->getInvoices()) ?>)</a>
			</td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>
<?php } ?>