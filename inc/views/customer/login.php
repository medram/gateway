<div class="d-flex text-center" style="height: 60vh;">
	<?php if (isset($_GET['step']) && $_GET['step'] == 2){ ?>
		<form action="" method="POST" class="form-signin">
			<!-- <img class="mb-4" src="../../assets/brand/bootstrap-solid.svg" alt="" width="72" height="72"> -->
			<h1 class="h3 mb-3 font-weight-normal">Customer's Area<small class="text-muted"></small></h1>
			<?php
			if (isset($msg['err']) && $msg['err'] != '')
			{
				echo "<div class='alert alert-warning'>{$msg['err']}</div>";
			}
			?>
			<label for="email" class="sr-only">Password</label>
			<input type="password" id="email" name="password" class="form-control" placeholder="Password" required autofocus>

			<input class="btn btn-lg btn-success btn-block" type="submit" name="submitPassword" value="Continue">
		</form>
	<?php } else if (isset($_GET['step']) && $_GET['step'] == 1) { ?>
		<form action="" method="POST" class="form-signin">
			<!-- <img class="mb-4" src="../../assets/brand/bootstrap-solid.svg" alt="" width="72" height="72"> -->
			<h1 class="h3 mb-3 font-weight-normal">Customer's Area<small class="text-muted"></small></h1>
			<?php
			if (isset($msg['err']) && $msg['err'] != '')
			{
				echo "<div class='alert alert-warning'>{$msg['err']}</div>";
			}
			?>
			<label for="password" class="sr-only">New password</label>
			<input type="password" id="password" name="password" class="form-control" placeholder="New password" required autofocus>
			<label for="confirm-password" class="sr-only">Password</label>
			<input type="password" id="confirm-password" name="confirm-password" class="form-control" placeholder="Confirm new password" required>

			<input class="btn btn-lg btn-success btn-block" type="submit" name="submitNewPassword" value="Save">
		</form>
	
	<?php } else { ?>
		<form action="" method="POST" class="form-signin">
			<!-- <img class="mb-4" src="../../assets/brand/bootstrap-solid.svg" alt="" width="72" height="72"> -->
			<h1 class="h3 mb-3 font-weight-normal">Customer's Area<small class="text-muted"></small></h1>
			<?php
			if (isset($msg['err']) && $msg['err'] != '')
			{
				echo "<div class='alert alert-warning'>{$msg['err']}</div>";
			}
			?>
			<label for="inputEmail" class="sr-only">Email address</label>
			<input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required autofocus>
			<input class="btn btn-lg btn-primary btn-block" type="submit" name="submitEmail" value="Sign in">
		</form>
	<?php } ?>
</div>

