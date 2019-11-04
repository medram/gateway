<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="icon" href="favicon.ico">

		<title>Dashboard login page!</title>

		<!-- Bootstrap core CSS -->
		<link href="../assets/css/bootstrap.min.css" rel="stylesheet">

		<!-- Custom styles for this template -->
		<link href="../assets/css/style.css" rel="stylesheet">
	</head>

	<body class="d-flex text-center">
		<form action="" method="POST" class="form-signin">
			<!-- <img class="mb-4" src="../../assets/brand/bootstrap-solid.svg" alt="" width="72" height="72"> -->
			<h1 class="h3 mb-3 font-weight-normal">MR4Web <small class="text-muted">checkout.</small></h1>
			<?php
			if (isset($msg['err']) && $msg['err'] != '')
			{
				echo "<div class='alert alert-warning'>{$msg['err']}</div>";
			}
			?>
			<label for="inputEmail" class="sr-only">Email address</label>
			<input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required autofocus>
			<label for="inputPassword" class="sr-only">Password</label>
			<input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
			<!-- <div class="checkbox mb-3">
				<label>
					<input type="checkbox" value="remember-me"> Remember me
				</label>
			</div> -->
			<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
			<p class="mt-5 mb-3 text-muted">&copy; <?php echo date('Y') ?> Powred by MR4web</p>
		</form>
	</body>
</html>
