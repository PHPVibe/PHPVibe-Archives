<?php include_once("phpvibe.php");
include_once("com/youtube_api.php");
$page = "playlist";
$p_id = mysql_real_escape_string($_GET["edit"]);

if(isset($_GET['delete'])){ 
    $c_owner = $user->getId();
	$v_del = ",".mysql_real_escape_string($_GET['delete']);
	$del = dbquery(" Update playlists Set videos = Replace (videos, '".$v_del."','') where owner = '".$c_owner."' and id = '".$p_id."'");
	 
$msg = 'Video '.$_get['delete'].' will no longer be a part of this playlist.';
}


if(!$user->isAuthorized() || !$p_id )	{ 
$content= "Please choose a valid playlist or login to edit your playlists!"; }

else {

$content=""; 



if(!empty($msg)) { $content.= '<div class="success-box">'.$msg.'</div>';}	
$csql = dbquery("SELECT * FROM `playlists` WHERE `id` = '".$p_id."' LIMIT 0,1");
while($vid = mysql_fetch_array($csql)){
$playlist_name =  $vid["title"];
$playlist_owner =  $vid["owner"];
$playlist_picture =  str_replace("../","",$vid["picture"]);
$playlist_permalink =  $vid["permalink"];
$playlist_description =  $vid["description"];
$playlist_videos =  $vid["videos"];
}

if($user->getId() == $playlist_owner ) :

$content.='	
 <div class="formul">
 <div class="tbhead"><h5>'.$playlist_name.'</h5></div>

<table cellpadding="0" cellspacing="0" width="100%" class="tableStatic">

    <thead>

        <tr>

<td width="10%">ID</td>
<td width="80%">Playlist</a></td>
<td width="10%">Options</td>		</tr>

	</thead>

    <tbody>

	';


$vid_array = explode(',', $playlist_videos);
$vid_array = array_filter($vid_array);
$vid_array = array_unique($vid_array);

foreach($vid_array as $vid){
$v1 	=  new Youtube_class();
$youtube = $v1->getYoutubeVideoDataByVideoId($vid);	
 $this_vid_title = $youtube['title']; 
 $this_vid_link = "http://www.youtube.com/watch?v=".$vid;
 $this_vid_thumb = "http://i2.ytimg.com/vi/".$vid."/default.jpg";
$content.= '
<tr>		
<td>'.$vid.'</td>
<td>
<p style="float:left; width:120px; margin-right:9px;"><a class=\'repeat\' href="'. $this_vid_link.'" target="_blank"><img src=\''. $this_vid_thumb.'\'></a></p>
<p> '. $this_vid_title.' </p>

</td>

';
$content.= '
<td>
<div class="button-group">
<a href="manage-playlist.php?edit='.$p_id.'&delete='.$vid.'" title="Are you sure you want to delete this video?" class="button red icon delete">Delete</a>
</div>
 </td>		

</tr>
';	
}			
$content.='	


	</tbody>

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