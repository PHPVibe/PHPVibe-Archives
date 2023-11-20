<?php
require_once 'DefaultController.class.php';
$config = MK_Config::getInstance();
class MK_DashboardController extends MK_DefaultController{

	public function _init(){
		parent::_init();
		$this->getView()->getHead()->prependTitle( 'Dashboard' );
	}

	public function sectionIndex(){
		
		$config = MK_Config::getInstance();

		$message_list = array();

		// Check: If running in demo mode
		if( $config->core->mode == MK_Core::MODE_DEMO )
		{
			$message_list[] = array(
				'type' => 'warning',
				'message' => "<strong>".$config->instance->name."</strong> is currently running in demonstration mode. Editing and deleting records is disabled. You can create records, however."
			);
		}
		
		// Check: If running in demo mode
		if( empty($config->licence->key))
		{
			$message_list[] = array(
				'type' => 'warning',
				'message' => "<strong>".$config->instance->name."</strong> needs a serial key. Please get one from phpVibe.com or the website will self-shutdown at some point.."
			);
		}
		
		// Check: json_encode function
		if( !function_exists('json_encode') )
		{
			$message_list[] = array(
				'type' => 'warning',
				'message' => "Cannot find the function 'json_encode' - This is used for some extended JavaScript functionality."
			);
		}
		
		// Check: cURL installed
		if( !function_exists('curl_init') )
		{
			$message_list[] = array(
				'type' => 'warning',
				'message' => "cURL library not installed - This is used for downloading resources located remotely."
			);
		}
		
		// Check: ZipArchive class
		if( !class_exists('ZipArchive') )
		{
			$message_list[] = array(
				'type' => 'warning',
				'message' => "Cannot find the 'ZipArchive' library - This is used for performing a backup."
			);
		}
		
		// Check: Can use ini_set
		if( !ini_set('memory_limit', '20M') )
		{
			$message_list[] = array(
				'type' => 'warning',
				'message' => "Cannot use 'ini_set'."
			);
		}
		else
		{
			ini_restore('memory_limit');
		}
		
		// Check: Uploads directory is writable
		if( !is_writable('../'.$config->site->upload_path) )
		{
			$message_list[] = array(
				'type' => 'warning',
				'message' => "Uploads folder is not writable '../".$config->site->upload_path."' Please chmod to 0777."
			);
		}
		
		// Check: Thumbs directory is writable
		if( !is_writable('../tpl/img/thumbs') )
		{
			$message_list[] = array(
				'type' => 'warning',
				'message' => "Thumbs folder is not writable '../tpl/img/thumbs/' Please chmod to 0777."
			);
		}
		
		// Check: Backups directory is writable
		if( !is_writable('resources/backups') )
		{
			$message_list[] = array(
				'type' => 'warning',
				'message' => "Backups folder is not writable 'resources/backups/' Please chmod to 0777."
			);
		}
		
		// Check: Restore directory is writable
		if( !is_writable('resources/restore') )
		{
			$message_list[] = array(
				'type' => 'warning',
				'message' => "Restore folder is not writable 'resources/restore/' Please chmod to 0777."
			);
		}
		
		// Check: Can use set_time_limit
		if( !set_time_limit(0) )
		{
			$message_list[] = array(
				'type' => 'warning',
				'message' => "Cannot use 'set_time_limit'."
			);
		}
		else
		{
			ini_restore('time_limit');
		}
		
		// Check: Backup no more than 30 days ago
		$backup_type = MK_RecordModuleManager::getFromType('backup');
		$backup_search = array(
			array('literal' => "`date_time` > DATE_SUB(NOW(), INTERVAL 30 DAY)")
		);

		$backup_records = $backup_type->searchRecords($backup_search);
		if( count($backup_records) == 0 )
		{
			$message_list[] = array(
				'type' => 'warning',
				'message' => "You have not <a href=\"".$this->getView()->uri(array('controller' => 'dashboard', 'section' => 'backup'))."\">backed up</a> within the last 30 days."
			);
		}
		
		if( count($message_list) === 0 )
		{
			$message_list[] = array(
				'type' => 'information',
				'message' => "There are currently no system notifications."
			);
		}
		
		$this->getView()->message_list = $message_list;
		
	}

	public function sectionFileManager()
	{
		$config = MK_Config::getInstance();

		$this->getView()->getHead()->prependTitle( 'File Manager' );

		$messages = array();
		$files = array();

		$files_to_delete = array();

		if( $get_file = MK_Request::getQuery('file-select') )
		{
			$files_to_delete[] = $get_file;
		}
		elseif( $post_files = MK_Request::getPost('file-select') )
		{
			$files_to_delete = $post_files;
		}

		if( count($files_to_delete) > 0 )
		{
			foreach($files_to_delete as $file)
			{
				$file = '../'.$config->site->upload_path.$file;
				$current_file = new MK_File($file);
				$current_file->delete();
			}
			$messages[] = new MK_Message('success', "The selected files were successfully deleted. <a href=\"".$this->getView()->uri()."\">Return to file list</a>.");
		}
		else
		{
		
			if( !is_readable('../'.$config->site->upload_path) )
			{
				$messages[] = new MK_Message('error', "The folder '../".$config->site->upload_path."' cannot be read. Please chmod this folder to 0777.");
			}
			else
			{
				$paginator = new MK_Paginator();
				$paginator
					->setPage( MK_Request::getParam('page', 1) )
					->setPerPage( 10 );
	
				$file_list = scandir('../'.$config->site->upload_path);
				
				foreach($file_list as $file)
				{
					if( $file === 'index.php' )
					{
						continue;
					}
					$file = '../'.$config->site->upload_path.$file;
					if($file != '.' && $file != '..' && !is_dir($file))
					{
						$files[] = new MK_File($file);
					}
				}
	
				$paginator->setTotalRecords( count($files) );
				$files = array_splice($files, $paginator->getRecordStart(), $paginator->getPerPage());
				$this->getView()->paginator = $paginator->render( $this->getView()->uri(array('page' => '{page}')) );
			}
	
			if( count($files) === 0 )
			{
				$messages[] = new MK_Message('information', "There are no files to display.");
			}
	
			$this->getView()->files = $files;
		}

		$this->getView()->messages = $messages;
	}

	public function sectionBackup(){

		$config = MK_Config::getInstance();

		$this->getView()->getHead()->prependTitle( 'Backup' );

		$form_settings = array(
			'attributes' => array(
				'class' => 'standard clear-fix large'
			)
		);

		$form_structure = array(
			'backup_confirm' => array(
				'type' => 'select',
				'options' => array(
					0 => 'No',
					1 => 'Yes'
				),
				'label' => 'Start backup?',
				'validation' => array(
					'boolean_true' => array()
				)
			),
			'backup_submit' => array(
				'type' => 'submit',
				'attributes' => array(
					'value' => 'Confirm'
				)
			)
		);

		$form = new MK_Form($form_structure, $form_settings);
		
		$this->getView()->form = $form->render();

		if($form->isSuccessful())
		{
			$messages = array();
			try
			{
				if(!class_exists('ZipArchive'))
				{
					throw new MK_Exception("Cannot find the 'ZipArchive' library - This is used for performing a backup.");
				}
				$this->getView()->setDisplayPath('dashboard/backup-processed');		
				ini_set('memory_limit', '200M');
				set_time_limit(0);
				$config = MK_Config::getInstance();
		
				// Create archive
				$zip = new MK_ZipArchive();
				$timestamp = time();
				$file_name = 'resources/backups/backup-'.$timestamp.'.zip';
				if ($zip->open($file_name, ZIPARCHIVE::CREATE) !== true)
				{
					throw new MK_Exception("Could not create backup file '$file_name'. Please ensure this directory is writable.");
				}
		
				// Backup files
				$message_list = array();
				
				$iterator  = new RecursiveIteratorIterator(new RecursiveDirectoryIterator("../tpl/uploads/"));
		
				foreach($iterator as $key=>$value)
				{
					$filename = basename($key);
					$zip->addFile($key, 'uploads/'.$filename) or $messages[] = new MK_Message('warning', "Cannot add file '$key' to archive - It may be corrupt or too large.");
				}
				
				// Backup Database
				$database_backup = 'resources/backups/database-'.$timestamp.'.sql';
				$mysql_dump = new MK_MySQLDump($config->db->name, $database_backup, false, false);
				$mysql_dump->doDump();
				$zip->addFile($database_backup, 'database/database.sql') or $messages[] = new MK_Message('warning', "Cannot add file 'database.sql' to archive - It may be corrupt or too large.");
				unlink($database_backup);
		
				// Create backup record
				$backup_type = MK_RecordModuleManager::getFromType('backup');
				$new_backup = MK_RecordManager::getNewRecord( $backup_type->getId() );
				$new_backup
					->setFile('admin/'.$file_name)
					->save();
				$this->getView()->backup = $new_backup;
		
				$messages[] = new MK_Message('success', 'Your backup has been successfully created. You can restore backups using the <a href="'.$this->getView()->uri( array('controller' => 'backups') ).'">backups module</a>.');

				// Close archive
				$zip->close();
			}
			catch(Exception $e)
			{
				$messages[] = new MK_Message('error', $e->getMessage());
			}

			$this->getView()->messages = $messages;
		}
		
	}

	public function sectionSettings(){
		$config = MK_Config::getInstance();

		$this->getView()->getHead()->prependTitle( 'Settings' );

		$form_settings = array(
			'attributes' => array(
				'class' => 'standard clear-fix large'
			)
		);

		$form_structure = array();
		  $form_structure['licence_key'] = array(
				'type' => 'text',
				'label' => 'Licence Key',
				'tooltip' => 'This is licence key you have created for this domain at phpVibe.com.',
				'fieldset' => 'Video Configs',
				'value' => $config->licence->key
			);
		 $form_structure['video_storage'] = array(
			'type' => 'select',
			'options' => array(
				1 => 'Youtube only. Very lightweight',
				2 => 'Store videos data from Youtube'
			),
				'label' => 'Video Storage',
				'tooltip' => 'Select how your video portal behaves. Selecting storage will allow counting views and display most viewed videos..but it will also use more server resources.',
				'fieldset' => 'Video Configs',
				'value' =>  $config->video->storage
			);	
			$form_structure['video_player'] = array(
			'type' => 'select',
			'options' => array(
				1 => 'Use Youtube player',
				2 => 'Use JwPlayer'
				
			),
				'label' => 'Video Player',
				'tooltip' => 'Select what video player your prefer.',
				'fieldset' => 'Video Configs',
				'value' =>  $config->video->player
			);	
		// Pull in custom component settings
		foreach($config->db->components as $component)
		{
			$module_settings = 'resources/components/'.$component.'/settings.php';
			if( is_file($module_settings) )
			{
				require_once $module_settings;
			}
		}
      
		
		if($config->core->mode === MK_Core::MODE_FULL)
		{
			$form_structure['db_host'] = array(
				'type' => 'text',
				'label' => 'Host',
				'fieldset' => 'Database',
				'value' => $config->db->host
			);
			$form_structure['db_username'] = array(
				'type' => 'text',
				'label' => 'Username',
				'fieldset' => 'Database',
				'value' => $config->db->username
			);
			$form_structure['db_password'] = array(
				'type' => 'text',
				'label' => 'Password',
				'fieldset' => 'Database',
				'value' => $config->db->password,
				'attributes' => array(
					'type' => 'password'
				)
			);
			$form_structure['db_name'] = array(
				'type' => 'text',
				'label' => 'Database name',
				'fieldset' => 'Database',
				'value' => $config->db->name
			);
		}
		
		$form_structure['site_facebook_app_id'] = array(
			'type' => 'text',
			'label' => 'Facebook App ID',
			'fieldset' => 'External Services',
			'value' => $config->site->facebook->app_id
		);

		$form_structure['site_facebook_app_secret'] = array(
			'type' => 'text',
			'label' => 'Facebook App Secret',
			'fieldset' => 'External Services',
			'value' => $config->site->facebook->app_secret
		);
		
		$form_structure['site_facebook_login'] = array(
			'type' => 'select',
			'options' => array(
				0 => 'No',
				1 => 'Yes'
			),
			'label' => 'Facebook Login',
			'tooltip' => 'Can users login to the site using their Facebook account?',
			'fieldset' => 'External Services',
			'value' => $config->site->facebook->login
		);

		$form_structure['site_twitter_app_key'] = array(
			'type' => 'text',
			'label' => 'Twitter App Key',
			'fieldset' => 'External Services',
			'value' => $config->site->twitter->app_key
		);

		$form_structure['site_twitter_app_secret'] = array(
			'type' => 'text',
			'label' => 'Twitter App Secret',
			'fieldset' => 'External Services',
			'value' => $config->site->twitter->app_secret
		);
		
		$form_structure['site_twitter_login'] = array(
			'type' => 'select',
			'options' => array(
				0 => 'No',
				1 => 'Yes'
			),
			'label' => 'Twitter Login',
			'tooltip' => 'Can users login to the site using their Twitter account?',
			'fieldset' => 'External Services',
			'value' => $config->site->twitter->login
		);

		$form_structure['site_name'] = array(
			'type' => 'text',
			'label' => 'Name',
			'fieldset' => 'Website',
			'validation' => array(
				'instance' => array()
			),
			'value' => $config->site->name
		);

		$form_structure['site_timezone'] = array(
			'type' => 'select',
			'options' => MK_Utility::getTimezoneList(),
			'label' => 'Timezone',
			'fieldset' => 'Website',
			'validation' => array(
				'instance' => array()
			),
			'value' => $config->site->timezone
		);

		$form_structure['site_valid_file_extensions'] = array(
			'type' => 'textarea',
			'label' => 'File extensions',
			'tooltip' => 'The following file types can be uploaded to the site. Separate with a comma \',\'.',
			'fieldset' => 'Website',
			'validation' => array(
				'instance' => array()
			),
			'value' => implode(', ', (array) $config->site->valid_file_extensions)
		);

		$form_structure['site_email'] = array(
			'type' => 'text',
			'label' => 'Email address',
			'fieldset' => 'Website',
			'validation' => array(
				'email' => array(),
				'instance' => array()
			),
			'value' => $config->site->email
		);
		$form_structure['email_signature'] = array(
			'type' => 'textarea',
			'attributes' => array(
				'class' => 'input-textarea-small'
			),
			'label' => 'Email signature',
			'tooltip' => 'This will be appended to the bottom of any emails sent to users. This field is HTML.',
			'fieldset' => 'Website',
			'value' => $config->site->email_signature
		);
		$form_structure['site_url'] = array(
			'type' => 'text',
			'label' => 'URL',
			'fieldset' => 'Website',
			'validation' => array(
				'url' => array(),
				'instance' => array()
			),
			'value' => $config->site->url
		);
		$form_structure['site_date_format'] = array(
			'type' => 'text',
			'label' => 'Date format',
			'validation' => array(
				'instance' => array()
			),
			'fieldset' => 'Website',
			'value' => $config->site->date_format
		);
		$form_structure['site_time_format'] = array(
			'type' => 'text',
			'label' => 'Date format',
			'validation' => array(
				'instance' => array()
			),
			'fieldset' => 'Website',
			'value' => $config->site->time_format
		);
		$form_structure['site_template'] = array(
			'type' => 'select',
			'options' => array(),
			'label' => 'Template',
			'fieldset' => 'Website',
			'value' => $config->template.'/'.$config->template_theme
		);
		$form_structure['user_timeout'] = array(
			'type' => 'text',
			'label' => 'User login time',
			'validation' => array(
				'instance' => array(),
				'integer' => array()
			),
			'tooltip' => 'This field defines how long users will be signed in for (in seconds). After this period users will need to login again.',
			'fieldset' => 'Website',
			'value' => $config->site->user_timeout
		);

		$form_structure['search_submit'] = array(
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Save Changes'
			)
		);

		$handle = scandir('application/views');

		$components_core = array();
		$components_optional = array();
		foreach($handle as $template_folder)
		{
			if($template_folder!='.' && $template_folder!='..' && is_dir('application/views/'.$template_folder))
			{
				$template_details = simplexml_load_file('application/views/'.$template_folder.'/details.xml');
				$template_name = (string) $template_details->name;
				$form_structure['site_template']['options'][$template_name] = array();
				
				$theme_handle = scandir('application/views/'.$template_folder.'/themes');
				foreach( $theme_handle as $theme_folder )
				{
					if($theme_folder!='.' && $theme_folder!='..' && is_dir('application/views/'.$template_folder.'/themes/'.$theme_folder))
					{
						$theme_details = simplexml_load_file('application/views/'.$template_folder.'/themes/'.$theme_folder.'/details.xml');
						$form_structure['site_template']['options'][$template_name][$template_folder.'/'.$theme_folder] = (string) $theme_details->name.' - By '.(string) $theme_details->author;
					}
				}

			}
		}

		$form = new MK_Form($form_structure, $form_settings);

		if( $form->isSuccessful() )
		{
			$message = array();
			$config_data = array();
			
			$fields = $form->getFields();
			$config_data['licence.key'] = $form->getField('licence_key')->getValue();
			$config_data['video.storage'] = $form->getField('video_storage')->getValue();
			$config_data['video.player'] = $form->getField('video_player')->getValue();
			
			$config_data['licence.checked'] = time();
			if($config->core->mode === MK_Core::MODE_FULL)
			{
				$config_data['db.host'] = $form->getField('db_host')->getValue();
				$config_data['db.name'] = $form->getField('db_name')->getValue();
				$config_data['db.username'] = $form->getField('db_username')->getValue();
				$config_data['db.password'] = $form->getField('db_password')->getValue();
			}

			$config_data['site.facebook.app_id'] = $form->getField('site_facebook_app_id')->getValue();
			$config_data['site.facebook.app_secret'] = $form->getField('site_facebook_app_secret')->getValue();
			$config_data['site.facebook.login'] = $form->getField('site_facebook_login')->getValue();

			$config_data['site.twitter.app_key'] = $form->getField('site_twitter_app_key')->getValue();
			$config_data['site.twitter.app_secret'] = $form->getField('site_twitter_app_secret')->getValue();
			$config_data['site.twitter.login'] = $form->getField('site_twitter_login')->getValue();

			$valid_file_extensions = explode(',', $form->getField('site_valid_file_extensions')->getValue());
			$valid_file_extensions = array_map('trim', $valid_file_extensions);
			$valid_file_extensions = array_filter($valid_file_extensions);
			$valid_file_extensions = array_unique($valid_file_extensions);
			$config_data['site.valid_file_extensions'] = implode(',', $valid_file_extensions);

			$config_data['site.name'] = $form->getField('site_name')->getValue();
			$config_data['site.timezone'] = $form->getField('site_timezone')->getValue();
			$config_data['site.email'] = $form->getField('site_email')->getValue();
			$config_data['site.email_signature'] = $form->getField('email_signature')->getValue();
			$config_data['site.url'] = $form->getField('site_url')->getValue();
			$config_data['site.date_format'] = $form->getField('site_date_format')->getValue();
			$config_data['site.time_format'] = $form->getField('site_time_format')->getValue();
			$config_data['site.template'] = $form->getField('site_template')->getValue();
			$config_data['user.timeout'] = $form->getField('user_timeout')->getValue();

			foreach($fields as $field_key => $field_value)
			{
				list($config_area, $config_section, $config_node) = explode('-', $field_key);
				if($config_area === 'extensions')
				{
					$config_data["extensions.".$config_section.".".$config_node] = $field_value->getValue();
				}
			}

			if($config->core->mode === MK_Core::MODE_DEMO)
			{
				$messages[] = new MK_Message('warning', 'Settings cannot be updated as <strong>'.$config->instance->name.'</strong> is running in demonstration mode.');
			}
			else
			{
				$messages[] = new MK_Message('success', 'Your settings have been updated. <a href="'.$this->getView()->uri( array('controller' => 'dashboard', 'section' => 'settings') ).'">Make more changes</a> or <a href="'.$this->getView()->uri( array('controller' => 'dashboard', 'section' => 'settings') ).'">return to the dashboard</a>.');
				MK_Utility::writeConfig($config_data);
			}

			$this->getView()->messages = $messages;
			$this->getView()->setDisplayPath('dashboard/settings-processed');		
		}
		else
		{
			$this->getView()->form = $form->render();
		}
		
	}

}

?>