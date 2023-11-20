<?php

class MK_Form_Field_Submit extends MK_Form_Field_Abstract{

	protected function renderField(){
		if(empty($this->attributes['type'])){
			$this->attributes['type'] = 'submit';
		}
		$this->attributes['id'] = $this->getName();
		$this->attributes['name'] = $this->getName();
		$html = '<input'.$this->getAttributes().' class="button blue"/>';
		return $html;
	}

}

?>