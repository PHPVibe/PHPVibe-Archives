<?php //echo $vq;
$videos = $db->get_results($vq);
if ($videos) {
echo '<div class="loop-content phpvibe-video-list">'; 


foreach ($videos as $video) {
			$title = stripslashes(_cut($video->title, 46));
			$full_title = stripslashes(str_replace("\"", "",$video->title));			
			$url = video_url($video->id , $video->title);
			
		
echo '
<div id="video-'.$video->id.'" class="video">
<div class="video-thumb">
		<a class="clip-link" data-id="'.$video->id.'" title="'.$full_title.'" href="'.$url.'">
			<span class="clip">
				<img src="'.$video->thumb.'" alt="'.$full_title.'" /><span class="vertical-align"></span>
			</span>
							
			<span class="overlay"></span>
		</a>
		 <span class="timer">'.video_time($video->duration).'</span>
	</div>	
	<div class="video-data">
	<h4 class="video-title"><a href="'.$url.'" title="'.$full_title.'">'.$title.'</a></h4>					
</div>	
	</div>
';
}
echo '<br style="clear:both;"/></div>';
}
?>