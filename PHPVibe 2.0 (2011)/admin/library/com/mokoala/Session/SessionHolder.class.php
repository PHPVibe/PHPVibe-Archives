<?php

class MK_Session_Holder extends MK_Config_Handler{

	protected $_namespace;

	public function __construct($namespace){
		$this->_namespace = $namespace;
	}
	
	protected function save(){
		$_SESSION[$this->_namespace] = $this->_data;
	}

}

?>