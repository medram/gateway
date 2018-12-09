<div class="row mt-5">
	<div class="col-md-12">
		<h1><?php echo isset($title)? $title : '' ?></h1>
	</div>
</div>
<div class="row" style="min-height: 300px;">
	<div class="col-md-12">
		
	<?php
	if (isset($pageContent))
		echo $pageContent;

	?>
	</div>
</div>