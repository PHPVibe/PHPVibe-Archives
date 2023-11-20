<?php  error_reporting(1);
require_once '../app/init.php';
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
die("Login first! <a href=\"".$site_url."login.php\">Proced to login >> </a>");
}

function admin_panel() {
global $site_url;
return $site_url."vibe-cp/";
}
?>