<?php  error_reporting(E_ALL); 
//Vital file include
require_once("../load.php");
ob_start();
// physical path of admin
if( !defined( 'ADM' ) )
	define( 'ADM', ABSPATH.'/'.ADMINCP);
define( 'in_admin', 'true' );
require_once( ADM.'/adm-functions.php' );
require_once( ADM.'/adm-hooks.php' );
$phpenversion = false;
if (function_exists('version_compare')){
if(version_compare(PHP_VERSION, '5.4.0') >= 0) {
/* Ioncube for PHP 4+ */
include_once( ADM.'/main4.php' );
} elseif(version_compare(PHP_VERSION, '5.4.0') >= 0) {
/* Ioncube for PHP 4.3 */
include_once( ADM.'/main3.php' );
} else {
/* Falback to ioncube for PHP < 4.3 */
include_once( ADM.'/main.php' );
} 
} else {
/* Falback to ioncube for PHP < 4.3 */
include_once( ADM.'/main.php' );
}
ob_end_flush();
//That's all folks!
?>