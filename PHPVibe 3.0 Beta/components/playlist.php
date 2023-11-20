<?php $pageNumber = MK_Request::getQuery('page', 1);		
$pagi_url = $site_url.'playlist/'.$router->fragment(1).'/'.$router->fragment(2).'/&page=';
//echo $channel_slug;
$csql = dbquery("SELECT * FROM `playlists` WHERE `id` = '".$router->fragment(1)."' LIMIT 0,1");
while($row = mysql_fetch_array($csql)){
$playlist_name =  $row["title"];
$playlist_owner =  $row["owner"];
$playlist_picture =  str_replace("../","",$row["picture"]);
$playlist_permalink =  $row["permalink"];
$playlist_description =  $row["description"];
$playlist_views =  $row["views"];
}
$user_module = MK_RecordModuleManager::getFromType('user');
if($user_id = $playlist_owner)
{
	try
	{
	$user_profile = MK_RecordManager::getFromId($user_module->getId(), $user_id);
	$seo_title =  $playlist_name." by ".$user_profile->getDisplayName();
   $seo_description = $seo_title." ".$playlist_description ;
   }
   catch(Exception $e)
	{
		header('Location: index.php', true, 302);
	}
}  

include_once("tpl/header.php");
include_once("tpl/playlist.tpl.php");
include_once("tpl/footer.php");
$increasevideo = dbquery("UPDATE playlists SET views = views+1 WHERE id = '".$router->fragment(1)."';"); ?>