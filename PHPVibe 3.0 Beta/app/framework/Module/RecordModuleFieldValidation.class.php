<?php

class MK_RecordModuleFieldValidation extends MK_Record
{
	
	public function save( $update_meta = true )
	{
		$config = MK_Config::getInstance();
		$delete_arguments = mysql_query("DELETE FROM `modules_fields_validation_arguments` WHERE `validation_id` = '".$this->getId()."'", $config->db->con);
		
		if( is_array($this->getValidationArguments()) )
		{
			foreach( $this->getValidationArguments() as $index => $argument )
			{
				$insert_arguments = mysql_query("INSERT INTO `modules_fields_validation_arguments` (`validation_id`, `index`, `value`) VALUES ('".$this->getId()."', '".mysql_real_escape_string($index, $config->db->con)."', '".mysql_real_escape_string($argument, $config->db->con)."')");
			}
		}
		
		return parent::save($update_meta);
	}
	
	public function delete()
	{
		parent::delete();
		
		$config = MK_Config::getInstance();
		$delete_arguments = mysql_query("DELETE FROM `modules_fields_validation_arguments` WHERE `validation_id` = '".$this->getId()."'", $config->db->con);		
	}
	
	public function getRule()
	{
	
		$config = MK_Config::getInstance();

		$get_arguments = mysql_query("SELECT * FROM `modules_fields_validation_arguments` WHERE `validation_id` = '".$this->getId()."' ORDER BY `index` ASC");
		
		$rule = array();
		$arguments = array();
		
		if( mysql_num_rows($get_arguments) > 0 )
		{
			while($res_arguments = mysql_fetch_assoc($get_arguments))
			{
				$arguments[$res_arguments['index']] = $res_arguments['value'];
			}
		}

		$rule = array(
			$this->getName() => $arguments
		);

		return $rule;
		
	}

}

?>