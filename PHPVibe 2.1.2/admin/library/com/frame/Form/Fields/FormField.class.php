<?php

require_once 'FormField.interface.php';

abstract class MK_Form_Field_Abstract implements MK_Form_Field_Interface{

	protected $name;
	protected $label;
	protected $fieldset;
	protected $tooltip;
	protected $type;
	protected $value;
	protected $attributes = array();
	protected $validation = array();

	protected $validator;

	public function __construct($name, $field_data = null){

		$this->name = $name;
		$this->validator = new MK_Validator();

		if(!empty($field_data['validation'])){
			$this->validation = $field_data['validation'];
		}

		if(!empty($field_data['label'])){
			$this->label = $field_data['label'];
		}

		if(!empty($field_data['tooltip'])){
			$this->tooltip = $field_data['tooltip'];
		}

		if(!empty($field_data['type'])){
			$this->type = $field_data['type'];
		}

		$this->fieldset = !empty($field_data['fieldset']) ? $field_data['fieldset'] : 'default';

		if(isset($field_data['value'])){
			$this->setValue($field_data['value']);
		}

		if(!empty($field_data['attributes'])){
			$this->attributes = $field_data['attributes'];
		}

	}
	
	public function getValidator(){
		return $this->validator;
	}

	public function getFieldset(){
		return $this->fieldset;
	}

	public function getValue(){
		return $this->value;
	}

	public function isSubmitted(){
		return array_key_exists( $this->getName(), $_POST );
	}

	public function setValue($post_value = null){
		$this->value = $post_value;
	}
	
	public function process(){
		
	}

	public function validate(){

		foreach($this->validation as $rule => $args)
		{
			if( $rule === 'instance' && substr( $this->getType(), 0, 4 ) == 'file' )
			{
				continue;
			}

			$method = 'check'.MK_Utility::stringToReference($rule);

			if(!is_array($args)){
				$args = array();
			}
			
			if(method_exists($this->validator, $method)){

				$this->validator->$method($this->getValue(), $args);

			}

		}

	}
	
	public function isValid(){
		
		return $this->validator->getStatus();
		
	}
	
	public function render(){
		$html = '<div class="'.$this->getClasses().'">';
		$html .= $this->renderField();
		$html .= $this->getTooltip();
		$html .= $this->getErrors();
		$html .= '</div>';
		return $html;
	}

	protected function getClasses(){
		return 'clear-fix form-field field-'.slug($this->getName()).' form-field-'.slug($this->getType());
	}

	protected function getTooltip(){
		if(!empty($this->tooltip)){
			return '<p class="tooltip">'.$this->tooltip.'</p>';
		}else{
			return '';	
		}
	}
	
	public function getName(){
		return $this->name;
	}
	
	public function getType(){
		return $this->type;
	}
	
	public function getLabel(){
		return $this->label;
	}
	
	protected function getErrors(){
		$error = $this->getValidator()->getErrors();
		$error = array_shift($error);
		if(!empty($error)){
			return '<p class="error message">'.$error.'</p>';
		}else{
			return '';	
		}
	}
	
	protected function getAttributesFromArray($attributes_array){
		$attribute_list = array();
		if(!empty($attributes_array) && is_array($attributes_array)){
			foreach($attributes_array as $attribute => $value){
				$attribute_list[] = $attribute.(!empty($value) ? '="'.form_data($value).'"' : '');
			}
		}
		return count($attribute_list) > 0 ? ' '.implode(' ', $attribute_list) : '';
	}

	protected function getAttributes(){
		return $this->getAttributesFromArray($this->attributes);
	}

	protected function renderField(){
		$html = '<label class="input-text" for="'.$this->getName().'">'.$this->getLabel().'</label>';
		$html .= '<div class="input-left"><div class="input-right"><input'.($this->getAttributes()).' class="data input-text" name="'.$this->getName().'" id="'.$this->getName().'" value="'.$this->getValue().'" /></div></div>';
		return $html;
	}

}

?>