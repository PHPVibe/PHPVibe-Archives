<?php
 $result = $cachedb->get_results("SELECT ".DB_PREFIX."videos.title,".DB_PREFIX."videos.id as vid,".DB_PREFIX."videos.thumb, ".DB_PREFIX."videos.views,".DB_PREFIX."videos.duration,".DB_PREFIX."users.name, ".DB_PREFIX."users.id as owner FROM ".DB_PREFIX."videos LEFT JOIN ".DB_PREFIX."users ON ".DB_PREFIX."videos.user_id = ".DB_PREFIX."users.id where ".DB_PREFIX."videos.category ='".$video->category."' and ".DB_PREFIX."videos.pub > 0  ORDER BY ".DB_PREFIX."videos.id DESC limit 0,".get_option('related-nr')." ");
if ($result) {
	foreach ($result as $related) {
	$duration = ($related->duration > 0) ? video_time($related->duration) : '<i class="icon-picture"></i>';
		
echo '
					<li data-id="'.$related->vid.'" class="item-post">
				<div class="inner">
					
	<div class="thumb">
		<a class="clip-link" data-id="'.$related->vid.'" title="'._html($related->title).'" href="'.video_url($related->vid , $related->title).'">
			<span class="clip">
				<img src="'.thumb_fix($related->thumb, true, 100, 64).'" alt="'._html($related->title).'" /><span class="vertical-align"></span>
			</span>
		<span class="timer">'.$duration.'</span>					
			<span class="overlay"></span>
		</a>
	</div>			
					<div class="data">
						<span class="title"><a href="'.video_url($related->vid , $related->title).'" rel="bookmark" title="'._html($related->title).'">'._cut(_html($related->title),154 ).'</a></span>
			
						<span class="usermeta">
							'._lang('by').' <a href="'.profile_url($related->owner, $related->name).'"> '._html($related->name).' </a>
							<p>'.$related->views.' '._lang('views').'</p>
						</span>
					</div>
				</div>
				</li>
		
	';
	}
}

?>