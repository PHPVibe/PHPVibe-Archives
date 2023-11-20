<?php //echo $vq;
$videos = $db->get_results($vq);
if(isset($heading) && !empty($heading)) { echo '<h3 class="loop-heading"><span>'.stripslashes($heading).'</span></h3>';}
if(isset($heading_meta) && !empty($heading_meta)) { echo $heading_meta;}
if ($videos) {

echo '<div class="loop-content phpvibe-video-list">'; 
foreach ($videos as $video) {
			$title = stripslashes(_cut($video->title, 50));
			$full_title = stripslashes(str_replace("\"", "",$video->title));			
			$url = video_url($video->id , $video->title);
echo '
<div id="video-'.$video->id.'" class="video">
<div class="video-thumb">
		<a class="clip-link" data-id="'.$video->id.'" title="'.$full_title.'" href="'.$url.'">
			<span class="clip">
				<img src="'.thumb_fix($video->thumb, true, get_option('thumb-width'), get_option('thumb-height')).'" alt="'.$full_title.'" /><span class="vertical-align"></span>
			</span>
          	<span class="overlay"></span>
		</a>';
if($video->duration > 0) { echo '   <span class="timer">'.video_time($video->duration).'</span>'; }
echo '</div>	
<div class="video-data">
	<h4 class="video-title"><a href="'.$url.'" title="'.$full_title.'">'._html($title).'</a></h4>						
	<p class="stats">
		'._lang("by").' <a href="'.profile_url($video->user_id, $video->owner).'" title="'.$video->owner.'">'.$video->owner.'</a> <span class="pull-right">'.$video->views.' '._lang('views').'</span>
	</p>
</div>	
	</div>
';
}
/* Kill for home if several blocks */
if(!isset($kill_infinite) || !$kill_infinite) { echo '<nav id="page_nav"><a href="'.$canonical.'&ajax&p='.next_page().'"></a></nav>'; }
echo ' <br style="clear:both;"/></div>';
} else {
echo _lang('Sorry but there are no results.');
}
?>