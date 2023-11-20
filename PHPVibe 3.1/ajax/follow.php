<? require_once("../phpvibe.php");
if(isset($_REQUEST['id']) && $user->isAuthorized()){ 
$toadd = mysql_escape_string($_REQUEST['id']);
$check = dbrows(dbquery("SELECT * FROM users_friends WHERE uid = '".$toadd."' AND fid ='".$user->getId()."' "));
if($check == 0) :
 $add_sql = "INSERT INTO users_friends (`uid`, `fid`) VALUES ('".$toadd."', '".$user->getId()."');";
  dbquery($add_sql);
  echo '<div class="success-box">Friendship request sent</div>';
  $to_now_mail = "true";
  else:
  echo '<div class="alert-box">You are already friends or a request is still pending.</div>';
  endif;
if(isset($to_now_mail)){
    $user_id = $toadd;
	$user_module = MK_RecordModuleManager::getFromType('user');
    $user_profile = MK_RecordManager::getFromId($user_module->getId(), $user_id);
	$u_canonical = $site_url.'user/'.$user_profile->getId().'/'.seo_clean_url($user_profile->getDisplayName()) .'/'; 
	
		$message .=  $user->getDisplayName()."is now following you on ".$config->site->name." <br />\n";
		$message .=  "Log in to see who followed you recently <a href=\"".$u_canonical."\">".$u_canonical."</a>  <br />\n";	
		
	
	$mailer = new MK_BrandedEmail();
			$mailer
				->setSubject('New follower')
				->setMessage($message)
				->send($user_profile->getEmail(), $user_profile->getDisplayName());
	}
}
?>