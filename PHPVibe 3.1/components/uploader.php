<?php $seo_title = $config->site->htitle;
$seo_description = $config->site->hdesc;
$width = "728";
$height = "366";
$vid = new phpVibe($width, $height);
if($user->isAuthorized() && $user->getGroup()->getAccessLevel() >= $config->video->submit) {

 $content.='
<div id="preview"></div> 
<div id="dumpvideo"></div>
<div id="submiter" style="width:46%; display:block; position:relative; float: right; margin-right:3px;margin-top:20px;">

  <div class="form" style="border-top:0px;">
  <h2>'.$lang['submit-link'].'</h2>
	 <div class="formRow"> ';

 $content.='	
 <input type="text" name="link" id="link" placeholder="Youtube, Vimeo or other link"  />

</div>
 <div class="formRow"> 
   <input type="button" name="getVideo" id="getVideo" class="buttonS bBlue" value="'.$lang['submit-video'].'" />
   </div> 	 
	 </div>
</div>

';


}
$content_title = $lang['submit-video'];
include_once("tpl/header.php");
include_once("tpl/content.tpl.php");
include_once("tpl/footer.php");

?>