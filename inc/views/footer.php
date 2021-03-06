			<footer class="my-4 text-muted text-center text-small">
				<p class="mb-1">&copy; <?php echo date('Y')." ".getConfig('site_name') ?> .</p>
				<ul class="list-inline">
					<li class="list-inline-item"><a href="<?php echo BASE_URL ?>privacy-policy.php">Privacy Policy</a></li>
					<li class="list-inline-item"><a href="<?php echo BASE_URL ?>terms.php">Terms</a></li>
					<li class="list-inline-item"><a href="<?php echo BASE_URL ?>contact-us.php">Contact us</a></li>
					<li class="list-inline-item"><a href="<?php echo BASE_URL ?>customer">Client's Area</a></li>
				</ul>
				<!-- <span><?php echo DEBUG? microtime(true) - START_TIME.'s' : '' ;?></span> -->
			</footer>
		</div> <!-- / container div -->
		<!-- Bootstrap core JavaScript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="<?php echo BASE_URL ?>assets/js/jquery.min.js"></script>
		<script src="<?php echo BASE_URL ?>assets/js/bootstrap.min.js"></script>
		<script>
			// Example starter JavaScript for disabling form submissions if there are invalid fields
			(function() {
				'use strict';

				window.addEventListener('load', function() {
					// Fetch all the forms we want to apply custom Bootstrap validation styles to
					var forms = document.getElementsByClassName('needs-validation');
					
					// Loop over them and prevent submission
					var validation = Array.prototype.filter.call(forms, function(form) {
						console.log(form);
						form.addEventListener('submit', function(event) {
							if (form.checkValidity() === false) {
								event.preventDefault();
								event.stopPropagation();
							}
							form.classList.add('was-validated');
						}, false);
					});
				}, false);
			})();
		</script>
	</body>
</html>