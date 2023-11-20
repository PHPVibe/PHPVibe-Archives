<?php
// This file initializes Mokoala
require_once 'library/com/mokoala/Mokoala.php';

// The next logical redirect page
$logical_redirect = (!empty($config->site->referer) && $config->site->referer === $config->site->page ? $config->site->base : $config->site->referer);

// Connect to the database
MK_MySQL::connect();

// Start session & establish name-space
$session = MK_Session::getInstance();

// Get a copy of the sites config options
$config = MK_Config::getInstance();

// Define how cookies are used
$cookie = MK_Cookie::getInstance();


//define site url for backwards compatibility
$site_url = $config->site->url;

// Check if user is logging in with Facebook
if( $config->site->facebook->login && ( $facebook_session = $facebook->getSession() ))
{
	$user_details = $facebook->api('/me');

	// Check if users has already logged in with this facebook account
	try
	{
		MK_Authorizer::authorizeByFacebookId( $user_details['id'] );
		$user = MK_Authorizer::authorize();
	}
	// If user hasn't logged in with this Facebook account
	catch( Exception $e )
	{
		// Check if this user is already registered with their Facebook email address 
		try
		{
			MK_Authorizer::authorizeByFacebookEmail( $user_details['email'] );
			$user = MK_Authorizer::authorize();
			
			if( !$user->getName() )
			{
				$user->setName( $user_details['name'] );
			}
			
			if( !$user->getAvatar() )
			{
				$user_details['picture'] = MK_FileManager::uploadFileFromUrl( 'http://graph.facebook.com/'.$user_details['id'].'/picture?type=large', $config->site->upload_path );
				$user->setAvatar( $user_details['picture'] );
			}

			$user
				->setFacebookId( $user_details['id'] )
				->save();
		}
		catch( Exception $e )
		{
			$user_module = MK_RecordModuleManager::getFromType('user');
			$user = MK_RecordManager::getNewRecord($user_module->getId());
			
			$user_details['picture'] = MK_FileManager::uploadFileFromUrl( 'http://graph.facebook.com/'.$user_details['id'].'/picture?type=large', $config->site->upload_path );
	
			$user
				->setEmail( $user_details['email'] )
				->setDisplayName( $user_details['name'] )
				->setName( $user_details['name'] )
				->setAvatar( $user_details['picture'] )
				->setType( MK_RecordUser::TYPE_FACEBOOK )
				->setFacebookId( $user_details['id'] )
				->save();
		}
	}

	$cookie->set('login', $user->getId(), $config->site->user_timeout);
	$session->login = $user->getId();
	
	if( !$redirect = $config->extensions->core->login_url )
	{
		$redirect = $logical_redirect;
	}
	header('Location: index.php', true, 302);
	exit;
}
// Check if user logged in with Twitter 
elseif( $config->site->twitter->login && $session->twitter_access_token )
{
	$user_details = $config->twitter->get('account/verify_credentials');
	unset($session->twitter_access_token);
	
	try
	{
		MK_Authorizer::authorizeByTwitterId( $user_details->id );
		$user = MK_Authorizer::authorize();

		$cookie->set('login', $user->getId(), $config->site->user_timeout);
		$session->login = $user->getId();
		
		if( !$redirect = $config->extensions->core->login_url )
		{
			$redirect = $logical_redirect;
		}
	}
	catch( Exception $e )
	{
		if( !$redirect = $config->extensions->core->login_url )
		{
			$redirect = $logical_redirect;
		}

		$session->twitter_details = serialize(
			array(
				'picture' => str_replace('_normal', '', $user_details->profile_image_url),
				'display_name' => $user_details->name,
				'name' => $user_details->name,
				'twitter_id' => $user_details->id,
				'email' => '',
			)
		);
	}

}
// Check if user hasn't finished logging in with Twitter
elseif( $config->site->twitter->login && !empty($session->twitter_details) && strpos($config->site->page_name, 'login.php') === false )
{
	header('Location: login.php', true, 302);
	exit;
}
// Check if user completed login with Twitter 
elseif( $config->site->twitter->login && !empty($session->twitter_details) )
{
	$user_details = unserialize( $session->twitter_details );
	if( !empty($user_details['email']) )
	{
	
		$user_details['picture'] = MK_FileManager::uploadFileFromUrl( $user_details['picture'], $config->site->upload_path );
	
		$user_module = MK_RecordModuleManager::getFromType('user');
		$user = MK_RecordManager::getNewRecord($user_module->getId());
	
		$user
			->setEmail( $user_details['email'] )
			->setDisplayName( $user_details['name'] )
			->setName( $user_details['name'] )
			->setAvatar( $user_details['picture'] )
			->setType( MK_RecordUser::TYPE_TWITTER )
			->setTwitterId( $user_details['twitter_id'] )
			->save();
	
		$cookie->set('login', $user->getId(), $config->site->user_timeout);
		$session->login = $user->getId();
		
		unset($session->twitter_details);
		header('Location: index.php', true, 302);
		exit;
	}
}

// If user session has expired but cookie is still active
if( $cookie->login && empty($session->login) )
{
	$session->login = $cookie->login;
}

// Get current user
if( !empty($session->login) )
{
    MK_Authorizer::authorizeById( $session->login );
}

$user = MK_Authorizer::authorize();

if (!$user->getGroup()->isAdmin()) {
die("Login first!");
}
?>
