<?php
$pageNumber = MK_Request::getQuery('page', 1);	
$pagi_url = $site_url.'videos/'.$Info->Get("list").'/&page=';
include 'pagination.php';
$seo_title = $lang[$Info->Get("list")];
// Define wich list to load
include_once("tpl/header.php");

switch($Info->Get("list")){
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