<?php include_once("header.php");
$width = "600";
$height = "306";
$vid = new phpVibe($width, $height);
$local_id = $_GET["id"];
if(isset($_POST['source'])) {

$title = mysql_real_escape_string(cleanInput($_POST['title']));
$thumb = mysql_real_escape_string(cleanInput($_POST['thumb']));
$duration = mysql_real_escape_string(cleanInput($_POST['time']));
$desc = mysql_real_escape_string(cleanInput($_POST['description']));
$tags = mysql_real_escape_string(cleanInput($_POST['tags']));
$channel = mysql_real_escape_string(cleanInput($_POST['channel']));
$source = mysql_real_escape_string(cleanInput($_POST['source']));
$nsfw = mysql_real_escape_string(cleanInput($_POST['nsfw']));

$insertvideo = dbquery("UPDATE videos SET 
source = '".$source."', 
nsfw = '".$nsfw."',
duration = '".$duration."',
thumb = '".$thumb."',
title = '".$title."', 
description = '".$desc."',
tags = '".$tags."',
category = '".$channel."'  
WHERE id	= '".$local_id ."'");		
}


 $sql = dbquery("SELECT * FROM `videos` WHERE `id` = '".$local_id."' LIMIT 0,1");
$video = dbarray( $sql);

$content.= "<center>".$vid->getEmbedCode($video["source"])."</center>";
$content.='	 <form action="video_edit.php?id='.$local_id.'" method="post" class="form" style="width:100%; min-width:700px;">
 <div class="formRow"> 
 <label for="source">Video source</label>
 <div class="formRight">
	  <input type="text" name="source" id="source" value="'.$video["source"].'"  />
	  </div>
<div class="clear"></div>
</div>
	 <div class="formRow"> 
 <label for="title">Video title</label>
 <div class="formRight">
 <input type="text" name="title" id="title" value="'.$video["title"].'"  class="required"/>
</div>
<div class="clear"></div>
</div>
	 <div class="formRow"> 
 <label for="thumb">Thumbnail <span>(link)</span></label>
 <div class="formRight">
 <input type="text" name="thumb" id="thumb" value="'.$video["thumb"].'" class="required"/>
</div>
<div class="clear"></div>
</div>
	 <div class="formRow"> 
 <label for="time">Duration <span>(in seconds)</span></label>
 <div class="formRight">
 <input type="text" name="time" id="time" value="'.$video["duration"].'"  class="required"/>
</div>
<div class="clear"></div>
</div>
	 <div class="formRow"> 
 <label for="description">Description</label>
 <div class="formRight">

  <textarea  name="description" id="description" rows="5" cols="36"  class="required">'.$video["description"].'</textarea>
</div>
<div class="clear"></div>
</div>
	 <div class="formRow"> 
 <label for="tags">Tags <span>(comma separated)</span></label>
 <div class="formRight">
 <input type="text" name="tags" id="tags" value="'.$video["tags"].'"  class="required"/>
</div>
<div class="clear"></div>
</div>
	 <div class="formRow"> 
 <label for="channel">Channel</label>
 <div class="formRight">
<select name="channel"> ';						
 $chsql = dbquery("SELECT * FROM `channels` order by cat_name ASC");
 $content.='<option value="'.$video["category"].'">Keep unchanged</option';
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
  <option value="0">Safe video</option>
 <option value="1">Not safe for work</option>
</div>
<div class="clear"></div>
</div>
 <div class="formRow"> 
 <br />
  <div class="formRight">
   <br />
   <input type="submit" name="submit" id="submit" class="button blue" value="Save video" />
   </div> 	
 </div> 	   
	 </form>

';

?>
	<div id="content">
<div class="box">
<div class="box-header"><h1>Submit a new video</h1></div>
<div class="box-content">
<? echo $content; ?>

</div>
<br style="clear:both;">
	</div>
<?
include_once("footer.php");
?>