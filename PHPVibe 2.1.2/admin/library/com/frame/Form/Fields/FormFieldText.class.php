<?php

class MK_Form_Field_Text extends MK_Form_Field_Abstract{
	
	public function __construct($name, $field_data = null){
		
		parent::__construct($name, $field_data);
		
		if(empty($this->attributes['type']) ){
			$this->attributes['type'] = 'text';
		}

	}
	
}

?>