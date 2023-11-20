<?php
class MK_RecordUserMessage extends MK_Record
{

	public function save( $update_meta = true )
	{
		if( $this->getType() == 'inbox_unread' )
		{
			$sent_message = MK_RecordManager::getNewRecord( $this->module_id );
			$sent_message
				->setSubject( $this->getSubject() )
				->setMessage( $this->getMessage() )
				->setRecipient( $this->getRecipient() )
				->setSender( $this->getSender() )
				->setType( 'sent' )
				->save();
		}
		parent::save( $update_meta );
	}

}

?>