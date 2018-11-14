<?php

use MR4Web\Models\Coupon;
use MR4Web\Models\Plan;
use MR4Web\Models\Product;

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
			<label for="code">Coupon Code:</label>
			<input type="text" id="code" name="code" class="form-control" value="<?php @show2input($coupon->code) ?>" required><br>
			
			<label for="value">Coupon Value :</label>
			<div class="input-group mb-3">
				<input type="number" min="0" id="value" name="value" class="form-control" value="<?php @show2input($coupon->value) ?>" required>
				<div class="input-group-append">
					<select name="type" class="form-control">
						<option value="%" <?php echo @show2input($coupon->type) == '%'? 'selected' : '' ?> >%</option>
						<option value="$" <?php echo @show2input($coupon->type) == '$'? 'selected' : '' ?> >$</option>
					</select>
				</div>
			</div>
			<br>

			<label for="usage">Max Usage Times :</label>
			<input type="number" min="1" id="usage" name="total-usage" class="form-control" value="<?php @show2input($coupon->total_valid_time) ?>" required><br>
			
			<label for="status">Status :</label>
			<select name="status" id="status" class="form-control">
				<?php
					$selected1 = '';
					$selected2 = '';
					if (isset($coupon) && $coupon instanceof Coupon)
						if ($coupon->status)
							$selected1 = 'selected';
						else
							$selected2 = 'selected';
				?>
				<option value="1" <?php echo $selected1 ?> >Active</option>
				<option value="0" <?php echo $selected2 ?> >Inactive</option>
			</select><br>
			
			<label for="plan">Choose Plans that Coupon belongs to :</label>
			<select name="plans[]" id="plan" class="form-control" size="5" style="font-family: consolas" multiple required>
				<?php foreach (Product::getAll(['id', 'DESC']) as $product): ?>
					<option disabled><?php echo $product->name ?></option>
				<?php foreach ($product->getPlans() as $plan): ?>
						<?php
							$selected = '';
							if (isset($coupon) && $coupon instanceof Coupon)
								if ($plan->supportCoupon($coupon))
									$selected = 'selected';
						?>
						<option value="<?php echo $plan->id ?>" <?php echo $selected ?> ><?php echo "|_ ".$plan->name ?></option>
				<?php endforeach; ?>
				<?php endforeach; ?>
			</select><br>

			<input type="submit" name="saveCoupon" class="btn btn-primary" value="Save">
		</form>
	</div>
	<div class="col-md-6">
		<a href="coupons.php" class="btn btn-primary btn-sm"><i class="fa fa-fw fa-arrow-left"></i> GO Back!</a>
	</div>
</div>