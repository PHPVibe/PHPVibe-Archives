<?php
require_once '../app/framework/Core/Controller.class.php';
class MK_DefaultController extends MK_Controller{


	protected function _init()
	{
		parent::_init();
		$this->_initNavigation();

		$config = MK_Config::getInstance();
		$this->getView()->getHead()->setBase( $config->site->base_href );
		$this->getView()->getHead()->prependTitle( $config->instance->name );
	}

	protected function _initNavigation()
	{

		$config = MK_Config::getInstance();
		
		$html = '';
		if($config->db->con && $config->site->installed)
		{
			
			$module_module = MK_RecordModuleManager::getFromType('module');

			$search_options = array(
				array('field' => 'parent_module_id', 'value' => 0)
			);

			$modules = $module_module->searchRecords($search_options);

			foreach($modules as &$module)
			{
				$search_options = array(
					array('field' => 'parent_module_id', 'value' => $module->getId())
				);
				$module->setSubModules( $module_module->searchRecords($search_options) );
			}

			$this->getView()->modules = $modules;

		}
	
	}

}

?>