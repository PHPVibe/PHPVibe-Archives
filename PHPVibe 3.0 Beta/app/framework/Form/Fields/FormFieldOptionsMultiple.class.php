<?php

require_once 'FormFieldOptions.class.php';

abstract class MK_Form_Field_Options_Multiple_Abstract extends MK_Form_Field_Options_Abstract{

	protected $value = array();

	public function setValue($post_value = null){
		$this->value = $post_value;
	}

}

?>