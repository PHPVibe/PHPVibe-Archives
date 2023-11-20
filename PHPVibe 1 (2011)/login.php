<?php
require_once("_inc.php");
require_once("library/video.func.php");
$head_title = array();
$head_desc = array();
$head_title[] = 'Login here M8'; 
$head_desc[] = 'This shows you how phpVibe Basic Login system works'; 

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
				'class' => 'narrow clear-fix standard',
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
		
		$output = '<h2 class="narrow">Twitter Login</h2>';
		$output .= '<p class="narrow">'.__("Please enter your email address to finish logging in.").'</p>';
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
				'class' => 'narrow clear-fix standard'
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
		
		$output = '<h2 class="narrow">'.__("Login").'</h2>';
		$output .= '<p class="narrow">'.__("Please enter your email address and password. If you can't remember your password then use the").' <a href="forgot-pass.php">'.__("forgotten password").'</a> '.__("form.").'</p>';
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
	
	$output.=$form->render();
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
<?php      
//include_once("sidebar.php");
include_once("tpl/php/footer.php");
?>