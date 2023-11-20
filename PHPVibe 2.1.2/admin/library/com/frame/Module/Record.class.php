<?php

class MK_Record extends MK_MetaFactoryExtra{
	
	protected $module_id;
	
	public function __construct( $module_id, $record_id = null ){
		
		$this->module_id = $module_id;
		$this->meta = $this->getModule()->getFieldList();

		if($record_id){
			$data = $this->build($record_id);
			$this->populate($data);
		}
		
	}

	public function getModule(){
		return MK_RecordModuleManager::getFromId($this->module_id);
	}

	public function getMetaValue( $key, MK_Record $field = null ){

		$value = parent::getMetaValue($key);

		if( !empty($field) ){

			return MK_DataRenderer::getRealValue($value, $field);
			
		}else{
			return $value;	
		}

	}

	public function canEdit( MK_Record $user ){

		$config = MK_Config::getInstance();

		if( $config->core->mode !== MK_Core::MODE_FULL )
		{
			if($this->getModule()->getType() === 'module')
			{
				return $this->getModule()->isLocked();
			}
			else
			{
				return $this->getModule()->isLockRecords();
			}
		}
		
	}
	
	public function getSubRecords( $levels = 0, &$records = array() )
	{
		$record_module = $this->getModule();

		if($field_parent = $record_module->getFieldParent())
		{
			$field_module = MK_RecordModuleManager::getFromType('module_field');
			$field_parent = MK_RecordManager::getFromId($field_module->getId(), $field_parent);

			$search_criteria = array(
				array('value' => $this->getId(), 'field' => $field_parent->getName())
			);

			$search_records = $record_module->searchRecords($search_criteria);

			foreach( $search_records as $search_record )
			{
				$records[] = $search_record;
				$search_record->getSubRecords( 0, $records);
			}
		}
		return $records;

	}

	public function getParentRecords()
	{
		$record_module = $this->getModule();
		$records = array();

		if($field_parent = $record_module->getFieldParent())
		{
			$field_module = MK_RecordModuleManager::getFromType('module_field');
			$field_parent = MK_RecordManager::getFromId($field_module->getId(), $field_parent);

			$current_record = $this;

			while( $parent_id = $current_record->getMetaValue($field_parent->getName()) )
			{
				$current_record = MK_RecordManager::getFromId($record_module->getId(), $parent_id);
				$records[] = $current_record;
			}
			
			unset($current_record);

		}

		return $records;

	}

	public function save( $update_meta = true )
	{
		
		$config = MK_Config::getInstance();
		if( !empty( $this->meta['id'] ) )
		{
			$old_data = $this->build( $this->getId() );

			$sql_parts = array();

			foreach($this->meta as $value_key => $value_data)
			{
				if($old_data[$value_key] != $value_data)
				{
					$sql_parts[] = "`".mysql_real_escape_string($value_key, $config->db->con)."` = '".mysql_real_escape_string($value_data, $config->db->con)."'";
				}
			}
			
			if(count($sql_parts) > 0)
			{
				$update_user = mysql_query("UPDATE `".$this->getModule()->getTable()."` SET ".implode(', ', $sql_parts)." WHERE `id` = '".$this->getId()."' LIMIT 1", $config->db->con);
				if( $error = mysql_error( $config->db->con ) ){
					throw new MK_SQLException($error);
				}
			}
			
			$record_id = $this->meta['id'];
		}
		else
		{
			$data = array_filter($this->meta);
	
			$fields = array_keys($data);
			$values = array_values($data);
			
			foreach($values as $value_key => $value_data){
				$values[$value_key] = mysql_real_escape_string($value_data, $config->db->con);
			}

			$ins_user = mysql_query("INSERT INTO `".$this->getModule()->getTable()."` (`".implode('`, `', $fields)."`) VALUES ('".implode('\', \'', $values)."')", $config->db->con);
			if( $error = mysql_error( $config->db->con ) )
			{
				throw new MK_SQLException($error);
			}
			else
			{
				$record_id = mysql_insert_id($config->db->con);
				$data = $this->build($record_id);
				$this->populate($data);
			}
			
		}
		
		return $this;
		
	}

	public function __process( $type, $call, $arguments )
	{
		if( $type === 'render' )
		{
			return $this->renderMetaValue( $call, reset($arguments) ? array_shift($arguments) : null );
		}
		else
		{
			return parent::__process( $type, $call, $arguments );
		}
	}
	
	public function renderMetaValue( $key )
	{
		if( array_key_exists( $key, $this->meta ) )
		{
			$field_module = MK_RecordModuleManager::getFromType('module_field');
			$field = MK_RecordManager::getFromId( $field_module->getId(), $this->getModule()->getField($key) );

			return MK_DataRenderer::render( $this->meta[$key], $field );
		}
		else
		{
			throw new MK_ModuleException('Field \''.$key.'\' does not exist');
		}
		
	}

	protected function build( $id ){

		$config = MK_Config::getInstance();
		$get_record = mysql_query("SELECT * FROM `".$this->getModule()->getTable()."` WHERE `id` = '".mysql_real_escape_string($id, $config->db->con)."' LIMIT 1", $config->db->con);
		if(mysql_num_rows( $get_record ) > 0){
			return mysql_fetch_assoc($get_record);
		}else{
			throw new MK_ModuleRecordException('The Record Id \''.$id.'\' given does not exist');	
		}

	}

	public function populate( $data )
	{
		foreach( $data as $field => $value )
		{
			if( array_key_exists( $field, $this->meta) )
			{
				$this->meta[$field] = $value;
			}
			else
			{
				$this->meta_extra[$field] = $value;
			}
		}
	}
	
	public function delete(){
		
		$config = MK_Config::getInstance();

		$dependents = $this->getDependents();

		foreach($dependents['records'] as $record)
		{
			$record->delete();
		}

		foreach($dependents['files'] as $file)
		{
			unlink('../'.$file);
		}

		mysql_query("DELETE FROM `".$this->getModule()->getTable()."` WHERE `id` = ".$this->getId()." LIMIT 1", $config->db->con);
		
	}
	
	public function getDependents(){

		$dependents = array(
			'files' => array(),
			'records' => array()
		);

		$config = MK_Config::getInstance();
		$fields = $this->getModule()->getFields();
		$files = array();

		foreach($fields as $name => $attributes){
			if( substr( $attributes->getType(), 0, 4) === 'file' && !empty($this->meta[$attributes->getName()]) ){
				$dependents['files'][] = $this->meta[$attributes->getName()];
			}
		}

		$field_module = MK_RecordModuleManager::getFromType('module_field');

		$search_criteria = array(
			array('value' => $this->getModule()->getType(), 'field' => 'type')
		);
		
		$records_fields = $field_module->searchRecords($search_criteria);
		
		foreach($records_fields as $record_field){
			
			$record_module = MK_RecordModuleManager::getFromId($record_field->getModuleId());

			$search_criteria = array(
				array('value' => $this->getId(), 'field' => $record_field->getName())
			);
			
			$new_dependents = $record_module->searchRecords($search_criteria);
			
			foreach($new_dependents as $dependent){
				$dependents['records'][] = $dependent;
			}

		}
		
		if($this->getModule()->getFieldParent()){

			$parent_field = MK_RecordManager::getFromId($field_module->getId(), $this->getModule()->getFieldParent());

			$search_criteria = array(
				array('value' => $this->getId(), 'field' => $parent_field->getName())
			);
			
			$sub_records = $this->getModule()->searchRecords($search_criteria);
			
			foreach($sub_records as $sub_record){
				$dependents['records'][] = $sub_record;
			}
			
		}
		
		return $dependents;

	}

}

?>