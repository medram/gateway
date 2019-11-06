<?php if ($plans){ ?>
	<?php foreach ($plans as $plan) {
		$product = $plan->getProduct();
		$file = $product->getFiles()[0];
		$downloadLink = $file->getDownloadLink($plan, $customer);
		$licenses = $plan->getLicenses($customer);
	?>
		<div class="card mb-3">
		  	<h5 class="card-header"><i class="fa fa-fw fa-cube"></i> <?php echo $product->name.' v'.$product->version.' ('.$plan->name.')' ?>
		      	<?php if ($plan->status == 1){ ?>
		  	    	<a href="<?php echo BASE_URL.'checkout.php?pl='.$plan->id ?>" target="_blank" class="btn btn-success btn-sm pull-right ml-2"><i class="fa fa-shopping-cart"></i> BUY MORE !</a>
		    	<?php } ?>

		      	<?php if ($downloadLink){ ?>
		  	    	<a href="<?php echo $downloadLink ?>" class="btn btn-primary btn-sm pull-right"><i class="fa fa-download"></i> Download Now</a>
		    	<?php } ?>
			</h5>
		  <div class="card-body">
		    <!-- <h5 class="card-title">Special title treatment</h5> -->
		    <div class="row">
		    	<div class="col-lg-9">
		    		<p class="card-text">
		    			- <?php echo $product->small_desc ?><br>
		    			- <?php echo $plan->desc ?>
		    		</p>
		    		<div>
		    			<?php if ($licenses){ ?>
		    				<h5><i class="fa fa-key"></i> Licenses <small>(use it to activate your product)</small>:</h5>
		    				<table class="table table-sm table-bordered">
		    					<tr>
		    						<th>#</th>
		    						<th><small><b>License code</b></small></th>
		    						<th><small><b>Used/Total Activations</b></small></th>
		    						<th><small><b>Status</b></small></th>
		    					</tr>
	    						<?php foreach ($licenses as $key => $license) { ?>
		    					<tr>
		    						<td><?php echo $key+1 ?></td>
		    						<td>
			    						<code class='text-primary'><?php echo $license->license_code ?></code><br>
		    						</td>
		    						<td><?php echo $license->activation_num.'/'.$license->activation_max ?></td>
		    						<td>
		    							<?php
		    							if ($license->banned)
		    								echo "<span class='badge badge-danger'>Banned</span>";
		    							else
		    								echo "<span class='badge badge-success'>Active</span>";
		    							?>
		    						</td>
		    					</tr>
		    					<?php } ?>
		    				</table>
		    			<?php } ?>
		    		</div>
		    	</div>
		    	<div class="col-lg-3">
		    		<h5 class="card-title">Product support email:</h5>
		    		<code><?php echo $product->email_support ?></code>
		    	</div>
		    </div>
<!-- 		    <?php if ($downloadLink){ ?>
			    <a href="<?php echo $downloadLink ?>" class="btn btn-primary"><i class="fa fa-download"></i> Download Now</a>
		  	<?php } ?> -->
		  </div>
		</div>
	<?php } ?>
<?php } else { echo "No Products For now!"; } ?>