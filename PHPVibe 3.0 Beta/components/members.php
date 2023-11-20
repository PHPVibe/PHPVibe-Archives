<?php $pageNumber = MK_Request::getQuery('page', 1);

$pagi_url = $site_url.'members/'.$router->fragment(1).'/&page=';
$seo_title = $lang['members-title'] . " " .$router->fragment(1);
$seo_description = $lang['members-description'];

$nr_query = "SELECT COUNT(*) FROM users";
$result = mysql_query($nr_query);
$numberofresults = mysql_result($result, 0);
$BrowsePerPage = 40;
switch($router->fragment(1)){
case "oldest":
$order = "order by id ASC";		
break;
default:
$order = "order by id DESC";
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