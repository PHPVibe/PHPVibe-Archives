<div class="box one">

 		<div class="header">

 			<h2>Video likes</h2>

    <!--Toggle-->

    <span class="toggle"></span>

 		</div>

 		<div class="content padding">
<div id="wall" class="facebookWall">

<?php

$nr_query = "SELECT COUNT(*) FROM likes where uid = '".$user_profile->getId()."' and type='like'";
$result = mysql_query($nr_query);
$numberofresults = mysql_result($result, 0);
$BrowsePerPage = 3;
$limit = 'LIMIT ' .($pageNumber - 1) * $BrowsePerPage .',' .$BrowsePerPage; 
$l_result=dbquery("SELECT vid FROM likes where uid = '".$user_profile->getId()."' and type='like' order by id desc $limit");

 while ($info = dbarray($l_result)):
$vid .= $info['vid'].", ";
endwhile;
$vid_array = explode(', ', $vid);

foreach($vid_array as $liked){	
if (empty($liked) ) {
continue;
}
 if (is_numeric($liked)) {
 $v_result=dbquery("SELECT youtube_id,title FROM videos WHERE id = '".$liked."' limit 0,1");
 while($row = mysql_fetch_array($v_result)):
 $this_vid_id = $row["youtube_id"];
  $this_vid_link = "http://www.youtube.com/watch?v=".$row["youtube_id"];
 $this_vid_title = $row["title"];
 endwhile;
 
 } else {
 $this_vid_id = $liked;
  $this_vid_link = "http://www.youtube.com/watch?v=".$liked;
 
 }


$u_avatar = $user_profile->getAvatar();
$u_name = $user_profile->getDisplayName();
$u_url = $site_url.'user/'.$user_id.'/'.seo_clean_url($u_name) .'/';

echo '
<li>
<img class="avatar" src="'.$site_url.'components/thumb.php?f='.$u_avatar.'&h=62&w=62&m=crop" />
<div class="status">
<h2><a href="'.$u_url.'">'.$u_name.'</a> liked:</h2>';
 if (isset($this_vid_title)) {
echo '<p class="message">'.$this_vid_title.'</p>';
}

if ($AE->parseUrl( $this_vid_link )) {
$AE->setWidth(425);
$AE->setHeight(240); 
echo '<div class="attachment">'.$AE->getEmbedCode().'</div>';  
}
echo '</div>
<div class="comment-data">
';  

$object_id = 'video_'.$this_vid_id; //identify the object which is being commented
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
$a->set_per_page($BrowsePerPage);
$a->set_values($numberofresults);
$a->show_pages($pagi_url);
?>
</div>
    </div>	
 