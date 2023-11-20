<?php

/*
	Loader for Mokoala
*/
$dir_path = dirname(__FILE__);

require_once $dir_path.'/../facebook/Facebook.class.php';
require_once $dir_path.'/../twitter/Twitter.class.php';
require_once $dir_path.'/../oauth/OAuth.class.php';

require_once $dir_path.'/Utility/DataRenderer.class.php';
require_once $dir_path.'/Utility/FieldHandler.class.php';
require_once $dir_path.'/Utility/Backup.class.php';
require_once $dir_path.'/Utility/Email.class.php';
require_once $dir_path.'/Utility/BrandedEmail.class.php';
require_once $dir_path.'/Utility/Message.class.php';
require_once $dir_path.'/Utility/MetaFactory.class.php';
require_once $dir_path.'/Utility/MetaFactoryExtra.class.php';
require_once $dir_path.'/Utility/Paginator.class.php';
require_once $dir_path.'/Utility/Utility.class.php';
require_once $dir_path.'/Utility/MySQLDump.class.php';
require_once $dir_path.'/Utility/ZipArchive.class.php';
require_once $dir_path.'/Utility/ConfigHandler.interface.php';
require_once $dir_path.'/Utility/ConfigHandler.class.php';
require_once $dir_path.'/Utility/Config.class.php';
require_once $dir_path.'/Utility/ConfigHolder.class.php';

require_once $dir_path.'/Authorizer/Authorizer.class.php';

require_once $dir_path.'/Cookie/Cookie.class.php';
require_once $dir_path.'/Cookie/CookieHolder.class.php';

require_once $dir_path.'/Calendar/Calendar.class.php';

require_once $dir_path.'/Core/View/Head.class.php';
require_once $dir_path.'/Core/Request.class.php';
require_once $dir_path.'/Core/Core.class.php';
require_once $dir_path.'/Core/Controller.class.php';
require_once $dir_path.'/Core/View.class.php';

require_once $dir_path.'/Database/MySQL.class.php';

require_once $dir_path.'/Directory/Directory.class.php';

require_once $dir_path.'/Exception/Exception.class.php';
require_once $dir_path.'/Exception/ControllerException.class.php';
require_once $dir_path.'/Exception/InputException.class.php';
require_once $dir_path.'/Exception/ModuleException.class.php';
require_once $dir_path.'/Exception/ModuleRecordException.class.php';
require_once $dir_path.'/Exception/SQLException.class.php';
require_once $dir_path.'/Exception/ViewException.class.php';

require_once $dir_path.'/File/FileManager.class.php';
require_once $dir_path.'/File/File.class.php';
require_once $dir_path.'/File/Image.class.php';
require_once $dir_path.'/File/ImageThumb.class.php';

require_once $dir_path.'/Form/Validator.class.php';
require_once $dir_path.'/Form/Form.class.php';

require_once $dir_path.'/Module/Record.class.php';
require_once $dir_path.'/Module/RecordManager.class.php';
require_once $dir_path.'/Module/RecordModule.class.php';
require_once $dir_path.'/Module/RecordModuleField.class.php';
require_once $dir_path.'/Module/RecordModuleFieldValidation.class.php';
require_once $dir_path.'/Module/RecordModuleManager.class.php';
require_once $dir_path.'/Module/RecordUser.class.php';

require_once $dir_path.'/Session/Session.class.php';
require_once $dir_path.'/Session/SessionHolder.class.php';

require_once $dir_path.'/globals.php';
require_once $dir_path.'/config.php';
$config = MK_Config::getInstance();

foreach($config->db->components as $component)
{
	$module_includes_path = $dir_path.'/../../../resources/components/'.$component.'/extensions';

	if( is_dir($module_includes_path) )
	{
		$module_includes = scandir($module_includes_path);
		foreach($module_includes as $module)
		{
			if($module == '.' || $module == '..')
			{
				continue;
			}

			$module_path = $module_includes_path.'/'.$module;
			if( is_file($module_path) )
			{
				require_once $module_path;
			}
		}
	}
}

?>