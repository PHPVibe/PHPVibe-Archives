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
//On/OFF
if(_get('action') == "offline") {
if(_post('offline')) {
echo("Site is now offline");
 update_option('site-offline', '1');
} else {
echo("Site is now online");
update_option('site-offline', '0');
}
}
//Language export
if(_get('action') == "exportlang") {
if(_get('id')) {
$tid = _get('id');	
$lang = $db->get_row("SELECT * from ".DB_PREFIX."languages where term_id = $tid");	
if($lang) {
$ar = array();
$zip = json_decode($lang->lang_terms,true);
foreach ($zip as $key=>$value) {
$ar[$key] = $value;
}	
$ar["language-code"] = $lang->lang_code;
header('Content-Type: application/json');
header('Content-Description: File Transfer');
header('Content-Disposition: attachment; filename="lang-'.$lang->lang_code.'-'.date('Y-m-d').'.json"');
echo json_encode($ar, true);
}	
}
//end export
}

/* End admin check */
 $db->clean_cache();
}
?>