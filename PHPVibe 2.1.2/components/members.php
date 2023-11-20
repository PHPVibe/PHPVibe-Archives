<?php
if (!isset($_GET['page'])) {
	$pageNumber = 1;  
} else {        
	$pageNumber = htmlentities($_GET['page']); 
}

$to_cache = "members".$Info->Get("list").$pageNumber;


$pagi_url = $site_url.'members/'.$Info->Get("list").'/&page=';
$seo_title = $lang['members-title'] . " " .$Info->Get("list");
$seo_description = $lang['members-description'];

$nr_query = "SELECT COUNT(*) FROM users";
$result = mysql_query($nr_query);
$numberofresults = mysql_result($result, 0);
$BrowsePerPage = 20;

switch($Info->Get("list")){
case "oldest":
$order = "order by id ASC";		
		break;
default:
$order = "order by id DESC";
		break;			
}

include 'pagination.php';
$a = new pagination;	
$a->set_current($pageNumber);
$a->set_first_page(true);
$a->set_pages_items(12);
$a->set_per_page($BrowsePerPage);
$a->set_values($numberofresults);

include_once("tpl/header.php");
include_once("tpl/members.tpl.php");
include_once("tpl/footer.php");
/*
} 
echo $Cache->Stop();
*/
?>