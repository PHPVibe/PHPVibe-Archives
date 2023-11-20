<?php

require_once 'Fields/FormField.class.php';

require_once 'Fields/FormFieldLink.class.php';
require_once 'Fields/FormFieldText.class.php';
require_once 'Fields/FormFieldTextMultiple.class.php';
require_once 'Fields/FormFieldSlider.class.php';
require_once 'Fields/FormFieldPassword.class.php';
require_once 'Fields/FormFieldSubmit.class.php';
require_once 'Fields/FormFieldCheckboxMultiple.class.php';
require_once 'Fields/FormFieldCheckbox.class.php';
require_once 'Fields/FormFieldCaptcha.class.php';
require_once 'Fields/FormFieldSelect.class.php';
require_once 'Fields/FormFieldSelectMultiple.class.php';
require_once 'Fields/FormFieldTextarea.class.php';
require_once 'Fields/FormFieldRichText.class.php';
require_once 'Fields/FormFieldDatetime.class.php';
require_once 'Fields/FormFieldDatetimeNow.class.php';
require_once 'Fields/FormFieldDatetimeStatic.class.php';
require_once 'Fields/FormFieldDate.class.php';
require_once 'Fields/FormFieldStatic.class.php';
require_once 'Fields/FormFieldFile.class.php';
require_once 'Fields/FormFieldFileImage.class.php';

class MK_Form
{
	protected $data			= array();

	protected $settings		= array();
	protected $fields		= array();

	public function __construct( $fields, $settings = array() )
	{
		$default_settings = array(
			'inline_validation' => false,
			'attributes'		=> array(
				'name' 				=> 'form',
				'autocomplete' 		=> 'on',
				'enctype' 			=> 'multipart/form-data',
				'method' 			=> 'post',
				'action' 			=> $_SERVER['REQUEST_URI']
			)
		);

		$this->settings = array_merge_replace($default_settings, $settings);

		/*if(!function_exists('json_encode')){
			$this->settings['inline_validation'] = false;
		}*/

		// Pull all POST & FILES values into single array
		$this->data = array_merge_replace($_FILES, $_POST);

		$fields = array_filter($fields);

		foreach($fields as $name => $field)
		{
			if(empty($field['type']))
			{
				$field['type'] = 'text';
			}

			if($this->isSubmitted())
			{
				if(get_magic_quotes_gpc() && !is_array($this->data[$name]))
				{
					$this->data[$name] = stripslashes($this->data[$name]);
				}

				$field['value'] = isset($this->data[$name]) ? $this->data[$name] : null;
			}
			else
			{
				$field['value'] = isset($field['value']) ? $field['value'] : null;
			}

			$this->fields[$name] = $this->loadFieldObject($field['type'], $name, $field);
		}

		if($this->isSubmitted())
		{
			$field_list = array_keys($this->fields);

			foreach($field_list as $field)
			{
				$this->fields[$field]->validate();
			}

			if($this->isSuccessful())
			{
				foreach($field_list as $field)
				{
					$this->fields[$field]->process();
				}				
			}
		}

	}

	protected function loadFieldObject($type, $name, $field)
	{

		$type = str_replace(' ', '_', ucwords( str_replace(array('-', '_'), ' ', $type) ) );
		$classname = 'MK_Form_Field_'.$type;
		if(class_exists($classname))
		{
			return new $classname($name, $field);
		}
		else
		{
			return new MK_Form_Field_Text($name, $field);
		}

	}

	protected function getAttributes()
	{
		$attribute_list = array();
		if(!empty($this->settings['attributes']) && is_array($this->settings['attributes']))
		{
			foreach($this->settings['attributes'] as $attribute => $value)
			{
				$attribute_list[] = $attribute.'="'.form_data($value).'"';
			}
		}
		return count($attribute_list) > 0 ? ' '.implode(' ', $attribute_list) : '';
	}
	
	public function getField($field_name)
	{
		if(array_key_exists($field_name, $this->fields))
		{
			return $this->fields[$field_name];
		}
		else
		{
			return null;	
		}
	}
	
	public function getFields()
	{
		$field_list = &$this->fields;
		return $field_list;
	}
	
	public function render()
	{

		$html = '<form'.$this->getAttributes().'>';
		$fieldsets = array();

		foreach($this->fields as $name => $field)
		{
			$fieldsets[$field->getFieldset()][] = $field->render();
		}
		
		$fieldset_list = array_keys($fieldsets);

		if( count($fieldset_list) === 1 )
		{
			$html .= implode('', array_pop($fieldsets) );
		}
		else
		{
			foreach($fieldset_list as $fieldset_name)
			{
				$default_fieldset_html = '';
				if( $fieldset_name !== 'default' )
				{
					$html .= '<fieldset>';
					$html .= '<legend>'.$fieldset_name.'</legend>';
					$html .= implode('', $fieldsets[$fieldset_name]);
					$html .= '</fieldset>';
				}
				else
				{
					$default_fieldset_html .= implode('', $fieldsets[$fieldset_name]);
				}
			}
			$html.=$default_fieldset_html;
		}
		
		$html .= '</form>';

		return $html;

	}
	
	public function isValid()
	{
		
		foreach($this->fields as $name => $field)
		{
			if(!$this->fields[$name]->isValid())
			{
				return false;
			}
		}
		
		return true;

	}

	public function isSubmitted()
	{
		if( count($this->data) > 0 )
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function isSuccessful()
	{
		if( $this->isSubmitted() && $this->isValid() )
		{
			return true;
		}
		else
		{
			return false;
		}
	}

}
?>