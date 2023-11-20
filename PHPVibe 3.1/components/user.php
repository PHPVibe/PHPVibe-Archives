<?php $user_module = MK_RecordModuleManager::getFromType('user');
if (!isset($_GET['page'])) {
	$pageNumber = 1;  
} else {        
	$pageNumber = htmlentities($_GET['page']); 
}
if($user_id = $router->fragment(1))
{
	try
	{
	$user_profile = MK_RecordManager::getFromId($user_module->getId(), $user_id);
	$u_canonical = $site_url.'user/'.$user_profile->getId().'/'.seo_clean_url($user_profile->getDisplayName()) .'/';
	
if($user->isAuthorized() && !is_owner($router->fragment(1)))
{
$follower_check = dbrows(dbquery("SELECT id from users_friends WHERE uid = '".$router->fragment(1)."' AND fid = '".$user->getId()."'"));
$followed_check = dbrows(dbquery("SELECT id from users_friends WHERE fid = '".$router->fragment(1)."' AND uid = '".$user->getId()."'"));
if($follower_check != 0) : $is_follower = true; else: $is_follower = false;  endif;
if($followed_check != 0) : $is_followed = true; else: $is_followed = false;  endif; 
} else {
$is_follower = false;
$is_followed = false;
}

    $width = "340";
    $height = "160";
    $vid = new phpVibe($width, $height);
	$pagi_url = $u_canonical.'&page=';
	$sk= "wall";
	

	$seo_title = $user_profile->getDisplayName() .$lang['user-aft-title'];
    $seo_description = substr($user_profile->getAbout(), 0, 160);
	include_once("tpl/header.php");
	include_once("tpl/user.tpl.php");
	include_once("tpl/footer.php");
	}
	catch(Exception $e)
	{
		header('Location: index.php', true, 302);
	}
}
else
{
	echo "That profile doesn't exist! ";
}

?>
