<div class="row">
	<div class="col-sm-6">
		<form action="" method="post">
			<?php
			if (isset($msg['err']))
				echo "<div class='alert alert-warning'>".$msg['err']."</div>";
			else if (isset($msg['ok']))
				echo "<div class='alert alert-success'>".$msg['ok']."</div>";
			?>
			<label for="fname">First name:</label>
			<input type="text" id="fname" name="fname" class="form-control" value="<?php @show2input($customer->fname) ?>" required><br>
			
			<label for="lname">Last name:</label>
			<input type="text" id="lname" name="lname" class="form-control" value="<?php @show2input($customer->lname) ?>" required><br>

			<label for="email">Email:</label>
			<input type="email" id="email" name="customer-email" class="form-control" value="<?php @show2input($customer->email) ?>" required><br>

			<label for="gender">Gender:</label>
			<select name="gender" id="gender" class="form-control" value="<?php show2input($customer->gender) ?>">
				<option value="">Unknown</option>
				<option value="M">Male</option>
				<option value="F">Female</option>
			</select><br>

			<input type="submit" name="saveCustomer" class="btn btn-primary" value="Create">
		</form>
	</div>
	<div class="col-md-6">
		<a href="customers.php" class="btn btn-primary btn-sm"><i class="fa fa-fw fa-arrow-left"></i> GO Back!</a>
	</div>
</div>