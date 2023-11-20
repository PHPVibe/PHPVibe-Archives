<div id="channel-content" class="main-holder pad-holder span10 top10 nomargin">
<?php 
$heading = $channel->cat_name;
$options = DB_PREFIX."videos.id,".DB_PREFIX."videos.title,".DB_PREFIX."videos.user_id,".DB_PREFIX."videos.thumb,".DB_PREFIX."videos.views,".DB_PREFIX."videos.liked,".DB_PREFIX."videos.duration,".DB_PREFIX."videos.nsfw";
$vq = "select ".$options.", ".DB_PREFIX."users.name as owner FROM ".DB_PREFIX."videos LEFT JOIN ".DB_PREFIX."users ON ".DB_PREFIX."videos.user_id = ".DB_PREFIX."users.id WHERE ".DB_PREFIX."videos.category in (SELECT cat_id from ".DB_PREFIX."channels where cat_id = '".$channel->cat_id."' or child_of = '".$channel->cat_id."' ) and ".DB_PREFIX."videos.pub > 0 ORDER BY ".DB_PREFIX."videos.id DESC ".this_offset(bpp());
include_once(TPL.'/video-loop.php');
?>
</div>