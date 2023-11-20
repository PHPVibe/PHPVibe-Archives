<div id="profile-cover" class="row-fluid" style="<?php if($profile->cover) { ?>background-image: url('<?php echo thumb_fix($profile->cover);?>')!important; background-repeat: no-repeat; background-size: 100% 315px; <?php } ?>">
<div class="span3">
<div class="profile-avatar">
<a rel="lightbox" href="<?php echo thumb_fix($profile->avatar);?>"><img class="img-shadow" src="<?php echo thumb_fix($profile->avatar, true, 210, 210);?>" alt="<?php echo $profile->name;?>" /></a>
<?php if(is_powner()) { ?>
<div class="btn-avatar btn-group">
<a href="<?php echo $canonical; ?>&sk=edit" class="btn btn-small"><i class="icon-pencil"></i> <?php echo _lang("change");?></a>
</div>
			
<?php } ?>				
</div>
</div>

</div>
<div id="profile-head" class="row-fluid">
<div class="span6">
<a href="<?php echo $canonical; ?>"><h1 class="profile-heading"> <?php 
if(date('d-m-Y', strtotime($profile->lastlogin)) != date('d-m-Y')) {
echo '<i class="icon-circle offline" style="margin-right:7px;"></i>';
} else {
echo '<i class="icon-circle online" style="margin-right:7px;"></i>';
} echo _html($profile->name);  ?>
</h1></a>
</div>
<div class="span6">
<div class="pull-right"><?php subscribe_box($profile->id); ?></div>
<div class="clearfix"></div>
</div>
</div>
</div>
<div class="row-fluid block main-holder" style="position:relative;">

<div class="span3 top10">
<div class="box">
<div class="box-head">
<h4 class="box-heading"><?php echo _lang("About"); ?></h4>
<?php if(is_powner()) { ?>
<a href="<?php echo $canonical; ?>&sk=edit" class="btn btn-small pull-right tipS" title="<?php echo _lang("Edit your details");?>"><i class="icon-pencil"></i></a>
<?php } ?>	
</div>
<div class="box-body list">
<ul>
<?php if($profile->local) { ?> <li> <i class="icon-home"></i><?php echo _html($profile->local);?> </li><?php } ?>
<?php if($profile->gender) { ?> <li> <i class="icon-check-empty"></i><?php echo ($profile->gender < 2) ? _lang("Male") : _lang("Female");?> </li><?php } ?>
<?php if($profile->country) { ?> <li> <i class="icon-globe"></i><?php echo _html($profile->country);?> </li><?php } ?>
<?php if($profile->bio) { ?><li> <i class="icon-pencil"></i><?php echo _html($profile->bio);?> </li><?php } ?>
<?php if($profile->fblink) { ?> <li> <i class="icon-facebook-sign"></i><a href="https://facebook.com/<?php echo $profile->fblink;?>" rel="nofollow" target="_blank"><?php echo $profile->fblink;?></a> </li><?php } ?>
<?php if($profile->glink) { ?> <li> <i class="icon-google-plus"></i><a href="https://plus.google.com/<?php echo $profile->glink;?>" rel="nofollow" target="_blank"><?php echo $profile->glink;?></a> </li><?php } ?>
<?php if($profile->twlink) { ?> <li> <i class="icon-twitter"></i><a href="https://twitter.com/<?php echo $profile->twlink;?>" rel="nofollow" target="_blank"><?php echo $profile->twlink;?></a> </li><?php } ?>
<?php if($profile->lastlogin) { ?> <li> <i class="icon-time"></i><?php echo _lang("Last login:");?> <?php echo time_ago($profile->lastlogin);?> </li><?php } ?>
<?php if($profile->date_registered) { ?> <li> <i class="icon-signin"></i><?php echo _lang("Registered:");?> <?php echo time_ago($profile->date_registered);?> </li><?php } ?>

</ul>
</div>
</div>
<?php $plays = $db->get_results("SELECT * FROM ".DB_PREFIX."playlists where owner= '".$profile->id."' order by views desc limit 0,100");
if($plays) { 
$plnr = $db->num_rows;
?>
<div class="box">
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

<?php 
if(_get('sk') !== "subscribers") {
 $followers = $cachedb->get_results("SELECT id,avatar,name,lastlogin from ".DB_PREFIX."users where id in (select fid from ".DB_PREFIX."users_friends where uid ='".$profile->id."') order by lastlogin desc limit 0,15");
if($followers) {
$fnr = $cachedb->num_rows;
?>
<div class="box">
<div class="box-head">
<h4 class="box-heading"><?php echo _lang('Subscribers'); ?></h4><a class="pull-right" href="<?php echo $canonical; ?>&sk=subscribers"><?php echo _lang("View all"); ?></a>
</div>
<div class="box-body">
<?php
if($fnr > 10) {
echo '<div class="scroll-items">';
}
foreach ($followers as $follower) {
echo '
<div class="populars">
<a class="tipW pull-left" title="'.$follower->name.'" href="'.profile_url($follower->id , $follower->name).'"><img src="'.thumb_fix($follower->avatar, true, 27, 27).'" alt="'.$follower->name.'" /></a>
<span class="pop-title"><a title="'.$follower->name.'" href="'.profile_url($follower->id , $follower->name).'">'._cut(stripslashes($follower->name), 16).'</a></span>';
if(date('d-m-Y', strtotime($follower->lastlogin)) != date('d-m-Y')) {
echo '<i class="icon-circle offline pull-right"></i>';
} else {
echo '<i class="icon-circle online pull-right"></i>';
}
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
}
if(_get('sk') !== "subscribed") {
$followings = $cachedb->get_results("SELECT id,avatar,name,lastlogin from ".DB_PREFIX."users where id in (select uid from ".DB_PREFIX."users_friends where fid ='".$profile->id."') order by lastlogin desc limit 0,15");
if($followings) {
$snr = $cachedb->num_rows;
?>

<div class="box">
<div class="box-head">
<h4 class="box-heading"><?php echo _lang('Subscribed to'); ?></h4><a class="pull-right" href="<?php echo $canonical; ?>&sk=subscribed"><?php echo _lang("View all"); ?></a>
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
<span class="pop-title"><a title="'.$following->name.'" href="'.profile_url($following->id , $following->name).'">'._cut(stripslashes($following->name), 16).'</a></span>';
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
}
?>
</div>
<div id="profile-content">
<?php if(is_powner() && !_get('sk')) { ?>
<div id="shareTowall">
<div class="widget widget-tabs">

	<!-- Tabs Heading -->
	<div class="widget-head">
		<ul>
			<li><a data-toggle="tab" href="#pictureTab"><i class="icon-picture"></i></a></li>
			<li class="active"><a data-toggle="tab" href="#ytTab"><i class="icon-youtube-square"></i></a></li>
		</ul>
	</div>
	<!-- // Tabs Heading END -->
	
	<div class="widget-body">
		<div class="tab-content">
			
			<div class="tab-pane" id="pictureTab">
			<div class="share">
<form id="validate" class="form-horizontal styled" action="<?php echo canonical(); ?>" enctype="multipart/form-data" method="post">
<input type="file" name="play-img" id="play-img" class="validate[required] styled">
<input type="text" class="validate[required] full" style="margin-top:5px; margin-bottom:5px;" name="pic-title" placeholder="<?php echo _lang("What's this picture?"); ?>"/>
<input type="text" class="full" style=" margin-bottom:5px;" name="pic-desc" placeholder="<?php echo _lang("Say something more about this picture"); ?>"/>
<input type="text" id="tags" name="tags" class="tags" value="<?php echo _lang("picture"); ?>">
<button type="submit" class="btn btn-primary"><i class="icon-ok"></i> <?php echo _lang(" Post now"); ?> </button>
				
</form>
</div>
<br style="clear:both;">
</div>
	<div class="tab-pane active" id="ytTab">
			<div class="share">
<form id="validate" class="form-horizontal styled" action="<?php echo site_url().share; ?>&type=2&step=2" enctype="multipart/form-data" method="post">
	<input type="text" id="vfile" name="vfile" class=" span12" value="" placeholder="<?php echo _lang("http://www.youtube.com/watch?v=fIadOXV1wVg"); ?>">
	<span class="help-block" id="limit-text"><?php echo _lang("Link to video (Youtube, Metacafe, etc)"); ?></span>
<button type="submit" class="btn btn-primary"><i class="icon-ok"></i> <?php echo _lang(" Continue"); ?> </button>
				
</form>
</div>
<br style="clear:both;">
</div>
</div>
</div>
</div>
</div>
<?php } ?>	

<?php 
switch(_get('sk')){
case 'edit':
include_once(TPL.'/profile/edit.php');	
break;
case 'subscribed':
$count = $db->get_row("Select count(*) as nr from ".DB_PREFIX."users where ".DB_PREFIX."users.id in ( select uid from ".DB_PREFIX."users_friends where fid ='".$profile->id."')");
$vq = "select id,avatar,name from ".DB_PREFIX."users where ".DB_PREFIX."users.id in ( select uid from ".DB_PREFIX."users_friends where fid ='".$profile->id."') ORDER BY ".DB_PREFIX."users.views DESC ".this_offset(18);
include_once(TPL.'/profile/users.php');	
$pagestructure = $canonical.'&sk=subscribed&p=';
$bp = bpp();	
break;
case 'subscribers':
$count = $db->get_row("Select count(*) as nr from ".DB_PREFIX."users where ".DB_PREFIX."users.id in ( select fid from ".DB_PREFIX."users_friends where uid ='".$profile->id."')");
$vq = "select id,avatar,name from ".DB_PREFIX."users where ".DB_PREFIX."users.id in ( select fid from ".DB_PREFIX."users_friends where uid ='".$profile->id."') ORDER BY ".DB_PREFIX."users.views DESC ".this_offset(18);
include_once(TPL.'/profile/users.php');	
$pagestructure = $canonical.'&sk=subscribers&p=';
$bp = bpp();
break;
default:
echo '
<div class="innerLR heading-buttons border-bottom">
<h3 class="margin-none pull-left">Recent Activity</h3>
										

			<div class="btn-group pull-right">
			<a class="btn btn-small btn-info">'._lang("Sort").' </a>
<a data-toggle="dropdown" class="btn btn-small btn-info btn-circle dropdown-toogle"><span class="caret"></span> </a>

			<ul class="dropdown-menu pad-icons">
			<div class="triangle"></div>
			<li class="TipE" title="'._lang("All activity").'"><a href="'.$canonical.'"><i class="icon-list"></i>'._lang("All activity").'</a></li>
			<li class="TipE" title="'._lang("Videos shared").'"><a href="'.$canonical.'&sort=4"><i class="icon-play"></i>'._lang("Videos shared").'</a></li>
			<li class="TipE" title="'._lang("Liked videos").'"><a href="'.$canonical.'&sort=1"><i class="icon-heart"></i>'._lang("Liked videos").'</a></li>
			<li class="TipE" title="'._lang("Comments").'"><a href="'.$canonical.'&sort=6"><i class="icon-comments"></i>'._lang("Comments").'</a></li>	
<li class="TipE" title="'._lang("Watched").'"><a href="'.$canonical.'&sort=3"><i class="icon-eye-open"></i>'._lang("Watched videos").'</a></li>			
			</ul>
		</div>
	<div class="clearfix"></div>
	</div>

';
$sort =(isset($_GET['sort']) && (intval($_GET['sort']) > 0) ) ? "and type='".intval($_GET['sort'])."'" : "";
$count = $db->get_row("Select count(*) as nr from ".DB_PREFIX."activity where user='".$profile->id."' ".$sort);
$vq = "Select * from ".DB_PREFIX."activity where user='".$profile->id."' ".$sort." ORDER BY id DESC ".this_offset(60);
include_once(TPL.'/profile/activity.php');	
$pagestructure = $canonical.'&p=';
$bp = 60;
break;			
}
if(isset($bp) && $pagestructure) {
$a = new pagination;	
$a->set_current(this_page());
$a->set_first_page(true);
$a->set_pages_items(7);
$a->set_per_page($bp);
$a->set_values($count->nr);
$a->show_pages($pagestructure);
}
?>
</div>
<div class="span2 pull-right nomargin" style="text-align:center"> 
<?php echo _ad('0','profile-right'); ?>
</div>
