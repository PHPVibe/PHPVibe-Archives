<?php

class MK_Config_Handler implements MK_Config_Handler_Interface{

	protected $_data = array();

	public function __set($key, $value){
		$this->_data[$key] = $value;
		$this->save();
	}

	public function __get($key){
		if($this->__isset($key)){
			return $this->_data[$key];
		}else{
			return null;
		}
	}
	
	public function __isset($key){
		if(array_key_exists($key, $this->_data)){
			return true;
		}else{
			return false;
		}
	}
	
	public function __unset($key){
		if(array_key_exists($key, $this->_data)){
			unset($this->_data[$key]);
			$this->save();
		}
	}
	
	public function load($data){
		if( is_array($data) ){
			foreach($data as $key => $value){
				$this->_data[$key] = $value;
			}
		}else{
			$this->_data = $data;
		}
	}
	
	protected function save(){}

}

?>