<?php

class MK_Cookie_Holder extends MK_Config_Handler{

	protected $_domain;
	protected $_path;

	public function __construct($path, $domain){
		$this->_path = $path;
		$this->_domain = $domain;
	}

	public function __set($key, $value){}
	
	public function __isset($key)
	{
		if(array_key_exists($key, $_COOKIE)){
			return true;
		}else{
			return false;
		}
	}
	
	public function __unset($key)
	{
		setcookie($key, '', time() - 86400, $this->_path, $this->_domain );
	}

	public function set($key, $value, $expiry)
	{
		setcookie($key, $value, time() + $expiry, $this->_path, $this->_domain );
	}

}


?>