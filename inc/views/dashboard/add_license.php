<?php

use MR4Web\Models\License;
use MR4Web\Models\Customer;
use MR4Web\Models\Product;

$editMode = isset($license)? true : false ;
$saveBtn = $editMode ? 'Save' : 'Generate';

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
			<label for="max">Max Activation:</label>
			<input type="number" min="0" id="max" name="max" class="form-control" value="<?php @show2input($license->activation_max) ?>" required><br>
			
			<label for="customer-id">Customer ID :</label>
			<input type="number" min="1" id="customer-id" name="customer-id" class="form-control" value="<?php @show2input($license->customers_id) ?>" required><br>
				
			<label for="status">Status :</label>
			<select name="status" class="form-control" id="status">
				<option value="0" <?php echo ($editMode && $license->banned == 0) ? 'selected' : '' ?> >Active</option>
				<option value="1" <?php echo ($editMode && $license->banned == 1) ? 'selected' : '' ?> >Banned</option>
			</select><br>

<!-- 			<label for="product">Product that License belongs to :</label>
			<select name="product-id" id="product" class="form-control" style="font-family: consolas" required>
				<option selected disabled>Selecte a Product!</option>
				<?php foreach (Product::getAll(['id', 'DESC']) as $product): ?>
					<?php
					$selected = @$license->products_id == $product->id ? $selected = 'selected' : '' ;
					?>
					<option value="<?php echo $product->id ?>" <?php echo $selected ?> ><?php echo $product->name ?></option>
				<?php endforeach; ?>
			</select><br> -->

			<label for="plan">Choose Plans that License belongs to :</label>
			<select name="plan-id" id="plan" class="form-control" style="font-family: consolas" required>
				<option selected disabled>Selecte a Plan</option>
				<?php
				if (isset($license) && $license instanceof License)
					$currentPlanID = $license->getPlan()->id;
				foreach (Product::getAll(['id', 'DESC']) as $product):
				?>
					<option disabled><?php echo $product->name ?></option>
				<?php foreach ($product->getPlans() as $plan): ?>
						<?php
							$selected = '';	
							if ($currentPlanID == $plan->id)
								$selected = 'selected';
						?>
						<option value="<?php echo $plan->id ?>" <?php echo $selected ?> ><?php echo "|_ ".$plan->name ?></option>
				<?php endforeach; ?>
				<?php endforeach; ?>
			</select><br>

			<input type="submit" name="saveLicense" class="btn btn-primary" value="<?php echo $saveBtn ?>">
		</form>
	</div>
	<div class="col-md-6">
		<a href="licenses.php" class="btn btn-primary btn-sm"><i class="fa fa-fw fa-arrow-left"></i> GO Back!</a>
	</div>
</div>