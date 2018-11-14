<?php

namespace MR4Web\Models;

use MR4Web\Models\PDOModel;

class Setting extends PDOModel {

	private static $_settings = [];

	public function __construct($data = NULL)
	{
		$schema = [
			'id'		=> \PDO::PARAM_INT,
			'name'		=> \PDO::PARAM_STR,
			'value'		=> \PDO::PARAM_STR,
			'autoload'	=> \PDO::PARAM_STR
		];
		parent::__construct($schema, $data);
	}

	// $getAll = true means that will fetch all settings.
	public static function getSettings()
	{
		//echo 'loading...<br>';
		if (count(self::$_settings))
			return self::$_settings;

		$buffer = self::getAllBy(['autoload' => 1]);
		
		foreach ($buffer as $setting)
			self::$_settings[$setting->name] = $setting->value;

		return self::$_settings;
	}

	public static function get($key = NULL)
	{
		if ($key == NULL) return NULL;

		self::getSettings(); // auto load settings if are not exists.

		if (!isset(self::$_settings[$key]))
		{
			$setting = self::getBy(['name' => $key]);
			self::$_settings[$setting->name] = $setting->value;
		}
		return self::$_settings[$key];
	}
}

?>