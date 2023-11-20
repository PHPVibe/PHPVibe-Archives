<?php

class MK_Message
{
	
	protected $message;
	protected $type;
	
	const TYPE_SUCCESS = 'success';
	const TYPE_ERROR = 'error';
	const TYPE_WARNING = 'warning';

	public function __construct( $type, $message )
	{
		$this->message = $message;
		$this->type = $type;
	}
	
	public function getType()
	{
		return $this->type;	
	}
	
	public function getMessage()
	{
		return $this->message;	
	}

}

?>