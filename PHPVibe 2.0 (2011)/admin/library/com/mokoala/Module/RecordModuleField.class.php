<?php

class MK_RecordModuleField extends MK_Record{
	
	public function getValidation(MK_Record &$record){

		$validation_module = MK_RecordModuleManager::getFromType('module_field_validation');
		$rules = array();

		$search = array(
			array(
				'field' => 'field_id',
				'value' => $this->getId()
			)
		);

		$validations = $validation_module->searchRecords( $search );

		foreach($validations as $validation){
			$rule = $validation->getRule();

			$module = MK_RecordModuleManager::getFromId($this->getModuleId());

			foreach($rule as $name => $args){
				if($name === 'unique' || $name === 'unique_current'){
					$args = array($record, $this, $module);
				}
				$rules[$name] = $args;
			}
		}

		return $rules;
		
	}
	
	protected function fieldAttributes($type){
		$modules = MK_RecordModuleManager::getFromType('module');
		$module_types = $modules->getRecords();
		$type_list = array();
		foreach($module_types as $module_type){
			$type_list[] = $module_type->getType();
		}

		if(in_array($type, array('orderby_direction'))):
			return "VARCHAR(4) NOT NULL";
		elseif(in_array($type, array('rich_text_large', 'rich_text_small', 'textarea_large', 'textarea_small'))):
			return "TEXT NOT NULL";
		elseif(in_array($type, array('datetime_now'))):
			return "TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP";
		elseif(in_array($type, array('datetime', 'datetime_static'))):
			return "TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00'";
		elseif(in_array($type, array('date'))):
			return "DATE NOT NULL";
		elseif(in_array($type, array('id'))):
			return "INT(16) NOT NULL AUTO_INCREMENT PRIMARY KEY";
		elseif(in_array($type, array('checkbox', 'yes_no'))):
			return "TINYINT(1) NOT NULL";
		elseif(in_array($type, array('integer', 'file_size')) || in_array($type, $type_list)):
			return "BIGINT (32) UNSIGNED NOT NULL";
		elseif(in_array($type, array('module_field_current')) || in_array($type, $type_list)):
			return "INT(32) NOT NULL";
		else:
			return "VARCHAR(255) NOT NULL";
		endif;
	}
	
	public function save( $update_meta = true ){

		$config = MK_Config::getInstance();

		$module = MK_RecordModuleManager::getFromId($this->getModuleId());

		if( !empty( $this->meta['id'] ) ){

			$old_data = $this->build( $this->getId() );
			mysql_query("ALTER TABLE `".$module->getTable()."` CHANGE `".$old_data['name']."` `".$this->getName()."` ".$this->fieldAttributes($this->getType()), $config->db->con );

		}else{

			mysql_query("ALTER TABLE `".$module->getTable()."` ADD `".$this->getName()."` ".$this->fieldAttributes( $this->getType() ), $config->db->con);

		}
	
		return parent::save( $update_meta );

	}
	
	public function delete(){
		
		$config = MK_Config::getInstance();
		
		$module = MK_RecordModuleManager::getFromId( $this->getModuleId() );
		mysql_query("ALTER TABLE `".$module->getTable()."` DROP COLUMN `".$this->getName()."`", $config->db->con);

		parent::delete();
		
	}

}

?>