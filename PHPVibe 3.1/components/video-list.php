<?php $pageNumber = MK_Request::getQuery('page', 1);	
$pagi_url = $site_url.'videos/'.$router->fragment(1).'/&page=';
$seo_title = $lang[$router->fragment(1)];
include_once("tpl/header.php");
include_once("tpl/videolist.tpl.php");
include_once("tpl/footer.php");
?>