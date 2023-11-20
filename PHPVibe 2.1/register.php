<?php
require_once("phpvibe.php");
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
			'class' => 'clear-fix titled standard'
		)
	);

	$structure = array(
		'display_name' => array(
			'label' => 'Display name',
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
			'label' => 'Password',
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
				'value' => 'Register'
			)
		)
	);

	
	if($config->site->facebook->login)
		{
		$content .= '<a href="'.$config->site->url.'login.php?platform=facebook"><img src="'.$config->site->url.'tpl/images/facebook_signin.png" alt="Connect with Fb" /></a>
';
		}
	
		if($config->site->twitter->login)
		{
$content .= '<a href="'.$config->site->url.'login.php?platform=twitter"><img src="'.$config->site->url.'tpl/images/twitter_signin.png" alt="Connect with Twitter"/></a>
';
		}

	

	$form = new MK_Form($structure, $settings);
	

	//$content = '<h2 class="narrow">Create an account</h2>';
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

		$content .= '<p class="alert success">Thank you for registering; you have been signed in and can <a href="edit-profile.php">make changes to your profile</a>.</p>';

	}else{
	
	
		$content .= $form->render();
	}
	$content_title = "Create an account";
include_once("tpl/header.php");     
include_once("tpl/content.tpl.php");
include_once("tpl/footer.php");
?>