<div class="row">
	<div class="col-md-8">
		<h2 class="text-success"><i class="fa fa-fw fa-money"></i> Revenue:
		<select name="filter-time" class="form-control pull-right" style="display: inline-block; width: 150px;">
			<option value="all">All</option>
			<option value="today">Today</option>
			<option value="last-week">Last week</option>
			<option value="last-month">Last month</option>
		</select>
		</h2>
		<table class="table table-sm table-striped table-hover">
			<thead>
				<tr>
					<th>Gross</th>
					<th>Fee</th>
					<th>Profit</th>
				</tr>
			</thead>
			<tbody>
				<?php if ($tr_gross): ?>
				<tr>
					<td>$<?php echo $tr_gross ?></td>
					<td><span class="text-danger">$<?php echo $tr_fee ?></span></td>
					<td><b class="text-success">$<?php echo $tr_earned ?></b></td>
				</tr>

				<?php else: ?>
					<tr><td class="text-center" colspan="3">No available data for now!</td></tr>
				<?php endif; ?>
			</tbody>
		</table>
		
		
		<h2 class="text-danger"><i class="fa fa-w fa-ticket"></i> Coupons:</h2>
		<table class="table table-sm table-striped table-hover">
			<thead>
				<tr>
					<th>Active/total</th>
					<th>Inactive/total</th>
					<th>Expired/Total</th>
					<th>Valid Time / Total Valid Time</th>
				</tr>
			</thead>
			<tbody>
				<?php if ($coupon_total): ?>
				<tr>
					<td><?php echo $coupon_active.'/'.$coupon_total ?></td>
					<td><?php echo $coupon_inactive.'/'.$coupon_total ?></td>
					<td><?php echo $coupon_expired.'/'.$coupon_total ?></td>
					<td><?php echo $coupon_valid_time.'/'.$coupon_total_valid_time ?></td>
				</tr>

				<?php else: ?>
					<tr><td class="text-center" colspan="4">No available data for now!</td></tr>
				<?php endif; ?>
			</tbody>
		</table>
		
		<h2 class="text-info"><i class="fa fa-w fa-cube"></i> Products (<?php echo $products_total ?>):</h2>
		<table class="table table-sm table-striped table-hover">
			<thead>
				<tr>
					<th>Product</th>
					<th>Revenue (profit/gross)</th>
				</tr>
			</thead>
			<tbody>
				<?php if ($products_total): ?>
					<?php foreach ($products_rows as $row): ?>
					<tr>
						<td><?php echo $row['product']['name']." <small>v".$row['product']['version']."</small>"; ?></td>
						<td class="text-success"><?php echo $row['profit'].'<b>/</b>'.$row['gross'] ?> $</td>
					</tr>
					<?php endforeach; ?>
		
				<?php else: ?>
					<tr><td class="text-center" colspan="3">No available data for now!</td></tr>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
	<div class="col-md-4">
		<div class="text-muted">
			<h2 class="text-info">Other</h2>
			<b><i class="fa fa-users"></i> Customers: </b><span><?php echo $customers_total ?></span><br>
			<b><i class="fa fa-credit-card"></i> Transactions: </b><span><?php echo $tr_total ?></span><br>
			<b><i class="fa fa-cube"></i> Products: </b><span><?php echo $products_total ?></span><br>
			<b><i class="fa fa-flag-o"></i> Plans: </b><span><?php echo $plans_total ?></span><br>
		</div>
	</div>
</div>