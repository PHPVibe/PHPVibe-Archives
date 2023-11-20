<?php $pageNumber = MK_Request::getQuery('page', 1);

$seo_title = $lang['members-title'] . " " .$router->fragment(1);
$seo_description = $lang['members-description'];

$numberofresults = dbcount("*","users");
$BrowsePerPage = $config->video->bpp;


switch($router->fragment(1)){
case "registration":
$order = "order by id desc";	
$pagi_url = $site_url.'members/'.$router->fragment(1).'/&page=';	
break;
default:
$order = "order by lastlogin desc";
$pagi_url = $site_url.'members/&page=';
break;			
}

$a = new pagination;	
$a->set_current($pageNumber);
$a->set_first_page(true);
$a->set_pages_items(12);
$a->set_per_page($BrowsePerPage);
$a->set_values($numberofresults);

include_once("tpl/header.php");
include_once("tpl/members.tpl.php");
include_once("tpl/footer.php");
?>