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
			'class' => 'clear-fix styled-form'
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
		'avatar' => array(
			'label' => "Profile picture <p class='hint'>Don't leave blank!</p>",
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
		//send mwelcome mail
        $to_mail = $form->getField('email')->getValue();
		$to_name = $form->getField('display_name')->getValue();
        $headers  = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=utf-8\n";
		$headers .= "From: ".$config->site->name." <".$config->site->email."> \n";
	    $subject = $to_name." welcome to ".$config->site->name;
		$message .=  "Thank you registering  ".$to_name."!     ";
		$message .=  " Enjoy browing top quality videos at ".$config->site->url;			
	    mail($to_mail,$subject,$message,$headers);
		//end welcome mail
		
		if( $redirect = $config->extensions->core->register_url )
		{
			header('Location: '.$redirect, true, 302);
		}
		
	 
	 
		$content .= '<p class="alert success">Thank you for registering; you have been signed in and can <a href="edit-profile.php">make changes to your profile</a>.</p>';
        
	}else{
	
	
		$content .= $form->render();
		$content .= '<br /><br /> <p style="margin-left:30px;">Two faster alternatives : <br /><a href="'.$config->site->url.'login.php?platform=facebook"><img src="'.$config->site->url.'tpl/images/light/fb-button.png" alt="Connect with Fb" /></a>
';	
$content .= '<a href="'.$config->site->url.'login.php?platform=twitter"><img src="'.$config->site->url.'tpl/images/light/t-button.png" alt="Connect with Twitter"/></p></a>
'; 
	}
	
	
	$content_title = "Create an account";
include_once("tpl/header.php");     
include_once("tpl/content.tpl.php");
include_once("tpl/footer.php");
?>