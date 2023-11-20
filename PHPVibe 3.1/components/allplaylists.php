<?php $pageNumber = MK_Request::getQuery('page', 1);		
$pagi_url = $site_url.'playlists/&page=';
$seo_title =  $lang['playlists'];
$seo_description = '';
include_once("tpl/header.php");
include_once("tpl/allplaylists.tpl.php");
include_once("tpl/footer.php");
?>