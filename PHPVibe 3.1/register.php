<?php require_once("phpvibe.php");
$reqform = true;
$page = "registration";
	
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
			'class' => 'form',
			'id' => 'regform'
		)
	);

	$structure = array(
		'display_name' => array(
			'label' => $lang['dname'],
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
		'avatar' => array(
			'label' => "Avatar",
			'type' => 'file_image',
			'upload_path' => $config->site->upload_path,
			'validation' => array(
				'instance' => array(),
			),
		),	
		'submit' => array(
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Register'
											
			)
		)
	);

	

	$form = new MK_Form($structure, $settings);
	

	//$content = '<h2 class="narrow">Create an account</h2>';
	if($form->isSuccessful()){
		
		$user = MK_RecordManager::getNewRecord($user_module->getId());
		
		$user
			->setEmail($form->getField('email')->getValue())
			->setPassword($form->getField('password')->getValue())
			->setDisplayName($form->getField('display_name')->getValue())
			->setAvatar( $form->getField('avatar')->getValue() )
			->save();
		
		$session->login = $user->getId();
		$cookie->set('login', $user->getId(), $config->site->user_timeout);

		if( $redirect = $config->extensions->core->register_url )
		{
			header('Location: '.$redirect, true, 302);
		}

		$content .= '<p class="alert success">Thank you for registering; you have been signed in and can <a href="edit-profile.php">make changes to your profile</a>.</p>';

	}else{
	
	$or = '<div class="formRow"><input value="Register"';
	$fc ='<div class="formRow"><label>'.$lang['ayh'].'</label><div class="formRight"><div class="QapTcha"></div></div>'.$or;
		//$content .= $form->render();
		$content .= str_replace($or,$fc,$form->render());
		$content .= '<p style="margin-left:30px;margin-top:30px;"><a href="'.$config->site->url.'login.php?platform=facebook"><img src="'.$config->site->url.'tpl/images/fb-signin.png" alt="Connect with Fb" /></a>
';	
$content .= '<a href="'.$config->site->url.'login.php?platform=twitter"><img src="'.$config->site->url.'tpl/images/tw-signin.png" alt="Connect with Twitter"/></p></a>
'; 
	}
	
	
	$content_title = "Create an account";
include_once("tpl/header.php");     
include_once("tpl/content.tpl.php");
include_once("tpl/footer.php");
?>