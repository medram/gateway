<?php
session_start();

define('START_TIME', microtime(true));
define('PROTOCOL', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' && $_SERVER['SERVER_PORT'] == 443 ? 'https' : 'http');
define('BASE_URL', PROTOCOL.'://'.$_SERVER['HTTP_HOST'].'/test/gateway/');

define('DEBUG', true);
define('DEBUG_SHOW_ERRORS', true);
//define('DEBUG_SHOW_MSGS_CONSOLE', true);
define('ENCRYPTION_KEY', sha1('md4web'));

define('ROOT', str_replace('\\', '/', dirname(__FILE__)).'/');
define('INC', ROOT.'inc/');
define('CLASS_DIR', INC.'classes/');
define('VIEWS_DIR', INC.'views/');
define('UPLOADS_DIR', INC.'uploads/');
define('API_DIR', ROOT.'API/');

// default timezone.
date_default_timezone_set("Etc/GMT+0");

require_once "vendor/autoload.php";
require_once INC.'common.php';

// force to use https.
useSSL(true);

/*
* autoload classes.
*/
spl_autoload_register(function ($filename){

	/*
	$aliases = [
		'MR4Web\\API\\' => API_DIR,
		'MR4Web\\'	=> CLASS_DIR,
	];

	$path = '';

	foreach ($aliases as $key => $value)
	{
		print_r($path);
		if ($path != '')
			break;
	}
	$path = preg_replace("/^MR4Web/", CLASS_DIR, $filename);
	*/
	
	$path = str_ireplace('MR4Web\\', CLASS_DIR, $filename);
	$path = $path.'.php';
	$path = str_ireplace(['\\', '//'], '/', $path);

	//echo $path."<br>";
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