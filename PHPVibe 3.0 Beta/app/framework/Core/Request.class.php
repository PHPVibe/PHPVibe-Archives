<?php

abstract class MK_Request
{
	
	protected static $params = array();

	public static function init($query = array(), $post = array())
	{
		self::$params = array(
			'param' => array(),
			'query' => $query,
			'post' => $post
		);
	}

	public static function getParam( $key, $default_value = null )
	{
		$value = $default_value;
		$value = self::_getParam( $key, $value );
		$value = self::getQuery( $key, $value );
		$value = self::getPost( $key, $value );
		return $value;
	}

	protected static function _getParam( $key = null, $default_value = null )
	{
		if(empty($key))
		{
			return self::$params['param'];
		}
		elseif( array_key_exists( $key, self::$params['param'] ) )
		{
			return self::$params['param'][$key];
		}
		else
		{
			return $default_value;
		}
	}

	public static function getPost( $key = null, $default_value = null )
	{
		if(empty($key))
		{
			return self::$params['post'];
		}
		elseif( array_key_exists( $key, self::$params['post'] ) )
		{
			return self::$params['post'][$key];
		}
		else
		{
			return $default_value;
		}
	}

	public static function getQuery( $key = null, $default_value = null )
	{
		if(empty($key))
		{
			return self::$params['query'];
		}
		elseif( array_key_exists( $key, self::$params['query'] ) )
		{
			return self::$params['query'][$key];
		}
		else
		{
			return $default_value;
		}
	}
	
	public static function setParam( $key, $value )
	{
		self::$params['param'][$key] = $value;
	}
	
	public static function setPost( $key, $value )
	{
		self::$params['post'][$key] = $value;
	}
	
	public static function setQuery( $key, $value )
	{
		self::$params['query'][$key] = $value;
	}
	
}

?>