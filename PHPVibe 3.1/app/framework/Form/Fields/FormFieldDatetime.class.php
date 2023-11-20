<?php

class MK_Form_Field_Datetime extends MK_Form_Field_Abstract{
	
	public function setValue($post_value = null)
	{
		if(
			is_array($post_value) &&
			array_key_exists('h', $post_value) &&
			array_key_exists('i', $post_value) &&
			array_key_exists('m', $post_value) &&
			array_key_exists('d', $post_value) &&
			array_key_exists('y', $post_value)
		)
		{
			$this->value = mktime($post_value['h'], $post_value['i'], 01, $post_value['m'], $post_value['d'], $post_value['y']);
		}
		elseif(is_string($post_value) && !empty($post_value))
		{
			$this->value = strtotime( $post_value );
		}
		elseif(!is_array($post_value))
		{
			$this->value = $post_value;
		}
	}
	
	public function getValue(){
		return !empty($this->value) ? date('Y-m-d H:i:s', $this->value) : null;
	}

	protected function renderField(){

		$value = $this->value;
		$name = $this->getName();
		$months = MK_Utility::getMonthList();

		$html = '<label class="input-text" for="'.$name.'[m]">'.$this->getLabel().'</label>';

		$html.='<select name="'.$this->getName().'[m]" id="'.$this->getName().'_m" class="select-small">';
		if(empty($value)){
			$html.='<option selected="selected" value=""></option>';
		}
		foreach($months as $m => $month){
			$html.='<option'.( !empty($value) && $m == date('n', $value) ? ' selected="selected"' : null ).' value="'.$m.'">'.$month.'</option>';
		}
		$html.='</select>';

		$html.='<select name="'.$name.'[d]" id="'.$name.'_d" class="select-xxsmall">';
		if(empty($value)){
			$html.='<option selected="selected" value=""></option>';
		}
		for($d=1;$d<=31;$d++){
			$html.='<option'.( !empty($value) && $d == date('j', $value) ? ' selected="selected"' : null ).' value="'.$d.'">'.str_pad($d, 2, "0", STR_PAD_LEFT).'</option>';
		}
		$html.='</select>';

		$html.='<select name="'.$name.'[y]" id="'.$name.'_y" class="select-xsmall">';
		if(empty($value)){
			$html.='<option selected="selected" value=""></option>';
		}
		for($y = date('y') - 100; $y <= date('Y') + 100; $y++){
			$html.='<option'.( !empty($value) && $y == date('Y', $value) ? ' selected="selected"' : null ).' value="'.$y.'">'.$y.'</option>';
		}
		$html.='</select>';

		$html.='<p class="float-text">at</p>';

		$html.='<select name="'.$name.'[h]" id="'.$name.'_h" class="select-xxsmall">';
		if(empty($value)){
			$html.='<option selected="selected" value=""></option>';
		}
		for($h=0; $h <= 23; $h++){
			$html.='<option'.( !empty($value) && $h == date('H', $value) ? ' selected="selected"' : null ).' value="'.$h.'">'.str_pad($h, 2, "0", STR_PAD_LEFT).'</option>';
		}
		$html.='</select>';

		$html.='<select name="'.$name.'[i]" id="'.$name.'_i" class="select-xxsmall">';
		if(empty($value)){
			$html.='<option selected="selected" value=""></option>';
		}
		for($i=0; $i <= 59; $i++){
			$html.='<option'.( !empty($value) && $i == date('i', $value) ? ' selected="selected"' : null ).' value="'.$i.'">'.str_pad($i, 2, "0", STR_PAD_LEFT).'</option>';
		}
		$html.='</select>';
		
		return $html;
	}
	
}

?>