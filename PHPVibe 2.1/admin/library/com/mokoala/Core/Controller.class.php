<?php

class MK_Controller{

	protected $template = 'default';
	protected $view;

	public function __construct(){

		$this->view = new MK_View($this);
		$this->view->setDisplayPath( MK_Request::getParam('controller').'/'.MK_Request::getParam('section') );		

		$this->_init();
		
	}
	
	protected function _init()
	{

	}

	public function getView(){
		return $this->view;
	}

}

?>