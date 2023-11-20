<?php
class MK_Validator
{
	
	protected $validation_status = true;
	protected $error_list = array();

	protected static $rules = array(
		'length' => array('label' => 'Length (Min, Max)', 'arguments' => 2),
		'length_max' => array('label' => 'Max Length (Max)', 'arguments' => 1),
		'length_min' => array('label' => 'Min Length (Min)', 'arguments' => 1),
		'boolean_true' => array('label' => 'Boolean (Must be true)', 'arguments' => 0),
		'integer' => array('label' => 'Integer', 'arguments' => 0),
		'integer_not_zero' => array('label' => 'Integer (Not zero)', 'arguments' => 0),
		'instance' => array('label' => 'Instance', 'arguments' => 0),
		'unique' => array('label' => 'Unique field value', 'arguments' => 0),
		'unique_current' => array('label' => 'Unique field value (For current module)', 'arguments' => 0),
		'confirm' => array('label' => 'Confirm', 'arguments' => 0),
		'email' => array('label' => 'Email address', 'arguments' => 0),
		'url' => array('label' => 'URL', 'arguments' => 0),
		'file_format' => array('label' => 'File Format', 'arguments' => 0),
		'image_format' => array('label' => 'Image Format', 'arguments' => 0)
	);

	public static function getRules()
	{
		return self::$rules;
	}

	public function addError($message)
	{
		$this->validation_status = false;
		array_push($this->error_list, $message);
	}

	public function getErrors()
	{
		$error_list_return = $this->error_list;
		$this->error_list = array();
		return $error_list_return;
	}
	
	public function getStatus()
	{
		return $this->validation_status;
	}

	public function checkLength($string, $args)
	{
		$string = strip_tags($string);
		list($min_characters, $max_characters) = $args;
		$s_len = strlen($string);

		if($s_len > $min_characters && $max_characters+1 > $s_len)
		{
			return true;
		}
		else
		{
			if( isset($this) )
			{
				$this->addError("Must be between $min_characters and $max_characters characters");
			}
			return false;
		}
	}

	public function checkLengthMax($string, $args)
	{
		$string = strip_tags($string);
		list($max_characters) = $args;
		$s_len = strlen($string);

		if($max_characters >= $s_len)
		{
			return true;
		}
		else
		{
			if( isset($this) )
			{
				$this->addError("Must be no more than $max_characters characters in length");
			}
			return false;
		}
	}

	public function checkLengthMin($string, $args)
	{
		$string = strip_tags($string);
		list($min_characters) = $args;
		$s_len = strlen($string);
		if($s_len >= $min_characters)
		{
			return true;
		}
		else
		{
			if( isset($this) )
			{
				$this->addError("Must be at least $min_characters characters in length");
			}
			return false;
		}
	}

	public function checkBooleanTrue($string, $args)
	{
		$outcome = (boolean) $string;
		
		if($outcome === true)
		{
			return true;
		}
		else
		{
			if( isset($this) )
			{
				$this->addError("The field must be set");
			}
			return false;
		}
	}

	public function checkInstance($string)
	{
		$s_len = strlen($string);

		if($s_len > 0)
		{
			return true;
		}
		else
		{
			if( isset($this) )
			{
				$this->addError("This field cannot be blank");
			}
			return false;
		}
	}

	public function checkInteger($int)
	{
		if(is_numeric($int))
		{
			return true;
		}
		else
		{
			if( isset($this) )
			{
				$this->addError("This field must be a number");
			}
			return false;
		}
	}

	public function checkIntegerNotZero($int)
	{
		if(is_numeric($int) && $int > 0)
		{
			return true;
		}
		else
		{
			if( isset($this) )
			{
				$this->addError("This field cannot be blank");
			}
			return false;
		}
	}

	public function checkUnique($string, $args)
	{
		$config = MK_Config::getInstance();

		$module = array_pop($args);
		$field = array_pop($args);
		$record = array_pop($args);
		
		$search_criteria = array(
			array('field' => $field->getName(), 'value' => $string)
		);
		
		if($record)
		{
			$search_criteria[] = array('literal' => "`id` <> '".mysql_real_escape_string($record->getId(), $config->db->con)."'");
		}
		
		$records = $module->searchRecords($search_criteria);

		if(count($records) === 0)
		{
			return true;
		}
		else
		{
			$this->addError("This ".$field->getLabel()." is already in use");
			return false;
		}
	}

	// Change _post reference
	public function checkUniqueCurrent($string, $args)
	{
		$config = MK_Config::getInstance();

		$module = array_pop($args);
		$field = array_pop($args);
		$record = array_pop($args);

		$search_criteria = array(
			array('field' => $field->getName(), 'value' => $string),
			array('field' => 'module_id', 'value' => MK_Request::getPost('module_id')),
			array('literal' => "`id` <> '".mysql_real_escape_string($record->getId(), $config->db->con)."'")
		);
		
		$records = $module->searchRecords($search_criteria);

		if(count($records) === 0)
		{
			return true;
		}
		else
		{
			if( isset($this) )
			{
				$this->addError("This value is already in use");
			}
			return false;
		}
	}

	public function checkUrl($string)
	{
		if(empty($string) || preg_match("#^(http|https|ftp)://([A-Z0-9][A-Z0-9_-]*(?:.[A-Z0-9][A-Z0-9_-]*)+):?(d+)?/?#i", $string))
		{
			return true;
		}
		else
		{
			if( isset($this) )
			{
				$this->addError("Must be at URL");
			}
			return false;
		}
	}

	public function checkEmail($string)
	{
		if(empty($string) || preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i", $string))
		{
			return true;
		}
		else
		{
			if( isset($this) )
			{
				$this->addError("Must be at valid email");
			}
			return false;
		}
	}

	public function checkConfirm($string, $args)
	{
		list($string_new_confirm, $string_confirm) = $args;
		if($string_new_confirm != $string_confirm)
		{
			if( isset($this) )
			{
				$this->addError("Fields do not match");
			}
			return false;
		}
		else
		{
			return true;
		}
	}

}
?>