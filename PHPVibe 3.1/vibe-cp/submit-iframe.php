<?php include_once("header.php");
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

if(isset($_POST['source'])) {
$title = mysql_real_escape_string(cleanInput($_POST['title']));
$thumb = mysql_real_escape_string(cleanInput($_POST['thumb']));
$time = date(DATE_RFC822);
$duration = mysql_real_escape_string(cleanInput($_POST['time']));
$desc = mysql_real_escape_string(cleanInput($_POST['description']));
$tags = mysql_real_escape_string(cleanInput($_POST['tags']));
$channel = mysql_real_escape_string(cleanInput($_POST['channel']));
$source = real_strip_tags($_POST['source']);
$nsfw = mysql_real_escape_string(cleanInput($_POST['nsfw']));
$usr = $user->getId();
$featured = mysql_real_escape_string(cleanInput($_POST['featured']));

$insertvideo = dbquery("INSERT INTO videos (`user_id`, `date`, `thumb`, `title`, `duration`, `tags` , `views` , `liked` , `category`, `description`, `featured`,`nsfw`,`embed`) VALUES 
('".$usr."', '".$time."', '".$thumb."', '".$title ."', '".$duration."', '".$tags."', '1', '0','".$channel."','".$desc."','".$featured."','".$nsfw."','".addslashes($source)."')");		
$new_id = mysql_insert_id();
$content.= $title." has been created.<br /><br />";
$url = $site_url.'video/'.$new_id.'/'.seo_clean_url($title) .'/';
$content.= "<a href=\"".$url."\" class=\"button blueB\"><span>View on site</span></a>";
}
else{ 

$content.='	
    <form action="submit-iframe.php" method="post" class="form" style="width:100%; min-width:700px;">
	 	 <div class="formRow"> 
 <label for="source">Video embed/iframe code</label>
 <div class="formRight">
 <textarea name="source" id="source" class="required"></textarea>
</div>
<div class="clear"></div>
</div>
	 <div class="formRow"> 
 <label for="title">Video title</label>
 <div class="formRight">
 <input type="text" name="title" id="title" value=""  class="required"/>
</div>
<div class="clear"></div>
</div>
	 <div class="formRow"> 
 <label for="thumb">Thumbnail <span>(link)</span></label>
 <div class="formRight">
  <input type="text" name="thumb" id="thumb" value="" class="required"/>
   <br />
 <p><img src="" style="width:180px;height:auto; margin:10px;"/> </p>


</div>
<div class="clear"></div>
</div>
	 <div class="formRow"> 
 <label for="time">Duration <span>(in seconds)</span></label>
 <div class="formRight">
 <input type="text" name="time" id="time" value=""  class="required"/>
</div>
<div class="clear"></div>
</div>
	 <div class="formRow"> 
 <label for="description">Description</label>
 <div class="formRight">

  <textarea  name="description" id="description" rows="5" cols="36"  class="required"></textarea>
</div>
<div class="clear"></div>
</div>
	 <div class="formRow"> 
 <label for="tags">Tags <span>(comma separated)</span></label>
 <div class="formRight">
 <input type="text" name="tags" id="tags" value=""  class="required"/>
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
 <label for="featured">Feature this video?</label>
 <div class="formRight">
 <select name="featured" id="featured">
  <option value="0">No</option>
  <option value="1">Yes</option>
	</select>
</div>

<div class="clear"></div>
</div>
<div class="clear"></div>
<div class="formRow"> 
 <label for="nsfw">Safe for work?</label>
 <div class="formRight">
 <select name="nsfw" id="nsfw">
  <option value="0">Safe video</option>
 <option value="1">Not safe for work</option>
 	</select>
</div>
<div class="clear"></div>
</div>

 <div class="formRow"> 
 <br />
  <div class="formRight">
  
   <input type="submit" name="submit" id="submit" class="button blue" value="Save video" />
   <div class="clear"></div>
   </div> 	
 </div> 	   
	 </form>

';
}
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