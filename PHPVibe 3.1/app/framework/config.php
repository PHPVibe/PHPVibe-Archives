<?php // Parse config
$config_ini = parse_ini_file(dirname(__FILE__).'/../config.ini.php');

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
$config_data['site']['page'] 				= (string) $current_page;
$config_data['site']['page_name'] 			= (string) $current_page_name;
$config_data['site']['base_href'] 			= (string) $base_href;
$config_data['site']['upload_path']			= (string) !empty($config_ini['site.upload_path']) ? $config_ini['site.upload_path'] : null;
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
$config_data['site']['headerc'] 	= (string) !empty($config_ini['site.headerc']) ? $config_ini['site.headerc'] : null;
$config_data['site']['footerc'] 	= (string) !empty($config_ini['site.footerc']) ? $config_ini['site.footerc'] : null;
$config_data['site']['user_timeout'] 		= (integer) !empty($config_ini['user.timeout']) ? $config_ini['user.timeout'] : null;
$config_data['site']['dlang'] 	= (string) !empty($config_ini['site.dlang']) ? $config_ini['site.dlang'] : "en";
$config_data['site']['langs'] 	= (string) !empty($config_ini['site.langs']) ? $config_ini['site.langs'] : "en,";
$config_data['seo']['htitle'] 	= (string) !empty($config_ini['seo.htitle']) ? $config_ini['seo.htitle'] : null;
$config_data['seo']['hdesc'] 	= (string) !empty($config_ini['seo.hdesc']) ? $config_ini['seo.hdesc'] : null;
$config_data['seo']['prevideo'] 	= (string) !empty($config_ini['seo.prevideo']) ? $config_ini['seo.prevideo'] : null;
$config_data['seo']['postvideo'] 	= (string) !empty($config_ini['seo.htitle']) ? $config_ini['seo.postvideo'] : null;
$config_data['site']['url'] 				= (string) !empty($config_ini['site.url']) ? $config_ini['site.url'] : null;
$config_data['site']['mediafolder'] 				= (string) !empty($config_ini['site.mediafolder']) ? $config_ini['site.mediafolder'] : 'media';
$config_data['site']['videofolder'] 				= (string) !empty($config_ini['site.videofolder']) ? $config_ini['site.videofolder'] : 'flv';
$config_data['site']['thumbsfolder'] 				= (string) !empty($config_ini['site.thumbsfolder']) ? $config_ini['site.thumbsfolder'] : 'thumbs';
$config_data['site']['picsfolder'] 				= (string) !empty($config_ini['site.picsfolder']) ? $config_ini['site.picsfolder'] : 'pictures';
$config_data['site']['storethumbs'] 				= (boolean)!empty($config_ini['site.storethumbs']) ? $config_ini['site.storethumbs'] : null;
$config_data['site']['wpics'] 				= (string) !empty($config_ini['site.wpics']) ? $config_ini['site.wpics'] : 185;
$config_data['site']['hpics'] 				= (string) !empty($config_ini['site.hpics']) ? $config_ini['site.hpics'] : 150;
$config_data['cache']['video'] 	= (boolean) !empty($config_ini['cache.video']) ? $config_ini['cache.video'] : null;
$config_data['cache']['time'] 	= (string) !empty($config_ini['cache.time']) ? $config_ini['cache.time'] : 3600;

$config_data['licence']['key'] 		= (integer) !empty($config_ini['licence.key']) ? $config_ini['licence.key'] : null;
$config_data['video']['player'] 		= (integer) !empty($config_ini['video.player']) ? $config_ini['video.player'] : null;
$config_data['video']['submit'] 		= (integer) !empty($config_ini['video.submit']) ? $config_ini['video.submit'] : null;
$config_data['video']['bpp'] 		= (integer) !empty($config_ini['video.bpp']) ? $config_ini['video.bpp'] : 36;
$config_data['video']['devkey'] 		= (string) !empty($config_ini['video.devkey']) ? $config_ini['video.devkey'] : null;
$config_data['video']['api'] 		= (integer) !empty($config_ini['video.api']) ? $config_ini['video.api'] : null;

$config_data['video']['allowupload'] 		= (integer) !empty($config_ini['video.allowupload']) ? $config_ini['video.allowupload'] : null;
$config_data['video']['size'] 		= (integer) !empty($config_ini['video.size']) ? $config_ini['video.size'] : '-1';
$config_data['video']['maxuploads'] 		= (integer) !empty($config_ini['video.maxuploads']) ? $config_ini['video.maxuploads'] : 10;
$config_data['video']['maxlibrary'] 		= (integer) !empty($config_ini['video.maxlibrary']) ? $config_ini['video.maxlibrary'] : 30;

$config_data['site']['banned'] 		= (integer) !empty($config_ini['site.banned']) ? $config_ini['site.banned'] : null;

$config_data['server']['local'] 			= (string) $_SERVER['SERVER_NAME'] === 'localhost' ? true : false;
$config_data['server']['name'] 				= (string) $base_href_host;
$config_data['server']['time'] 				= (integer) time();

$config_data['server']['execution_start'] 	= (float) !empty($start) ? $start : 0;
$config_data['core']['name'] 				= (string) 'phpVibe';
$config_data['core']['version'] 			= (string) '3.1';
$config_data['core']['mode'] 				= (string) MK_Core::MODE_FULL;
$config_data['core']['clean_uris'] 			= (boolean) false;
$config_data['core']['url'] 				= (string) 'http://www.phprevolution.com/';

$config_data['instance']['name'] 			= (string) 'phpVibe';
$config_data['instance']['version'] 		= (string) '3.1';
$config_data['instance']['url'] 			= (string) 'http://www.revolution.com';

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