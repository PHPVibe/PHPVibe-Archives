<?php if(!$user->isAuthorized()) 	{ die("Please login first"); }
if(isset($_GET['create'])){ 
if(isset($_POST['title'])){ 

$cat_title = $_POST['title'];
$cat_description = $_POST['description'];
$owner = $user->getId();
$time = date(DATE_RFC822);
	$formInputName   = 'thumb';							# This is the name given to the form's file input
	$savePath	     = 'uploads';								# The folder to save the image
	$saveName        = 'playlist-'.seo_clean_url($_POST['title']);									# Without ext
	$allowedExtArray = array('.jpg', '.png', '.gif');	# Set allowed file types
	$imageQuality    = 100;
		// *** Create object
		$uploadObj = new imageUpload($formInputName, $savePath, $saveName , $allowedExtArray);

		// *** If everything is swell, continue...
		if ($uploadObj->getIsSuccessful()) {
			//$uploadObj -> resizeImage(200, 200, 'crop');
			
			$uploadObj -> saveImage($uploadObj->getTargetPath(), $imageQuality);
		} else {
			die($uploadObj->getError());
		}
		
		$picture  = $uploadObj->getTargetPath();

$insertvideo = dbquery("INSERT INTO playlists (`owner`, `title`, `picture`, `description`) VALUES ('".addslashes($owner)."','".addslashes($cat_title)."', '".addslashes($picture)."' , '".addslashes($cat_description)."')"); 


$msg = 'Playlist '.$cat_title.' has been created succesfully.';
}
$content=""; 
if(!empty($msg)) { $content.= '<div class="success-box">'.$msg.'</div>';}	
$content.='	

<form action="myplay/&create=1" method="post" class="form" enctype="multipart/form-data">
<div class="formRow"> 
<label for="image">'.$lang['cover'].'</label>
<div class="formRight">
<input type="file" name="thumb" id="thumb" accept="image/gif, image/jpeg" class="validate[required]" />
</div>
 <div class="clear"></div>
</div> 
 <div class="formRow"> 
<label for="title">'.$lang['title'].'</label>
<div class="formRight">
 <input type="text" name="title" id="title" class="validate[required]" />
 </div>
 <div class="clear"></div>
  </div> 
    
 <div class="formRow">  <label for="description">'.$lang['description'].':</label>
 <div class="formRight">
   <textarea  name="description" id="description" class="validate[required]"></textarea>
  
  </div>
  <div class="clear"></div>
  </div> 
  <div class="formRow">
   <input type="submit" name="submit" id="submit" class="buttonS bLightBlue" value="'.$lang['create-playlist'].'" />
   <div class="clear"></div>
   </div>
  </form>';	 
$content_title = "Create a new playlist";
} else{

if(isset($_GET['delete'])){ 
    $owner = $user->getId();
	 $del = dbquery("DELETE from playlists WHERE id = '".$_GET['delete']."' and owner='".$owner."'");
	 
$msg = 'Playlist '.$_get['delete'].' has been deleted succesfully.';
}
if(isset($_POST['title'])){ 
$cat_title = $_POST['title'];
$cat_description = $_POST['description'];
$old_child = $_POST['ch1'];

$time = date(DATE_RFC822);
	$formInputName   = 'thumb';							# This is the name given to the form's file input
	$savePath	     = 'uploads';								# The folder to save the image
	$saveName        = 'playlist-'.seo_clean_url($_POST['title']);									# Without ext
	$allowedExtArray = array('.jpg', '.png', '.gif');	# Set allowed file types
	$imageQuality    = 100;
		// *** Create object
		$uploadObj = new imageUpload($formInputName, $savePath, $saveName , $allowedExtArray);

		// *** If everything is swell, continue...
		if ($uploadObj->getIsSuccessful()) {
			//$uploadObj -> resizeImage(200, 200, 'crop');
			
			$uploadObj -> saveImage($uploadObj->getTargetPath(), $imageQuality);
			$picture  = $uploadObj->getTargetPath();
		} else {
			$picture  = $_POST['ch1'];
		}

$owner = $user->getId();
$cc_play = $_POST['playlists'];
$insertvideo = dbquery("UPDATE playlists  SET title = '".$cat_title."', picture = '".$picture."', description = '".$cat_description."'  WHERE id	= '".$cc_play."'");		
}
$content=""; 

if(isset($_GET['edit'])){
$csql = dbquery("SELECT * FROM `playlists` WHERE `id` = '".$_GET['edit']."'");
$row = dbarray($csql);
$playlist_name =  $row["title"];
$playlist_owner =  $row["owner"];
$playlist_picture =  $row["picture"];
$playlist_description =  $row["description"];

if(!empty($msg)) { $content.= '<div class="success-box">'.$msg.'</div>';}	

$content.='	
<form action="myplay/&edit='.$_GET['edit'].'" method="post" class="form" enctype="multipart/form-data">
 <input type="hidden" name="playlists" id="playlists" size="54" value="'.$_GET['edit'].'"  />
 <div class="formRow"> 
 <label for="title">'.$lang['cover'].'</label>
 <div class="formRight">
<input type="file" name="thumb" id="thumb" accept="image/gif, image/jpeg"/>
<input type="hidden" name="ch1" id="ch1" size="4" value="'.$playlist_picture.'"/>
</div>
 <div class="clear"></div>
</div>
   <div class="formRow"> 
    <label for="title">'.$lang['pre-cover'].'</label>
 <div class="formRight">
<img src="'.$playlist_picture.'" border="0" width="150" height="100"/>
</div>
 <div class="clear"></div>
</div>
    <div class="formRow"> 
<label for="title">'.$lang['title'].'</label>
<div class="formRight">
 <input type="text" name="title" id="" size="54" value="'.$playlist_name.'"  />
 </div>
  <div class="clear"></div>
</div> 
  <div class="formRow"> 
<label for="title">Description</label>
<div class="formRight">
<textarea  name="description" id="comments" rows="5" cols="36">'.$playlist_description.'</textarea>
 </div>
  <div class="clear"></div>
</div> 

   <div class="formRow"> 
   <input type="submit" name="submit" id="submit" class="buttonS bLightBlue" value="'.$lang['update-playlist'].'" />
    <div class="clear"></div>
   </div> 
  </form>	 
  ';
}


if(!empty($msg)) { $content.= '<div class="success-box">'.$msg.'</div>';}	
$content.='	
 <div class="formul">
 <div class="tbhead"><h5>'.$lang['myplaylists'].'</h5></div>
<table cellpadding="0" cellspacing="0" width="100%" class="tableStatic">
 <thead>
  <tr>
<td width="30%">'.$lang['cover'].'</td>
<td width="30%">'.$lang['name'].'</td>
<td width="40%">'.$lang['options'].'</td>		
</tr>
</thead>
<tbody>
';

$chsql = dbquery("SELECT * FROM `playlists` where owner = '".$user->getId()."' order by id DESC");

 while($row = mysql_fetch_array($chsql)){
$content.= '
<tr>		
<td>
<a class=\'lightbox\' href="../'.$row["picture"].'" target="_blank"><img src=\'../'.$row["picture"].'\'  width="200" height="100"></a>
</td>
<td>'.stripslashes($row["title"]).' </td>
';
$content.= '
<td>
<div class="buttons">
<a href="myplay/&delete='.$row["id"].'" title="Are you sure you want to delete this video?" class="button left"><span class="icon icon56"></span><span class="label">Delete</span></a>
<a href="myplay/&edit='.$row["id"].'" title="Edit playlist" class="button middle"><span class="icon icon145"></span><span class="label">Edit</span></a>
<a href="'.$site_url.'playmanager/&edit='.$row["id"].'" title="Edit playlist videos" class="button right"><span class="icon icon99"></span><span class="label">Videos</span></a>
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
      


 	
$content_title = $lang['manplaylists'];


}
include_once("tpl/header.php");     
include_once("tpl/content.tpl.php");
include_once("tpl/footer.php");
?>