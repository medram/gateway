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
			<input type="number" id="price" name="price" class="form-control" value="<?php @show2input($plan->price) ?>" required><br>
			
			<label for="old-price">Old Price (in USD) :</label>
			<input type="number" id="old-price" name="old-price" class="form-control" value="<?php @show2input($plan->old_price) ?>" required><br>
			
			<label for="paymentType">Payment Type :</label>
			<select name="payment-type" id="paymentType" class="form-control">
				<option selected disabled>Choose the Payment type!</option>
				<?php foreach (Plan::getPaymentsType() as $key => $type): ?>
				<option value="<?php echo $key ?>" 
				<?php
					if (isset($plan))
						if (@$plan->payment_type == $key)
							echo 'selected';
				?> 
				><?php echo $type ?></option>
			<?php endforeach; ?>
			</select><br>

			<input type="submit" name="savePlan" class="btn btn-primary" value="Save">
		</form>
	</div>
	<div class="col-md-6">
		<a href="?p_id=<?php echo $p_id ?>" class="btn btn-primary btn-sm"><i class="fa fa-fw fa-arrow-left"></i> GO Back!</a>
	</div>
</div>