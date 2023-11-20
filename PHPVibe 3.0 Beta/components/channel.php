<?php if (!isset($_GET['page'])) { 	$pageNumber = 1;  } else {  $pageNumber = htmlentities($_GET['page']); }
$pagi_url = $site_url.'channel/'.$router->fragment(1).'/&page=';
if($router->fragment(1) != "list-all"):
$channel_slug = CleanInput($router->fragment(1));
//echo $channel_slug;
$csql = dbquery("SELECT * FROM `channels` WHERE `yt_slug` = '".$channel_slug."' LIMIT 0,1");
$row = dbarray($csql);
$channel_name =  $row["cat_name"];
$channel_description =  $row["cat_desc"];
$channel_id = $row["cat_id"];

endif;
if($router->fragment(1) == "list-all"):
$seo_title = "Browse channels";
$seo_description = "Our list of channels";
else:
$seo_title =  "Channel : ".$channel_name;
$seo_description = $seo_title." ".$channel_description ;
endif;
include_once("tpl/header.php");
if($router->fragment(1) == "list-all"):
include_once("tpl/allchannels.tpl.php");
else:
include_once("tpl/channel.tpl.php");
endif;
include_once("tpl/footer.php");
?>