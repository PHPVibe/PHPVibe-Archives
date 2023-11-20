<div class="span2 top10">
<div class="module">
<h2 class="module-title">
<?php echo stripslashes(user_name());?>
</h2>
<div class="avatar">
<span class="clip">
<img src="<?php echo thumb_fix( user_avatar( ));?>" alt="<?php echo user_name();?>" />
</span>		
</div>
<div class="pull-left user-box" style="width:100%; padding:20px 2px;">
<?php subscribe_box(user_id()); ?>
<div class="clearfix"></div>
</div>
<ul>
<li> <i class="icon-plus"></i><a href="<?php echo site_url().me;?>&sk=new-playlist"><?php echo _lang('Create playlist');?></a> </li>
<li> <i class="icon-edit"></i><a href="<?php echo site_url().me;?>&sk=playlists"><?php echo _lang('Manage playlists');?></a> </li>
<li> <i class="icon-remove-circle"></i><a href="<?php echo site_url().me;?>&sk=likes"><?php echo _lang('Manage likes');?></a> </li>
<li> <i class="icon-check"></i><a href="<?php echo site_url().me;?>&sk=videos"><?php echo _lang('Manage videos');?></a> </li>
</ul>
</div>
<?php $plays = $db->get_results("SELECT * FROM ".DB_PREFIX."playlists where id= '".user_id()."' order by views desc limit 0,100");
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
<div id="profile-content" class="main-holder pad-holder span8 nomargin top20">
<?php 
$count = $db->get_row("Select count(*) as nr from ".DB_PREFIX."activity where user in (select uid from ".DB_PREFIX."users_friends where fid ='".user_id()."')");
$vq = "Select ".DB_PREFIX."activity.*, ".DB_PREFIX."users.avatar,".DB_PREFIX."users.name from ".DB_PREFIX."activity left join ".DB_PREFIX."users on ".DB_PREFIX."activity.user=".DB_PREFIX."users.id where ".DB_PREFIX."activity.user in (select uid from ".DB_PREFIX."users_friends where fid ='".user_id()."') ORDER BY ".DB_PREFIX."activity.id DESC ".this_limit();
include_once(TPL.'/layouts/global_activity.php');	
$pagestructure = canonical().'&p=';
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
<?php $populars = $db->get_results("SELECT id,avatar,name from ".DB_PREFIX."users where id not in (select uid from ".DB_PREFIX."users_friends where fid ='".user_id()."') order by rand() limit 0,4");
if($populars) {
echo '<h3>'._lang("Interesting people").'</h3>';
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