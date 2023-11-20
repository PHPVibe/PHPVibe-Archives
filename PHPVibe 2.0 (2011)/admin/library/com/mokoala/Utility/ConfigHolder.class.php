<?php
class MK_Config_Holder extends stdClass{

	public function loadConfig($config){
		foreach($config as $key => $value){
			if(!is_array($value)){
				$this->{$key} = $value;
			}else{
				if(isset($this->{$key}) and $this->{$key} instanceof MK_Config_Holder){
					$this->{$key}->loadConfig($value);
				}else{
					$this->{$key} = new MK_Config_Holder();
					$this->{$key}->loadConfig($value);
				}
			}
		}
	}

	public function __get($name)
	{
		return '';
	}

}

?>