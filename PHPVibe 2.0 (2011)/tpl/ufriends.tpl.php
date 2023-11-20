
	
<div class="box one">

 		<div class="header">

 			<h2>Friends</h2>

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
echo '<a href="'.$f_canonical.'" title="'.$f_name.'"><img class="border_white" src="'.$site_url.'components/thumb.php?f='.$f_avatar.'&h=68&w=68&m=crop" / alt="'.$f_name.'"></a>';

}

?>

    </div>	
 