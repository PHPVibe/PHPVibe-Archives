<?php

class MK_Cookie
{

	protected static $_cookie = null;

	public static function start($path, $server)
	{
		self::$_cookie = new MK_Cookie_Holder($path, $server);
		self::$_cookie->load($_COOKIE);
	}

	public static function getInstance()
	{
		return self::$_cookie;
	}

}

?>