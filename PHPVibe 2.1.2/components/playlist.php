<?php
require_once("com/youtube_api.php");
$pageNumber = MK_Request::getQuery('page', 1);		
$pagi_url = $site_url.'playlist/'.$Info->Get("id").'/'.$Info->Get("name").'/&page=';
include 'pagination.php';


if($Info->Get("id") != "0"):
//echo $channel_slug;
$csql = dbquery("SELECT * FROM `playlists` WHERE `id` = '".$Info->Get("id")."' LIMIT 0,1");
while($row = mysql_fetch_array($csql)){
$playlist_name =  $row["title"];
$playlist_owner =  $row["owner"];
$playlist_picture =  str_replace("../","",$row["picture"]);
$playlist_permalink =  $row["permalink"];
$playlist_description =  $row["description"];
$playlist_videos =  $row["videos"];
}
$qqquery = "select display_name, avatar from users where id = '".$playlist_owner."' limit 0,1";
$os = mysql_query($qqquery) or die(mysql_error());

while($rrow = mysql_fetch_array($os)){
$playlist_owner_name = $rrow['display_name'];
$playlist_owner_avatar = $rrow['avatar'];
}
endif;

if($Info->Get("id") == "0"):
$seo_title = $lang['playlists'];
$seo_description = $lang['playlists'];
else:
$seo_title =  $lang['playlist']." : ".$playlist_name.' by '.$playlist_owner_name;
$seo_description = $seo_title." ".$playlist_description ;
endif;


include_once("tpl/header.php");
if($Info->Get("id") == "0"):
include_once("tpl/allplaylists.tpl.php");
else:
include_once("tpl/playlist.tpl.php");
endif;
include_once("tpl/footer.php");
?>