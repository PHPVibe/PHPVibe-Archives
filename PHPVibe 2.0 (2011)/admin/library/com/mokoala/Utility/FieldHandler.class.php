<?php

class MK_FieldHandler
{

	public static function get(MK_Record $record = null, MK_Record &$field, $value = null)
	{
		
		$field_definition = array(
			'label' => $field->getLabel(),
			'tooltip' => $field->getTooltip(),
			'fieldset' => $field->getFieldset(),
			'value' => $value
		);
		
		if( !empty($record) )
		{
			$field_definition['validation'] = $field->getValidation($record);
		}
		
		$type = $field->getType() ? $field->getType() : 'text';
		$definition = 'field'.MK_Utility::stringToReference($type);

		if(method_exists('MK_FieldHandler', $definition))
		{
			return self::$definition( $record, $field, $value, $field_definition );
		}
		else
		{

			try{
				
				$field_definition['options'] = array();

				if( ( $specific_type = substr($type, -9) ) && $specific_type === '_multiple' )
				{
					$field_definition['type'] = 'checkbox_multiple';
					$type = substr( $type, 0, strlen($type) - 9 );
				}
				else
				{
					$field_definition['type'] = 'select';
					$field_definition['options']['0'] = 'None selected';
				}

				$module = MK_RecordModuleManager::getFromType($type);


				$field_module = MK_RecordModuleManager::getFromType('module_field');
				$slug_field = MK_RecordManager::getFromId($field_module->getId(), $module->getFieldSlug());

				foreach($module->getRecords() as $module_record){

					if( !empty($record) && ( $record->getModule()->getType() === $module_record->getModule()->getType() && $record->getId() === $module_record->getId() ))
					{
						continue;
					}
					
					if(empty($field_definition['value']) && $module_record->isDefaultValue())
					{
						$field_definition['value'] = $module_record->getId();
					}

					$text_indent = '';
			
					for($i = 0; $i < $module_record->getNestedLevel(); $i++){
						$text_indent.='&nbsp;&nbsp;&nbsp;';
					}
					$field_definition['options'][$module_record->getId()] = $text_indent.$module_record->getMetaValue($slug_field->getName());

				}
				
				if(count($field_definition['options']) === 1){
					$field_definition['type'] = 'static';
				}

				return $field_definition;

			}catch(Exception $e){

				$field_definition['type'] = $type;
				return $field_definition;

			}
		}
		
	}
	
	private static function fieldRichTextSmall(MK_Record $record = null, MK_Record $field, $value, $field_definition ){

		$field_definition['attributes'] = array(
			'class' => 'input-textarea-small'
		);
		$field_definition['type'] = 'rich_text';
		
		return $field_definition;
	}

	private static function fieldRichTextLarge(MK_Record $record = null, MK_Record $field, $value, $field_definition ){

		$field_definition['attributes'] = array(
			'class' => 'input-textarea-large'
		);
		$field_definition['type'] = 'rich_text';
		
		return $field_definition;
	}

	private static function fieldTextareaSmall(MK_Record $record = null, MK_Record $field, $value, $field_definition ){

		$field_definition['attributes'] = array(
			'class' => 'input-textarea-small'
		);
		$field_definition['type'] = 'textarea';
		
		return $field_definition;
	}

	private static function fieldTextareaLarge(MK_Record $record = null, MK_Record $field, $value, $field_definition ){

		$field_definition['attributes'] = array(
			'class' => 'input-textarea-large'
		);
		$field_definition['type'] = 'textarea';
		
		return $field_definition;
	}
	
	private static function fieldFileImage(MK_Record $record = null, MK_Record $field, $value, $field_definition ){
		return self::fieldFile( $record, $field, $value, $field_definition );
	}
	
	private static function fieldFile(MK_Record $record = null, MK_Record $field, $value, $field_definition ){

		$config = MK_Config::getInstance();

		$field_definition['upload_path'] = '../'.$config->site->upload_path;
		$field_definition['type'] = $field->getType();
		
		if(!empty($config->site->valid_file_extensions) && $field_definition['type'] === 'file')
		{
			$field_definition['valid_extensions'] = (array) $config->site->valid_file_extensions;
		}
		
		return $field_definition;
		
	}
	
	private static function fieldTimeZone(MK_Record $record = null, MK_Record $field, $value, $field_definition ){

		return array(
			'validation' => $field->getValidation($record),
			'label' => $field->getLabel(),
			'tooltip' => $field->getTooltip(),
			'fieldset' => $field->getFieldset(),
			'value' => $value,
			'type' => 'select',
			'options' => array_merge(array('' => 'None selected'), MK_Utility::getTimezoneList())
		);
		
	}
	
	private static function fieldModuleFieldCurrent( MK_Record $record = null, MK_Record $field, $value, $field_definition ){

		$module = MK_RecordModuleManager::getFromType('module_field');
		$search_criteria = array(
			array('value' => $record->getId(), 'field' => 'module_id')
		);
		
		$search_records = $module->searchRecords($search_criteria);
		
		$field_definition['type'] = 'select';
		$field_definition['options'] = array();
		
		$field_definition['options']['0'] = 'None defined';
		foreach($search_records as $record_id => $record_data){
			$field_definition['options'][$record_data->getId()] = $record_data->getLabel().' ('.$record_data->getName().')';
		}

		if(count($field_definition['options']) === 0){
			$field_definition['type'] = 'static';
		}

		return $field_definition;
		
	}
	
	private static function fieldModuleField( MK_Record $record = null, MK_Record $field, $value, $field_definition ){

		$module_type = MK_RecordModuleManager::getFromType('module');
		$module_field_type = MK_RecordModuleManager::getFromType('module_field');

		$modules = $module_type->getRecords();

		$field_definition['type'] = 'select';
		$field_definition['options'] = array();
		
		foreach($modules as $module)
		{

			$search_criteria = array(
				array('value' => $module->getId(), 'field' => 'module_id')
			);

			$fields = $module_field_type->searchRecords($search_criteria);
			
			foreach( $fields as $field )
			{
				$field_definition['options'][$module->getName()][$field->getId()] = $field->getLabel().' ('.$field->getName().')';
			}

		}
		
		if(count($field_definition['options']) === 0){
			$field_definition['type'] = 'static';
		}

		return $field_definition;
		
	}
	
	private static function fieldOrderbyDirection( MK_Record $record = null, MK_Record $field, $value, $field_definition ){
		
		$field_definition['type'] = 'select';
		$field_definition['options'] = array(
			'DESC' => 'Descending',
			'ASC' => 'Ascending'
		);

		return $field_definition;
		
	}
	
	private static function fieldUserType( MK_Record $record = null, MK_Record $field, $value, $field_definition ){
		
		$field_definition['type'] = 'select';
		$field_definition['options'] = array(
			MK_RecordUser::TYPE_CORE => 'Core',
			MK_RecordUser::TYPE_FACEBOOK => 'Facebook',
			MK_RecordUser::TYPE_TWITTER => 'Twitter',
		);

		return $field_definition;
		
	}
	
	private static function fieldUserMessageType( MK_Record $record = null, MK_Record $field, $value, $field_definition ){
		
		$field_definition['type'] = 'select';
		$field_definition['options'] = array(
			'inbox_unread' => 'Inbox (Unread)',
			'inbox_read' => 'Inbox (Read)',
			'draft' => 'Draft',
			'sent' => 'Sent'
		);

		return $field_definition;
		
	}
	
	private static function fieldYesNo( MK_Record $record = null, MK_Record $field, $value, $field_definition ){
		
		$field_definition['type'] = 'select';
		$field_definition['options'] = array(
			'0' => 'No',
			'1' => 'Yes'
		);

		return $field_definition;
		
	}
	
	private static function fieldModuleValidationRule( MK_Record $record = null, MK_Record $field, $value, $field_definition ){
		
		$field_definition['type'] = 'select';
		$field_definition['options'] = array();
		
		$rules = MK_Validator::getRules();
		
		foreach( $rules as $name => $rule )
		{
			$field_definition['options'][$name] = $rule['label'].' - '.$rule['arguments'];
		}

		return $field_definition;
		
	}
	
	private static function fieldStatus( MK_Record $record = null, MK_Record $field, $value, $field_definition ){
		
		$field_definition['type'] = 'select';
		$field_definition['options'] = array(
			'active' => 'Active',
			'inactive' => 'Inactive'
		);

		return $field_definition;
		
	}
	
	private static function fieldType( MK_Record $record = null, MK_Record $field, $value, $field_definition ){
		
		$field_definition['type'] = 'select';
		$field_definition['options'] = array(
			'Standard fields' => array(
				'' => 'Text',
				'static' => 'Static',
				'integer' => 'Integer',
				'id' => 'Id',
				'rich_text_small' => 'Rich Text Editor (Small)',
				'rich_text_large' => 'Rich Text Editor (Large)',
				'textarea_small' => 'Textarea (Small)',
				'textarea_large' => 'Textarea (Large)',
				'orderby_direction' => 'Order by Direction',
				'password' => 'Password',
				'checkbox' => 'Checkbox',
				'yes_no' => 'Yes / No',
				'currency' => 'Currency'
			),
			'Date &amp; Time fields' => array(
				'time_zone' => 'Time Zone',
				'date' => 'Date',
				'datetime' => 'Date &amp; Time',
				'datetime_now' => 'Date &amp; Time (With current time as default)',
				'datetime_static' => 'Date &amp; Time (Can\'t be edited)',
			),
			'File fields' => array(
				'file' => 'Standard file',
				'file_image' => 'Image file'
			),
			'Module types (Multiple)' =>array(),
			'Module types' =>array(
				'module_field_current' => 'Field (From current module)'
			),
			'Special' =>array(
				'file_size' => 'File size',
				'status' => 'Status',
				'user_type' => 'User Type',
				'user_message_type' => 'User Message Type',
				'module_validation_rule' => 'Validation Rule'
			)
		);
		
		$module = MK_RecordModuleManager::getFromType('module');
		foreach($module->getRecords() as $module_record){

			$text_indent = '';
	
			for($i = 0; $i < $module_record->getNestedLevel(); $i++){
				$text_indent.='&nbsp;&#8627;&nbsp;';
			}

			$field_definition['options']['Module types (Multiple)'][$module_record->getType().'_multiple'] = $text_indent.$module_record->getName();
			$field_definition['options']['Module types'][$module_record->getType()] = $text_indent.$module_record->getName();

		}

		return $field_definition;
		
	}

	private static function fieldCurrency( MK_Record $record = null, MK_Record $field, $value, $field_definition ){

		$field_definition['type'] = 'select';
		$field_definition['options'] =  MK_Utility::getCurrencyList();

		return $field_definition;
	}

	private static function fieldId( MK_Record $record = null, MK_Record $field, $value, $field_definition ){

		return null;
		
	}
	
}