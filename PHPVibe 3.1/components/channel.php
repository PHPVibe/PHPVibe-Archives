<?php $pageNumber = MK_Request::getQuery('page', 1);
$this_url = $site_url.'channel/'.$router->fragment(1).'/';
if($router->fragment(1) != "list-all"){
$channel_slug = CleanInput($router->fragment(1));
//echo $channel_slug;
$csql = "SELECT * FROM `channels` WHERE `yt_slug` = '".$channel_slug."' LIMIT 0,1";
if ($row = $dbi->singlequery($csql, 0)) { 
$channel_name =  $row["cat_name"];
$channel_description =  $row["cat_desc"];
$channel_id = $row["cat_id"];
} else {
die("Channel not found");
}
}
if($router->fragment(1) == "list-all"){
$seo_title = "Browse channels";
$seo_description = "Our list of channels";
$pagi_url = $site_url.'channel/'.$router->fragment(1).'/&page=';
} else {
$seo_title =  "Channel : ".$channel_name;
$seo_description = $seo_title." ".$channel_description ;
}
include_once("tpl/header.php");
if($router->fragment(1) == "list-all") {
include_once("tpl/allchannels.tpl.php");
} else {
include_once("tpl/channel.tpl.php");
} 
include_once("tpl/footer.php");
?>