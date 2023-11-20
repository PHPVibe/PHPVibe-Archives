<?php

class MK_DataRenderer
{

	public static function getRealValue($value, MK_Record $field)
	{
		return self::render($value, $field);	
	}

	public static function render($value, MK_Record $field)
	{
		$config = MK_Config::getInstance();
		try{
			
			$type = $field->getType();
			
			if( in_array($type, array('datetime', 'datetime_now', 'datetime_static')) )
			{
				if(empty($value) || $value === '0000-00-00 00:00:00')
				{
					if($field->getName() === 'lastlogin')
					{
						return 'Never logged in';
					}
					else
					{
						return 'None defined';
					}
				}
				else
				{
					$datetime = strtotime($value);
					$previous_day_datetime = strtotime('-1 day', $datetime);
					if(date('d-m-Y') === date('d-m-Y', $datetime))
					{
						return 'Today at '.date( $config->site->time_format, $datetime);
					}
					elseif(date('d-m-Y') === date('d-m-Y', $previous_day_datetime))
					{
						return 'Yesterday at '.date( $config->site->time_format, $datetime);
					}
					else
					{
						return date( $config->site->datetime_format, $datetime);
					}
				}
			}
			elseif( in_array($type, array('date')) )
			{
				if(empty($value) || $value === '0000-00-00')
				{
					return 'None defined';
				}
				else
				{
					$datetime = strtotime($value);
					return date( $config->site->date_format, $datetime);
				}
			}
			elseif( $type === 'file_image' )
			{
				if( empty($value) )
				{
					return 'None defined';
				}
				else
				{
					return '<img class="image" src="components/thumb.php/'.$value.'/120/60/crop" />';
				}
			}
			elseif( $type === 'file_size' )
			{
				return MK_Utility::getFormattedFileSize($value);
			}
			elseif( $type === 'yes_no' )
			{
				return ($value ? 'Yes' : 'No');
			}
			else
			{

				$field_module = MK_RecordModuleManager::getFromType('module_field');
				$module = MK_RecordModuleManager::getFromType($field->getType());
				$slug_field = MK_RecordManager::getFromId($field_module->getId(), $module->getFieldSlug());

				if($value == 0){
					return 'None defined';
				}

				$record = MK_RecordManager::getFromId($module->getId(), $value);
				if($field->getType() === 'module_field')
				{
					return $record->getLabel().' ('.$record->getName().')';
				}
				else
				{
					return $record->getMetaValue($slug_field->getName());
				}
			}
			
		}catch(Exception $e){
			
			return $value;
			
		}
		
	}

}

?>