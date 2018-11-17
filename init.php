<?php
session_start();

define('START_TIME', microtime(true));

define('BASE_URL', 'https://'.$_SERVER['HTTP_HOST'].'/test/gateway/');

define('DEBUG', true);
define('DEBUG_SHOW_ERRORS', true);
//define('DEBUG_SHOW_MSGS_CONSOLE', true);
define('ENCRYPTION_KEY', sha1('md4web'));

define('ROOT', str_replace('\\', '/', dirname(__FILE__)).'/');
define('INC', ROOT.'inc/');
define('CLASS_DIR', INC.'classes/');
define('VIEWS_DIR', INC.'views/');
define('UPLOADS_DIR', INC.'uploads/');

// default timezone.
date_default_timezone_set("Etc/GMT+0");

require_once "vendor/autoload.php";
require_once INC.'common.php';


/*
* autoload classes.
*/
spl_autoload_register(function ($filename){
	$path = str_ireplace('MR4Web\\', CLASS_DIR, $filename);
	$path = $path.'.php';
	$path = str_ireplace('\\', '/', $path);

	if (file_exists($path))
	{
		//echo '<pre><b>Loading ...</b> '.$path.'</pre>';
		require $path;
	}	
	else
	{
		//echo "<pre>Fatal Error: The Class <b>\"".$filename."\"</b> Not Found on this path <b>".$path."</b></pre>";
	}
});

require_once INC.'plugins_inc.php';

?>