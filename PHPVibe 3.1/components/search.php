<?php
$pageNumber = MK_Request::getQuery('page', 1);
$q = $router->fragment(1);
$qterm = str_replace(" ", "+",$q);
$sql_keyword = mysql_real_escape_string(cleanInput($q));
$BrowsePerPage = $config->video->bpp;
if(strlen($sql_keyword) > 3) {
$numberofresults = dbcount("*","videos","MATCH (title,description,tags) AGAINST('".$sql_keyword."')");
$limit = 'LIMIT ' .($pageNumber - 1) * $BrowsePerPage .',' .$BrowsePerPage; 
$vbox_result = "SELECT *, MATCH(title,description,tags) AGAINST ('".$sql_keyword."') AS score from videos WHERE MATCH (title,description,tags) AGAINST('".$sql_keyword."') order by score desc ".$limit."";
} else {
$numberofresults = dbcount("*","videos","title like '%".$sql_keyword."%' or description like '%".$sql_keyword."%' or tags like '%".$sql_keyword."%'");
$limit = 'LIMIT ' .($pageNumber - 1) * $BrowsePerPage .',' .$BrowsePerPage; 
$vbox_result = "SELECT * FROM videos WHERE title like '%".$sql_keyword."%' or description like '%".$sql_keyword."%' or tags like '%".$sql_keyword."%' order by views desc ".$limit."";
}
$pagi_url = $site_url.'show/'.$qterm.'/&page=';
$a = new pagination;	
$a->set_current($pageNumber);
$a->set_first_page(true);
$a->set_pages_items(12);
$a->set_per_page($BrowsePerPage);
$a->set_values($numberofresults);
$seo_title = $lang['show-pre-title']." ".ucfirst($q)." ".$lang['show-aft-title'];
$seo_description = $lang['show-desc'] ." ".ucfirst($q);
include_once("tpl/header.php");
include_once("tpl/search.tpl.php");
include_once("tpl/footer.php");

?>