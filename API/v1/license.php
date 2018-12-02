<?php
require_once 'api_init.php';

if (!isset($_POST['action']) || is_null($_POST['action']))
	exit;

$action = isset($_POST['action']) ? strip_tags(_addslashes($_POST['action'])) : '' ;

require_once API_INC.'utils/res.php';
// should be called after the database connection.
require_once API_INC.'operations.php';

switch ($action)
{
	case 'activate':
		activate_operation();
		break;
	case 'deactivate':
		deactivate_operation();
		break;
}

Res::emit();

?>