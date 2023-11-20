<div id="playlist-content" class="main-holder pad-holder span10 top10 nomargin">
<?php 
$heading = '';
$heading_meta = '';
$heading_meta .= '
<div class="hcontainer">
<img class="pic" src="'.thumb_fix($playlist->picture, true, 60, 60).'" />
<div class="hmeta">
<span class="arrow"></span>
<div class="body">
<h1>'._html($playlist->title).'</h1>
'._html($playlist->description).'
<a class="btn btn-info pull-right tipN" title="'._lang("Play all").'" href="'.site_url().'forward/'.$playlist->id.'/"><i class="icon-forward" style="margin-right:3px;"></i>'._lang("Play all").'</a>
</div>
</div>
<div class="clearfix"></div>
</div>
';

$options = DB_PREFIX."videos.id,".DB_PREFIX."videos.title,".DB_PREFIX."videos.user_id,".DB_PREFIX."videos.thumb,".DB_PREFIX."videos.views,".DB_PREFIX."videos.liked,".DB_PREFIX."videos.duration,".DB_PREFIX."videos.nsfw";
$vq = "select ".$options.", ".DB_PREFIX."users.name as owner FROM ".DB_PREFIX."videos LEFT JOIN ".DB_PREFIX."users ON ".DB_PREFIX."videos.user_id = ".DB_PREFIX."users.id WHERE ".DB_PREFIX."videos.id in (SELECT ".DB_PREFIX."playlist_data.video_id from ".DB_PREFIX."playlist_data where playlist='".$playlist->id."') ORDER BY ".DB_PREFIX."videos.id DESC ".this_offset(bpp());
include_once(TPL.'/video-loop.php');
?>
</div>