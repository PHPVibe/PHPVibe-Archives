<?php include_once("header.php");
$width = "600";
$height = "306";
$vid = new phpVibe($width, $height);
$local_id = $_GET["id"];
function render_video($code) {
global $width,$height;
$postembed = str_replace("##videoW##",$width,$code);
$postembed = str_replace("##videoH##",$height,$postembed);
return stripslashes($postembed);
}
function real_strip_tags($embed) {
$embed = str_replace(array("'", "\n", "\r"), array('"', '', ''), $embed);
		//	remove extra html tags
		$embed = strip_tags($embed, '<iframe><embed><object><param>');

		if (strpos($embed, '<object') !== false)
		{
			$embed = preg_replace('/\/object>(.*)/i', '/object>', $embed);
		}
$embed = preg_replace('/width="([0-9]+)"/i', 'width="##videoW##"', $embed);
		$embed = preg_replace('/height="([0-9]+)"/i', 'height="##videoH##"', $embed);
		$embed = preg_replace('/value="(window|opaque|transparent)"/i', 'value="transparent"', $embed);
		$embed = preg_replace('/wmode="(.*?)"/i', 'wmode="transparent"', $embed);
		$embed = preg_replace('/width=([0-9]+)/i', 'width=##videoW##', $embed);
		$embed = preg_replace('/height=([0-9]+)/i', 'height=##videoH##', $embed);
		return $embed ;
}
if(isset($_POST['title'])) {

$title = mysql_real_escape_string(cleanInput($_POST['title']));
$thumb = mysql_real_escape_string(cleanInput($_POST['thumb']));
$duration = mysql_real_escape_string(cleanInput($_POST['time']));
$desc = mysql_real_escape_string(cleanInput($_POST['description']));
$tags = mysql_real_escape_string(cleanInput($_POST['tags']));
$channel = mysql_real_escape_string(cleanInput($_POST['channel']));
$source = mysql_real_escape_string(cleanInput($_POST['source']));
$nsfw = mysql_real_escape_string(cleanInput($_POST['nsfw']));
$iframe = real_strip_tags($_POST['iframe']);
$insertvideo = dbquery("UPDATE videos SET 
source = '".$source."', 
nsfw = '".$nsfw."',
duration = '".$duration."',
thumb = '".$thumb."',
title = '".$title."', 
description = '".$desc."',
tags = '".$tags."',
embed = '".$iframe."',
category = '".$channel."'  
WHERE id	= '".$local_id ."'");		
}


 $sql = dbquery("SELECT * FROM `videos` WHERE `id` = '".$local_id."' LIMIT 0,1");
$video = dbarray( $sql);
$embedvideo				=  !empty($video["embed"]) ? render_video($video["embed"]) : $vid->getEmbedCode($video["source"]);
$content.= "<center>".$embedvideo."</center>";
$content.='	 <form action="video_edit.php?id='.$local_id.'" method="post" class="form" style="width:100%; min-width:700px;">
 <div class="formRow"> ';
 if(!empty($video["source"])) {
 $content.='	<label for="source">Video source</label>
 <div class="formRight">
	  <input type="text" name="source" id="source" value="'.$video["source"].'"  />
	  </div>
<div class="clear"></div>
</div>';
}
 if(!empty($video["embed"])) {
 $content.='	<label for="iframe">Video embed</label>
 <div class="formRight">
	  <textarea name="iframe" id="iframe" value="'.stripslashes($video["embed"]).'" ></textarea>
	  </div>
<div class="clear"></div>
</div>';
}
$content.='		 <div class="formRow"> 
 <label for="title">Video title</label>
 <div class="formRight">
 <input type="text" name="title" id="title" value="'.stripslashes($video["title"]).'"  class="required"/>
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

  <textarea  name="description" id="description" rows="5" cols="36"  class="required">'.stripslashes($video["description"]).'</textarea>
</div>
<div class="clear"></div>
</div>
	 <div class="formRow"> 
 <label for="tags">Tags <span>(comma separated)</span></label>
 <div class="formRight">
 <input type="text" name="tags" id="tags" value="'.stripslashes($video["tags"]).'"  class="required"/>
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
<div class="box-header"><h1>Edit video</h1></div>
<div class="box-content">
<? echo $content; ?>

</div>
<br style="clear:both;">
	</div>
<?
include_once("footer.php");
?>