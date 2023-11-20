<?php
// This file initializes framework
require_once 'library/com/frame/framework.php';

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
die("Login first! <a href=\"".$site_url."admin/?module_path=account/login\">Proced to login >> </a>");
}
include_once '../com/cache.php';

$Cache = new CacheSys("../cache/", 600);
$VidCache = new CacheSys("../cache/videos/", 600000);
$FeedCache = new CacheSys("../cache/feeds/", 86400);
/* ----- Defines time to collect cache ----- */
$Cache->SetTtl(600);
$VidCache->SetTtl(600000);
$FeedCache->SetTtl(86400);

?>
