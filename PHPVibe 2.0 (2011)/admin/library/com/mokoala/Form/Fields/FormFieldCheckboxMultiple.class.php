<?php

require_once 'FormFieldOptionsMultiple.class.php';

class MK_Form_Field_Checkbox_Multiple extends MK_Form_Field_Options_Multiple_Abstract{

	public function setValue($value = null)
	{
		if( is_array($value) )
		{
			$this->value = $value;
		}
		else
		{
			$this->value = array();
		}
	}

	public function getValue()
	{
		if( is_array($this->value) )
		{
			return $this->value;
		}
		else
		{
			return array();	
		}
	}

	protected function renderField(){

		$html = '<label class="input-text" for="'.$this->getName().'">'.$this->getLabel().'</label>';
		$html .= '<div class="form-field-group">';

		foreach($this->options as $value => $option){

			if( !is_array( $option ) ){
				$option = array(
					'title' => $option
				);
			}

			if( in_array( $value, $this->value ) || !empty( $option['disabled'] ) ){
				$option['checked'] = 'checked';
				unset($option['disabled']);
			}
			
			$option['id'] = $this->getName().'_'.slug($option['title']);
			$option['name'] = $this->getName().'[]';
			$option['type'] = 'checkbox';
			$option['value'] = $value;
			
			$html.='<div class="group-option"><input'.$this->getAttributesFromArray( $option ).'><label for="'.$option['id'].'">'.$option['title'].'</label></div>';

		}

		$html .= '</div>';

		return $html;
	}

}

?>