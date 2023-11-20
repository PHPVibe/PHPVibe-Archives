<div id="home-content" class="main-holder pad-holder span8 top10">

<?php 

$options = DB_PREFIX."videos.id,".DB_PREFIX."videos.title,".DB_PREFIX."videos.user_id,".DB_PREFIX."videos.thumb,".DB_PREFIX."videos.views,".DB_PREFIX."videos.liked,".DB_PREFIX."videos.duration,".DB_PREFIX."videos.nsfw";
$boxes = $db->get_results("SELECT * FROM ".DB_PREFIX."homepage ORDER BY `order`,`id` ASC");
if ($boxes) {
if($db->num_rows > 1) { $kill_infinite = true; }
foreach ($boxes as $box) {
$query = $box->querystring;
$c_add="";
$limit =  $box->total;
$heading = $box->title;
if(!empty($box->ident)){ $c_add ="AND category = '".intval($box->ident)."'"; }
if($query == "most_viewed"):
$vq = "select ".$options.", ".DB_PREFIX."users.name as owner FROM ".DB_PREFIX."videos LEFT JOIN ".DB_PREFIX."users ON ".DB_PREFIX."videos.user_id = ".DB_PREFIX."users.id WHERE ".DB_PREFIX."videos.views > 0 and pub > 0 $c_add ORDER BY ".DB_PREFIX."videos.views DESC ".this_offset($limit);
elseif($query == "top_rated"):
$vq = "select ".$options.", ".DB_PREFIX."users.name as owner FROM ".DB_PREFIX."videos LEFT JOIN ".DB_PREFIX."users ON ".DB_PREFIX."videos.user_id = ".DB_PREFIX."users.id WHERE ".DB_PREFIX."videos.liked > 0 and pub > 0 $c_add ORDER BY ".DB_PREFIX."videos.liked DESC ".this_offset($limit);
elseif($query == "random"):
$vq = "select ".$options.", ".DB_PREFIX."users.name as owner FROM ".DB_PREFIX."videos LEFT JOIN ".DB_PREFIX."users ON ".DB_PREFIX."videos.user_id = ".DB_PREFIX."users.id WHERE ".DB_PREFIX."videos.views >= 0 and pub > 0 $c_add ORDER BY rand() ".this_offset($limit);
elseif($query == "featured"):
$vq = "select ".$options.", ".DB_PREFIX."users.name as owner FROM ".DB_PREFIX."videos LEFT JOIN ".DB_PREFIX."users ON ".DB_PREFIX."videos.user_id = ".DB_PREFIX."users.id WHERE ".DB_PREFIX."videos.featured = '1' and pub > 0 $c_add ORDER BY ".DB_PREFIX."videos.id DESC ".this_offset($limit);
else:
$vq = "select ".$options.", ".DB_PREFIX."users.name as owner FROM ".DB_PREFIX."videos LEFT JOIN ".DB_PREFIX."users ON ".DB_PREFIX."videos.user_id = ".DB_PREFIX."users.id WHERE ".DB_PREFIX."videos.views >= 0 and pub > 0 $c_add ORDER BY ".DB_PREFIX."videos.id DESC ".this_offset($limit);
endif;
include(TPL.'/video-loop.php');

}
} else {
echo _lang('No homeblocks defined by administrator.');
}
?>
</div>
<?php if (!is_ajax_call()) { ?>
<div class="span2 right-side hidden-phone hidden-tablet top10">
<div class="full" style="position:relative">
<div class="close-me visible-phone visible-tablet hidden-desktop">
<a id="mobi-hide-right-sidebar" class="topicon tipN" href="javascript:void(0)" title="<?php echo _lang('Hide'); ?>"><i class="icon-plus"></i></a>
</div>	
	<?php if(get_option('fb-fanpage') !== '') {?>
	<ul class="statistics">
				    			<li>
				    				<div class="top-info">
					    				<a href="http://facebook.com<?php echo get_option('fb-fanpage'); ?>" title="" class="dark-blue-square"><i class="icon-facebook-sign"></i></a>
					    				<strong><?php echo _fb_count(get_option('fb-fanpage')); ?></strong>
					    			</div>
									<div class="progress progress-micro"><div class="bar" style="width: 40%;"></div></div>
									<span><?php echo _lang('Facebook fans');?></span>
				    			</li>
</ul>
								<?php } ?>
<?php $users = $db->get_results("SELECT id,name,avatar FROM ".DB_PREFIX."users order by id desc limit 0,20");
if($users) {
$fnr = $db->num_rows;
?>
<div class="box">
<div class="box-head">
<h4 class="box-heading"><?php echo _lang('New users'); ?></h4>
</div>
<div class="box-body">
<?php
if($fnr > 10) {
echo '<div class="scroll-items">';
}
foreach ($users as $user) {
echo '
<div class="populars">
<a class="tipW pull-left" title="'.$user->name.'" href="'.profile_url($user->id , $user->name).'"><img src="'.thumb_fix($user->avatar, true, 27, 27).'" alt="'.$user->name.'" /></a>
<span class="pop-title"><a title="'.$user->name.'" href="'.profile_url($user->id , $user->name).'">'._cut(stripslashes($user->name), 13).'</a></span>';
echo '
<div class="clearfix"></div>
</div>
';
}

if($fnr > 10) {
echo '</div>';
}
echo '</div>
</div>
';
}
?>								
<?php $plays = $db->get_results("SELECT id,title,picture FROM ".DB_PREFIX."playlists where id in (SELECT distinct playlist FROM ".DB_PREFIX."playlist_data)order by views desc limit 0,20");
if($plays) { 
$plnr = $db->num_rows;
?>
<div class="box" style="margin-top:10px;">
<div class="box-head">
<h4 class="box-heading"><?php echo _lang('Playlists'); ?></h4>
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
}	?>
	</div>
</div>
<?php } ?>