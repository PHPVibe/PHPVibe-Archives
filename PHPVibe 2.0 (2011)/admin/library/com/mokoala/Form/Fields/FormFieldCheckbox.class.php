<?php

class MK_Form_Field_Checkbox extends MK_Form_Field_Abstract{
	
	public function setValue( $value = null )
	{
		$this->value = (boolean) $value;
	}
	
	public function getValue()
	{
		return $this->value;
	}
	
	protected function renderField(){
		$this->attributes['type'] = 'checkbox';
		if($this->getValue()){
			$this->attributes['checked'] = 'checked';
		}
		$html = '<label class="input-checkbox" for="'.$this->getName().'">'.$this->getLabel().'</label>';
		$html .= '<input'.($this->getAttributes()).' class="data input-checkbox" name="'.$this->getName().'" id="'.$this->getName().'" />';
		return $html;
	}

}

?>