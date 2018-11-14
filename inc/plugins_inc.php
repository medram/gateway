<?php

/*
	Available action for now:
	- before_dashboard_start
	- before_payment
	- after_payment
	- after_payment_done_successfully (Invoice)
	- after_payment_failed
	- before_user_logged_in (email, password)
	- after_user_logged_in (email, password)
	- before_user_logged_out
	- after_user_logged_out
	-

*/

function notifyCustomer(Invoice $invoice)
{
	/*
		get information.
		send email.
	*/
}

add_action('after_payment_done_successfully', 'notifyCustomer');

?>