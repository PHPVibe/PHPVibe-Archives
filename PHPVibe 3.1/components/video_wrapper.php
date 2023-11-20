<?php if(is_numeric($router->fragment(1))) {
if(MK_Request::getQuery('filter')){ 
MK_Session::start('mk');
$session = MK_Session::getInstance();
$session->filter = 'off';
}
include_once("video.php"); 
//Update views and count this view if not duplicated
$basic_id = cleanInput($router->fragment(1));
MK_Session::start('mk');
$session = MK_Session::getInstance();
$watched_list = (array) explode(',', $session->watched);
if ( !in_array($basic_id, $watched_list))
	{
$session->watched = $session->watched.','.$basic_id;	
$increasevideo = dbquery("UPDATE videos SET views = views+1 WHERE id = '".$basic_id."'");
	}

} else {
redirect($site_url);
}
?>