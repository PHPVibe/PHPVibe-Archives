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
<div class="span2 right-side hidden-phone hidden-tablet">
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
								

<?php $plays = $db->get_results("SELECT id,title,picture FROM ".DB_PREFIX."playlists order by views desc limit 0,20");
if($plays) { 
?>
							<div class="i-box">
	<div class="widget-head">
	<i class="icon-star"></i> <?php echo _lang('Top playlists'); ?>
	</div>
	<div class="widget-body">
	<div class="scroll-items">
	<ul>
	<?php foreach ($plays as $play) {
	echo '
	<li><a href="'.playlist_url($play->id, $play->title).'" title="'.$play->title.'">
	<img class="tiny" src="'.thumb_fix($play->picture).'"> 	'._cut(stripslashes($play->title), 20).'</a> <a class="pull-right tipS" title="'._lang("Play all").'" href="'.site_url().'forward/'.$play->id.'/"><i class="icon-forward" style="margin-right:7px;"></i></a></li>
	
	';
	
	}
	
	?>
	</ul>
	</div>
	</div>
	</div>
	<?php } ?>
	<?php $users = $db->get_results("SELECT id,name,avatar FROM ".DB_PREFIX."users order by id desc limit 0,20");
if($users) { 
?>
<div class="i-box" style="margin-top:20px;">
	<div class="widget-head">
	<i class="icon-group"></i> <?php echo _lang('Newest users'); ?>
	</div>
	<div class="widget-body">
	<div class="scroll-items">
	<ul>
	<?php foreach ($users as $user) {
	echo '
	<li><a href="'.profile_url($user->id, $user->name).'" title="'.$user->name.'"><img class="tiny" src="'.thumb_fix($user->avatar).'">
	'._cut(stripslashes($user->name), 20).'</a></li>
	
	';
	
	}
	
	?>
	</ul>
	</div>
	</div>
	</div>
	<?php } ?>
	</div>
</div>
<?php } ?>