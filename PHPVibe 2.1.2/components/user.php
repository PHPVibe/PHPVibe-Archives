<?php
if($user->isAuthorized() && ($user->getId() != $Info->Get("id")))
{
$friend_check = dbrows(dbquery("SELECT id from users_friends WHERE (uid = '".$user->getId()."' AND fid = '".$Info->Get("id")."' AND status = '1') OR (uid = '".$Info->Get("id")."' AND fid = '".$user->getId()."' AND status = '1')"));
 if($friend_check != 0) :
$is_friend = true;
else:
$is_friend = false;
 endif;
} else {
$is_friend = false;
}

if(isset($_POST['friendship']) && $user->isAuthorized() && !$is_friend){ 
$toadd = mysql_escape_string($_POST['friendship']);
$check = dbrows(dbquery("SELECT * FROM users_friends WHERE uid = '".$toadd."' AND fid ='".$user->getId()."' "));
if($check == 0) :
 $add_sql = "INSERT INTO users_friends (`uid`, `fid`, `status`) VALUES ('".$toadd."', '".$user->getId()."', '0');";
  dbquery($add_sql);
  echo '<div class="success-box">Friendship request sent</div>';
  $to_now_mail = "true";
  else:
  echo '<div class="alert-box">You are already friends or a request is still pending.</div>';
  endif;

}


$user_module = MK_RecordModuleManager::getFromType('user');
if (!isset($_GET['page'])) {
	$pageNumber = 1;  
} else {        
	$pageNumber = htmlentities($_GET['page']); 
}
if($user_id = $Info->Get("id"))
{
	try
	{
	$user_profile = MK_RecordManager::getFromId($user_module->getId(), $user_id);
	$u_canonical = $site_url.'user/'.$user_profile->getId().'/'.seo_clean_url($user_profile->getDisplayName()) .'/';
	if(isset($to_now_mail)){ 
	$headers  = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=utf-8\n";
		$headers .= "From: ".$config->site->name." <".$config->site->email."> \n";
	    $subject = $user_profile->getName()." you have a new friendship request";
		$message .=  "You have received a friend request from ".$user->getName()."\n";
		$message .=  "Handle it in your profile <a href=\"".$u_canonical."\">".$u_canonical."</a>  \n";	
		
	 mail($user_profile->getEmail(),$subject,$message,$headers);
	
	}
	include_once("embed/AutoEmbed.class.php");
    $AE = new AutoEmbed();
	if(isset($_GET['sk']) && $_GET['sk'] == "likes") {
	$sk = "likes";
	$pagi_url = $u_canonical.'&sk=likes&page=';
	} elseif(isset($_GET['sk']) && $_GET['sk'] == "friends") {
	$sk = "friends";
	$pagi_url = $u_canonical.'&sk=friends&page=';
	}	elseif(isset($_GET['sk']) && $_GET['sk'] == "video") {
	$sk = "video";
	$pagi_url = $u_canonical.'&sk=video&page=';
	}	
	else {
	$pagi_url = $u_canonical.'&sk=wall&page=';
	$sk= "wall";
	}
	include 'pagination.php';
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
