<?php

class MK_Form_Field_Textarea extends MK_Form_Field_Abstract{

	public function __construct($name, $field_data){

		parent::__construct($name, $field_data);

		$this->attributes['class'] = 'data input-textarea'.(!empty($this->attributes['class']) ? ' '.$this->attributes['class'] : '');

	}
		
	protected function renderField(){
		$html = '<label class="input-text" for="'.$this->getName().'">'.$this->getLabel().'</label>';
		$html .= '<div class="input-left"><div class="input-right"><textarea'.($this->getAttributes()).' name="'.$this->getName().'" id="'.$this->getName().'">'.form_data($this->getValue()).'</textarea></div></div>';
		return $html;
	}
	
}

?>