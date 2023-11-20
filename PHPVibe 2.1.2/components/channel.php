<?php
//echo $Info->Get("list");

if (!isset($_GET['page'])) {
	$pageNumber = 1;  
} else {        
	$pageNumber = htmlentities($_GET['page']); 
}
	
	
$pagi_url = $site_url.'channel/'.$Info->Get("name").'/&page=';
include 'pagination.php';
if($Info->Get("name") != "list-all"):
$channel_slug = $Info->Get("name");
//echo $channel_slug;
$csql = dbquery("SELECT * FROM `channels` WHERE `yt_slug` = '".$channel_slug."' LIMIT 0,1");
while($row = mysql_fetch_array($csql)){
$channel_name =  $row["cat_name"];
$channel_description =  $row["cat_desc"];
$channel_id = $row["cat_id"];

}
endif;
if($Info->Get("name") == "list-all"):
$seo_title = $lang['channels'];
$seo_description = $lang['channels'];
else:
$seo_title =  $lang['channel']." : ".$channel_name;
$seo_description = $seo_title." ".$channel_description ;
endif;


include_once("tpl/header.php");
if($Info->Get("name") == "list-all"):
include_once("tpl/allchannels.tpl.php");
else:
include_once("tpl/channel.tpl.php");
endif;
include_once("tpl/footer.php");
?>