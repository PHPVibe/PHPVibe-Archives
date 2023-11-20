<?php $seo_title = $config->site->htitle;
$seo_description = $config->site->hdesc;
$width = "728";
$height = "366";
$vid = new phpVibe($width, $height);
if($user->isAuthorized() && $user->getGroup()->getAccessLevel() >= $config->video->submit) {

if(isset($_POST['source'])) {
$title = mysql_real_escape_string(cleanInput($_POST['title']));
$time = date(DATE_RFC822);
$imageLibObj = new imageLib($_POST['thumb']);
$imageLibObj -> resizeImage($config->site->wpics, $config->site->hpics);    
$new_image = seo_clean_url($_POST['title'].$time).".png";
$imageLibObj -> saveImage($config->site->mediafolder.'/'.$config->site->thumbsfolder.'/'.$new_image, 100);
$thumb = $site_url.$config->site->mediafolder.'/'.$config->site->thumbsfolder.'/'.$new_image;
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
$content.= "<a href=\"".$url."\">".$title."</a> >>";
} elseif(isset($_REQUEST['initialsource']) && $vid->isValid($_REQUEST['initialsource'])) { 


$details = $vid->get_data();
$content.= "<center>".$vid->getEmbedCode($_REQUEST['initialsource'])."</center>";
$content.='	
     <form action="/submit/" method="post" class="form">
	  <input type="hidden" name="source" id="source" value="'.$_REQUEST['initialsource'].'"  />
	 <div class="formRow"> 
 <label for="title">'.$lang['title'].'</label>
 <div class="formRight">
 <input type="text" name="title" id="title" value="'.$details['title'].'"  class="required"/>
</div>
<div class="clear"></div>
</div>
	 <div class="formRow"> 
 <label for="thumb">'.$lang['video-thumb'].' <span>(link)</span></label>
 <div class="formRight">
 <input type="text" name="thumb" id="thumb" value="'.$details['thumbnail'].'" class="required"/>
    <br />
 <p><img src="'.$details['thumbnail'].'" style="width:180px;height:auto; margin:10px;"/> </p>
</div>
<div class="clear"></div>
</div>
	 <div class="formRow"> 
 <label for="time">Runtime <span>(seconds)</span></label>
 <div class="formRight">
 <input type="text" name="time" id="time" value="'.$details['duration'].'"  class="required"/>
</div>
<div class="clear"></div>
</div>
	 <div class="formRow"> 
 <label for="description">'.$lang['description'].'</label>
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
   <input type="submit" name="submit" id="submit" class="button blue" value="Continue" />
   </div> 	 
	 </form>

';

}else {
$cls = "text";
if(isset($_GET["vid"])){
$vid_source = base64_decode($_GET["vid"]);
$el= '<center>'.$vid->getEmbedCode($vid_source).'</center>';
$cls = "hidden";
}
$content='<p style="margin-left:15px;">'.$lang['sources'].'</p>	';
$content.=$el;
$content.='	
     <form action="/submit/" method="post" class="form">
	 <div class="formRow"> ';
	 if($cls != "hidden") {
  $content.='<label for="title">Video link</label>';
 }
 $content.='	
 <div class="formRight">
 <input type="'.$cls.'" name="initialsource" id="initialsource" value="'.$vid_source.'"  />
</div>
 <div class="formRow"> 
   <input type="submit" name="submit" id="submit" class="button blue" value="'.$lang['submit-video'].'" />
   </div> 	 
	 </form>
';

}
} else {
if(isset($_GET["vid"])){
$vid_source = base64_decode($_GET["vid"]);
$content= '<center>'.$vid->getEmbedCode($vid_source).'</center>';
}
$content.='
   <center>
   <p>You don\'t have the necesary requirements to submit videos</p>';
       if($config->site->facebook->login) {
$content.='
   <center>
   <a href="'.$config->site->url.'login.php?platform=facebook"><img src="'.$config->site->url.'tpl/images/fb-signin.png" alt="Connect with Fb" /></a>
    </center>';
   }
   if($config->site->twitter->login) {
   $content.='
	 <center>
	<a href="'.$config->site->url.'login.php?platform=twitter"><img src="'.$config->site->url.'tpl/images/tw-signin.png" alt="Connect with Twitter"/></a>
   </center>';
   }
  echo'
   </center>';
}
$content_title = $lang['submit-video'];
include_once("tpl/header.php");
include_once("tpl/content.tpl.php");
include_once("tpl/footer.php");

?>