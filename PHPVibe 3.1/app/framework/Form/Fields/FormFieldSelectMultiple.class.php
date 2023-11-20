<?php

require_once 'FormFieldOptionsMultiple.class.php';

class MK_Form_Field_Select_Multiple extends MK_Form_Field_Options_Multiple_Abstract{

	public function __construct($name, $field_data = null){

		parent::__construct( $name, $field_data );

		$this->attributes['multiple'] = 'multiple';

	}

	protected function renderField(){

		$html = '<label class="input-select" for="'.$this->getName().'">'.$this->getLabel().'</label>';
		$html .= '<div class="input-left"><div class="input-right">';
		$html .= '<select'.($this->getAttributes()).' class="data input-select" name="'.$this->getName().'[]" id="'.$this->getName().'">';
		foreach($this->options as $value => $option){
			$attributes = array();
			if( in_array( $value, $this->getValue() ) ){
				$attributes['selected'] = 'selected';
			}
			
			if(!empty($option['tooltip'])){
				$attributes['title'] = form_data($option['tooltip']);
			}
			
			$html.='<option'.$this->getAttributesFromArray( $attributes ).' value="'.form_data($value).'">'.$option['title'].'</option>';
		}
		$html .= '</select>';
		$html .= '</div></div>';
		return $html;
	}

}

?>