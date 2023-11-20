<?php
$pageNumber = MK_Request::getQuery('page', 1);	
$pagi_url = $site_url.'videos-by/'.$router->fragment(1).'/&page=';
$seo_title = $lang[$router->fragment(1)];
$user_module = MK_RecordModuleManager::getFromType('user');
if($user_id = $router->fragment(1))
{
	try
	{
	$user_profile = MK_RecordManager::getFromId($user_module->getId(), $user_id);
	$seo_title = $user_profile->getDisplayName() ." shared videos";
    $seo_description = "Videos from user ".$user_profile->getDisplayName();
   }
   catch(Exception $e)
	{
		header('Location: index.php', true, 302);
	}
}   
include_once("tpl/header.php");
include_once("tpl/user_videos.tpl.php");
include("tpl/footer.php");
?>