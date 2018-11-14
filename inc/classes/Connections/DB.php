<?php

namespace MR4Web\Connections;

use MR4Web\Configs\Config;

class DB 
{
	private static $_DB;

	private function __construct(){}
	private function __clone(){}

	public static function &getInstance()
	{
		if (!self::$_DB instanceof \PDO)
			self::$_DB = self::factoryConnection();
		return self::$_DB;
	}

	private static function factoryConnection ()
	{
		$conf = Config::Get('DB');

		try {
			$DB = new \PDO("mysql:host={$conf['HOSTNAME']};dbname={$conf['DB_NAME']}", $conf['DB_USER'], $conf['DB_PASS']);

			$DB->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

		} catch (\PDOException $e) {
			die('Error Connection to Database!');
		}

		$DB->query('SET NAMES UTF8');
		//echo "Connected<br>";
		return $DB;
	}
}





?>