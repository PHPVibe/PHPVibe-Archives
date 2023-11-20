<?php require_once("phpvibe.php");
if($user->isAuthorized()){ 		redirect($site_url); 	}

	// If the user clicked the 'sign in with Facebook' link
	if( $config->site->facebook->login && MK_Request::getQuery('platform') === 'facebook' )
	{
		$config = MK_Config::getInstance();
		$facebook_return = "";
		$facebook_url = $config->facebook->getLoginUrl(array(
			'next' => $facebook_return,
			'cancel_url' => $facebook_return,
			'req_perms' => 'email, user_photos, user_about_me, user_website'
		));

		redirect($facebook_url);
		
	}
	// If the user clicked the 'sign in with Twitter' link
	elseif( $config->site->twitter->login && MK_Request::getQuery('platform') === 'twitter' )
	{
		$config = MK_Config::getInstance();

		$twitter_request_token = $config->twitter->getRequestToken( MK_Utility::serverUrl( 'login.php' ) );

		$session->twitter_oauth_token = $twitter_request_token['oauth_token'];
		$session->twitter_oauth_token_secret = $twitter_request_token['oauth_token_secret'];

		$twitter_url = $config->twitter->getAuthorizeURL($session->twitter_oauth_token);

		redirect($twitter_url);
		
	}
	elseif( MK_Request::getQuery('platform') === 'core' )
	{
		unset( $session->twitter_details );
	}

	$user_module = MK_RecordModuleManager::getFromType('user');
	$field_module = MK_RecordModuleManager::getFromType('module_field');
	$criteria = array(
		array('field' => 'module_id', 'value' => $user_module->getId()),
		array('field' => 'name', 'value' => 'email')
	);
	
	$user_email_field = $field_module->searchRecords($criteria);
	$user_email_field = array_pop( $user_email_field );

	if( !empty( $session->twitter_details ) )
	{
		$settings = array(
			'attributes' => array(
				'class' => 'form',
				'action' => 'login.php'
			)
		);
	
		$structure = array(
			'email' => array(
				'label' => 'Email',
				'validation' => array(
					'email' => array(),
					'instance' => array(),
					'unique' => array(null, $user_email_field, $user_module)
				)
			),
			'twitter' => array(
				'type' => 'submit',
				'attributes' => array(
					'value' => 'Complete Login'
				)
			),
			'cancel' => array(
				'type' => 'link',
				'text' => 'Cancel Login',
				'attributes' => array(
					'href' => 'login.php?platform=core'
				)
			),
		);
	
		$form = new MK_Form($structure, $settings);
		
		$content = '<h2 class="narrow">Twitter Login</h2>';
		$content .= '<p class="narrow">Please enter your email address to finish logging in.</p>';
		if($form->isSuccessful())
		{
			$user_details = unserialize( $session->twitter_details );
			$user_details['email'] = $form->getField('email')->getValue();
			$session->twitter_details = serialize( $user_details );
			redirect('login.php');
			
		}
	}
	else
	{
		$settings = array(
			'attributes' => array(
				'class' => 'form'
			)
		);
	
		$structure = array(
			'email' => array(
				'label' => 'Email',
				'validation' => array(
					'email' => array(),
					'instance' => array()
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
			'login' => array(
				'type' => 'submit',
				'attributes' => array(
					'value' => 'Login'
				)
			)
		);
		
		
	
		$form = new MK_Form($structure, $settings);
		
		//$content = '<h2>Login</h2><br/>';

		if($form->isSuccessful()){
			$user = MK_Authorizer::authorizeByEmailPass(
				$form->getField('email')->getValue(),
				$form->getField('password')->getValue()
			);
			
			if($user->isAuthorized()){
				$session->login = $user->getId();
				$cookie->set('login', $user->getId(), $config->site->user_timeout);
	
				if( !$redirect = MK_Request::getQuery('redirect') )
				{
					redirect($site_url);
				} else {
				redirect($site_url.$redirect);
				}
				
			}else{
				$form->getField('email')->getValidator()->addError('This username and password combination does not match our records. Please try again.');
			}
		}
	}
	
	$content.=$form->render();
		$content .= '<br /><p style="margin-left:30px;"> If you can\'t remember your password then use the <a href="forgot-pass.php">forgotten password</a> form.</p>';
	    $content .= '<p style="margin-left:30px;">If you don\'t have an account with us you can manually <a href="'.$config->site->url.'register.php">register here for a new account</a>.</a>';
		 if($config->site->facebook->login) 		{
		$content .= '<p style="margin-left:30px;"><a href="'.$config->site->url.'login.php?platform=facebook"><img src="'.$config->site->url.'tpl/images/fb-signin.png" alt="Connect with Fb" /></a>
';	}
 if($config->site->twitter->login) {
$content .= '<a href="'.$config->site->url.'login.php?platform=twitter"><img src="'.$config->site->url.'tpl/images/tw-signin.png" alt="Connect with Twitter"/></p></a>
'; 
}
$reqform = true;
$content_title = "Login";
include_once("tpl/header.php");     
include_once("tpl/content.tpl.php");
include_once("tpl/footer.php");
?>