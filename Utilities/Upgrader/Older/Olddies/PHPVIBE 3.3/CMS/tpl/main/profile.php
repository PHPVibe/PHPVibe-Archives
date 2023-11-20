<div class="span2 top10">
<div class="module">
<h2 class="module-title">
<?php echo stripslashes($profile->name);?>
</h2>
<div class="avatar">
<span class="clip">
<img src="<?php echo thumb_fix($profile->avatar);?>" alt="<?php echo $profile->name;?>" />
</span>		
</div>
<div class="pull-left user-box" style="width:100%; padding:20px 2px;">
<?php subscribe_box($profile->id); ?>
<div class="clearfix"></div>
</div>
<ul>
<?php if($profile->country) { ?> <li> <i class="icon-map-marker"></i><?php echo stripslashes($profile->local);?>, <?php echo stripslashes($profile->country);?> </li><?php } ?>
<?php if($profile->bio) { ?><li> <i class="icon-info-sign"></i><?php echo stripslashes($profile->bio);?> </li><?php } ?>
</ul>
</div>
<?php $plays = $db->get_results("SELECT * FROM ".DB_PREFIX."playlists where owner= '".$profile->id."' order by views desc limit 0,100");
if($plays) { 
$p_cs = ''; //Dun add scroll
if($db->num_rows > 10) {$p_cs ='scroll-items'; /*Add scroll if more than 10 */}
?>
							<div class="i-box">
	<div class="widget-head">
	<?php echo _lang('Playlists'); ?>
	</div>
	<div class="widget-body">
	<div class="<?php echo $p_cs; ?>">
	<ul>
	<?php foreach ($plays as $play) {
	echo '
	<li><a href="'.playlist_url($play->id, $play->title).'" title="'.$play->title.'"><img class="tiny" src="'.thumb_fix($play->picture).'">
	'._cut(stripslashes($play->title), 20).'</a></li>
	
	';
	
	}
	
	?>
	</ul>
	</div>
	</div>
	</div>
	<?php }	?>
</div>
<div id="profile-content" class="main-holder pad-holder span8 nomargin top10">
<ul class="nav nav-tabs">
<li <?php if(!_get('sk')) {echo 'class="active"'; }?>><a href="<?php echo $canonical;?>"><?php echo _lang('Videos');?></a> </li>
<li <?php if(_get('sk') == "likes") {echo 'class="active"'; }?>><a href="<?php echo $canonical;?>&sk=likes"><?php echo _lang('Likes');?></a></li>
<li <?php if(_get('sk') == "subscribers") {echo 'class="active"'; }?>><a href="<?php echo $canonical;?>&sk=subscribers"><?php echo _lang('Subscribers');?></a></li>
<li <?php if(_get('sk') == "subscribed") {echo 'class="active"'; }?>><a href="<?php echo $canonical;?>&sk=subscribed"><?php echo _lang('Subscribed to');?></a></li>
<?php if (get_option('video-coms') <> 1) {?>
<li <?php if(_get('sk') == "social") {echo 'class="active"'; }?>><a href="<?php echo $canonical;?>&sk=social"><?php echo _lang('Buzz');?></a></li>
<?php } ?>
</ul>
<?php 
switch(_get('sk')){
case 'likes':
$count = $db->get_row("Select count(*) as nr from ".DB_PREFIX."videos where ".DB_PREFIX."videos.id in ( select vid from ".DB_PREFIX."likes where uid ='".$profile->id."')");
$vq = "select id,title,thumb, views, liked, duration from ".DB_PREFIX."videos where ".DB_PREFIX."videos.id in ( select vid from ".DB_PREFIX."likes where uid ='".$profile->id."') ORDER BY ".DB_PREFIX."videos.id DESC ".this_limit();
include_once(TPL.'/profile/videoloop.php');	
$pagestructure = $canonical.'&sk=likes&p=';
		break;
case 'subscribed':
$count = $db->get_row("Select count(*) as nr from ".DB_PREFIX."users where ".DB_PREFIX."users.id in ( select uid from ".DB_PREFIX."users_friends where fid ='".$profile->id."')");
$vq = "select id,avatar,name from ".DB_PREFIX."users where ".DB_PREFIX."users.id in ( select uid from ".DB_PREFIX."users_friends where fid ='".$profile->id."') ORDER BY ".DB_PREFIX."users.views DESC ".this_limit();include_once(TPL.'/profile/users.php');	
$pagestructure = $canonical.'&sk=subscribed&p=';	
	break;
case 'subscribers':
$count = $db->get_row("Select count(*) as nr from ".DB_PREFIX."users where ".DB_PREFIX."users.id in ( select fid from ".DB_PREFIX."users_friends where uid ='".$profile->id."')");
$vq = "select id,avatar,name from ".DB_PREFIX."users where ".DB_PREFIX."users.id in ( select fid from ".DB_PREFIX."users_friends where uid ='".$profile->id."') ORDER BY ".DB_PREFIX."users.views DESC ".this_limit();
include_once(TPL.'/profile/users.php');	
$pagestructure = $canonical.'&sk=subscribers&p=';
		break;	
case 'social':
$count = $db->get_row("Select count(*) as nr from ".DB_PREFIX."activity where user='".$profile->id."'");
$vq = "Select * from ".DB_PREFIX."activity where user='".$profile->id."' ORDER BY id DESC ".this_limit();
include_once(TPL.'/profile/activity.php');	
$pagestructure = $canonical.'&sk=social&p=';
		break;			
default:
$count = $db->get_row("Select count(*) as nr from ".DB_PREFIX."videos where user_id ='".$profile->id."'");

$vq = "select id,title,thumb, views, liked, duration from ".DB_PREFIX."videos where user_id ='".$profile->id."' and pub > 0 ORDER BY ".DB_PREFIX."videos.id DESC ".this_limit();
include_once(TPL.'/profile/videoloop.php');
$pagestructure = $canonical.'&p=';
		break;	
}
$a = new pagination;	
$a->set_current(this_page());
$a->set_first_page(true);
$a->set_pages_items(7);
$a->set_per_page(bpp());
$a->set_values($count->nr);
$a->show_pages($pagestructure);

?>
</div>
<div class="span2 nomargin popular-channels">
<?php $populars = $db->get_results("SELECT id,avatar,name from ".DB_PREFIX."users order by views desc limit 0,10");
if($populars) {
echo '<h3>'._lang("Popular channels").'</h3>';
foreach ($populars as $popular) {
echo '
<div class="populars">
<a class="tipE pull-left" title="'.$popular->name.'" href="'.profile_url($popular->id , $popular->name).'"><img src="'.thumb_fix($popular->avatar).'" alt="'.$popular->name.'" /></a>
<span class="pop-title"><a title="'.$popular->name.'" href="'.profile_url($popular->id , $popular->name).'">'._cut(stripslashes($popular->name), 16).'</a></span><div class="pop-subs">';
subscribe_box($popular->id,"btn btn-small", false);
echo '<div class="clearfix"></div>
</div>
<div class="clearfix"></div>
</div>';
}
}
?>
</div>