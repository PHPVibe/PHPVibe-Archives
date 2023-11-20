<?php

$config = MK_Config::getInstance();

// Get Module Types
$module_type = MK_RecordModuleManager::getFromType('module');
$module_field_type = MK_RecordModuleManager::getFromType('module_field');
$module_field_validation_type = MK_RecordModuleManager::getFromType('module_field_validation');

// Users
$user_module = MK_RecordManager::getNewRecord( $module_type->getId() );
$user_module
	->setName('Users')
	->setTable('users')
	->setSlug('users')
	->setParentModuleId(0)
	->setFieldUid(0)
	->setFieldSlug(0)
	->setFieldParent(0)
	->setFieldOrderBy(0)
	->setOrderbyDirection('DESC')
	->setManagementWidth('20%')
	->setType('user')
	->setLocked(0)
	->setLockRecords(0)
	->setCoreModule(0)
	->save();

$user_module_email = MK_RecordManager::getNewRecord( $module_field_type->getId() );
$user_module_email
	->setOrder(1)
	->setModuleId( $user_module->getId() )
	->setName('email')
	->setLabel('Email')
	->setType('')
	->setEditable(1)
	->setDisplayWidth('30%')
	->setTooltip('')
	->setFieldset('')
	->setSpecificSearch(0)
	->save();

$user_module_email_validation = MK_RecordManager::getNewRecord( $module_field_validation_type->getId() );
$user_module_email_validation
	->setName('email')
	->setFieldId($user_module_email->getId())
	->save();

$user_module_email_validation = MK_RecordManager::getNewRecord( $module_field_validation_type->getId() );
$user_module_email_validation
	->setName('instance')
	->setFieldId($user_module_email->getId())
	->save();

$user_module_email_validation = MK_RecordManager::getNewRecord( $module_field_validation_type->getId() );
$user_module_email_validation
	->setName('unique')
	->setFieldId($user_module_email->getId())
	->save();

$user_module_password = MK_RecordManager::getNewRecord( $module_field_type->getId() );
$user_module_password
	->setOrder(4)
	->setModuleId( $user_module->getId() )
	->setName('password')
	->setLabel('Password')
	->setType('password')
	->setEditable(1)
	->setDisplayWidth('')
	->setTooltip('')
	->setFieldset('')
	->setSpecificSearch(0)
	->save();

$user_module_lastlogin = MK_RecordManager::getNewRecord( $module_field_type->getId() );
$user_module_lastlogin
	->setOrder(8)
	->setModuleId( $user_module->getId() )
	->setName('lastlogin')
	->setLabel('Last login')
	->setType('datetime_static')
	->setEditable(1)
	->setDisplayWidth('')
	->setTooltip('')
	->setFieldset('')
	->setSpecificSearch(0)
	->save();

$user_module_lastip = MK_RecordManager::getNewRecord( $module_field_type->getId() );
$user_module_lastip
	->setOrder(12)
	->setModuleId( $user_module->getId() )
	->setName('lastip')
	->setLabel('Last IP used')
	->setType('static')
	->setEditable(1)
	->setDisplayWidth('')
	->setTooltip('')
	->setFieldset('')
	->setSpecificSearch(0)
	->save();

$user_module_group_id = MK_RecordManager::getNewRecord( $module_field_type->getId() );
$user_module_group_id
	->setOrder(5)
	->setModuleId( $user_module->getId() )
	->setName('group_id')
	->setLabel('User Group')
	->setType('user_group')
	->setEditable(1)
	->setDisplayWidth('')
	->setTooltip('')
	->setFieldset('')
	->setSpecificSearch(0)
	->save();

$user_module_avatar = MK_RecordManager::getNewRecord( $module_field_type->getId() );
$user_module_avatar
	->setOrder(11)
	->setModuleId( $user_module->getId() )
	->setName('avatar')
	->setLabel('Profile image')
	->setType('file_image')
	->setEditable(1)
	->setDisplayWidth('')
	->setTooltip('')
	->setFieldset('')
	->setSpecificSearch(0)
	->save();

$user_module_date_registered = MK_RecordManager::getNewRecord( $module_field_type->getId() );
$user_module_date_registered
	->setOrder(7)
	->setModuleId( $user_module->getId() )
	->setName('date_registered')
	->setLabel('Date registered')
	->setType('datetime_static')
	->setEditable(1)
	->setDisplayWidth('')
	->setTooltip('')
	->setFieldset('')
	->setSpecificSearch(0)
	->save();

$user_module_display_name = MK_RecordManager::getNewRecord( $module_field_type->getId() );
$user_module_display_name
	->setOrder(1)
	->setModuleId( $user_module->getId() )
	->setName('display_name')
	->setLabel('Display name')
	->setType('')
	->setEditable(1)
	->setDisplayWidth('')
	->setTooltip('')
	->setFieldset('')
	->setSpecificSearch(0)
	->save();

$user_module_display_name_validation = MK_RecordManager::getNewRecord( $module_field_validation_type->getId() );
$user_module_display_name_validation
	->setName('instance')
	->setFieldId($user_module_display_name->getId())
	->save();

$user_module_temporary_password = MK_RecordManager::getNewRecord( $module_field_type->getId() );
$user_module_temporary_password
	->setOrder(5)
	->setModuleId( $user_module->getId() )
	->setName('temporary_password')
	->setLabel('Temporary password')
	->setType('')
	->setEditable(0)
	->setDisplayWidth('')
	->setTooltip('')
	->setFieldset('')
	->setSpecificSearch(0)
	->save();

$user_module_facebook_id = MK_RecordManager::getNewRecord( $module_field_type->getId() );
$user_module_facebook_id
	->setOrder(12)
	->setModuleId( $user_module->getId() )
	->setName('facebook_id')
	->setLabel('Facebook ID')
	->setType('static')
	->setEditable(1)
	->setDisplayWidth('')
	->setTooltip('If the user has linked their account with Facebook or uses Facebook to login, this is their Facebook account ID.')
	->setFieldset('')
	->setSpecificSearch(0)
	->save();

$user_module_twitter_id = MK_RecordManager::getNewRecord( $module_field_type->getId() );
$user_module_twitter_id
	->setOrder(13)
	->setModuleId( $user_module->getId() )
	->setName('twitter_id')
	->setLabel('Twitter ID')
	->setType('static')
	->setEditable(1)
	->setDisplayWidth('')
	->setTooltip('If the user has linked their account with Twitter or uses Twitter to login, this is their Twitter account ID.')
	->setFieldset('')
	->setSpecificSearch(0)
	->save();

$user_module_type = MK_RecordManager::getNewRecord( $module_field_type->getId() );
$user_module_type
	->setOrder(3)
	->setModuleId( $user_module->getId() )
	->setName('type')
	->setLabel('Type')
	->setType('user_type')
	->setEditable(1)
	->setDisplayWidth('')
	->setTooltip('')
	->setFieldset('')
	->setSpecificSearch(0)
	->save();

// Users - Groups
$user_group_module = MK_RecordManager::getNewRecord( $module_type->getId() );
$user_group_module
	->setName('Groups')
	->setTable('users_groups')
	->setSlug('groups')
	->setParentModuleId( $user_module->getId() )
	->setFieldUid(0)
	->setFieldSlug(0)
	->setFieldParent(0)
	->setFieldOrderBy(0)
	->setOrderbyDirection('ASC')
	->setManagementWidth('20%')
	->setType('user_group')
	->setLocked(0)
	->setLockRecords(0)
	->setCoreModule(0)
	->save();

$user_group_module_name = MK_RecordManager::getNewRecord( $module_field_type->getId() );
$user_group_module_name
	->setOrder(2)
	->setModuleId( $user_group_module->getId() )
	->setName('name')
	->setLabel('Name')
	->setType('')
	->setEditable(1)
	->setDisplayWidth('30%')
	->setTooltip('')
	->setFieldset('')
	->setSpecificSearch(0)
	->save();

$user_group_module_name_validation = MK_RecordManager::getNewRecord( $module_field_validation_type->getId() );
$user_group_module_name_validation
	->setName('instance')
	->setFieldId($user_group_module_name->getId())
	->save();

$user_group_module_admin = MK_RecordManager::getNewRecord( $module_field_type->getId() );
$user_group_module_admin
	->setOrder(3)
	->setModuleId( $user_group_module->getId() )
	->setName('admin')
	->setLabel('Users are Admins?')
	->setType('yes_no')
	->setEditable(1)
	->setDisplayWidth('')
	->setTooltip('')
	->setFieldset('')
	->setSpecificSearch(0)
	->save();

$user_group_module_default_value = MK_RecordManager::getNewRecord( $module_field_type->getId() );
$user_group_module_default_value
	->setOrder(4)
	->setModuleId( $user_group_module->getId() )
	->setName('default_value')
	->setLabel('Default group')
	->setType('yes_no')
	->setEditable(1)
	->setDisplayWidth('')
	->setTooltip('')
	->setFieldset('')
	->setSpecificSearch(0)
	->save();

$user_group_module_access_level = MK_RecordManager::getNewRecord( $module_field_type->getId() );
$user_group_module_access_level
	->setOrder(5)
	->setModuleId( $user_group_module->getId() )
	->setName('access_level')
	->setLabel('Access Level')
	->setType('integer')
	->setEditable(1)
	->setDisplayWidth('')
	->setTooltip('')
	->setFieldset('')
	->setSpecificSearch(0)
	->save();

// Users - Meta
$user_meta_module = MK_RecordManager::getNewRecord( $module_type->getId() );
$user_meta_module
	->setName('Meta')
	->setTable('users_meta')
	->setSlug('meta')
	->setParentModuleId( $user_module->getId() )
	->setFieldUid(0)
	->setFieldSlug(0)
	->setFieldParent(0)
	->setFieldOrderBy(0)
	->setOrderbyDirection('DESC')
	->setManagementWidth('20%')
	->setType('user_meta')
	->setLocked(0)
	->setLockRecords(0)
	->setCoreModule(0)
	->save();

$user_meta_module_key = MK_RecordManager::getNewRecord( $module_field_type->getId() );
$user_meta_module_key
	->setOrder(2)
	->setModuleId( $user_meta_module->getId() )
	->setName('key')
	->setLabel('Key')
	->setType('')
	->setEditable(1)
	->setDisplayWidth('20%')
	->setTooltip('')
	->setFieldset('')
	->setSpecificSearch(0)
	->save();

$user_meta_module_value = MK_RecordManager::getNewRecord( $module_field_type->getId() );
$user_meta_module_value
	->setOrder(3)
	->setModuleId( $user_meta_module->getId() )
	->setName('value')
	->setLabel('Value')
	->setType('textarea_small')
	->setEditable(1)
	->setDisplayWidth('')
	->setTooltip('')
	->setFieldset('')
	->setSpecificSearch(0)
	->save();

$user_meta_module_user = MK_RecordManager::getNewRecord( $module_field_type->getId() );
$user_meta_module_user
	->setOrder(4)
	->setModuleId( $user_meta_module->getId() )
	->setName('user')
	->setLabel('User')
	->setType('user')
	->setEditable(1)
	->setDisplayWidth('30%')
	->setTooltip('')
	->setFieldset('')
	->setSpecificSearch(0)
	->save();

// Backups
$backup_module = MK_RecordManager::getNewRecord( $module_type->getId() );
$backup_module
	->setName('Backup')
	->setTable('backups')
	->setSlug('backups')
	->setParentModuleId(0)
	->setFieldUid(0)
	->setFieldSlug(0)
	->setFieldParent(0)
	->setFieldOrderBy(0)
	->setOrderbyDirection('DESC')
	->setManagementWidth('20%')
	->setType('backup')
	->setLocked(0)
	->setLockRecords(0)
	->setCoreModule(0)
	->save();

$backup_module_date_time = MK_RecordManager::getNewRecord( $module_field_type->getId() );
$backup_module_date_time
	->setOrder(2)
	->setModuleId( $backup_module->getId() )
	->setName('date_time')
	->setLabel('Date & Time')
	->setType('datetime_now')
	->setEditable(1)
	->setDisplayWidth('40%')
	->setTooltip('')
	->setFieldset('')
	->setSpecificSearch(0)
	->save();

$backup_module_date_time = MK_RecordManager::getNewRecord( $module_field_type->getId() );
$backup_module_date_time
	->setOrder(3)
	->setModuleId( $backup_module->getId() )
	->setName('file')
	->setLabel('File')
	->setType('file')
	->setEditable(1)
	->setDisplayWidth('')
	->setTooltip('')
	->setFieldset('')
	->setSpecificSearch(0)
	->save();

// Update based on inserts
$user_group_module
	->setFieldSlug( $user_group_module_name->getId() )
	->setFieldOrderBy( $user_group_module_name->getId() )
	->save();

$user_meta_module
	->setFieldSlug( $user_meta_module_key->getId() )
	->setFieldOrderBy( $user_meta_module_key->getId() )
	->save();

$user_module
	->setFieldSlug( $user_module_display_name->getId() )
	->setFieldOrderBy( $user_module_lastlogin->getId() )
	->save();

$backup_module
	->setFieldSlug( $backup_module_date_time->getId() )
	->setFieldOrderBy( $backup_module_date_time->getId() )
	->save();

// Insert new records
$new_user_group = MK_RecordManager::getNewRecord( $user_group_module->getId() );
$new_user_group
	->setName('Administrators')
	->setAdmin(1)
	->setDefaultValue(0)
	->setAccessLevel(3)
	->save();

$new_user_group = MK_RecordManager::getNewRecord( $user_group_module->getId() );
$new_user_group
	->setName('Members')
	->setAdmin(0)
	->setDefaultValue(1)
	->setAccessLevel(1)
	->save();

?>