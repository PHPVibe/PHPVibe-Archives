<?php

class MK_Form_Field_Link extends MK_Form_Field_Abstract{

	protected $text;

	public function __construct($name, $field_data = null){
		
		parent::__construct($name, $field_data);
		
		if( !empty($field_data['text']) ){
			$this->text = $field_data['text'];
		}

	}
	
	public function getText(){
		return $this->text;
	}

	protected function renderField(){

		$html = '<div class="input-left"><div class="input-right">
						<a'.($this->getAttributes()).'>'.$this->getText().'</a>
				</div></div>';
		return $html;
	}

}

?>