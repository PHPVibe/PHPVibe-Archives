<?php
include('../phpvibe.php');
if( !$user->isAuthorized() ) { die("You have no business here untill you login!");}

if(MK_Request::getPost('playlist_id')){ 
$add_it = ','.MK_Request::getPost('video');
$p_id = MK_Request::getPost('playlist_id');
$updateplaylist = dbquery("update playlists set videos=concat(videos,'".$add_it."') where owner = '".$user->getId()."' and id='".$p_id."'"); 
echo '<div class="success-box">Video has been added to the playlist. </div>';
}
?>