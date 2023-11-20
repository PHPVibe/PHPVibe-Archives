<?php

$config = MK_Config::getInstance();

// Get Module Types
$user_type = MK_RecordModuleManager::getFromType('user');
$module_type = MK_RecordModuleManager::getFromType('module');
$module_field_type = MK_RecordModuleManager::getFromType('module_field');
$module_field_validation_type = MK_RecordModuleManager::getFromType('module_field_validation');

// Jobs
$user_message_module = MK_RecordManager::getNewRecord( $module_type->getId() );
$user_message_module
	->setName('Messages')
	->setTable('users_messages')
	->setSlug('messages')
	->setParentModuleId( $user_type->getId() )
	->setFieldUid(0)
	->setFieldSlug(0)
	->setFieldParent(0)
	->setFieldOrderby(0)
	->setOrderbyDirection('DESC')
	->setManagementWidth('20%')
	->setType('user_message')
	->setLocked(0)
	->setLockRecords(0)
	->setCoreModule(0)
	->save();

$user_message_subject = MK_RecordManager::getNewRecord( $module_field_type->getId() );
$user_message_subject
	->setOrder(2)
	->setModuleId( $user_message_module->getId() )
	->setName('subject')
	->setLabel('Subject')
	->setType('')
	->setEditable(1)
	->setDisplayWidth('20%')
	->setTooltip('')
	->setFieldset('')
	->setSpecificSearch(0)
	->save();

$user_message_subject_validation = MK_RecordManager::getNewRecord( $module_field_validation_type->getId() );
$user_message_subject_validation
	->setName('instance')
	->setFieldId($user_message_subject->getId())
	->save();

$user_message_date_sent = MK_RecordManager::getNewRecord( $module_field_type->getId() );
$user_message_date_sent
	->setOrder(3)
	->setModuleId( $user_message_module->getId() )
	->setName('date_sent')
	->setLabel('Date Sent')
	->setType('datetime_now')
	->setEditable(1)
	->setDisplayWidth('25%')
	->setTooltip('')
	->setFieldset('')
	->setSpecificSearch(0)
	->save();

$user_message_recipient = MK_RecordManager::getNewRecord( $module_field_type->getId() );
$user_message_recipient
	->setOrder(4)
	->setModuleId( $user_message_module->getId() )
	->setName('recipient')
	->setLabel('Recipient')
	->setType('user')
	->setEditable(1)
	->setDisplayWidth('20%')
	->setTooltip('')
	->setFieldset('')
	->setSpecificSearch(0)
	->save();

$user_message_sender = MK_RecordManager::getNewRecord( $module_field_type->getId() );
$user_message_sender
	->setOrder(5)
	->setModuleId( $user_message_module->getId() )
	->setName('sender')
	->setLabel('Sender')
	->setType('user')
	->setEditable(1)
	->setDisplayWidth('')
	->setTooltip('')
	->setFieldset('')
	->setSpecificSearch(0)
	->save();

$user_message_type = MK_RecordManager::getNewRecord( $module_field_type->getId() );
$user_message_type
	->setOrder(6)
	->setModuleId( $user_message_module->getId() )
	->setName('type')
	->setLabel('Type')
	->setType('user_message_type')
	->setEditable(1)
	->setDisplayWidth('')
	->setTooltip('')
	->setFieldset('')
	->setSpecificSearch(1)
	->save();


$user_message_message = MK_RecordManager::getNewRecord( $module_field_type->getId() );
$user_message_message
	->setOrder(7)
	->setModuleId( $user_message_module->getId() )
	->setName('message')
	->setLabel('Message')
	->setType('rich_text_large')
	->setEditable(1)
	->setDisplayWidth('')
	->setTooltip('')
	->setFieldset('')
	->setSpecificSearch(0)
	->save();

$user_message_module
	->setFieldSlug( $user_message_subject->getId() )
	->setFieldOrderby( $user_message_date_sent->getId() )
	->save();

?>