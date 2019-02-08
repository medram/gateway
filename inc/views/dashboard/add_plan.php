<?php

use MR4Web\Models\Plan;

?>
<div class="row">
	<div class="col-sm-6">
		<?php
		if (isset($msg['err']))
			echo "<div class='alert alert-warning'>".$msg['err']."</div>";
		else if (isset($msg['err']))
			echo "<div class='alert alert-success'>".$msg['ok']."</div>";
		?>
		<form action="" method="post">
			
			<label for="name">Plan Name:</label>
			<input type="text" id="name" name="name" class="form-control" value="<?php @show2input($plan->name) ?>" required><br>
			
			<label for="desc">Description :</label>
			<input type="text" id="desc" name="desc" class="form-control" value="<?php @show2input($plan->desc) ?>" required><br>
			
			<label for="price">Price (in USD) :</label>
			<input type="number" id="price" min="0" step=".01" name="price" class="form-control" value="<?php @show2input($plan->price) ?>" required><br>
			
			<label for="old-price">Old Price (in USD) :</label>
			<input type="number" min="0" step=".01" id="old-price" name="old-price" class="form-control" value="<?php @show2input($plan->old_price) ?>" required><br>
			
			<label for="max-licenses">Max Licenses :</label>
			<input type="number" min="0" id="max-licenses" name="max-licenses" class="form-control" value="<?php @show2input($plan->max_licenses) ?>" required><br>

			<label for="planStatus">Plan Status :</label>
			<select id="planStatus" name="status" class="form-control">
				<option value="1" <?php echo (@$plan->status == 1)? 'selected' : '' ?> >active</option>
				<option value="0" <?php echo (@$plan->status == 0)? 'selected' : '' ?> >inactive</option>
			</select><br>

			<label for="planType">Plan Type :</label>
			<select name="plan-type" id="planType" class="form-control">
				<option selected disabled>Choose the Plan type!</option>
				<?php foreach (Plan::getPlanType() as $key => $type): ?>
				<option value="<?php echo $key ?>" 
				<?php
					if (isset($plan))
						if (@$plan->plan_type == $key)
							echo 'selected';
				?> 
				><?php echo $type ?></option>
			<?php endforeach; ?>
			</select><br>

			<label for="analytics">Analytics Code :</label>
			<textarea id="analytics" name="analytics-code" class="form-control" rows="6"><?php @show2input($plan->analytics_code) ?></textarea><br>

			<label for="tp-analytics">Thank you page analytics Code :</label>
			<textarea id="tp-analytics" name="tp-analytics-code" class="form-control" rows="6"><?php @show2input($plan->thanks_page_analytics_code) ?></textarea><br>

			<input type="submit" name="savePlan" class="btn btn-primary" value="Save">
			<br>
			<br>
		</form>
	</div>
	<div class="col-md-6">
		<a href="?p_id=<?php echo $p_id ?>" class="btn btn-primary btn-sm"><i class="fa fa-fw fa-arrow-left"></i> GO Back!</a>
	</div>
</div>