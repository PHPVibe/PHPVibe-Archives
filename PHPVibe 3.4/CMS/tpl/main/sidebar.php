<div id="sidebar-wrapper" class="span2 left-sidebar top10 hidden-phone hidden-tablet">
<div id="sidebar"> 
<div class="close-me visible-phone visible-tablet hidden-desktop">
<a id="mobi-hide-sidebar" class="topicon tipN" href="javascript:void(0)" title="<?php echo _lang('Hide'); ?>"><i class="icon-plus"></i></a>
</div>
<?php /* The video lists */
echo '<div class="box"> 
	<div class="box-body list">	
	<ul>
	<li><i class="icon-bullhorn"></i><a href="'.list_url(browse).'" title="'._lang('Browse').'"> '._lang('Browse').'</a></li>
	<li><i class="icon-list-ol"></i><a href="'.list_url(mostviewed).'" title="'._lang('Most Viewed').'"> '._lang('Most Viewed').'</a></li>
	<li><i class="icon-check"></i><a href="'.list_url(promoted).'" title="'._lang('Featured').'"> '._lang('Featured').'</a></li>
	<li><i class="icon-heart"></i><a href="'.list_url(mostliked).'" title="'._lang('Most Liked').'"> '._lang('Most Liked').'</a></li>	
	
    </ul>   
    </div>
    </div>';

if (is_user()) {
/* start my  subscriptions */ 
$followings = $db->get_results("SELECT id,avatar,name,lastlogin from ".DB_PREFIX."users where id in (select uid from ".DB_PREFIX."users_friends where fid ='".user_id()."') order by lastlogin desc limit 0,15");
if($followings) {
$snr = $db->num_rows;
?>

<div class="box">
<div class="box-head">
<h4 class="box-heading"><?php echo _lang('My subscriptions'); ?></h4><a class="pull-right" href="<?php echo profile_url(user_id(), user_name()); ?>&sk=subscribed"><?php echo _("View all"); ?></a>
</div>
<div class="box-body">
<?php
if($snr > 10) {
echo '<div class="scroll-items">';
}
foreach ($followings as $following) {
echo '
<div class="populars">
<a class="tipW pull-left" title="'.$following->name.'" href="'.profile_url($following->id , $following->name).'"><img src="'.thumb_fix($following->avatar, true, 27, 27).'" alt="'.$following->name.'" /></a>
<span class="pop-title"><a title="'.$following->name.'" href="'.profile_url($following->id , $following->name).'">'._cut(stripslashes($following->name), 13).'</a></span>';
if(date('d-m-Y', strtotime($following->lastlogin)) != date('d-m-Y')) {
echo '<i class="icon-circle offline pull-right"></i>';
} else {
echo '<i class="icon-circle online pull-right"></i>';
}
echo '
<div class="clearfix"></div>
</div>';
}
if($snr > 10) {
echo '</div>';
}
echo '</div>
</div>
';
}
/* end subscriptions */
/* start my playlists */	
$plays = $db->get_results("SELECT * FROM ".DB_PREFIX."playlists where owner= '".user_id()."' order by views desc limit 0,100");
if($plays) { 
$plnr = $db->num_rows;
?>
<div class="box">
<div class="box-head">
<h4 class="box-heading"><?php echo _lang('My Playlists'); ?></h4>
</div>
<div class="box-body">
<?php 
if($plnr > 10) {
echo '<div class="scroll-items">';
}
foreach ($plays as $play) {
echo '<div class="populars">
<a class="tipW pull-left" href="'.playlist_url($play->id, $play->title).'" original-title="'.$play->title.'" title="'.$play->title.'"><img src="'.thumb_fix($play->picture, true, 27, 27).'"></a>
<span class="pop-title"><a title="'.$play->title.'" href="'.playlist_url($play->id, $play->title).'">'._cut(stripslashes($play->title), 20).'</a></span>
<div class="clearfix"></div>
</div>';
}
if($plnr > 10) {
echo '</div>';
}
echo '</div>
</div>';
}	
/* end my playlists */	
} else { 
/*If guest, show some statistics*/
?>

<ul class="statistics">
				    			<li>
				    				<div class="top-info">
					    				<a href="#" title="" class="blue-square"><i class="icon-film"></i></a>
					    				<strong><?php echo _count('videos'); ?></strong>
					    			</div>
									<div class="progress progress-micro"><div class="bar" style="width: 40%;"></div></div>
									<span><?php echo _lang('Videos');?></span>
				    			</li>
								<li>
				    				<div class="top-info">
					    				<a href="#" title="" class="sea-square"><i class="icon-group"></i></a>
					    				<strong><?php echo _count('users'); ?></strong>
					    			</div>
									<div class="progress progress-micro"><div class="bar" style="width: 40%;"></div></div>
									<span><?php echo _lang('Members');?></span>
				    			</li>
				    			<li>
				    				<div class="top-info">
					    				<a href="#" title="" class="red-square"><i class="icon-eye-open"></i></a>
					    				<strong><?php echo _count('videos','views',true ); ?></strong>
					    			</div>
									<div class="progress progress-micro"><div class="bar" style="width: 40%;"></div></div>
									<span><?php echo _lang('Video views');?></span>
				    			</li>
				    			<li>
				    				<div class="top-info">
					    				<a href="#" title="" class="green-square"><i class="icon-ok"></i></a>
					    				<strong><?php echo _count('likes' ); ?></strong>
					    			</div>
									<div class="progress progress-micro"><div class="bar" style="width: 40%;"></div></div>
									<span><?php echo _lang('Video likes');?></span>
				    			</li>
				    			<li>
				    				<div class="top-info">
					    				<a href="#" title="" class="purple-square"><i class="icon-fast-forward"></i></a>
					    				<strong><?php echo _count('playlists' ); ?></strong>
					    			</div>
									<div class="progress progress-micro"><div class="bar" style="width: 40%;"></div></div>
									<span><?php echo _lang('Playlists');?></span>
				    			</li>
							
				    		</ul>

<?php } 
$pagesx = $db->get_results("select title,pid,pic from ".DB_PREFIX."pages WHERE menu = '1' ORDER BY title ASC ".this_limit()."");
 /* The video lists */
 if($pagesx) {
echo '<div class="box"> 
<div class="box-head">
<h4 class="box-heading">'._lang('Information').'</h4>
</div>
	<div class="box-body list">	
	<ul>';
	foreach ($pagesx as $px) {
echo '<li><i class="icon-copy"></i><a href="'.page_url($px->pid, $px->title).'" title="'._html($px->title).'"> '._html($px->title).'</a></li>';

	
	}

  echo '  </ul>   
    </div>
    </div>';
}
?>
</div>
</div>