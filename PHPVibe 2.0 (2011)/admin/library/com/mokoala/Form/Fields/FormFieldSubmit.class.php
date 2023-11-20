<?php

class MK_Form_Field_Submit extends MK_Form_Field_Abstract{

	protected function renderField(){
		if(empty($this->attributes['type'])){
			$this->attributes['type'] = 'submit';
		}
		$this->attributes['id'] = $this->getName();
		$this->attributes['name'] = $this->getName();
		$html = '<div class="input-left"><div class="input-right">
						<input'.$this->getAttributes().' />
				</div></div>';
		return $html;
	}

}

?>