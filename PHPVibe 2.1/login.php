<?php
require_once("phpvibe.php");


if($user->isAuthorized()){
		header('Location: '.$config->site->base, true, 302);
		exit;
	}

	// If the user clicked the 'sign in with Facebook' link
	if( $config->site->facebook->login && MK_Request::getQuery('platform') === 'facebook' )
	{
		$config = MK_Config::getInstance();
		$facebook_return = MK_Utility::serverUrl( $config->site->referer );
		$facebook_url = $config->facebook->getLoginUrl(array(
			'next' => $facebook_return,
			'cancel_url' => $facebook_return,
			'req_perms' => 'email, user_photos'
		));

		header('Location: '.$facebook_url, true, 302);
		exit;
	}
	// If the user clicked the 'sign in with Twitter' link
	elseif( $config->site->twitter->login && MK_Request::getQuery('platform') === 'twitter' )
	{
		$config = MK_Config::getInstance();

		$twitter_request_token = $config->twitter->getRequestToken( MK_Utility::serverUrl( 'login.php' ) );

		$session->twitter_oauth_token = $twitter_request_token['oauth_token'];
		$session->twitter_oauth_token_secret = $twitter_request_token['oauth_token_secret'];

		$twitter_url = $config->twitter->getAuthorizeURL($session->twitter_oauth_token);

		header('Location: '.$twitter_url, true, 302);
		exit;
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
				'class' => 'clear-fix titled standard',
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
			header('Location: login.php', true, 302);
			exit;
		}
	}
	else
	{
		$settings = array(
			'attributes' => array(
				'class' => 'clear-fix titled standard'
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
		
		$content = '<h2>Login</h2><br/>';
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
				$content .= '<br /><p>Or enter your email address and password. If you can\'t remember your password then use the <a href="forgot-pass.php">forgotten password</a> form.</p>';

		if($form->isSuccessful()){
			$user = MK_Authorizer::authorizeByEmailPass(
				$form->getField('email')->getValue(),
				$form->getField('password')->getValue()
			);
			
			if($user->isAuthorized()){
				$session->login = $user->getId();
				$cookie->set('login', $user->getId(), $config->site->user_timeout);
	
				if( !$redirect = $config->extensions->core->register_url )
				{
					$redirect = $logical_redirect;
				}
				header('Location: '.$redirect, true, 302);
				exit;
			}else{
				$form->getField('email')->getValidator()->addError('This username and password combination does not match our records. Please try again.');
			}
		}
	}
	
	$content.=$form->render();
	
$content_title = "Login to be awesome";
include_once("tpl/header.php");     
include_once("tpl/content.tpl.php");
include_once("tpl/footer.php");
?>