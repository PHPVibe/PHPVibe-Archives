<?php
include("../_inc.php");
include("tolink.php");
include "../library/AutoEmbed.class.php";
$AE = new AutoEmbed();


if(isSet($_POST['content']))
// de repus POST
{
$id=time();//Demo Use
$msg=$_POST['content'];
// de repus POST
$c_user = $user->getId();
$t=time();
$c_time = date("F j, Y, g:i a",$t);
$cuvinte=explode(' ',$msg);
$atach = "";
foreach ($cuvinte as $item){
		$item=trim($item);
		$http = stristr($item, 'http://');
		$www = stristr($item, 'www.');
		if (($http==true) or ($www==true)){
			if ($AE->parseUrl($item)) {
			$atach = $item;
			break;
			}
				
			
		}		
	}

if(!empty($atach))
{ 
$sql=mysql_query("insert into user_wall(message,u_id,att,time)values('$msg','$c_user ','$atach','$c_time')");

}

else {
$sql=mysql_query("insert into user_wall(message,u_id,time)values('$msg','$c_user ','$c_time')");
}

$result=mysql_query("select * from user_wall where u_id = '".$c_user."' order by msg_id desc");
$row=mysql_fetch_array($result);
$id=$row['msg_id'];
$msg=$row['message'];
$user_id=$row['u_id'];
$user_time=$row['time'];
$msg=toLink($msg);
$user_module = MK_RecordModuleManager::getFromType('user');
$user_profile = MK_RecordManager::getFromId($user_module->getId(), $user_id);
$u_avatar = $user_profile->getAvatar();
$u_name = $user_profile->getDisplayName();
}


echo '
<li>
<img class="avatar" src="../../library/thumb.php?f='.$u_avatar.'&h=62&w=62&m=crop" />
<div class="status">
<h2><a href="#">'.$u_name.'</a></h2>
<p class="message">'.$msg.'</p>
';
if ($AE->parseUrl($user_video)) {
$AE->setWidth(240);
$AE->setHeight(160); 
echo '<div class="attachment">'.$AE->getEmbedCode().'</div>';  
}
echo '</div>
<p class="meta">'.$user_time.' &nbsp; <span class="delete_button"><a href="#" id="'.$id.'" class="delete_update"> DELETE STATUS</a></span></p>
<div class="comment-data">
';  

$object_id = 'status_'.$id; //identify the object which is being commented
include('../loadComments.php'); //load the comments and display    
echo '</div></li>';


?>