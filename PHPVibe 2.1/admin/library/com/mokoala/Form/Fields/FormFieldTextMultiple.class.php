<?php

require_once 'FormFieldOptionsMultiple.class.php';
class MK_Form_Field_Text_Multiple extends MK_Form_Field_Options_Multiple_Abstract{
	
	protected function renderField(){
		$html = '<label class="input-text" for="'.$this->getName().'">'.$this->getLabel().'</label>';
		$counter = 0;
		if( count($this->value) > 0 )
		{
			foreach($this->value as $single_value)
			{
				$html .= '<input'.($this->getAttributes()).' class="data input-text input-text-xsmall" name="'.$this->getName().'[]" value="'.$single_value.'" />';
			}
		}
		else
		{
			$html .= '<input'.($this->getAttributes()).' class="data input-text input-text-xsmall" name="'.$this->getName().'[]" value="'.$single_value.'" />';
		}
		return $html;
	}
	
}

?>