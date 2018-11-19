<?php

namespace MR4Web\Models;

use MR4Web\Models\PDOModel;
use MR4Web\Models\Role;

class User extends PDOModel {

	private static $_currentUser;
	private $_userFolder;
	private $_usersFolders = ['products'];

	public function __construct($data = NULL)
	{
		$schema = [
			'id'		=> \PDO::PARAM_INT,
			'username'	=> \PDO::PARAM_STR,
			'email'		=> \PDO::PARAM_STR,
			'password'	=> \PDO::PARAM_STR,
			'token'		=> \PDO::PARAM_STR,
			'created'	=> \PDO::PARAM_STR,
			'roles_id'	=> \PDO::PARAM_INT
		];

		parent::__construct($schema, $data);
		$this->_createUserFolders();
	}

	private function _createUserFolders()
	{
		//print_r(self::$_currentUser);
		if (!is_null($this->id))
		{
			$path = UPLOADS_DIR.'users/ID_'.$this->id.'/';
			
			//mkdir($path, 0777);
			foreach ($this->_usersFolders as $name)
			{
				if (!is_dir($path.$name))
				{
					mkdir($path.$name, 0777, true);
				}
			}
			
			$this->_userFolder = $path;
		}
	}

	public function getRole()
	{
		return Role::get($this->roles_id);
	}

	public static function login($email, $password)
	{
		do_action('before_user_logged_in', [$email, $password]);

		$pass = hash('sha256', ENCRYPTION_KEY.$password);
		
		$user = self::getBy([
			'email' => $email,
			'password' => $pass
		]);

		if ($user instanceof User)
		{
			self::$_currentUser = $user;
			// make a session.
			$_SESSION['login']['status'] = true;
			$_SESSION['login']['token'] = $user->token;
			$_SESSION['login']['ip'] = get_client_ip();
			$_SESSION['login']['agent'] = $_SERVER['HTTP_USER_AGENT'];

			do_action('after_user_logged_in', $this);

			return true;
		}

		return false;
	}

	public static function logout()
	{
		do_action('before_user_logged_out');
		unset($_SESSION['login']);
		do_action('after_user_logged_out');
	}

	public static function isLogin()
	{
		$browser = isset($_SESSION['login'])? $_SESSION['login'] : [];
		
		if (count($browser) && $browser['status'] == true && $browser['ip'] == get_client_ip() && $browser['agent'] == $_SERVER['HTTP_USER_AGENT'])
		{
			$user = User::getBy(['token' => $browser['token']]);
			if ($user instanceof User)
			{
				self::$_currentUser = $user;
				return true;
			}
		}

		return false;
	}

	public static function getUser()
	{
		if (self::$_currentUser instanceof User)
			return self::$_currentUser;
		return NULL;
	}

	public function getUserProductsPath()
	{
		return $this->_userFolder.'products/';
	}
}

?>