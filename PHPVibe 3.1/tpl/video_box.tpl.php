<?php if(!empty($box_title)) { echo '<div class="block_title"><h2>'.stripslashes($box_title).'</h2></div>';}
if (empty($row["box"])){
echo '<div class="loop-content switchable-view boxed-small" data-view="boxed-small">'; } else {
echo '<div class="loop-content switchable-view '.$row["box"].'" data-view="'.$row["box"].'">'; 
}

if ($cboxes = $dbi->query($vbox_result, 0)) {
foreach ($cboxes as $video) {
			$title = stripslashes(substr($video["title"], 0, 29));
			$full_title = stripslashes(str_replace("\"", "",$video["title"]));			
			$url = $site_url.'video/'.$video["id"].'/'.seo_clean_url($full_title) .'/';
			
		
echo '
<div id="video-'.$video["id"].'" class="video">
<div class="thumb">
		<a class="clip-link" data-id="'.$video["id"].'" title="'.$full_title.'" href="'.$url.'">
			<span class="clip">
				<img src="'.$video["thumb"].'" alt="'.$full_title.'" /><span class="vertical-align"></span>
			</span>
							
			<span class="overlay"></span>
		</a>
		 <span class="timer">'.sec2hms($video["duration"]).'</span>
	</div>	
	<div class="data">
			<h2 class="title"><a href="'.$url.'" title="'.$full_title.'">'.$title.'</a></h2>						
			<p class="stats"><span class="views"><i class="count">'.$video["views"].'</i> </span><span class="likes"><i class="count">'.$video["liked"].'</i></span></p>

		</div>	
	</div>
';
}
}
$dbi->disconnect();
echo '<br style="clear:both;"/></div>';
?>