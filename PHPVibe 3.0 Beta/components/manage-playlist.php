<?php if(!$user->isAuthorized()) 	{ die("Please login first"); }
if(isset($_GET['create'])){ 
if(isset($_POST['title'])){ 

$cat_title = $_POST['title'];
$cat_description = $_POST['description'];
$picture = $_POST['ch'];
$owner = $user->getId();

$insertvideo = dbquery("INSERT INTO playlists (`owner`, `title`, `picture`, `description`) VALUES ('".addslashes($owner)."','".addslashes($cat_title)."', '".addslashes($picture)."' , '".addslashes($cat_description)."')"); 


$msg = 'Playlist '.$cat_title.' has been created succesfully.';
}
$content=""; 
if(!empty($msg)) { $content.= '<div class="success-box">'.$msg.'</div>';}	
$content.='	


<form id="imageform" method="post" enctype="multipart/form-data" class="form" action=\'com/playlist_ajax.php\'>
 <div class="formRow"> 
<label for="title">Playlist cover</label>
<div class="formRight">
<input type="file" name="photoimg" id="photoimg"/>
</div>
</div> 

</form>

<br/>
<form action="myplay/&create=1" method="post" class="form">
 <div class="formRow">  
<label for="image">Cover</label>
<div class="formRight">
<div id="preview"></div>
 </div>
  </div> 
 <div class="formRow"> 
<label for="title">Playlist title</label>
<div class="formRight">
 <input type="text" name="title" id="" size="54" value=""  />
 </div>
  </div> 


     
 <div class="formRow">  <label for="description">Description:</label>
 <div class="formRight">
 <br />
   <textarea  name="description" id="description"></textarea>
   
  </div>
  </div> 
  <div class="formRow">
   <input type="submit" name="submit" id="submit" class="button blue" value="Create playlist" />
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
$new_child = $_POST['ch'];
if(!empty($new_child)) {
$picture = $new_child;
} else {
$picture = $old_child;
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


<form id="imageform" method="post" enctype="multipart/form-data" class="form" action=\'com/playlist_ajax.php\'>
 <div class="formRow"> 
 <label for="title">Playlist cover</label>
 <div class="formRight">
<img src="'.$playlist_picture.'" border="0" width="150" height="100"/>
</div>
</div>
 <div class="formRow"> 
<label for="title">Change cover</label>
<div class="formRight">
<input type="file" name="photoimg" id="photoimg"/>
</div>
</div> 
</form>


<form action="myplay/&edit='.$_GET['edit'].'" method="post" class="form">
 <input type="hidden" name="playlists" id="playlists" size="54" value="'.$_GET['edit'].'"  />
 <div class="formRow"> 
 <label for="title">&nbsp;</label>
 <div class="formRight">
<div id="preview"></div>
<input type="hidden" name="ch1" id="ch1" size="4" value="'.$playlist_picture.'"/>
</div>
</div>
    <div class="formRow"> 
<label for="title">Playlist title<span>(required)</span></label>
<div class="formRight">
 <input type="text" name="title" id="" size="54" value="'.$playlist_name.'"  />
 </div>
</div> 
  <div class="formRow"> 
<label for="title">Description</label>
<div class="formRight">
<br />
  <textarea  name="description" id="comments" rows="5" cols="36">'.$playlist_description.'</textarea>

 </div>
</div> 

   <div class="formRow"> 
   <input type="submit" name="submit" id="submit" class="button blue" value="Update playlist" />
   </div> 
  </form>	 
  ';
}


if(!empty($msg)) { $content.= '<div class="success-box">'.$msg.'</div>';}	
$content.='	
 <div class="formul">
 <div class="tbhead"><h5>My playlists</h5></div>
<table cellpadding="0" cellspacing="0" width="100%" class="tableStatic">
 <thead>
  <tr>
<td width="30%">Cover</td>
<td width="30%">Playlist</td>
<td width="40%">Options</td>		
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
<div class="button-group">
<a href="myplay/&delete='.$row["id"].'" title="Are you sure you want to delete this video?" class="button red icon delete">Delete</a>
<a href="myplay/&edit='.$row["id"].'" title="Edit playlist" class="button red icon pencilangled">Edit</a>
<a href="'.$site_url.'playmanager/&edit='.$row["id"].'" title="Edit playlist videos" class="button red icon pencilangled">Managevideos</a>
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
      


 	
$content_title = "Manage your playlists";


}
include_once("tpl/header.php");     
include_once("tpl/content.tpl.php");
include_once("tpl/footer.php");
?>