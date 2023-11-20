<?php

class MK_BrandedEmail extends MK_Email
{
	
	public function __construct()
	{
		$config = MK_Config::getInstance();
		$this->sender_email = $config->site->email;
		$this->replyto = $config->site->email;
		$this->sender_name = $config->site->name;
	}

	public function getSubject()
	{
		$config = MK_Config::getInstance();
		return '['.$config->site->name.'] '.$this->subject;
	}
	
	public function getMessage()
	{
		$config = MK_Config::getInstance();
		return $this->message.( !empty($config->site->email_signature) ? '<br /><br />'.MK_Utility::unescapeText( $config->site->email_signature ) : '' );
	}

}

?>