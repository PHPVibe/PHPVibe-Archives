<?php

abstract class MK_Form_Field_Options_Abstract extends MK_Form_Field_Abstract{

	protected $options = array();

	public function __construct($name, $field_data){

		parent::__construct($name, $field_data);

		if(!empty($field_data['options'])){
			$this->options = $field_data['options'];
		}

	}

}

?>