<div class="row my-4">
	<div class="col-md-12">
		<h1>Download page</h1>
	</div>
</div>
<div class="alert alert-success" role="alert">
	<div class="row">
		<div class="col-md-1"><i class="fa fa-check fa-4x"></i></div>
		<div class="col-md-11">
		  <h4 class="alert-heading">The Payment has been done successfully.</h4>
		  <p>And don't forget to check your email box.</p>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="card">
		  <h5 class="card-header">Download <?php echo $productName ?></h5>
		  <div class="card-body">
		    <h6 class="card-title">Hi <?php echo $customer->fname.' '.$customer->lname ?></h6>
		    <p>Thank you for purchasing <?php echo $productName.' ('.$plan->name.')'?> ,<br>
	You could download the product which have purchased from here or via an email that we sent to you.</p>
		    <p class="card-text">
		    	<h5><?php echo $productName ?> Informations:</h5>
		    	You could download the "<?php echo $productName ?>" from the link below:<br>
		    	<div class="text-center mt-3">
		    		<a href="<?php echo $downloadLink ?>" target="_blank" title="Download" class="btn btn-primary btn-lg"><i class="fa fa-fw fa-download"></i> DOWNLOAD</a>
		    	</div>
		    	Or from here:<br>
		    	<a href="<?php echo $downloadLink ?>" target="_blank" title="Download"><?php echo $downloadLink ?></a><br><br>
		    	<h5><?php echo $productName ?> License(s):</h5>
		    	You could use the license(s) below to activate your <?php echo $productName ?> :
		    	<div class="lead text-primary text-center mt-3 font-weight-bold"><?php echo $licenses ?></div><br>
		    	<h5><?php echo $productName ?> Support:</h5>
		    	<b>Node:</b> if you have any suggestions, issues or problems with product, please feel free to contact us at:
		    	<a href="mailto:<?php echo $product_email_support ?>" ><?php echo $product_email_support ?></a>
		    </p>
		  </div>
		</div>		
	</div>
</div>
