<?php if( $user->isAuthorized() && $user->getId() == $user_profile->getId() ) { ?>
<div class="box one">

 		<div class="header">

 			<h2><?php print $lang['friend-req']; ?></h2>

    <!--Toggle-->

    <span class="toggle"></span>

 		</div>

 		<div class="content padding">

		<?php if(($pageNumber == "1") && ( $user->isAuthorized() && $user->getId() == $user_profile->getId() )) { 


$fresult = dbquery("SELECT id,fid FROM users_friends WHERE uid = '".$user_profile->getId()."' and status ='0'  ");
$fnr = mysql_num_rows($fresult); 
if ($fnr == "0") { echo $lang['no-friend-req']; } 

 while($row = mysql_fetch_array($fresult)){

//echo $bff;
$user_fmodule = MK_RecordModuleManager::getFromType('user');
$user_f = MK_RecordManager::getFromId($user_fmodule->getId(), $row["fid"]);

$f_avatar = $user_f->getAvatar();
$f_name = $user_f->getDisplayName();
$f_canonical = $site_url.'user/'.$row["fid"].'/'.seo_clean_url($f_name) .'/';
$action_url =  $site_url.'components/friend_req.php?id='.$row["id"].'&action=';
echo '
<div style="width:162px; margin: 2px 5px; float:left; border: 1px dashed #000">
<a href="'.$f_canonical.'" title="'.$f_name.'"><img src="'.$site_url.'com/timthumb.php?src='.$f_avatar.'&h=88&w=162&crop&q=100" / alt="'.$f_name.'"></a>
<p><center><strong>'.$f_name.'</strong></center></p>
<div class="button-group" style="margin: 1px 3px;">
<a href="'.$action_url.'aprove&lightbox[width]=396&lightbox[height]=120&lightbox[modal]=true" class="lightbox button red icon star">Accept</a> 
<a href="'.$action_url.'deny&lightbox[width]=396&lightbox[height]=120&lightbox[modal]=true" class="lightbox button red icon delete">Reject</a>
</div></div>';
}


}
?>
</div>
</div>
<?php } ?>
	
<div class="box one">

 		<div class="header">

 			<h2><?php print $lang['friends']; ?></h2>

    <!--Toggle-->

    <span class="toggle"></span>

 		</div>

 		<div class="content padding">
		


<?php
$fresult = dbquery("SELECT fid FROM users_friends WHERE uid = '".$user_profile->getId()."' and status ='1'  ");

while ($info = dbarray($fresult)):
$friendslist.= $info['fid'].", ";
endwhile;

$frresult = dbquery("SELECT uid FROM users_friends WHERE fid = '".$user_profile->getId()."' and status ='1'  ");

while ($rinfo = dbarray($frresult)):
$friendslist.= $rinfo['uid'].", ";
endwhile;

$farray = explode(', ', $friendslist);

foreach($farray as $bff){
if (empty($bff) ) {
continue;
}	
//echo $bff;
$user_fmodule = MK_RecordModuleManager::getFromType('user');
$user_f = MK_RecordManager::getFromId($user_fmodule->getId(), $bff);

$f_avatar = $user_f->getAvatar();
$f_name = $user_f->getDisplayName();
$f_canonical = $site_url.'user/'.$bff.'/'.seo_clean_url($f_name) .'/';
echo '<a href="'.$f_canonical.'" title="'.$f_name.'"><img class="border_white" src="'.$site_url.'com/timthumb.php?src='.$f_avatar.'&h=68&w=68&crop&q=100" / alt="'.$f_name.'"></a>';

}

?>

    </div>	
 