<?php
if (!isset($_GET['page'])) {
	$pageNumber = 1;  
} else {        
	$pageNumber = htmlentities($_GET['page']); 
}

$to_cache = $Info->Get("term").$pageNumber;
// setup cache for this page at 1 day
 /*$Cache->SetTtl(86400);
if(!$Cache->Start("$to_cache")){ */
$type = "1";
$display_type = "1";
$nb_display = "21";
$q = $Info->Get("term");
$qterm = str_replace(" ", "+",$Info->Get("term"));
$pagi_url = $site_url.'show/'.$qterm.'/&page=';
include 'pagination.php';
$a = new pagination;	
$a->set_current($pageNumber);
$a->set_first_page(true);
$a->set_pages_items(12);
$a->set_per_page($nb_display);
$a->set_values(420);

include_once("tpl/header.php");
include_once("tpl/show.tpl.php");
include_once("tpl/footer.php");
/*
} 
echo $Cache->Stop();
*/
?>