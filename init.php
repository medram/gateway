<?php
session_start();

define('START_TIME', microtime(true));

define('DEBUG', true);
define('DEBUG_SHOW_ERRORS', false);
//define('DEBUG_SHOW_MSGS_CONSOLE', true);
define('ENCRYPTION_KEY', sha1('md4web'));

define('ROOT', str_replace('\\', '/', dirname(__FILE__)).'/');
define('INC', ROOT.'inc/');
define('CLASS_DIR', INC.'classes/');
define('VIEWS_DIR', INC.'views/');
define('UPLOADS_DIR', INC.'uploads/');
define('API_DIR', ROOT.'API/');
define('PLUGINS_DIR', INC.'plugins/');

// default timezone.
date_default_timezone_set("Etc/GMT+0");

require_once "vendor/autoload.php";

// loading .env file.
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

/*
* autoload classes.
*/
spl_autoload_register(function ($filename){

	$path = str_ireplace('MR4Web\\', CLASS_DIR, $filename);
	$path = $path.'.php';
	$path = str_ireplace(['\\', '//'], '/', $path);

	//echo $path."<br>";
	if (file_exists($path))
	{
		require $path;
	}
	else
	{
		//echo "<pre>Fatal Error: The Class <b>\"".$filename."\"</b> Not Found on this path <b>".$path."</b></pre>";
	}
});

// Make a base url for this project
define('PROTOCOL', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' && $_SERVER['SERVER_PORT'] == 443 ? 'https' : 'http');
$projectFolder = trim(MR4Web\Configs\Config::get('projectFolder'), '/');
$projectFolder = $projectFolder != '' ? $projectFolder.'/' : $projectFolder;

define('DOMAIN', PROTOCOL.'://'.$_SERVER['HTTP_HOST']);
define('BASE_URL', PROTOCOL.'://'.$_SERVER['HTTP_HOST'].'/'.$projectFolder);
define('DASHBOARD_URL', BASE_URL.'dashboard/');

require_once INC.'common.php';

// force to use https.
$force_https = getenv('FORCE_HTTPS') === 'true' ? true : false ;
useSSL($force_https);

require_once INC.'plugins_inc.php';

?>
