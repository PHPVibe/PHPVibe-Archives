<?php if(!$user->isAuthorized()) 	{ die("Please login first"); }
$p_id = mysql_real_escape_string($_GET["edit"]);

if(!$user->isAuthorized() || !$p_id )	{ 
$content= "Please choose a valid playlist or login to edit your playlists!"; }

else {
if(isset($_GET['delete'])){ 
    $c_owner = $user->getId();
	$v_del = ",".mysql_real_escape_string($_GET['delete']);
	$del = dbquery("Delete from playlist_data where id = '".$_GET['delete']."'");
	 
$msg = 'Video '.$_get['delete'].' will no longer be a part of this playlist.';
}
$content=""; 

if(!empty($msg)) { $content.= '<div class="success-box">'.$msg.'</div>';}	
$csql = dbquery("SELECT * FROM `playlists` WHERE `id` = '".$p_id."' LIMIT 0,1");
while($vid = mysql_fetch_array($csql)){
$playlist_name =  $vid["title"];
$playlist_owner =  $vid["owner"];
$playlist_picture =  str_replace("../","",$vid["picture"]);
$playlist_permalink =  $vid["permalink"];
$playlist_description =  $vid["description"];

}
if($user->getId() == $playlist_owner ) :
$data = mysql_query("select playlist_data.*, videos.title,videos.thumb from playlist_data LEFT JOIN videos ON playlist_data.video_id =videos.id WHERE playlist_data.playlist ='".$p_id."' ORDER BY id DESC LIMIT 0,100000");


$content.='	
 <div class="formul">
 <div class="tbhead"><h5>'.$playlist_name.'</h5></div>
<table cellpadding="0" cellspacing="0" width="100%" class="tableStatic">
 <thead>
 <tr>
<td width="25%">Thumb</td>
<td width="40%">Title</a></td>
<td width="30%">Options</td>		</tr>
</thead>
 <tbody>';
while($video = mysql_fetch_array($data)){
$full_title = stripslashes(str_replace("\"", "",$video["title"]));			
$url = $site_url.'video/'.$video["id"].'/'.seo_clean_url($full_title) .'/';
$content.= '
<tr>		
<td>
<a class=\'repeat\' href="'. $url.'" target="_blank"><img src=\''. $video["thumb"].'\' style="width:150px;height:100px;"></a>
</td>
<td>'. $full_title.'</td>';
$content.= '
<td>
<div class="button-group">
<a href="'.$site_url.'playmanager/&edit='.$p_id.'&delete='.$video["id"].'" title="Are you sure you want to delete this video from playlist?" class="button red icon delete">Remove video</a>
</div>
 </td>		
</tr>
';	
}			
$content.='	</tbody>
</table> 
</div>
  ';
 else: 
 $content.='<div class="alert-box">Nice try! Go to your own playlists ;)</div>';
endif;
 
}

 	
$content_title = "Managing : ".$playlist_name;
include_once("tpl/header.php");     
include_once("tpl/content.tpl.php");
include_once("tpl/footer.php");
?>