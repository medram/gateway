<?php

namespace MR4Web\Configs;

class Config 
{
	private static $_config;

	private function __construct(){} 
	private function __clone(){}

	public static function Get($param=null)
	{
		if (self::$_config == '')
			self::Load();

		if (isset(self::$_config[$param]))
			return self::$_config[$param];
	} 

	private static function load()
	{
		$path = INC.'config.php';
		if (file_exists($path))
		{
			self::$_config = include $path; 
		}
	} 
}

?>