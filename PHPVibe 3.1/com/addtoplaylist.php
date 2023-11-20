<?php require_once("../phpvibe.php");
 if($user->isAuthorized()) { 
if(MK_Request::getQuery('playlist_id') && MK_Request::getQuery('video')){ 
$add_video = CleanInput(MK_Request::getQuery('video'));
$p_id = CleanInput(MK_Request::getQuery('playlist_id'));
$playlist_result = dbquery("select * from playlist_data WHERE playlist = '".$p_id."' AND video_id ='".$add_video."'");
$num_playlists = mysql_num_rows($playlist_result);
if ($num_playlists >0) :
echo "<p>".$lang['skipedit']." ".MK_Request::getQuery('pname')."</p>"; 
else:
$insertvideo = dbquery("Insert INTO playlist_data (`playlist`, `video_id`) VALUES ('".$p_id."', '".$add_video."')");
echo "<p>".$lang['gotit']." ".MK_Request::getQuery('pname')."</p>"; 
endif;
}
}
?>