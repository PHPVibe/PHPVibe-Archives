<?php include_once("phpvibe.php");
$page = "playlist";
if(!$user->isAuthorized())
	{ $content="Please login first"; }
	else {
if(isset($_POST['title'])){ 

$cat_title = $_POST['title'];
$cat_description = $_POST['description'];
$yt_slug = $_POST['permalink'];
$picture = $_POST['ch'];
$owner = $user->getId();

$insertvideo = dbquery("INSERT INTO playlists (`owner`, `title`, `picture`, `description`,  `permalink`) VALUES ('".addslashes($owner)."','".addslashes($cat_title)."', '".addslashes($picture)."' , '".addslashes($cat_description)."', '".addslashes($yt_slug)."')"); 


$msg = 'Playlist '.$cat_title.' has been created succesfully.';
}
$content=""; 

if(!empty($msg)) { $content.= '<div class="success-box">'.$msg.'</div>';}	
$content.='	


<form id="imageform" style="margin-left:30px;" method="post" enctype="multipart/form-data" action=\'com/playlist_ajax.php\'>
<div class="uploader bright-red">

<input type="text" class="filename" readonly="readonly"/>

<input type="button" name="file" class="button" value="Choose cover image..."/>

<input type="file" size="30" name="photoimg" id="photoimg"/>

</div>

</form>

<br/>
<form action="create-playlist.php" method="post" class="styled-form">
<label for="title">Playlist title<span>(required)</span></label>
 <input type="text" name="title" id="" size="54" value=""  />

<div id="preview"></div>
     <label for="permalink">Permalink <span>(How the link should look)</span></label>
    <input type="text" name="permalink" value=""   size="54"/>
   <label for="description">Description:</label>
   <textarea  name="description" id="comments" rows="5" cols="36"></textarea></dd>
   <input type="submit" name="submit" id="submit" value="Create playlist" />
  </form>	 
  ';?>    

 <?php 
 }	
$content_title = "Create a new playlist";
include_once("tpl/header.php");     
include_once("tpl/content.tpl.php");
include_once("tpl/footer.php");
 ?>