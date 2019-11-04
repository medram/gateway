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
			<input type="text" id="lname" name="lname" class="form-control" value="<?php @show2input($customer->lname) ?>"><br>

			<label for="email">Email:</label>
			<input type="email" id="email" name="customer-email" class="form-control" value="<?php @show2input($customer->email) ?>" required><br>

			<label for="gender">Gender:</label>
			<select name="gender" id="gender" class="form-control">
				<option value="">Unknown</option>
				<option value="M" <?php if(@show2input($customer->gender, false) == "M") echo 'selected'?>>Male</option>
				<option value="F" <?php if(@show2input($customer->gender, false) == "F") echo 'selected'?>>Female</option>
			</select><br>

			<label for="active">Active :</label>
			<select name="active" id="active" class="form-control">
				<option value="1" <?php if(@show2input($customer->active, false) == 1) echo 'selected'?>>Yes</option>
				<option value="0" <?php if(@show2input($customer->active, false) == 0) echo 'selected'?>>No</option>
			</select><br>


			<input type="submit" name="saveCustomer" class="btn btn-primary" value="Save">
		</form>
	</div>
	<div class="col-md-6">
		<a href="customers.php" class="btn btn-primary btn-sm"><i class="fa fa-fw fa-arrow-left"></i> GO Back!</a>
	</div>
</div>