<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="icon" href="favicon.ico">

		<title>Customer's Area</title>

		<!-- Bootstrap core CSS -->
		<link href="../assets/css/bootstrap.min.css" rel="stylesheet">

		<!-- Custom styles for this template -->
		<link href="../assets/css/style.css" rel="stylesheet">
	</head>

	<body class="text-center">
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
			<input type="password" id="email" name="password" class="form-control" placeholder="Password" required>

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
			<label for="email" class="sr-only">New password</label>
			<input type="password" id="email" name="password" class="form-control" placeholder="New password" required>
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
			<input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required>
			<input class="btn btn-lg btn-primary btn-block" type="submit" name="submitEmail" value="Sign in">
		</form>
	<?php } ?>
		<p class="mt-5 mb-3 text-muted">&copy; <?php echo date('Y') ?> Powred by MR4web</p>
	</body>
</html>
