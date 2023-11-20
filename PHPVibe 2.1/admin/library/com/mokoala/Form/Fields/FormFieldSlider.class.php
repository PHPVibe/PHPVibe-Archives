<?php

require_once 'FormFieldOptionsMultiple.class.php';

class MK_Form_Field_Slider extends MK_Form_Field_Options_Multiple_Abstract{

	protected function renderField(){
		$value = $this->value;

		$html = '<label class="input-text" for="'.$this->getName().'">'.$this->getLabel().'</label>';
		$counter = 0;
		foreach($this->options as $option){
			$index = $counter;
			$counter++;

			$html.='<div class="slider-field clear-fix">';
			$html.='<div class="tooltip"><h5 class="text">'.$option['label'].'</h5><p>'.(!empty($option['tooltip']) ? $option['tooltip'] : '').'</p></div>';
			$html.='<label class="input-text" for="'.$this->getName().'_'.$index.'">'.(!empty($option['label']) ? $option['label'] : '').'</label>';
			$html.='<input class="slider input-text" name="'.$this->getName().'['.$index.']" id="'.$this->getName().'+'.$index.'" value="'.( empty($value[$index]) ? '0' : $value[$index] ).'" />';
			$html.='</div>';
		}

		return $html;
	}

	public function setValue($value = null){
		
		if( is_array( $value ) ){
			$this->value = $value;
		}else{
			$this->value = explode(',', $value);
		}
		
	}

	public function getValue(){
		
		return implode(',', $this->value);
		
	}

	public function render(){
		$html ='<div class="'.$this->getClasses().'">';
		$html .= $this->renderField();
		$html .= $this->getTooltip();
		$html .= $this->getErrors();
		$html.='</div>';
		return $html;
	}

}

?>