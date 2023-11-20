<?php

require_once 'FormFieldOptions.class.php';

class MK_Form_Field_Select extends MK_Form_Field_Options_Abstract{

	protected function renderField(){

		$html = '<label for="'.$this->getName().'">'.$this->getLabel().'</label>';
		$html .= '<div class="formRight">';
		$html .= '<select'.($this->getAttributes()).' name="'.$this->getName().'" id="'.$this->getName().'" value="'.$this->getValue().'">';
		if( is_array( reset($this->options) ) ){
			$html .= $this->renderFieldGroup();
		}else{
			$html .= $this->renderFieldSingle();
		}
		$html .= '</select>';
		$html .= '</div><div class="clear"></div>';
		return $html;
	}
	
	private function renderFieldSingle(){
		$html = '';
		foreach($this->options as $value => $option){
			$attributes = array();
			if( $value == $this->getValue() ){
				$attributes['selected'] = 'selected';
			}
			$html.='<option'.$this->getAttributesFromArray( $attributes ).' value="'.form_data($value).'">'.$option.'</option>';
		}
		return $html;
	}
	
	private function renderFieldGroup(){
		$html = '';
		foreach($this->options as $label => $options){
			$html.='<optgroup label="'.form_data($label).'">';
			foreach($options as $value => $option){
				$attributes = array();
				if( $value == $this->getValue() ){
					$attributes['selected'] = 'selected';
				}
				$html.='<option'.$this->getAttributesFromArray( $attributes ).' value="'.form_data($value).'">'.$option.'</option>';
			}
			$html.='</optgroup>';
		}
		return $html;
	}

}

?>