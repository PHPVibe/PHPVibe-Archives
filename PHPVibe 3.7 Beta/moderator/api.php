<?php  error_reporting(0); 
//Vital file include
require_once("../load.php");
ob_start();
// Login, maybe?
if (is_admin()) {
// physical path of admin
if( !defined( 'ADM' ) )
	define( 'ADM', ABSPATH.'/'.ADMINCP);
define( 'in_admin', 'true' );

require_once( ADM.'/adm-functions.php' );
require_once( ADM.'/adm-hooks.php' );
//Queries
if(_get('action') == "offline") {
if(_post('offline')) {
echo("Site is now offline");
 update_option('site-offline', '1');
} else {
echo("Site is now online");
update_option('site-offline', '0');
}
}

/* End admin check */
 $db->clean_cache();
}
?>