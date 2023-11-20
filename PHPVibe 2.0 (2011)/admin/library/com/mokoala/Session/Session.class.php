<?php

class MK_Session
{

	protected static $_session;

	public static function start($namespace = 'default', $path = '/', $domain = null)
	{

		if(self::$_session === null)
		{
			session_set_cookie_params(86400, $path, $domain);
			session_start();
			self::$_session = new MK_Session_Holder($namespace);
		}

		if(array_key_exists($namespace, $_SESSION))
		{
			$config = MK_Config::getInstance();
			self::$_session->load($_SESSION[$namespace]);
		}

	}
	
	public static function getInstance()
	{
		return (object) self::$_session;
	}

}

?>