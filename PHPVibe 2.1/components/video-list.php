<?php
//echo $Info->Get("list");

if (!isset($_GET['page'])) {
	$pageNumber = 1;  
} else {        
	$pageNumber = htmlentities($_GET['page']); 
}
	include_once("embed/AutoEmbed.class.php");
	$AE = new AutoEmbed();
	
$pagi_url = $site_url.'videos/'.$Info->Get("list").'/&page=';
include 'pagination.php';

// Define wich list to load
include_once("tpl/header.php");
switch($Info->Get("list")){
	case "shared":
		include_once("tpl/shared.tpl.php");
		break;
		
	default:
		include_once("tpl/shared.tpl.php");
		break;	
}

include_once("tpl/footer.php");
?>