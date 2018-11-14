<?php

if (isset($msg['err']))
	echo "<div class='alert alert-warning'>".$msg['err']."</div>";
else if (isset($msg['err']))
	echo "<div class='alert alert-success'>".$msg['ok']."</div>";
?>
<div class="row">
	<div class="col-sm-6">
		<form action="" method="post">
			
			<label for="name">Product Name:</label>
			<input type="text" id="name" name="name" class="form-control" value="<?php @show2input($product->name) ?>" required><br>
			
			<label for="version">Product version (eg: 1.2.3):</label>
			<input type="text" id="version" name="version" class="form-control" value="<?php @show2input($product->version) ?>" required><br>
			
			<label for="desc">Small Description:</label>
			<input type="text" id="desc" name="desc" class="form-control" value="<?php @show2input($product->small_desc) ?>" required><br>
			
			<label for="email_support">Email Support:</label>
			<input type="email" id="email_support" name="email_support" class="form-control" value="<?php @show2input($product->email_support) ?>" required><br>
			
			<input type="submit" name="saveProduct" class="btn btn-primary" value="Save">
		</form>
	</div>
	<div class="col-md-6">
		<a href="products.php" class="btn btn-primary btn-sm"><i class="fa fa-fw fa-arrow-left"></i> GO Back!</a>
	</div>
</div>