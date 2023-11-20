<?php $this_id = mysql_real_escape_string(cleanInput($router->fragment(1)));
$result=mysql_query("select * from user_wall where msg_id = '".$this_id."' limit 0,1");
$sts = dbarray($result);
$width = "380";
$height = "260";
$vid = new phpVibe($width, $height);
$user_module = MK_RecordModuleManager::getFromType('user');
if($user_id = $sts["u_id"])
{
	try
	{
	$user_profile = MK_RecordManager::getFromId($user_module->getId(), $user_id);
	$u_canonical = $site_url.'user/'.$user_profile->getId().'/'.seo_clean_url($user_profile->getDisplayName()) .'/';
	$seo_title = $user_profile->getDisplayName()."  ".$sts["time"];
    $seo_description = $sts["message"];
   }
   catch(Exception $e)
	{
		header('Location: index.php', true, 302);
	}
}   
include_once("tpl/header.php");
include("tpl/status.tpl.php");
include_once("tpl/footer.php");
?>
