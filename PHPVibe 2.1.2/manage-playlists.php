<?php include_once("phpvibe.php");
$page = "playlist";
if(isset($_GET['delete'])){ 
    $owner = $user->getId();
	 $del = dbquery("DELETE from playlists WHERE id = '".$_GET['delete']."' and owner='".$owner."'");
	 
$msg = 'Playlist '.$_get['delete'].' has been deleted succesfully.';
}
if(isset($_POST['title'])){ 
$cat_title = $_POST['title'];
$cat_description = $_POST['description'];
$yt_slug = $_POST['permalink'];
$old_child = $_POST['ch1'];
$new_child = $_POST['ch'];
if(!empty($new_child)) {
$picture = $new_child;
} else {
$picture = $old_child;
}
$owner = $user->getId();
$cc_play = $_POST['playlists'];
$insertvideo = dbquery("UPDATE playlists  SET title = '".$cat_title."', picture = '".$picture."', permalink = '".$yt_slug."', description = '".$cat_description."'  WHERE id	= '".$cc_play."'");		
}

if(!$user->isAuthorized())
	{ $content="Please login first"; }
	else {

$content=""; 

if(isset($_GET['edit'])):
$csql = dbquery("SELECT * FROM `playlists` WHERE `id` = '".$_GET['edit']."' LIMIT 0,1");
while($row = mysql_fetch_array($csql)){
$playlist_name =  $row["title"];
$playlist_owner =  $row["owner"];
$playlist_picture =  $row["picture"];
$playlist_permalink =  $row["permalink"];
$playlist_description =  $row["description"];
$playlist_videos =  $row["videos"];
}
if(!empty($msg)) { $content.= '<div class="success-box">'.$msg.'</div>';}	

$content.='	


<form id="imageform" style="margin-left:30px;" method="post" enctype="multipart/form-data" action=\'com/playlist_ajax.php\'>
<div class="uploader bright-red">

<input type="text" class="filename" readonly="readonly"/>

<input type="button" name="file" class="button" value="Choose cover image..."/>

<input type="file" size="30" name="photoimg" id="photoimg"/>

</div>

</form>
<p style="margin-left:30px;"><img src="'.$playlist_picture.'" border="0" width="200" height="200"/></p>
<br/>
<form action="manage-playlists.php" method="post" class="styled-form">
 <input type="hidden" name="playlists" id="playlists" size="54" value="'.$_GET['edit'].'"  />
<label for="title">Playlist title<span>(required)</span></label>
 <input type="text" name="title" id="" size="54" value="'.$playlist_name.'"  />
<label for="title">Playlist title<span>(required)</span></label>
<input type="hidden" name="ch1" id="ch1" size="4" value="'.$playlist_picture.'"/>
<div id="preview"></div>
     <label for="permalink">Permalink <span>(How the link should look)</span></label>
    <input type="text" name="permalink" value="'.$playlist_permalink.'" size="54"/>
   <label for="description">Description:</label>
   <textarea  name="description" id="comments" rows="5" cols="36">'.$playlist_description.'</textarea></dd>
   <input type="submit" name="submit" id="submit" value="Update playlist" />
  </form>	 
  ';
endif;


if(!empty($msg)) { $content.= '<div class="success-box">'.$msg.'</div>';}	
$content.='	
 <div class="formul">
 <div class="tbhead"><h5>My playlists</h5></div>

<table cellpadding="0" cellspacing="0" width="100%" class="tableStatic">

    <thead>

        <tr>

<td width="5%">ID</td>
<td width="40%">Playlist</a></td>
<td width="55%">Options</td>		</tr>

	</thead>

    <tbody>

	';


$chsql = dbquery("SELECT * FROM `playlists` where owner = '".$user->getId()."' order by id DESC");

 while($row = mysql_fetch_array($chsql)){
$content.= '
<tr>		
<td>'.$row["id"].'</td>
<td>
<p><a class=\'lightbox\' href="../'.$row["picture"].'" target="_blank"><img src=\'../'.$row["picture"].'\'  width="140" heaight="100"></a></p>
<p>'.stripslashes($row["title"]).' </p>

</td>

';
$content.= '
<td>
<div class="button-group">
<a href="manage-playlist.php?edit='.$row["id"].'" title="Edit videos" class="button blue on icon reload">Manage videos</a>
<a href="manage-playlists.php?edit='.$row["id"].'" title="Edit playlist" class="button red icon pencilangled">Edit playlist</a>
<a href="manage-playlists.php?delete='.$row["id"].'" title="Are you sure you want to delete this video?" class="button red on icon delete">Delete</a>
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
      
}

 	
$content_title = "Manage your playlists";
include_once("tpl/header.php");     
include_once("tpl/content.tpl.php");
include_once("tpl/footer.php");
 ?>