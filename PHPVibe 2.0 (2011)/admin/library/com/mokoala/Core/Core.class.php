<?php

class MK_Core
{

	const MODE_DEMO = 'demo';
	const MODE_FULL = 'full';
	const MODE_PRODUCT = 'product';

	public static function isValidController( $name )
	{
		$name = MK_Utility::stringToReference($name);
		$controller_filename = 'application/controllers/'.$name.'Controller.class.php';
		if( $controller_file_exists = is_file($controller_filename) )
		{
			require_once $controller_filename;

			$controller_class = 'MK_'.$name.'Controller';
			if( class_exists($controller_class) )
			{
				return $controller_class;
			}
			else
			{
				throw new MK_ControllerException('Expected controller class \''.$controller_class.'\' does not exist');
			}
		}
		else
		{
			return false;
		}
	}

	public static function init($path = array())
	{

		$controller_name = count($path) > 0 ? array_shift($path) : 'index';
		$section_name = count($path) > 0 ? array_shift($path) : 'index';

		while( count( $path ) > 0 )
		{
			$param_key = array_shift($path);
			$param_value = array_shift($path);
			MK_Request::setQuery($param_key, $param_value);
		}

		MK_Request::setParam('controller', $controller_name);
		MK_Request::setParam('section', $section_name);

		try
		{
			
			// Connect to Database
			$config = MK_Config::getInstance();
			MK_MySQL::connect();
			
			$config = MK_Config::getInstance();
			$session = MK_Session::getInstance();

			// Check site is installed
			// If not then redirect to installer
			if( !$config->site->installed && MK_Request::getParam('controller') !== 'install')
			{
				MK_View::redirect(array('controller' => 'install'));
			}
			// If so then authorize the user
			elseif( $config->site->installed && $config->db->con )
			{
				if( !empty($session->login) )
				{
					MK_Authorizer::authorizeById( $session->login );
				}
				
				// Authorize user
				$user = MK_Authorizer::authorize();
	
				// Check if user is authorized
				if( (!$user->isAuthorized() || ( $user->isAuthorized() && !$user->getGroup()->isAdmin() ) ) && ( MK_Request::getParam('controller') !== 'install' && MK_Request::getParam('controller') !== 'account' ) )
				{
					MK_View::redirect(array('controller' => 'account', 'section' => 'log-out'));
				}

			}
			elseif( $config->site->installed && !$config->db->con )
			{
				throw new MK_SQLException("Could not connect to database.");
			}

			
			// Choose & run controller
			if( $controller_class = self::isValidController($controller_name) )
			{
	
				MK_Request::setParam('controller', $controller_name);
				$controller = new $controller_class();
	
				$controller_section = MK_Utility::stringToReference($section_name);
		
				$controller_section = 'section'.$controller_section;
				if(method_exists($controller, $controller_section))
				{
					MK_Request::setParam('section', $section_name);
					$controller->$controller_section();
				}
				else
				{
					throw new MK_ControllerException('Expected section method \''.$controller_section.'\' does not exist');
				}
	
			}
			else
			{
	
				self::isValidController('module');
				try
				{
					$module = MK_RecordModuleManager::getFromSlug( $section_name );
					MK_Request::setParam('controller', $controller_name);
					MK_Request::setParam('section', $section_name);
					$controller_name = 'module_'.$controller_name.'_'.$section_name;
				}
				catch(Exception $e)
				{
					$module = MK_RecordModuleManager::getFromSlug( $controller_name );
					MK_Request::setParam('controller', $controller_name);
					$controller_name = 'module_'.$controller_name;
				}

				if( $controller_class = self::isValidController($controller_name) )
				{
					$controller = new $controller_class($module);
				}
				else
				{
					$controller = new MK_ModuleController($module);
				}
	
			}
			
		}
		catch( Exception $e )
		{
			$controller = new MK_ErrorController($e);
		}

		$config = MK_Config::getInstance();
		$config_data['server']['execution_time'] = microtime(true) - $config->server->execution_start;
		MK_Config::loadConfig($config_data);

		$controller->getView()->renderDisplay();
		$controller->getView()->renderTemplate();

		MK_MySQL::disconnect();

		return $controller;
		
	}
	
}

?>