<div class="box one">

 		<div class="header">

 			<h2>Wall</h2>

    <!--Toggle-->

    <span class="toggle"></span>

 		</div>

 		<div class="content padding">
<div id="wall" class="facebookWall">

<?php

$nr_query = "SELECT COUNT(*) FROM user_wall where u_id = '".$user_profile->getId()."'";
$result = mysql_query($nr_query);
$numberofresults = mysql_result($result, 0);
$BrowsePerPage = 20;

$limit = 'LIMIT ' .($pageNumber - 1) * $BrowsePerPage .',' .$BrowsePerPage; 
$result=mysql_query("select * from user_wall where u_id = '".$user_profile->getId()."' order by msg_id desc $limit");
 while($row = mysql_fetch_array($result)){
$id=$row['msg_id'];
$msg=$row['message'];
$user_id=$row['u_id'];
$user_time=$row['time'];
$user_video=$row['att'];
$msg= twitterify($msg);
$u_avatar = $user_profile->getAvatar();
$u_name = $user_profile->getDisplayName();
$u_url = $site_url.'user/'.$user_id.'/'.seo_clean_url($u_name) .'/';

echo '
<li>
<img class="avatar" src="'.$site_url.'components/thumb.php?f='.$u_avatar.'&h=62&w=62&m=crop" />
<div class="status">
<h2><a href="'.$u_url.'">'.$u_name.'</a> said:</h2>
<p class="meta">'.time_ago($user_time).'</p>
<p class="message">'.$msg.'</p>
';
if ($AE->parseUrl($user_video)) {
$AE->setWidth(340);
$AE->setHeight(180); 
echo '<div class="attachment">'.$AE->getEmbedCode().'</div>';  
}
echo '</div>
<div class="comment-data">
';  

$object_id = 'status_'.$id; //identify the object which is being commented
include("./components/loadComments.php"); //load the comments and display    
echo '</div></li>';

}
?>
</div>
<div class="clear"></div>

<?php
$a = new pagination;	
$a->set_current($pageNumber);
$a->set_first_page(true);
$a->set_pages_items(12);
$a->set_per_page(20);
$a->set_values($numberofresults);
$a->show_pages($pagi_url);
?>
</div>
    </div>	
 