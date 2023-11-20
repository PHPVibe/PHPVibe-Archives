<?php error_reporting(E_ALL);
// physical path of your root
if( !defined( 'ABSPATH' ) )
	define( 'ABSPATH', str_replace( '\\', '/',  dirname( __FILE__ ) )  );

// physical path of includes directory
if( !defined( 'INC' ) )
	define( 'INC', ABSPATH.'/lib' );
// physical path of theme
if( !defined( 'THEME' ) )
	define( 'THEME', 'main' );	
// physical path of themes directory
if( !defined( 'TPL' ) )
	define( 'TPL', ABSPATH.'/tpl/'.THEME);	
// security
if( !defined( 'in_phpvibe' ) )
	define( 'in_phpvibe', true);
//Include config 
require_once( ABSPATH.'/vibe_config.php' );
//Call database classes
require_once( INC.'/ez_sql_core.php' );
require_once( INC.'/class.ezsql.php' );
//Define cache class from db (all queryes runed will be cached)
$cachedb = new ezSQL_mysql(DB_USER,DB_PASS,DB_NAME,DB_HOST,'utf8');
$cachedb->cache_timeout = 2; //Note: this is hours
$cachedb->cache_dir = ABSPATH.'/cache';
$cachedb->use_disk_cache = true;
$cachedb->cache_queries = true;
// Include all global functions
require_once( INC.'/functions.plugins.php' );
require_once( INC.'/functions.php' );
require_once( INC.'/functions.user.php' );
require_once( INC.'/functions.html.php' );
require_once( INC.'/functions.kses.php' );
require_once( INC.'/class.providers.php' );
//Get all global site options
$all_options = get_all_options();

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
</head>
<body dir="ltr">
';
//Print the embed code
echo  $embedvideo;
echo '</body>
</html>
';
} else {
//No video
echo _lang("Video was removed.");
}

}
?>