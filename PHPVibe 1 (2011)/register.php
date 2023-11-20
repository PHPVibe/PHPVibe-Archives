<?php
require_once("_inc.php");
require_once("library/video.func.php");
$head_title = array();
$head_desc = array();
$head_title[] = 'Register here M8'; 
$head_desc[] = 'This shows you how phpVibe Basic Register system works'; 



	if($user->isAuthorized()){
		header('Location: '.$config->site->base, true, 302);
		exit;
	}

	// We get an instance of the users module, the email field and the display name field to make sure the given email and display name is unique
	$user_module = MK_RecordModuleManager::getFromType('user');
	$field_module = MK_RecordModuleManager::getFromType('module_field');
	$criteria = array(
		array('field' => 'module_id', 'value' => $user_module->getId()),
		array('field' => 'name', 'value' => 'email')
	);
	
	$user_email_field = $field_module->searchRecords($criteria);
	$user_email_field = array_pop( $user_email_field );

	$settings = array(
		'attributes' => array(
			'class' => 'narrow clear-fix standard'
		)
	);

	$structure = array(
		'display_name' => array(
			'label' => __("Display name"),
			'validation' => array(
				'instance' => array()
			)
		),
		'email' => array(
			'label' => 'Email',
			'validation' => array(
				'email' => array(),
				'instance' => array(),
				'unique' => array(null, $user_email_field, $user_module)
			)
		),
		'password' => array(
			'label' => __("Password"),
			'validation' => array(
				'instance' => array(),
			),
			'attributes' => array(
				'type' => 'password'
			)
		),
		'submit' => array(
			'type' => 'submit',
			'attributes' => array(
				'value' => __("Register")
			)
		)
	);

	
	if($config->site->facebook->login)
	{
		$structure['facebook'] = array(
			'type' => 'link',
			'text' => 'Facebook Login',
			'attributes' => array(
				'href' => 'login.php?platform=facebook'
			)
		);	
	}

	if($config->site->twitter->login)
	{
		$structure['twitter'] = array(
			'type' => 'link',
			'text' => 'Twitter Login',
			'attributes' => array(
				'href' => 'login.php?platform=twitter'
			)
		);	
	}

	$form = new MK_Form($structure, $settings);
	

	$output = '<h2 class="narrow">'.__("Creat an account").'</h2>';
	if($form->isSuccessful()){
		
		$user = MK_RecordManager::getNewRecord($user_module->getId());
		
		$user
			->setEmail($form->getField('email')->getValue())
			->setPassword($form->getField('password')->getValue())
			->setDisplayName($form->getField('display_name')->getValue())
			->save();
		
		$session->login = $user->getId();
		$cookie->set('login', $user->getId(), $config->site->user_timeout);

		if( $redirect = $config->extensions->core->register_url )
		{
			header('Location: '.$redirect, true, 302);
		}

		$output .= '<p class="alert success">Thank you for registering; you have been signed in and can <a href="edit-profile.php">make changes to your profile</a>.</p>';

	}else{
		$output .= $form->render();
	}
include_once("tpl/php/global_header.php");
?>


<div id="content-bkg">   
<div class="wrapper">
<div class="clearfix" id="main-content">

<div class="col col3">
  <div class="col-bkg clearfix">
  <h2><?php echo __("Why login?");?></h2>
  <?php echo __("By logging into our website you can like videos, create playlist, share statuses, follow other members and make friends.");?>
  <h2><?php echo __("It's fun");?></h2>
  </div>
  </div>
<div class="col col7 col-last clearfix">
  <div class="col-bkg clearfix">
    <h1><?php echo __("Login to enjoy all the functions of our video website");?></h1>
		
		<?php print $output; ?>		
		
  </div>

</div>





	</div>
	</div>
	</div>
	</div>
<div class="clearfix"></div>	
<?php      
include_once("tpl/php/footer.php");
?>