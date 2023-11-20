<?php

require_once 'DefaultController.class.php';

class MK_IndexController extends MK_DefaultController{

	public function sectionIndex(){
		
		$this->getView()->setRender( false );
		
		$config = MK_Config::getInstance();
		$user = MK_Authorizer::authorize();
		
		$this->getView()->redirect(array('controller' => 'dashboard'));
		
	}

}

?>