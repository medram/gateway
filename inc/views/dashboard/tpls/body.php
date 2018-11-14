<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
	<span class="navbar-brand col-sm-3 col-md-2 mr-0">MR4Web <small class="text-muted">Checkout.</small></span>
	<!-- <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search"> -->
	<ul class="navbar-nav px-3">
		<li class="nav-item text-nowrap">
			<a class="nav-link" href="login.php?action=logout">Sign out</a>
		</li>
	</ul>
</nav>

<div class="container-fluid">
	<div class="row">
		<nav class="col-md-2 d-none d-md-block bg-light sidebar">
			<div class="sidebar-sticky">
				<ul class="nav flex-column">
					<li class="nav-item">
						<a class="nav-link" href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="products.php"><i class="fa fa-fw fa-flask"></i> Products</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="licenses.php"><i class="fa fa-fw fa-key"></i> Licenses</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="coupons.php"><i class="fa fa-fw fa-ticket"></i> Coupons</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="customers.php"><i class="fa fa-fw fa-users"></i> Customers</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="transactions.php"><i class="fa fa-fw fa-credit-card"></i> Transactions</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="payers.php"><i class="fa fa-fw fa-users"></i> Payers</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="users.php"><i class="fa fa-fw fa-users"></i> Users & Roles</a>
					</li>
				</ul>
			</div>
		</nav>

		<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
			<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
				<h1 class="h2" id="welcome"><?php echo $dash_title ?></h1>
			</div>
			<div>
				<?php echo $dash_content ?>
			</div>
		</main>
	</div>
</div>