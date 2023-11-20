<?php
$list = intval(_get('list'));
$options = DB_PREFIX."videos.id as vid,".DB_PREFIX."videos.title,".DB_PREFIX."videos.user_id as owner, ".DB_PREFIX."videos.thumb,".DB_PREFIX."videos.views,".DB_PREFIX."videos.liked,".DB_PREFIX."videos.duration,".DB_PREFIX."videos.nsfw";
$result =$db->get_results("select ".$options.", ".DB_PREFIX."users.name as name FROM ".DB_PREFIX."videos LEFT JOIN ".DB_PREFIX."users ON ".DB_PREFIX."videos.user_id = ".DB_PREFIX."users.id WHERE ".DB_PREFIX."videos.id in (SELECT ".DB_PREFIX."playlist_data.video_id from ".DB_PREFIX."playlist_data where playlist='".$list."') ORDER BY ".DB_PREFIX."videos.id DESC ".this_offset(get_option('related-nr')));

 if ($result) {
	foreach ($result as $related) {
		
echo '
					<li data-id="'.$related->vid.'" class="item-post">
				<div class="inner">
					
	<div class="thumb">
		<a class="clip-link" data-id="'.$related->vid.'" title="'.stripslashes($related->title).'" href="'.video_url($related->vid , $related->title, $list).'">
			<span class="clip">
				<img src="'.thumb_fix($related->thumb).'" alt="'.stripslashes($related->title).'" /><span class="vertical-align"></span>
			</span>
		<span class="timer">'.video_time($related->duration).'</span>					
			<span class="overlay"></span>
		</a>
	</div>			
					<div class="data">
						<span class="title"><a href="'.video_url($related->vid , $related->title, $list).'" rel="bookmark" title="'.stripslashes($related->title).'">'._cut(stripslashes($related->title),54 ).'</a></span>
			
						<span class="usermeta">
							'._lang('by').' <a href="'.profile_url($related->owner, $related->name).'"> '.stripslashes($related->name).' </a></span>
						</span>
					</div>
				</div>
				</li>
		
	';
	}
}

?>