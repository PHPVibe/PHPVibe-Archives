<?php require_once '../phpvibe.php';
$width = 728;
$height = 366;
$vid = new phpVibe($width, $height);
if(isset($_REQUEST['link']) && $vid->isValid($_REQUEST['link'])) { 
$embed =  $vid->getEmbedCode($_POST['link']);
$details = $vid->get_data();
$content.= "<center>".$embed."</center>";
$content.='	
     <form action="/submit/" method="post" class="form">
	  <input type="hidden" name="source" id="source" value="'.$_POST['link'].'"  />
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
    <br />
 <p><img src="'.$details['thumbnail'].'" style="width:180px;height:auto; margin:10px;"/> </p>
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
<select name="channel" id="channel"> ';						
 $chsql = dbquery("SELECT * FROM `channels` order by cat_name ASC");
 while($row = mysql_fetch_array($chsql)){
$content.='	<option value="'.$row["cat_id"].'">'.$row["cat_name"].' </option>';		
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
 </select>
</div>
<div class="clear"></div>
</div>
 <div class="formRow"> 
   <input type="submit" name="submit" id="submit" class="buttonS bBlue" value="Continue" />
   </div> 	 
	 </form>

';
} else {
$content = UNKNOWN_PROVIDER;
}
echo $content;

?>