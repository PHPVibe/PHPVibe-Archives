<?php
$pageNumber = MK_Request::getQuery('page', 1);	
$pagi_url = $site_url.'videos/'.$router->fragment(1).'/&page=';
$seo_title = $lang[$router->fragment(1)];
// Define wich list to load
include_once("tpl/header.php");

switch($router->fragment(1)){
	case "shared":
	    include_once("embed/AutoEmbed.class.php");
	    $AE = new AutoEmbed();
		include_once("tpl/shared.tpl.php");
		
	break;	
		
	default:
		include_once("tpl/videolist.tpl.php");
	break;	
}

include_once("tpl/footer.php");
?>