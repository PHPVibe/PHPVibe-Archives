<?php require_once 'DefaultController.class.php';
$config = MK_Config::getInstance();
$key = $config->licence->key;

class MK_InstallController extends MK_DefaultController{
	
	public function _init(){
		parent::_init();
		$this->getView()->setTemplatePath('small');
	
		$this->getView()->getHead()->prependTitle( 'Install' );

		$config = MK_Config::getInstance();
		$session = MK_Session::getInstance();

		$step_1_complete = ( !empty( $session->install['db.host'] ) && !empty( $session->install['db.username'] ) && !empty( $session->install['db.name'] ) );
		$step_2_complete = ( !empty( $session->install['site.name'] ) && !empty( $session->install['site.email'] ) && !empty( $session->install['site.url'] ) );
		$step_3_complete = ( !empty( $session->user['display_name'] ) && !empty( $session->user['email'] ) && !empty( $session->user['password'] ) );

		if( $config->site->installed )
		{
			$this->getView()->redirect(array('controller' => 'dashboard', 'section' => 'index'));
		}
		elseif( MK_Request::getParam('section') === 'step-2' && (!$step_1_complete) )
		{
			$this->getView()->redirect(array('controller' => 'install', 'section' => 'step-1'));
		}
		elseif( MK_Request::getParam('section') === 'step-3' && (!$step_2_complete || !$step_1_complete) )
		{
			$this->getView()->redirect(array('controller' => 'install', 'section' => 'step-2'));
		}
		elseif( ( MK_Request::getParam('section') === 'step-4' || MK_Request::getParam('section') === 'finished' ) && (!$step_3_complete || !$step_2_complete || !$step_1_complete) )
		{
			$this->getView()->redirect(array('controller' => 'install', 'section' => 'step-3'));
		}

	}

	public function sectionIndex(){
		
		$session = MK_Session::getInstance();
		unset($session->install, $session->user);
		$session->install = array();

		$this->getView()->getHead()->prependTitle( 'Requirements' );
		
		$messages = array();
		
		$messages[] = new MK_Message( (phpversion() >= 5 ? 'success' : 'warning'), '<strong>PHP 5</strong> or above' );
		$messages[] = new MK_Message( (is_writable('../uploads/') ? 'success' : 'warning'), 'The permissions of folder "<strong>../uploads/</strong>" set to <strong>0777</strong>' );
		$messages[] = new MK_Message( (is_writable('../media/') ? 'success' : 'warning'), 'The permissions of folder "<strong>../media</strong>" set to <strong>0777</strong>' );
		$messages[] = new MK_Message( (is_writable('../media/flv/') ? 'success' : 'warning'), 'The permissions of folder "<strong>../media/flv</strong>" set to <strong>0777</strong>' );
		$messages[] = new MK_Message( (is_writable('../media/thumbs/') ? 'success' : 'warning'), 'The permissions of folder "<strong>../media/thumbs</strong>" set to <strong>0777</strong>' );
		$messages[] = new MK_Message( (is_writable('../media/pictures/') ? 'success' : 'warning'), 'The permissions of folder "<strong>../media/pictures</strong>" set to <strong>0777</strong>' );

		$messages[] = new MK_Message( (is_writable('../cache/') ? 'success' : 'warning'), 'The permissions of folder "<strong>../cache/</strong>" set to <strong>0777</strong>' );
		$messages[] = new MK_Message( (is_writable('../cache/images') ? 'success' : 'warning'), 'The permissions of folder "<strong>../cache/images</strong>" set to <strong>0777</strong>' );
		$messages[] = new MK_Message( (is_writable('../cache/videos') ? 'success' : 'warning'), 'The permissions of folder "<strong>../cache/videos</strong>" set to <strong>0777</strong>' );

		$messages[] = new MK_Message( (is_writable('../app/config.ini.php') ? 'success' : 'warning'), 'The permissions of file "<strong>app/config.ini.php</strong>" set to <strong>0777</strong>' );
		
		$this->getView()->messages = $messages;
	}
	
	public function sectionStep1(){

		$session = MK_Session::getInstance();
		$config = MK_Config::getInstance();

		$this->getView()->getHead()->prependTitle( 'Step 1' );

		
		$form_structure = array(
			'db_host' => array(
				'label' => 'Host',
				'value' => !empty( $session->install['db.host'] ) ? $session->install['db.host'] : 'localhost',
				'validation' => array(
					'instance' => array()
				),
				'attributes' => array(
					'autofocus' => 'autofocus'
				)
			),
			'db_username' => array(
				'label' => 'Username',
				'value' => !empty( $session->install['db.username'] ) ? $session->install['db.username'] : '',
				'validation' => array(
					'instance' => array()
				)
			),
			'db_password' => array(
				'label' => 'Password',
				'value' => !empty( $session->install['db.password'] ) ? $session->install['db.password'] : '',
				'attributes' => array(
					'type' => 'password'
				)
			),
			'db_name' => array(
				'label' => 'Database Name',
				'value' => !empty( $session->install['db.name'] ) ? $session->install['db.name'] : '',
				'validation' => array(
					'instance' => array()
				)
			),
		
			'next_2' => array(
				'type' => 'submit',
				'attributes' => array(
					'value' => 'Step 2 &raquo;'
				)
			)
		);

		$form_settings = array(
			'attributes' => array(
				'class' => 'form '.$config->core->mode
			)
		);
		
		$form = new MK_Form($form_structure, $form_settings);
		
		if($form->isSuccessful())
		{
			if(!$tmp_con = @mysql_connect($form->getField('db_host')->getValue(), $form->getField('db_username')->getValue(), $form->getField('db_password')->getValue()))
			{
				$form->getField('db_host')->getValidator()->addError("Could not connect to host using details provided.");
			}
			else
			{
				if(!$tmp_db = @mysql_select_db($form->getField('db_name')->getValue(), $tmp_con))
				{
					$form->getField('db_name')->getValidator()->addError("Could not connect to database using details provided.");
				}
				else
				{
					$get_tables = mysql_query("SHOW TABLES IN `".mysql_real_escape_string($form->getField('db_name')->getValue(), $tmp_con)."`", $tmp_con);
					if($num_tables = mysql_num_rows($get_tables))
					{
						$form->getField('db_name')->getValidator()->addError("There are already tables present on this database, which could cause conflicts.");
					}
					else
					{
						$session->install = array_merge_replace(
							(array) $session->install,
							array(
								'db.host' => $form->getField('db_host')->getValue(),
								'db.username' => $form->getField('db_username')->getValue(),
								'db.password' => $form->getField('db_password')->getValue(),
								'db.name' => $form->getField('db_name')->getValue()
							), 1
						);
						$this->getView()->redirect(array('controller' => 'install', 'section' => 'step-2'));
					}
				}
			}
		}

		$this->getView()->install_form = $form->render();

	}
	
	public function sectionStep2(){
		$session = MK_Session::getInstance();
		$config = MK_Config::getInstance();
		
		$this->getView()->getHead()->prependTitle( 'Step 2' );

		$site_url = explode( '/', $config->site->base_href );
		array_pop($site_url); array_pop($site_url);
		$site_url = implode('/', $site_url).'/';

		$form_structure = array(
			'site_name' => array(
				'label' => 'Site Name',
				'value' => !empty( $session->install['site.name'] ) ? $session->install['site.name'] : '',
				'validation' => array(
					'length' => array(2, 64)
				),
				'attributes' => array(
					'autofocus' => 'autofocus'
				)
			),
			'site_url' => array(
				'label' => 'Site URL',
				'value' => !empty( $session->install['site.url'] ) ? $session->install['site.url'] : $site_url,
				'validation' => array(
					'url' => array()
				)
			),
			'site_email' => array(
				'label' => 'Admin Email',
				'value' => !empty( $session->install['site.email'] ) ? $session->install['site.email'] : '',
				'validation' => array(
					'email' => array()
				)
			),
			'next_3' => array(
				'type' => 'submit',
				'attributes' => array(
					'value' => 'Step 3 &raquo;'
				)
			),
			'prev_1' => array(
				'type' => 'submit',
				'attributes' => array(
					'value' => '&laquo; Step 1'
				)
			)
		);

		$form_settings = array(
			'attributes' => array(
				'class' => 'form'
			)
		);
		
		$form = new MK_Form($form_structure, $form_settings);
		
		if($form->getField('prev_1')->isSubmitted()){
			$this->getView()->redirect(array('controller' => 'install', 'section' => 'step-1'));
		}elseif($form->isSuccessful()){
			$session->install = array_merge_replace(
				(array) $session->install,
				array(
					'site.name' => $form->getField('site_name')->getValue(),
					'site.email' => $form->getField('site_email')->getValue(),
					'site.url' => $form->getField('site_url')->getValue()
				)
			);

			$this->getView()->redirect(array('controller' => 'install', 'section' => 'step-3'));
		}

		$this->getView()->install_form = $form->render();

	}

	public function sectionStep3(){
	 global $ini;
		$session = MK_Session::getInstance();
		$config = MK_Config::getInstance();

		$this->getView()->getHead()->prependTitle( 'Step 3' );

		$form_structure = array(
			'user_display_name' => array(
				'label' => 'Display Name',
				'value' => !empty( $session->user['display_name'] ) ? $session->user['display_name'] : '',
				'validation' => array(
					'length' => array(2, 64)
				),
				'attributes' => array(
					'autofocus' => 'autofocus'
				)
			),
			'user_email' => array(
				'label' => 'Email Address',
				'value' => !empty( $session->user['email'] ) ? $session->user['email'] : $session->install['site.email'],
				'validation' => array(
					'email' => array()
				)
			),
			'user_password' => array(
				'label' => 'Password',
				'value' => !empty( $session->user['password'] ) ? $session->user['password'] : '',
				'attributes' => array(
					'type' => 'password'
				),
				'validation' => array(
					'length' => array(4, 16)
				)
			),
			'next_4' => array(
				'type' => 'submit',
				'attributes' => array(
					'value' => 'Step 4 &raquo;'
				)
			),
			'prev_2' => array(
				'type' => 'submit',
				'attributes' => array(
					'value' => '&laquo; Step 2'
				)
			)
		);

		$form_settings = array(
			'attributes' => array(
				'class' => 'form'
			)
		);
		
		$form = new MK_Form($form_structure, $form_settings);
		
		if($form->getField('prev_2')->isSubmitted()){
			$this->getView()->redirect(array('controller' => 'install', 'section' => 'step-2'));
		}elseif($form->isSuccessful()){
			$session->user = array(
				'display_name' => $form->getField('user_display_name')->getValue(),
				'email' => $form->getField('user_email')->getValue(),
				'password' => $form->getField('user_password')->getValue()
			);

			MK_Utility::writeConfig($session->install,$ini);
			$this->getView()->redirect(array('controller' => 'install', 'section' => 'step-4'));
		}
		
		$this->getView()->install_form = $form->render();

	}

	public function sectionStep4(){
		$session = MK_Session::getInstance();

		$this->getView()->getHead()->prependTitle( 'Step 4' );

		$form_structure = array(
			'next_finish' => array(
				'type' => 'submit',
				'attributes' => array(
					'value' => 'Finish &raquo;'
				)
			),
			'prev_3' => array(
				'type' => 'submit',
				'attributes' => array(
					'value' => '&laquo; Step 3'
				)
			)
			
		);

		$form_settings = array(
			'attributes' => array(
				'class' => 'form'
			)
		);
		
		$form = new MK_Form($form_structure, $form_settings);
		
		if($form->getField('prev_3')->isSubmitted()){
			$this->getView()->redirect(array('controller' => 'install', 'section' => 'step-3'));
		}elseif($form->isSuccessful()){

			$config = MK_Config::getInstance();

			// Run SQL queries
				$sql_queries = array();
				$sql_file = 'mysql.sql';
				if(is_file($sql_file))
				{
					$sql_queries = array_merge($sql_queries, MK_Utility::SQLSplit(file_get_contents($sql_file)));
		
					foreach($sql_queries as $query)
					{
						mysql_query($query, $config->db->con);
					}
				}
				
				
			

			$this->getView()->redirect(array('controller' => 'install', 'section' => 'finished'));

		}

		$this->getView()->install_form = $form->render();

	}

	public function sectionFinished(){
	    global $ini;
		$session = MK_Session::getInstance();

		$group_module = MK_RecordModuleManager::getFromType('user_group');
		$search_group = array(
			array('field' => 'admin', 'value' => '1')
		);
		
		$admin_group = $group_module->searchRecords($search_group);
		$admin_group = array_pop( $admin_group );

		$user_module = MK_RecordModuleManager::getFromType('user');
		$new_user = MK_RecordManager::getNewRecord( $user_module->getId() );
		$new_user
			->setDisplayName( $session->user['display_name'] )
			->setEmail( $session->user['email'] )
			->setGroupId( $admin_group->getId() )
			->setPassword( $session->user['password'] )
			->save();
		
		$session->login = $new_user->getId();

		$session->install = array(
			'site.installed' => '1'
		);

		MK_Utility::writeConfig($session->install,$ini);

		$this->getView()->getHead()->prependTitle( 'Finished' );

		unset($session->user, $session->install);
	}

}

?>