<?php

class MK_RecordUser extends MK_Record
{

	protected $group;

	const TYPE_CORE = 'core';
	const TYPE_FACEBOOK = 'facebook';
	const TYPE_TWITTER = 'twitter';

	public function __construct( $module_id, $record_id = null ){
		
		parent::__construct( $module_id, $record_id );
		
		if(empty($record_id))
		{
			$group_type = MK_RecordModuleManager::getFromType('user_group');
			$search = array(
				array('field' => 'default_value', 'value' => '1')
			);
			$group = $group_type->searchRecords($search);
			$group = array_pop( $group );
			$this
				->setGroupId($group->getId())
				->setDateRegistered(date('Y-m-d H:i:s'))
				->setType( self::TYPE_CORE );
		}
		else
		{
			$user_meta_type = MK_RecordModuleManager::getFromType('user_meta');
			$search_criteria = array(
				array('field' => 'user', 'value' => $record_id)
			);
			$user_meta = $user_meta_type->searchRecords($search_criteria);

			foreach($user_meta as $meta)
			{
				$this->setMetaValue($meta->getKey(), $meta->getValue());
			}			
		}
		
	}

	public function setPassword($value)
	{
		$current_value = $this->getPassword();
		if( $current_value !== $value)
		{
			$value = MK_Utility::getHash($value);
			$this->setMetaValue('password', $value);
		}
		return $this;
	}

	public function setTemporaryPassword($value)
	{
		$current_value = $this->getPassword();
		if( $current_value !== $value)
		{
			$value = MK_Utility::getHash($value);
			$this->setMetaValue('temporary_password', $value);
		}
		return $this;
	}

	public function isAuthorized()
	{
		if( $this->getId() )
		{
			return true;
		}
		else
		{
			return false;	
		}
	}
	
	public function getGroup()
	{
		if(empty($this->group))
		{
			$group_id = $this->getGroupId();
			$group_type = MK_RecordModuleManager::getFromType('user_group');
			$this->group = MK_RecordManager::getFromId( $group_type->getId(), $group_id );
		}
		return $this->group;
	}
	
	public function save( $update_meta = true )
	{

		parent::save( $update_meta );

		if( $update_meta === true )
		{
			$user_meta_type = MK_RecordModuleManager::getFromType('user_meta');
	
			$search_criteria = array(
				array('field' => 'user', 'value' => $this->getId())
			);

			$user_meta = $user_meta_type->searchRecords($search_criteria);
			
			foreach($user_meta as $meta)
			{
				$meta->delete();
			}
	
			foreach($this->meta_extra as $key => $value)
			{
				if(!empty($value))
				{
					$new_meta = MK_RecordManager::getNewRecord($user_meta_type->getId());
					$new_meta
						->setKey($key)
						->setValue($value)
						->setUser($this->getId())
						->save( false );
				}
			}
		}

		return $this;	
	}

}

?>