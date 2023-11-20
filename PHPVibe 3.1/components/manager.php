<?php $p_id = $user->getId();
if(!$user->isAuthorized() )	{ 
$content= "Please login"; } else {


if(isset($_GET['delete'])){ 
  	$del = dbquery("Delete from videos_tmp where id = '".$_GET['delete']."' and uid ='".$p_id."'");
	unlink($_GET['media']);
	 
$msg = 'Media deleted.';
}
if(isset($_POST['source'])) {
$title = mysql_real_escape_string(cleanInput($_POST['title']));
$time = date(DATE_RFC822);
// *** Step 1 of 2) Set up the variables
	$formInputName   = 'thumb';							# This is the name given to the form's file input
	$savePath	     = $config->site->mediafolder."/".$config->site->thumbsfolder;								# The folder to save the image
	$saveName        = seo_clean_url($_POST['title'].$time);									# Without ext
	$allowedExtArray = array('.jpg', '.png', '.gif');	# Set allowed file types
	$imageQuality    = 100;
		// *** Create object
		$uploadObj = new imageUpload($formInputName, $savePath, $saveName , $allowedExtArray);

		// *** If everything is swell, continue...
		if ($uploadObj->getIsSuccessful()) {
		    $uploadObj -> resizeImage($config->site->wpics, $config->site->hpics, 'crop');			
			$uploadObj -> saveImage($uploadObj->getTargetPath(), $imageQuality);
		} else {
			die($uploadObj->getError());
		}
		
		$thumb = $uploadObj->getTargetPath();

$duration = mysql_real_escape_string(cleanInput($_POST['time']));
$desc = mysql_real_escape_string(cleanInput($_POST['description']));
$tags = mysql_real_escape_string(cleanInput($_POST['tags']));
$channel = mysql_real_escape_string(cleanInput($_POST['channel']));
$source = "localfile/".mysql_real_escape_string(cleanInput($_POST['source']));
$nsfw = mysql_real_escape_string(cleanInput($_POST['nsfw']));
$tvido = mysql_real_escape_string(cleanInput($_POST['temp_d']));
$usr = $user->getId();

$insertvideo = dbquery("INSERT INTO videos (`source`, `user_id`, `date`, `thumb`, `title`, `duration`, `tags` , `views` , `liked` , `category`, `description`, `nsfw`) VALUES 
('".$source."', '".$usr."', '".$time."', '".$thumb."', '".$title ."', '".$duration."', '".$tags."', '1', '0','".$channel."','".$desc."','".$nsfw."')");		
$new_id = mysql_insert_id();
$del_tmp = dbquery("Delete from videos_tmp where id = '".$tvido."' and uid ='".$p_id."'");
$content.= $title." has been created.<br /><br />";
$url = $site_url.'video/'.$new_id.'/'.seo_clean_url($title) .'/';
$content.= "<a href=\"".$url."\">".$title."</a> >>";
$del = dbquery("Delete from videos_tmp where id = '".cleanInput($_POST['tmp_id'])."' and uid ='".$p_id."'");
} 
$content=""; 
if(isset($_GET['publish']) && is_numeric($_GET['publish'])){ 
$sql = "select * from videos_tmp where uid ='".$p_id."' &&  id='".cleanInput($_GET['publish'])."'";
if ($details = $dbi->singlequery($sql, 0)) { 
$content.='	
     <form action="/manage/" method="post" class="form" enctype="multipart/form-data">
	  <input type="hidden" name="source" id="source" value="'.$details['path'].'"  />
	   <input type="hidden" name="tmp_id" id="tmp_id" value="'.$details['id'].'"  />
	 <div class="formRow"> 
 <label for="title">Media title</label>
 <div class="formRight">
 <input type="text" name="title" id="title" value="'.$details['name'].'"  class="validate[required]"/>
</div>
<div class="clear"></div>
</div>
	 <div class="formRow"> 
 <label for="thumb">Thumbnail</label>';
 	 $content.=' 
	  <div class="formRight" >

<input type="file" name="thumb" id="thumb" accept="image/gif, image/jpeg" class="validate[required]" />

 </div>
 <div class="clear"></div>
</div>
	 <div class="formRow"> 
 <label for="time">Duration <span>(in seconds)</span></label>
 <div class="formRight">
 <input type="text" name="time" id="time" value="'.$details['duration'].'"  class="validate[required,custom[onlyNumberSp]]"/>
</div>
<div class="clear"></div>
</div>';

 $content.='	
 <div class="formRow"> 
 <label for="description">Description</label>
 <div class="formRight">

  <textarea  name="description" id="description" rows="5" cols="36"  class="validate[required]"></textarea>
</div>
<div class="clear"></div>
</div>
	 <div class="formRow"> 
 <label for="tags">Tags <span>(comma separated)</span></label>
 <div class="formRight">
 <input type="text" name="tags" id="tags" value="'.$details['tags'].'"  class="validate[required]"/>
</div>
<div class="clear"></div>
</div>
	 <div class="formRow"> 
 <label for="channel">Channel</label>
 <div class="formRight">
<select name="channel"> ';						
 $chsql = dbquery("SELECT * FROM `channels` order by cat_name ASC");
 while($row = mysql_fetch_array($chsql)){
$content.='			
<option value="'.$row["cat_id"].'" />'.$row["cat_name"].' </option>';		
}			
$content.='	</select>
</div>
<div class="clear"></div>
</div>
<div class="formRow"> 
 <label for="tags">Safe for work?</label>
 <div class="formRight">
 <select name="nsfw" id="nsfw">
  <option value="0">Safe </option>
 <option value="1">Not safe for work</option>
 </select>
</div>
<div class="clear"></div>
</div>
 <div class="formRow"> 
   <input type="submit" name="submit" id="submit" class="buttonS bLightBlue" value="Continue" />
   </div> 	 
	 </form>
<div class="clear"></div>
';
}
}
if(!empty($msg)) { $content.= '<div class="success-box">'.$msg.'</div>';}	
$data = mysql_query("select * from videos_tmp where uid ='".$p_id."' ORDER BY id DESC");


$content.='	
 <div class="formul" style="margin: 0 20px;">
 <div class="tbhead"><h5>Unpublished Media</h5></div>
<table cellpadding="0" cellspacing="0" width="100%" class="tableStatic">
 <thead>
 <tr>
<td width="80">Type</td>
<td>File</a></td>
<td>Options</td>		</tr>
</thead>
 <tbody>';
while($video = mysql_fetch_array($data)){

$content.= '
<tr>		
<td  width="80" height="80">';
$content.= '<a href="'.$site_url.'components/player/player.swf?file='.$site_url.$video["path"].'&lightbox[width]=610&lightbox[height]=360" class="lightbox"><img src="'.$site_url.'tpl/images/wmp.png" width="80x" height="80px" /></a>';
$content.= '
</td>
<td align="center">'. $video["name"].'</td>';
$content.= '
<td>
<div class="button-group">
<a href="'.$site_url.'manage/&publish='.$video["id"].'" title="Publish media?" class="button"><span class="icon icon3"></span><span class="label">Publish</span></a>
<a href="'.$site_url.'manage/&delete='.$video["id"].'&media='.$video["path"].'" title="Are you sure you want to delete this?" class="button"><span class="icon icon56"></span><span class="label">Remove</span></a>
</div>
 </td>		
</tr>
';	
}			
$content.='	</tbody>
</table> 
</div>
  ';

 
}

 	
$content_title = "Managing media";
include_once("tpl/header.php");     
include_once("tpl/content.tpl.php");
include_once("tpl/footer.php");
?>