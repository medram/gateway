
	<div class="py-5 text-center">
		<!-- <img class="d-block mx-auto mb-4" src="" alt="" width="72" height="72"> -->
		<h2 class='text-success'><i class='fa fa-fw fa-check'></i> Secure Checkout</h2>
		<!-- <p class="lead">Below is an example form built entirely with Bootstrap's form controls. Each required form group has a validation state that can be triggered by attempting to submit the form without completing it.</p> -->
	</div>

	<div class="row">
		<div class="col-md-6 order-md-2 mb-4">
			<h4 class="d-flex justify-content-between align-items-center mb-3">
				<span class="text-muted">Order Summary</span>
				<span class="badge badge-danger badge-pill">Limited Offer</span>
			</h4>
			<ul class="list-group mb-3">
				<li class="list-group-item d-flex justify-content-between lh-condensed">
					<div>
						<h6 class="my-0"><?php echo $product->name.' v'.$product->version.' - '.$plan->name ?></h6>
						<small class="text-muted"><?php echo $plan->desc ?></small>
					</div>
					<span class="text-muted">
						<?php if ($plan->old_price != 0)
							echo '<del>$'.$plan->old_price.'</del><br>';
						?>
						$<?php echo $plan->price ?></span>
				</li>
				<?php if ($total->usedCoupon()): ?>
 				<li class="list-group-item d-flex justify-content-between bg-light">
					<div class="text-success">
						<h6 class="my-0">Coupon code</h6>
						<small><?php echo $total->getCoupon()->code ?></small>
					</div>
					<span class="text-success"><?php echo '-'.$total->getCoupon()->value.$total->getCoupon()->type ?></span>
				</li>
				<?php endif; ?>
				<?php if ($total->getSavedMoney()): ?>
				<li class="list-group-item d-flex justify-content-between bg-light">
					<div class="text-success">
						<h6 class="my-0">You Saved</h6>
						<!-- <small>EXAMPLECODE</small> -->
					</div>
					<span class="text-success">$<?php echo $total->getSavedMoney() ?></span>
				</li>
				<?php endif; ?>
				<li class="list-group-item d-flex justify-content-between">
					<span>Total (USD)</span>
					<!-- <strong class='text-muted'><del>$<?php echo $total->getTotalOldPrice() ?></del></strong> -->
					<strong>$<?php echo $total->getTotalPrice() ?></strong>
				</li>
			</ul>
			
			<?php if (isset($msg['coupon']['err'])) echo "<small class='text-danger'>".$msg['coupon']['err']."</small>";?>
			<?php if (!isset($_SESSION['coupon'])): ?>
 			<form action='' method='post' class="card p-2">
				<div class="input-group">
					<input type="text" class="form-control" name='coupon-code' placeholder="Coupon code">
					<div class="input-group-append">
						<button type="submit" name='apply-coupon' class="btn btn-secondary">Apply</button>
					</div>
				</div>
			</form>
			<?php else: ?>
				<div><a href='<?php echo $_SERVER['REQUEST_URI'] ?>&redeem=1'>Redeem Coupon (<?php echo $_SESSION['coupon'] ?>)</a></div>
			<?php endif; ?>
			
			<div class="row">
				<div class="col-md-12 text-center mt-3">
					<img src="assets/images/security-1.png" alt="256bit encription" title="256bit encription" width="100px">
					<img src="assets/images/security-2.png" alt="Encryption type" title="Encryption type" width="100px">
					<img src="assets/images/security-4.png" alt="100% secure transaction" title="100% secure transaction" width="100px">
					<img src="assets/images/paypal_support.png" alt="supporting visa and mastercard" title="supporting visa and mastercard">
				</div>
			</div>
		</div>
		<div class="col-md-6 order-md-1">
			<h4 class="mb-3"><i class='fa fa-fw fa-user'></i> Customer Information</h4>
			<?php
				if (isset($msg['validation']['err']) && $msg['validation']['err'] != '')
				{
					echo "<div class='alert alert-warning'>".$msg['validation']['err']."</div>";
				}
			?>
			<form action="" method="post" class="needs-validation" novalidate="">
			<div class="row">
				<div class="col-md-6 mb-3">
					<label for="firstName">First name</label>
					<input type="text" class="form-control" name="firstName" id="firstName" placeholder="" value="" required="">
					<div class="invalid-feedback">
						Valid first name is required.
					</div>
				</div>
				<div class="col-md-6 mb-3">
					<label for="lastName">Last name</label>
					<input type="text" class="form-control" name="lastName" id="lastName" placeholder="" value="" required="">
					<div class="invalid-feedback">
						Valid last name is required.
					</div>
				</div>
			</div>


			<div class="mb-3">
				<label for="email">Email</label>
				<input type="email" class="form-control" name="email" id="email" placeholder="you@example.com" required>
				<div class="invalid-feedback">
					Please enter a valid email.
				</div>
			</div>

			<!-- <div class="mb-3">
				<label for="address">Password</label>
				<input type="password" class="form-control" id="password" placeholder="********" required="">
				<div class="invalid-feedback">
					Please enter a password.
				</div>
			</div>

			<div class="mb-3">
				<label for="username">Confirm Password</label>
				<input type="password" class="form-control" id="confirm-password" placeholder="********" required="">
				<div class="invalid-feedback" style="width: 100%;">
					Your password is not matched.
				</div>
			</div> -->
			
			<!-- <hr class="mb-4">
			<div class="custom-control custom-checkbox">
				<input type="checkbox" class="custom-control-input" id="same-address">
				<label class="custom-control-label" for="same-address">Shipping address is the same as my billing address</label>
			</div>
			<div class="custom-control custom-checkbox">
				<input type="checkbox" class="custom-control-input" id="save-info">
				<label class="custom-control-label" for="save-info">Save this information for next time</label>
			</div> -->

<!-- 			<div class="mb-3">
				<label for="country">Country</label>
				
				<?php echo get_country_menu('country', 'form-control custom-select') ?>
				<div class="invalid-feedback">
					Choose Your Country.
				</div>
			</div> -->

			<div class="mb-3">
				<label>Gender</label><br>
				<div class="custom-control custom-radio">
					<input type="radio" id="male" name="gender" class="custom-control-input" value="1" required> 
					<label class="custom-control-label" for="male">Male</label>
				</div>
				<div class="custom-control custom-radio">
					<input type="radio" id="female" name="gender" class="custom-control-input" value="2" required>
					<label class="custom-control-label" for="female">Female</label>

					<div class="invalid-feedback">Choose your gender.</div>
				</div>
			</div>

			<!-- <hr class="mb-4"> -->
			<h4 class="mb-3"><i class='fa fa-fw fa-credit-card'></i> Payment Method</h4>
			<div class="d-block my-3">
				<?php foreach($paymentMethods as $key => $method): ?>
				<div class="custom-control custom-radio">
					<input id="paymentMethods<?php echo $key ?>" name="paymentMethod" type="radio" class="custom-control-input" <?php if ($method->id == 1) echo "checked" ?> value="<?php echo $method->id ?>" required="">
					<label class="custom-control-label" for="paymentMethods<?php echo $key ?>">
					<img src="<?php echo $method->image_url ?>" alt="<?php echo $method->name ?>" title="<?php echo $method->name ?>" height="25px"></label>
				</div>
				<?php endforeach; ?>
				<!-- <div class="custom-control custom-radio">
					<input id="credit" name="paymentMethod" type="radio" class="custom-control-input" required="">
					<label class="custom-control-label" for="credit">Credit card (Stripe)</label>
				</div> -->
			</div>
			<hr class="mb-4">
			<input type="hidden" name="submit" value="pay">
			<button class="btn btn-warning btn-lg btn-block" type="submit">Continue to checkout</button>
			</form>
		</div>
	</div>

