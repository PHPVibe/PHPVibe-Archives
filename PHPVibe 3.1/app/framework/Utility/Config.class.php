<?php

require_once 'ConfigHolder.class.php';

class MK_Config{

	public static $config;

	public static function loadConfig($config){
		if(empty(self::$config)){
			self::$config = new MK_Config_Holder();
		}
		self::$config->loadConfig($config);
	}
	
	public static function getInstance(){
		return self::$config;
	}
	
}

?>