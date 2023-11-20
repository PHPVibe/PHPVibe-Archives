<?php

// Parse config
$config_ini = parse_ini_file(dirname(__FILE__).'/../../../config.ini.php');

// set timezone
$config_ini['site.timezone'] = !empty($config_ini['site.timezone']) ? $config_ini['site.timezone'] : 'Europe/London' ;
date_default_timezone_set($config_ini['site.timezone']);

// Set error reporting
$error_levels = array(
	0 => 0,
	1 => E_ERROR | E_WARNING | E_PARSE,
	2 => E_ALL
);
$error_level = !empty($config_ini['site.error_reporting']) ? $config_ini['site.error_reporting'] : 1;
$error_level = in_array($error_level, $error_levels) ? $error_level : 1;
$error_level = $error_levels[$error_level];

error_reporting( $error_level );

// Current URI
$current_page = parse_url($_SERVER['REQUEST_URI']);
$current_page = $current_page['path'].(!empty($current_page['query']) ? '?'.$current_page['query'] : '').(!empty($current_page['fragment']) ? '#'.$current_page['fragment'] : '');

// Base URI
$base_href_path = pathinfo($_SERVER['SCRIPT_NAME'], PATHINFO_DIRNAME);
$cookie_base_href_path = rtrim( str_replace('admin', '', $base_href_path), '/' ).'/';

$current_page_name = str_replace_first($base_href_path, '', $current_page);

$base_href_protocol = ( array_key_exists('HTTPS', $_SERVER) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http' ).'://';
if( array_key_exists('HTTP_HOST', $_SERVER) && !empty($_SERVER['HTTP_HOST']) )
{
	$base_href_host = $_SERVER['HTTP_HOST'];
}
elseif( array_key_exists('SERVER_NAME', $_SERVER) && !empty($_SERVER['SERVER_NAME']) )
{
	$base_href_host = $_SERVER['SERVER_NAME'].( $_SERVER['SERVER_PORT'] !== 80 ? ':'.$_SERVER['SERVER_PORT'] : '' );
}
$base_href = rtrim( $base_href_protocol.$base_href_host.$base_href_path, "/" ).'/';

// $_POST, $_FILES, $_GET
$params = $_GET;
$post = array_merge_replace($_POST, $_FILES);

$path = array();

if( !empty( $params['module_path'] ) )
{
	$path = array_filter( explode( '/', $params['module_path'] ) );
	unset( $params['module_path'] );
}

MK_Request::init( $params, $post );

// Define Cookie & Session
$cookie_path = str_replace('admin', '', $base_href_path);
MK_Session::start( 'mk', $cookie_base_href_path, ( $_SERVER['SERVER_NAME'] === 'localhost' ? false : $base_href_host ) );
MK_Cookie::start(  $cookie_base_href_path, ( $_SERVER['SERVER_NAME'] === 'localhost' ? false : $base_href_host ) );

// Get session
$session = MK_Session::getInstance();

/*
	Referring URL
*/
if($tidy_referer = !empty($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER']) : null)
{
	$tidy_referer = $tidy_referer['path'].(!empty($tidy_referer['query']) ? '?'.$tidy_referer['query'] : '').(!empty($tidy_referer['fragment']) ? '#'.$tidy_referer['fragment'] : '');
}
		
if($tidy_current = !empty($_SERVER['REQUEST_URI']) ? parse_url($_SERVER['REQUEST_URI']) : null)
{
	$tidy_current = $tidy_current['path'].(!empty($tidy_current['query']) ? '?'.$tidy_current['query'] : '').(!empty($tidy_current['fragment']) ? '#'.$tidy_current['fragment'] : '');
}

// If no refer has been set
if( empty($session->referer) )
{
	// Has the user came from another site
	if(!empty($tidy_referer) && strpos($_SERVER['HTTP_REFERER'], $base_href_host) === false)
	{
		$http_referer = $tidy_referer;
	}
	// If not then set their session to the actual referer
	else
	{
		$http_referer = $tidy_current;
	}
}
elseif( $tidy_referer !== $tidy_current )
{
	$http_referer = $tidy_referer;
}
else
{
	$http_referer = $session->referer;
}

$session->referer = $http_referer;

// Custom module settings
foreach($config_ini as $custom_key => $custom_value)
{
	$config_key_sections = explode('.', $custom_key);
	if(count($config_key_sections) === 3 && $config_key_sections[0] === 'extensions')
	{
		$config_data['extensions'][$config_key_sections[1]][$config_key_sections[2]] = $custom_value;
	}
}

// Template / Theme
list($template, $template_theme) = explode('/', $config_ini['site.template']);

$config_data['db']['host'] 					= (string) !empty($config_ini['db.host']) ? $config_ini['db.host'] : null;
$config_data['db']['name'] 					= (string) !empty($config_ini['db.name']) ? $config_ini['db.name'] : null;
$config_data['db']['username'] 				= (string) !empty($config_ini['db.username']) ? $config_ini['db.username'] : null;
$config_data['db']['password'] 				= (string) !empty($config_ini['db.password']) ? $config_ini['db.password'] : null;
$config_data['db']['charset'] 				= (string) 'utf8';
$config_data['db']['components'] 			= !empty($config_ini['db.components']) ? $config_ini['db.components'] : array();

$config_data['site']['facebook']['app_id'] 	= (string) !empty($config_ini['site.facebook.app_id']) ? $config_ini['site.facebook.app_id'] : null;
$config_data['site']['facebook']['app_secret']	= (string) !empty($config_ini['site.facebook.app_secret']) ? $config_ini['site.facebook.app_secret'] : null;
$config_data['site']['facebook']['login']	= (boolean) !empty($config_ini['site.facebook.login']) ? $config_ini['site.facebook.login'] : null;

$config_data['site']['twitter']['app_key'] 	= (string) !empty($config_ini['site.twitter.app_key']) ? $config_ini['site.twitter.app_key'] : null;
$config_data['site']['twitter']['app_secret']	= (string) !empty($config_ini['site.twitter.app_secret']) ? $config_ini['site.twitter.app_secret'] : null;
$config_data['site']['twitter']['login']	= (boolean) !empty($config_ini['site.twitter.login']) ? $config_ini['site.twitter.login'] : null;

$config_data['site']['installed'] 			= (boolean) !empty($config_ini['site.installed']) ? $config_ini['site.installed'] : null;
$config_data['site']['path'] 				= (string) realpath(dirname(__FILE__).'/../../../..');
$config_data['site']['base'] 				= (string) str_replace('admin', '', $base_href_path);
$config_data['site']['page'] 				= (string) $current_page;
$config_data['site']['page_name'] 			= (string) $current_page_name;
$config_data['site']['base_href'] 			= (string) $base_href;
$config_data['site']['upload_path']			= (string) !empty($config_ini['site.upload_path']) ? $config_ini['site.upload_path'] : null;

$config_data['admin']['path'] 				= (string) realpath(dirname(__FILE__).'/../../..');

$config_data['site']['valid_file_extensions'] 	= !empty($config_ini['site.valid_file_extensions']) ? explode(',', $config_ini['site.valid_file_extensions']) : array();
$config_data['site']['date_format'] 		= (string) !empty($config_ini['site.date_format']) ? $config_ini['site.date_format'] : null;
$config_data['site']['time_format'] 		= (string) !empty($config_ini['site.time_format']) ? $config_ini['site.time_format'] : null;
$config_data['site']['datetime_format'] 	= (string) $config_data['site']['date_format'].' \a\t '.$config_data['site']['time_format'];
$config_data['site']['referer'] 			= (string) $session->referer;
$config_data['site']['charset'] 			= (string) 'utf-8';
$config_data['site']['name'] 				= (string) !empty($config_ini['site.name']) ? $config_ini['site.name'] : null;
$config_data['site']['url'] 				= (string) !empty($config_ini['site.url']) ? $config_ini['site.url'] : null;
$config_data['site']['timezone'] 			= (string) $config_ini['site.timezone'];
$config_data['site']['email'] 				= (string) !empty($config_ini['site.email']) ? $config_ini['site.email'] : null;
$config_data['site']['email_signature'] 	= (string) !empty($config_ini['site.email_signature']) ? $config_ini['site.email_signature'] : null;
$config_data['site']['htitle'] 	= (string) !empty($config_ini['site.htitle']) ? $config_ini['site.htitle'] : null;
$config_data['site']['hdesc'] 	= (string) !empty($config_ini['site.hdesc']) ? $config_ini['site.hdesc'] : null;
$config_data['site']['headerc'] 	= (string) !empty($config_ini['site.headerc']) ? $config_ini['site.headerc'] : null;
$config_data['site']['footerc'] 	= (string) !empty($config_ini['site.footerc']) ? $config_ini['site.footerc'] : null;

$config_data['site']['user_timeout'] 		= (integer) !empty($config_ini['user.timeout']) ? $config_ini['user.timeout'] : null;
$config_data['licence']['key'] 		= (integer) !empty($config_ini['licence.key']) ? $config_ini['licence.key'] : null;
$config_data['video']['player'] 		= (integer) !empty($config_ini['video.player']) ? $config_ini['video.player'] : null;
$config_data['video']['storage'] 		= (integer) !empty($config_ini['video.storage']) ? $config_ini['video.storage'] : null;
$config_data['video']['devkey'] 		= (string) !empty($config_ini['video.devkey']) ? $config_ini['video.devkey'] : null;
$config_data['video']['thumbs'] 		= (string) !empty($config_ini['video.thumbs']) ? $config_ini['video.thumbs'] : null;
$config_data['video']['tags'] 		= (string) !empty($config_ini['video.tags']) ? $config_ini['video.tags'] : null;
$config_data['video']['searchmode'] 		= (string) !empty($config_ini['video.searchmode']) ? $config_ini['video.searchmode'] : null;

$config_data['site']['banned'] 		= (integer) !empty($config_ini['site.banned']) ? $config_ini['site.banned'] : null;

$config_data['server']['local'] 			= (string) $_SERVER['SERVER_NAME'] === 'localhost' ? true : false;
$config_data['server']['name'] 				= (string) $base_href_host;
$config_data['server']['time'] 				= (integer) time();

$config_data['server']['execution_start'] 	= (float) !empty($start) ? $start : 0;

$config_data['template'] 					= (string) $template;
$config_data['template_theme'] 				= (string) $template_theme;

$config_data['core']['name'] 				= (string) 'phpVibe';
$config_data['core']['version'] 			= (string) '2.1.1';
$config_data['core']['mode'] 				= (string) MK_Core::MODE_FULL;
$config_data['core']['clean_uris'] 			= (boolean) false;
$config_data['core']['url'] 				= (string) 'http://www.phpvibe.com/';

$config_data['instance']['name'] 			= (string) 'phpVibe';
$config_data['instance']['version'] 		= (string) 'API v2';
$config_data['instance']['url'] 			= (string) 'http://www.phpvibe.com';

// If the Facebook API & Secret are defined then load the Facebook API class
if( function_exists('curl_init') && function_exists('json_encode') && !empty($config_data['site']['facebook']['app_secret']) && !empty($config_data['site']['facebook']['app_id']) )
{
	$facebook = new Facebook(array(
		'appId' => $config_data['site']['facebook']['app_id'],
		'secret' => $config_data['site']['facebook']['app_secret'],
		'cookie' => false
	));
	$config_data['facebook'] = $facebook;
}
else
{
	$config_data['site']['facebook']['login'] = (boolean) false;
	$config_data['facebook'] = null;
}

// If the Twitter Key & Secret are defined then load the Twitter API class
if( !empty($config_data['site']['twitter']['app_secret']) && !empty($config_data['site']['twitter']['app_key']) )
{
	if(empty($session->twitter_access_token) && ( $oauth_verifier = MK_Request::getQuery('oauth_verifier') ) && !empty($session->twitter_oauth_token) && !empty($session->twitter_oauth_token_secret))
	{
		$twitter = new TwitterOAuth($config_data['site']['twitter']['app_key'], $config_data['site']['twitter']['app_secret'], $session->twitter_oauth_token, $session->twitter_oauth_token_secret);
		unset($session->twitter_oauth_token, $session->twitter_oauth_token_secret);
		
		$twitter_access_token = $twitter->getAccessToken($oauth_verifier);
		$session->twitter_access_token = true;
		$twitter = new TwitterOAuth($config_data['site']['twitter']['app_key'], $config_data['site']['twitter']['app_secret'], $twitter_access_token['oauth_token'], $twitter_access_token['oauth_token_secret']);
	}
	else
	{
		$twitter = new TwitterOAuth($config_data['site']['twitter']['app_key'], $config_data['site']['twitter']['app_secret']);
	}
	$config_data['twitter'] = $twitter;
}
else
{
	$config_data['site']['twitter']['login'] = (boolean) false;
	$config_data['twitter'] = null;
}

MK_Config::loadConfig($config_data);
$config = MK_Config::getInstance();

?>