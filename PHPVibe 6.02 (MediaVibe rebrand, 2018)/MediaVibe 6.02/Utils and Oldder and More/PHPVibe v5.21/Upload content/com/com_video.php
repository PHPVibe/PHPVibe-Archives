<?php $v_id = token_id();
if(_get('nsfw') == 1) { $_SESSION['nsfw'] = 1; }
//Global video weight & height
$width = get_option('video-width');  
$height = get_option('video-height'); 
$embedCode = '';
//Query this video
if(intval($v_id) > 0) { 
$cache_name = "video-".$v_id;
$video = $cachedb->get_row("SELECT ".DB_PREFIX."videos.*, ".DB_PREFIX."channels.cat_name as channel_name ,".DB_PREFIX."users.avatar, ".DB_PREFIX."users.name as owner, ".DB_PREFIX."users.avatar FROM ".DB_PREFIX."videos 
LEFT JOIN ".DB_PREFIX."channels ON ".DB_PREFIX."videos.category =".DB_PREFIX."channels.cat_id LEFT JOIN ".DB_PREFIX."users ON ".DB_PREFIX."videos.user_id = ".DB_PREFIX."users.id WHERE ".DB_PREFIX."videos.`id` = '".$v_id."' limit 0,1");
$cache_name = null; //reset 
$is_owner = false;
if ($video) {
if(is_user()) {
/* Check if current user is the owner */	
if($video->user_id == user_id()){
$is_owner = true;
}	
}
// Canonical url
$canonical = video_url($video->id , $video->title); 
//Check for local thumbs
$video->thumb = thumb_fix($video->thumb);

//Check if it's private 
if((($video->privacy == 1) || $video->private == 1 ) && !im_following($video->user_id)) {
//Video is not public
$embedvideo = '<div class="vprocessing">
<div class="vpre">'._lang("This video is for subscribers only!").'</div> 
<div class="vex"><a href="'.profile_url($video->user_id,$video->owner).'">'._lang("Please subscribe to ").' '.$video->owner.' '._lang("to see this video").'</a>
</div>
</div>';

//Check if it's processing
}elseif(empty($video->source) && empty($video->embed) && empty($video->remote)) {
 $embedvideo = '<div class="vprocessing"><div class="vpre">'._lang("This video is being processed").'</div>
 <div class="vex">'._lang("Please check back in a few minutes.").'</div></div>';
} else {
//See what embed method to use
if($video->remote) {
	//Check if video is remote/link
   $vid = new Vibe_Providers($width, $height);    $embedvideo = $vid->remotevideo($video->remote);
   $origin = 1;
   } elseif($video->embed) {
   //Check if has embed code
	$embedvideo	=  render_video(stripslashes($video->embed));
	$origin = 2;
   } else {
   //Embed from video providers
   $vid = new Vibe_Providers($width, $height);    $embedvideo = $vid->getEmbedCode($video->source);
   $origin = 0;
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
add_filter( 'addplayers', 'jpsup' );  

//VideoJS
if((get_option('remote-player',1) == 6) || (get_option('choosen-player',1) == 6)|| (get_option('youtube-player',1) == 6))	{					 
add_filter( 'addplayers', 'vjsup' );  
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
if($video->liked < 0) {$video->liked = 0;}
if($video->liked < 0) {$video->disliked = 0;}
$likes_percent =  percent($video->liked, $video->liked + $video->disliked);
$dislikes_percent = ($likes_percent > 0 || $video->disliked > 0)? 100 - $likes_percent : 0;

//Time for design
 the_header();
include_once(TPL.'/video.php');	 
 the_footer();
 } else {
//Oups, not found
layout('404');
}
}else {
//Oups, not found
layout('404');
}
?>