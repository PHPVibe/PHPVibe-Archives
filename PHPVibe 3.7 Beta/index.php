<?php  error_reporting(E_ALL); 
// Degugging?
$sttime = microtime(true); 
//Check if installed
if(!is_readable('vibe_config.php') || is_readable('hold')){
echo '<h1>Hold on! Configuration file needs editing or "hold" file exists in root! </h1><br />';
echo 'To continue: <strong>edit database and site details</strong> in file vibe_config.php <br /> <strong><a href="setup/index.php">RUN SETUP</a></strong>, and after delete the file named hold in root  <br />';
die();
}
//Vital file include
require_once("load.php");
ob_start();
// Login, maybe?
if (!is_user()) {
    //action = login, logout ; type = twitter, facebook, google
    if (!empty($_GET['action']) && $_GET['action'] == "login") {
        switch ($_GET['type']) {
            case 'twitter':
			if(get_option('allowtw') == 1 ) {
                //Initialize twitter
				require_once( INC.'/twitter/EpiCurl.php' );
			    require_once( INC.'/twitter/EpiOAuth.php' );
                require_once( INC.'/twitter/EpiTwitter.php' );
                $twitterObj = new EpiTwitter(Tw_Key, Tw_Secret);
                //Get login url according to configurations you specified in configs.php
                $twitterLoginUrl = $twitterObj->getAuthenticateUrl(
                    null, array('oauth_callback' => $conf_twitter['oauth_callback']));
                redirect($twitterLoginUrl);
			}	
                break;
            case 'facebook':
			if(get_option('allowfb') == 1 ) {
                //Initialize facebook by using factory pattern over main class(SocialAuth)
				require_once( INC.'/fb/facebook.php' );
                $facebookObj = new Facebook(array(
  'appId'  => Fb_Key,
  'secret' => Fb_Secret,
));
                //Get login url according to configurations you specified in configs.php
                $facebookLoginUrl = $facebookObj->getLoginUrl(array('scope' => $conf_facebook['permissions'],
                                                                    'canvas' => 1,
                                                                    'fbconnect' => 0,
                                                                    'redirect_uri' => $conf_facebook['redirect_uri']));
                redirect($facebookLoginUrl);
			}	
                break;
            case 'google':
			if(get_option('allowg') == 1 ) {
                //Initialize google login
                
				require_once(INC.'/google/Google/Client.php');
				
				$client = new Google_Client();
$client->setClientId(trim(get_option('GClientID')));
$client->setClientSecret(trim(get_option('GClientSecret')));
$client->setRedirectUri($conf_google['return_url']);
$client->setScopes(array('https://www.googleapis.com/auth/userinfo.email','https://www.googleapis.com/auth/userinfo.profile'));
$authUrl = $client->createAuthUrl();

                if (!empty($authUrl)) {
                        
                       redirect($authUrl);
                }
             } 
			  break;
        
            default:
                //If any login system found, warn user
                echo _lang('Invalid Login system');
        }
    }
} else {
    if (!empty($_GET['action']) && $_GET['action'] == "logout") {
        //If action is logout, kill sessions
        user::clearSessionData();
        //var_dump($_COOKIE);exit;
       redirect(site_url()."index.php");
    }
}

// Let's start the site
$page = com();
$id_pos = null;
//Decide what to load
if(!$page)	{
$com_route = ABSPATH."/com/com_home.php";
$canonical = site_url();
} else {
// Define wich page to load
switch($page){
	case video:
		$com_route = ABSPATH."/com/com_video.php";		
		break;
    case videos:
		$com_route = ABSPATH."/com/com_videolist.php";		
		break;			
	case profile:
		$com_route = ABSPATH."/com/com_profile.php";		
		break;		
	case note:
		$com_route = ABSPATH."/com/com_note.php";			
		break;		
    case channel:
		$com_route = ABSPATH."/com/com_channel.php";		
		break;    		
	case playlist:
		$com_route = ABSPATH."/com/com_playlist.php";			
		break;	
	 case show:
		$com_route = ABSPATH."/com/com_search.php";		
		break;	
	
	case me:
		$com_route = ABSPATH."/com/com_manager.php";		
		$reqform = true;
		break;
    case buzz:
		$com_route = ABSPATH."/com/com_buzz.php";		
		$reqform = true;
		break;		
	case share:
		$com_route = ABSPATH."/com/com_share.php";		
		$reqform = true;
		break;
	case add:
		$com_route = ABSPATH."/com/com_add.php";		
		$reqform = true;
		break;
	case upmusic:
		$com_route = ABSPATH."/com/com_music.php";		
		$reqform = true;
		break;
    case upimage:
		$com_route = ABSPATH."/com/com_image.php";		
		$reqform = true;
		break;		
    case subscriptions:
		$com_route = ABSPATH."/com/com_subscriptions.php";		
		break;	
    case "login":
		$com_route = ABSPATH."/com/com_login.php";		
		break;	
    case "register":
		$com_route = ABSPATH."/com/com_register.php";		
		break;
	case page:
		$com_route = ABSPATH."/com/com_page.php";		
		break;	
	case blog:
		$com_route = ABSPATH."/com/com_blog.php";		
		break;
	case blogcat:
		$com_route = ABSPATH."/com/com_blogcat.php";		
		break;	
    case blogpost:
		$com_route = ABSPATH."/com/com_post.php";		
		break;		
    case "forward":
	redirect(start_playlist());	
	break;
	default:
		 $com_route = ABSPATH."/com/com_404.php";		
		 $canonical = site_url();
		break;	
}
//end switch coms
}
//end if com()
/* include the theme functions / filters */
include_once(TPL.'/tpl.globals.php');
//If offline
if(!is_admin() && (get_option('site-offline', 0) == 1 )) {
layout('offline');
exit();
}
//include the component
include_once($com_route);
//sitewide included functions 
/* Crons trigger */
if(function_exists('exec')) {
$time_passed = time() - get_option('cron_lastrun');
$cron_interval = get_option('cron_interval');

if( $time_passed  > $cron_interval) {
$arrOutput = '';
update_option('cron_lastrun', time());
$binpath = get_option('binpath','/usr/bin/php');
$command = $binpath." -f ".ABSPATH."/cron.php";
exec( "$command > /dev/null &", $arrOutput );
}
}
//end sitewide
//Debugging 
/*
if(is_admin()) {
echo "Time Elapsed: ".(microtime(true) - $sttime)."s <br />";
echo "Database debug";
echo '<pre>';
$db->debug();
echo '</pre>';
echo '----------------';
echo "Cache database debug";
echo '<pre>';
$cachedb->debug();
echo '</pre>';
}
*/
ob_end_flush();
//That's all folks!
?>