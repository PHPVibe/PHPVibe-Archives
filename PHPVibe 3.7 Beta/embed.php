<?php error_reporting(E_ALL);
require_once('load.php' );

$v_id = intval(_get('id'));
//Global video weight & height
$width = get_option('video-width');  $height = get_option('video-height'); $embedCode = '';
if($v_id > 0) { 
//use the same cache as per page
$cache_name = "video-".$v_id;
$video = $cachedb->get_row("SELECT ".DB_PREFIX."videos.*, ".DB_PREFIX."channels.cat_name as channel_name ,".DB_PREFIX."users.avatar, ".DB_PREFIX."users.name as owner, ".DB_PREFIX."users.avatar FROM ".DB_PREFIX."videos 
LEFT JOIN ".DB_PREFIX."channels ON ".DB_PREFIX."videos.category =".DB_PREFIX."channels.cat_id LEFT JOIN ".DB_PREFIX."users ON ".DB_PREFIX."videos.user_id = ".DB_PREFIX."users.id WHERE ".DB_PREFIX."videos.`id` = '".$v_id."' limit 0,1");
unset($cache_name);
if($video) {
//Player support
//JwPlayer
			 
add_filter( 'addplayers', 'jwplayersup' );  

//FlowPlayer
if((get_option('remote-player',1) == 2) || (get_option('choosen-player',1) == 2))	{					 
add_filter( 'addplayers', 'flowsup' );  
}
//jPlayer
if((get_option('remote-player',1) == 3) || (get_option('choosen-player',1) == 3))	{					 
add_filter( 'addplayers', 'jpsup' );  
}
//Check if it's processing
if(empty($video->source) && empty($video->embed) && empty($video->remote)) {
 $embedvideo = '<img src="'.site_url().'uploads/processing.png"/>';
} else {
//See what embed method to use
if($video->remote) {
	//Check if video is remote/link
   $vid = new Vibe_Providers($width, $height);    $embedvideo = $vid->remotevideo($video->remote);
   } elseif($video->embed) {
   //Check if has embed code
	$embedvideo	=  render_video(stripslashes($video->embed));
   } else {
   //Embed from external video url
   $vid = new Vibe_Providers($width, $height);    $embedvideo = $vid->getEmbedCode($video->source);
   }
 }  
 //Print iframe content
 echo '<!DOCTYPE html>  <html lang="en" dir="ltr"  data-cast-api-enabled="true">
<head>
<title>'._html($video->title).' - '.get_option('site-logo-text').'</title>
<link rel="canonical" href="'.video_url($video->id , $video->title).'">
<style>
.jwmain .jwvideo{z-index:11;}
.jwmain .jwcontrols{z-index:12;}
.flowplayer {   background-color: #333; }
.flowplayer .fp-engine, .flowplayer .fp-ui, .flowplayer .fp-message {z-index:150!important;}
.flowplayer.is-splash, .flowplayer.is-poster { cursor: pointer; background-position: center top;     background-size: 100% auto;}
.video-player iframe,.video-player object,.video-player embed,.video-player video{z-index:150!important; position:absolute;top:0;left:0;width:100% !important;height:100% !important;clear:both}
</style>
<link rel="stylesheet" href="'.site_url().'lib/players/ads.jplayer.css"/>
<script type="text/javascript">
if (typeof jQuery == \'undefined\') {
 document.write(\'<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"><\/script>\');
}
</script>
'.players_js();
 echo '</head>
<body dir="ltr">
<div class="video-player">
';
//Print the embed code
echo  $embedvideo;
echo '
</div>
</body>
</html>
';
} else {
//No video
echo _lang("Video was removed.");
}

}
?>