<?php include_once("header.php");
$width = "600";
$height = "306";
$vid = new phpVibe($width, $height);
if(!$user->isAuthorized()) 	{ die("Please login first"); }
if(isset($_POST['source'])) {
$title = mysql_real_escape_string(cleanInput($_POST['title']));
$thumb = mysql_real_escape_string(cleanInput($_POST['thumb']));
$t=time();
$time = date("F j, Y, g:i a",$t);
$duration = mysql_real_escape_string(cleanInput($_POST['time']));
$desc = mysql_real_escape_string(cleanInput($_POST['description']));
$tags = mysql_real_escape_string(cleanInput($_POST['tags']));
$channel = mysql_real_escape_string(cleanInput($_POST['channel']));
$source = mysql_real_escape_string(cleanInput($_POST['source']));
$nsfw = mysql_real_escape_string(cleanInput($_POST['nsfw']));
$usr = $user->getId();

$insertvideo = dbquery("INSERT INTO videos (`source`, `user_id`, `date`, `thumb`, `title`, `duration`, `tags` , `views` , `liked` , `category`, `description`, `nsfw`) VALUES 
('".$source."', '".$usr."', '".$time."', '".$thumb."', '".$title ."', '".$duration."', '".$tags."', '1', '0','".$channel."','".$desc."','".$nsfw."')");		
$new_id = mysql_insert_id();
$content.= $title." has been created.<br /><br />";
$url = $site_url.'video/'.$new_id.'/'.seo_clean_url($title) .'/';
$content.= "<a href=\"".$url."\" class=\"button blueB\"><span>View on site</span></a>";
}
elseif(isset($_POST['initialsource']) && $vid->getEmbedCode($_POST['initialsource']) != UNKNOWN_PROVIDER &&  $vid->getEmbedCode($_POST['initialsource']) != INVALID_URL) { 


$details = $vid->get_data();
$content.= "<center>".$vid->getEmbedCode($_POST['initialsource'])."</center>";
$content.='	
    <form action="submit.php" method="post" class="form" style="width:100%; min-width:700px;">
	  <input type="hidden" name="source" id="source" value="'.$_POST['initialsource'].'"  />
	 <div class="formRow"> 
 <label for="title">Video title</label>
 <div class="formRight">
 <input type="text" name="title" id="title" value="'.$details['title'].'"  class="required"/>
</div>
<div class="clear"></div>
</div>
	 <div class="formRow"> 
 <label for="thumb">Thumbnail <span>(link)</span></label>
 <div class="formRight">
 <input type="text" name="thumb" id="thumb" value="'.$details['thumbnail'].'" class="required"/>
</div>
<div class="clear"></div>
</div>
	 <div class="formRow"> 
 <label for="time">Duration <span>(in seconds)</span></label>
 <div class="formRight">
 <input type="text" name="time" id="time" value="'.$details['duration'].'"  class="required"/>
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
 <input type="text" name="tags" id="tags" value="'.$details['tags'].'"  class="required"/>
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
} else {
$content.='	
     <form action="submit.php" method="post" class="form" style="width:100%; min-width:700px;">
	 <div class="formRow"> 
 <label for="title">Video link</label>
 <div class="formRight">
 <input type="text" name="initialsource" id="initialsource" value=""  />
</div>
 <div class="formRow"> 
<br />  <div class="formRight">
   <input type="submit" name="submit" id="submit" class="button blue" value="Continue" />
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