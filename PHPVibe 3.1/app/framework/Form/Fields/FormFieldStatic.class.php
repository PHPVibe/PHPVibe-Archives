<?php

class MK_Form_Field_Static extends MK_Form_Field_Abstract{

	protected function renderField(){
		$html = '<label class="input-text" for="'.$this->getName().'">'.$this->getLabel().'</label>';
		$html .= '<p class="input-static">'.($this->getValue() ? $this->getValue() : 'None defined').'</p>';
		$html .= '<input type="hidden" name="'.$this->getName().'" value="'.$this->getValue().'" />';
		return $html;
	}
	
}

?>