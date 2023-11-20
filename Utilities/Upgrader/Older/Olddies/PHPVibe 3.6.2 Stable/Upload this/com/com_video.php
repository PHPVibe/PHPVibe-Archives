<?php $v_id = token_id();

if(_get('nsfw') == 1) { $_SESSION['nsfw'] = 1; }
//Global video weight & height
$width = get_option('video-width');  $height = get_option('video-height'); $embedCode = '';
//Query this video
if($v_id > 0) { 
$cache_name = "video-".$v_id;
$video = $cachedb->get_row("SELECT ".DB_PREFIX."videos.*, ".DB_PREFIX."channels.cat_name as channel_name ,".DB_PREFIX."users.avatar, ".DB_PREFIX."users.name as owner, ".DB_PREFIX."users.avatar FROM ".DB_PREFIX."videos 
LEFT JOIN ".DB_PREFIX."channels ON ".DB_PREFIX."videos.category =".DB_PREFIX."channels.cat_id LEFT JOIN ".DB_PREFIX."users ON ".DB_PREFIX."videos.user_id = ".DB_PREFIX."users.id WHERE ".DB_PREFIX."videos.`id` = '".$v_id."' limit 0,1");
unset($cache_name);
if ($video) {
// Canonical url
$canonical = video_url($video->id , $video->title); 
//Check for local thumbs
$video->thumb = thumb_fix($video->thumb);

//Check if it's private 
if(($video->privacy == 1) && !is_user()) {
//Video is not public
$embedvideo = '<div class="wpublic">'._lang("This video is not public!").' <a href="'.site_url().'login">'._lang("Please login or register to watch it").'</a></div>';

//Check if it's processing
}elseif(empty($video->source) && empty($video->embed) && empty($video->remote)) {
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
 if (nsfilter()) { 
$embedvideo	.='<div class="nsfw-warn"><span>'._lang("This video is not safe").'</span>
<a href="'.$canonical.'&nsfw=1">'.("I understand and I am over 18").'</a><a href="'.site_url().'">'._lang("I am under 18").'</a>
</div>';
} 
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

// SEO Filters
function modify_title( $text ) {
global $video;
    return strip_tags(_html(get_option('seo-video-pre','').$video->title.get_option('seo-video-post','')));
}
function modify_desc( $text ) {
global $video;
    return _cut(strip_tags(_html($video->description)), 160);
}
add_filter( 'phpvibe_title', 'modify_title' );
add_filter( 'phpvibe_desc', 'modify_desc' );
// Percentages of likes/dis
$likes_percent =  percent($video->liked, $video->liked + $video->disliked);
$dislikes_percent = ($likes_percent > 0 || $video->disliked > 0)? 100 - $likes_percent : 0;

//Time for design
 the_header();
include_once(TPL.'/video.php');
 the_footer();
 
//Track this view
 if(is_user()) {
 /* Look if he's watched it before*/
  if(!has_activity('3', $video->id)) {
 $db->query("UPDATE ".DB_PREFIX."videos SET views = views+1 WHERE id = '".$video->id."'");
 add_activity('3', $video->id);
 }
 } else {
 /* Track visitors trough a session */
 $track_it = true; /* Start with positive */
 
 if(isset($_SESSION['seen']) && !empty($_SESSION['seen'])) {
$watched_list = (array) explode(',', $_SESSION['seen']);
if ( in_array($video->id, $watched_list)) 	{  $track_it = false; /* Seen before */ }
}
if($track_it){
/* Add to session and update views count */
$_SESSION['seen'] = $video->id;
$db->query("UPDATE ".DB_PREFIX."videos SET views = views+1 WHERE id = '".$video->id."'");
}
//End visitor
}
//End tracking

} else {
//Oups, not found
layout('404');
}
}else {
//Oups, not found
layout('404');
}
?>