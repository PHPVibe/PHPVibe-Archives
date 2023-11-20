<?php

class MK_RecordModule extends MK_Record{
	
	protected $fields = array();
	protected $deleted = false;
	
	public function __construct( $id = null )
	{
		
		if( !empty($id) )
		{
			$this
				->setId($id)
				->buildFieldList();
		}
		else
		{
			$this->meta = $this->getModule()->getFieldList();
		}
	
	}
	
	protected function buildFieldList()
	{
		$config = MK_Config::getInstance();

		$get_module = mysql_query("SELECT * FROM `modules` WHERE `id` = '".mysql_real_escape_string($this->getId(), $config->db->con)."'", $config->db->con);
		$this->meta = mysql_fetch_assoc($get_module);
		mysql_free_result($get_module);

		$actual_field_module = 'fields';
		if($this->getSlug() === $actual_field_module){
			$field_module = $this;
		}else{
			$field_module = MK_RecordModuleManager::getFromSlug($actual_field_module);
		}

		$get_fields = mysql_query("SELECT * FROM `modules_fields` WHERE `module_id` = '".mysql_real_escape_string($this->getId(), $config->db->con)."' ORDER BY `order` ASC", $config->db->con);
		while($res_fields = mysql_fetch_assoc($get_fields)){
			$this->fields[$res_fields['name']] = $res_fields['id'];
		}
		mysql_free_result($get_fields);
		return $this;
	}
	
	public function _getRecords(&$records, MK_Paginator &$paginator = null, $options = array(), $parent = 0, $level = 0){
		
		$sql_where = array();
		$sql_orderby = array();

		$config = MK_Config::getInstance();
		$field_module = MK_RecordModuleManager::getFromType('module_field');

		if($this->getFieldParent()){
			$field = MK_RecordManager::getFromId($field_module->getId(), $this->getFieldParent());
			$sql_where[] = "`".$field->getName()."` = '".mysql_real_escape_string($parent, $config->db->con)."'";
		}

		if( !empty($options['orderby']) ){
			$sql_orderby[] = "`".$options['orderby']['field']."` ".$options['orderby']['direction']."";
		}

		$get_records = mysql_query("SELECT * FROM `".$this->getTable()."`".(count($sql_where) > 0 ? " WHERE ".implode(" AND ", $sql_where) : '').(count($sql_orderby) > 0 ? " ORDER BY ".implode(", ", $sql_orderby) : ''), $config->db->con);

		if(mysql_num_rows($get_records) > 0){

			while($res_records = mysql_fetch_assoc($get_records)){

				if($paginator && $paginator->getTotalRecords() == count($records)){
					break;
				}

				$new_field = MK_RecordManager::getFromId($this->getId(), $res_records['id']);
				$new_field->setNestedLevel($level);
				$records[] = $new_field;
				if($this->getFieldParent()){
					$this->_getRecords($records, $paginator, $options, $new_field->getId(), $level + 1);
				}

			}
			mysql_free_result($get_records);
		}

	}

	public function getRecords(MK_Paginator &$paginator = null, $options = array()){
	
		$config = MK_Config::getInstance();

		$records = array();
	
		if( $this->deleted === true )
		{
			return $records;
		}
		
		$field_module = MK_RecordModuleManager::getFromType('module_field');
		
		if( !empty($options['orderby']) ){
			$field = MK_RecordManager::getFromId($field_module->getId(), $options['orderby']['field']);
			$orderby_field = $field->getName();
			$orderby_direction = $options['orderby']['direction'];
		}elseif( $this->getFieldOrderby() && $this->getOrderbyDirection() ){
			$field = MK_RecordManager::getFromId($field_module->getId(), $this->getFieldOrderby());
			$orderby_field = $field->getName();
			$orderby_direction = $this->getOrderbyDirection();
		}

		if( isset($orderby_field, $orderby_direction) ){
			$options = array(
				'orderby' => array(
					'field' => $orderby_field,
					'direction' => $orderby_direction
				)
			);
		}
		
		if($paginator){
			$get_total_records = mysql_query("SELECT COUNT(`id`) as 'total' FROM `".$this->getTable()."`", $config->db->con);
			$res_total_records = mysql_fetch_assoc($get_total_records);
			$paginator->setTotalRecords($res_total_records['total']);
			mysql_free_result($get_total_records);
		}

		$this->_getRecords($records, $paginator, $options);

		if($paginator){
			$records = array_slice( $records, $paginator->getRecordStart(), $paginator->getPerPage() );
		}

		return $records;
		
	}

	public function searchRecords($search_criteria, $paginator = null, $options = array()){
		
		$config = MK_Config::getInstance();
		$sql_parts = array();
		$search_results = array();
		$field_module = MK_RecordModuleManager::getFromType('module_field');

		// Search criteria
		foreach($search_criteria as $criteria){

			if( empty($criteria['literal']) ){
				$field = $criteria['field'];
				$value = $criteria['value'];
				if( !empty( $criteria['wildcard'] ) && $criteria['wildcard'] === true){
					$sql_parts[] = "`".mysql_real_escape_string($field, $config->db->con)."` LIKE '".mysql_real_escape_string($value, $config->db->con)."'";
				}else{
					$sql_parts[] = "`".mysql_real_escape_string($field, $config->db->con)."` = '".mysql_real_escape_string($value, $config->db->con)."'";
				}
			}else{
				$sql_parts[] = $criteria['literal'];
			}

		}
		
		// Ordering
		if( !empty($options['orderby']) ){
			$field = MK_RecordManager::getFromId($field_module->getId(), $options['orderby']['field']);
			$orderby_field = $field->getName();
			$orderby_direction = $options['orderby']['direction'];
		}elseif( $this->getFieldOrderby() && $this->getOrderbyDirection() ){
			$field = MK_RecordManager::getFromId($field_module->getId(), $this->getFieldOrderby());
			$orderby_field = $field->getName();
			$orderby_direction = $this->getOrderbyDirection();
		}

		if( isset($orderby_field, $orderby_direction) ){
			$options = array(
				'orderby' => array(
					'field' => $orderby_field,
					'direction' => $orderby_direction
				)
			);
		}

		$get_records = mysql_query("SELECT * FROM `".$this->getTable()."`".($sql_parts ? " WHERE ".implode(' AND ', $sql_parts) : '').( !empty($options['orderby']) ? ' ORDER BY `'.$options['orderby']['field'].'` '.$options['orderby']['direction'] : "" ).( $paginator ? " LIMIT ".$paginator->getRecordStart().", ".$paginator->getPerPage() : ""), $config->db->con);
		if($paginator){
			$get_total_records = mysql_query("SELECT COUNT(`id`) AS `total` FROM `".$this->getTable()."`".($sql_parts ? " WHERE ".implode(' AND ', $sql_parts) : '' ), $config->db->con);
			$res_total_records = mysql_fetch_assoc( $get_total_records );
			$paginator->setTotalRecords($res_total_records['total']);
			mysql_free_result($get_total_records);
		}

		if(mysql_num_rows($get_records) > 0){
			while($res_records = mysql_fetch_assoc($get_records)){
				$search_results[] = MK_RecordManager::getFromId($this->getId(), $res_records['id']);
			}
		}
		
		mysql_free_result($get_records);
		
		return $search_results;
		
	}
	
	public function searchRecordExact($search_criteria){
		
		$config = MK_Config::getInstance();
		$sql_parts = array();
		
		foreach($search_criteria as $field => $value){
			$sql_parts[] = "`".mysql_real_escape_string($field, $config->db->con)."` = '".mysql_real_escape_string($value, $config->db->con)."'";
		}
		
		$get_record = mysql_query("SELECT `id` FROM `".$this->getTable()."` WHERE ".implode(' AND ', $sql_parts)." LIMIT 1", $config->db->con);

		if($res_record = mysql_fetch_assoc($get_record)){
			return MK_RecordManager::getFromId($this->getId(), $res_record['id']);
		}else{
			return null;	
		}
		
		mysql_free_result($get_record);
	}
	
	public function getDataGridFields()
	{
		return $this->getFields(true);
	}

	public function getFields($display_grid_only = false){
		
		$return_fields = array();
		$field_module = MK_RecordModuleManager::getFromSlug('fields');

		foreach($this->fields as $field_key => $field){
			$field = MK_RecordManager::getFromId($field_module->getId(), $field);

			if($display_grid_only === true){
				if($field->getDisplayWidth()){
					$return_fields[] = $field;
				}
			}else{
				$return_fields[] = $field;
			}

		}
		
		return $return_fields;
		
	}

	public function getField($field_name){
		
		if( !empty($this->fields[$field_name]) ){
			
			return $this->fields[$field_name];
			
		}
		
	}

	public function save( $update_meta = true ){
		$config = MK_Config::getInstance();

		if( !empty( $this->meta['id'] ) )
		{

			$old_data = $this->build( $this->getId() );
			$rename_table = mysql_query("RENAME TABLE `".$old_data['table']."` TO `".$this->getTable()."`", $config->db->con);
			return parent::save( $update_meta );

		}else{

			$create_table = mysql_query("CREATE TABLE `".$this->getTable()."` (id INT(16) NOT NULL AUTO_INCREMENT PRIMARY KEY)", $config->db->con);
			parent::save();
			$insert_record = mysql_query("INSERT INTO `modules_fields` (`order`, `module_id`, `name`, `label`, `type`, `editable`, `display_width`) VALUES ('1', '".$this->getId()."', 'id', 'ID', 'id', '0', '')", $config->db->con);
			$index_id = mysql_insert_id();
			$this->setFieldUid($index_id);
			return parent::save( $update_meta );
		}
		
	}
	
	public function getModule(){
		$module = MK_RecordModuleManager::getFromType('module');
		return $module;
	}
	
	public function getFieldList()
	{
		$fields = $this->fields;

		if(count($fields) === 1){
			$this->buildFieldList();
			$fields = $this->fields;
		}

		return array_fill_keys( array_keys( $fields ), '' );
	}
	
	public function delete(){

		$config = MK_Config::getInstance();

		$records = $this->getRecords();

		foreach($records as $record){
			$record->delete();
		}

		parent::delete();

		$this->deleted = true;
		$delete_table = mysql_query("DROP TABLE `".$this->getTable()."`", $config->db->con);

	}
	
}

?>