<?php

require_once 'FormFieldDatetime.class.php';

class MK_Form_Field_Datetime_Now extends MK_Form_Field_Datetime{
	
	public function setValue($post_value = null){

		parent::setValue($post_value);

		if( empty( $this->value ) ){
			$this->value = time();
		}
		
		
	}

}

?>