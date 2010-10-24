<?php
session_start();

/** 
 * class to handle logging in, to use it make a table to hold login data
 * and build a model with db/buildmodels.php for the table
 * the class should implement the PW interface in lib/pw.php
 * by default this is whatever LOGINCLASS is
 */
class Login {

	private static $ldata;
	private static $errors;

	public static function logout() {
		self::$ldata = null;
		unset($_SESSION['login']);
		unset($_COOKIE['from']);
		setcookie('from',null,mktime(0,0,0,1,1,1970));
	}

	public static function check() {
		$pwclass = LOGINMODEL;
		return self::authenticate($pwclass);
	}

	private static function authenticate($pwclass) {
		# if already logged in then 
		if (is_array($_SESSION['login'])) return $_SESSION['login'];

		$pw = new $pwclass;
		$login = $_REQUEST['login'];
		if (!$pw->valid_login($login)) return;

		$password = $_REQUEST['password'];

		if (!$pw->valid_pw($password)) return;
		$password = $pw->encode_pw($password);

		$ldata = $pw->get_login($login);
		$loginok = ($ldata['password'] === $password) ? true : false;

		if ($loginok) {
			$ldata = self::save_login($login,$ldata);
			return $ldata;
		}
		return;
	}

	public static function encode($pw) {
		require(SALTFILE);
		return sha1($pw.SALT);
	}

	/**
	 * convenience method for checking the password data in 
	 * tools/passwordform.tpl
	 */
	public static function getpw($pwclass=LOGINMODEL) {
		self::err(null,true);
		$ldata = Login::authenticate($pwclass);
		if (!is_array($ldata)) {
			self::err("you are not logged in!");
			return false;
		}
		$pw = new $pwclass;
		$me = $pw->getone($ldata['login']);
		if ($me['password'] != $pw->encode_pw($_REQUEST['old_password'])) {
			self::err("old password was wrong!");
		}
		if (!Check::validpassword($newpw=$_REQUEST['new_password'])) {
			self::err("invalid password ".Check::err());
		}
		if ($newpw == $_REQUEST['old_password']) {
			self::err("new password same as old password - aborting");
			return false;
		}
		if ($newpw != $_REQUEST['confirm_password']) {
			self::err("new passwords don't match!");
		}
		if (count(self::err())) {
			return false;
		}
		return $pw->encode_pw($newpw);
	}
	
	private static function save_login($this_login,$ldata) {
		unset($ldata['password']);
		self::$ldata = $ldata;
		$_SESSION['login'] = $ldata;
		$_SESSION['login']['login'] = $this_login;
		$_SESSION['login']['time'] = $time = time();
		return $_SESSION['login'];
	}

	public static function err($error=null,$refresh=false) {
		if ($refresh) self::$errors = array();
		if (isset($error)) self::$errors[] = $error;
		return self::$errors;
	}
}
