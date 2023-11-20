<?php

require_once 'DefaultController.class.php';

class MK_ErrorController extends MK_DefaultController
{

	public function _init()
	{
		parent::_init();
		$this->getView()->getHead()->prependTitle( 'Error' );
		$this->getView()->setDisplayPath('error/index');		
	}

	public function __construct( Exception $error )
	{
		parent::__construct();
		if( $error instanceof MK_SQLException )
		{
			$this->getView()->setTemplatePath('small');		
		}
		$this->getView()->error = $error->getMessage();
		$this->getView()->error_trace = nl2br($error->getTraceAsString());
	}

}

?>