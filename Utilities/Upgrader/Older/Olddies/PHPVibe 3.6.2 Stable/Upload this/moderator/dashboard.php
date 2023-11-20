<?php  if(this_page() == 1) { ?>

<section class="panel panel-default ">
<div class="panel-heading">Statistics</div>

<ul class="statistics">
  <li>
    <div class="top-info">
      <a href="<?php echo admin_url('videos'); ?>" title="" class="blue-square">
        <i class="icon-film">
        </i>
      </a>
      <strong>
        <?php echo _count('videos'); ?>
      </strong>
    </div>
    <div class="progress progress-micro">
      <div class="bar" style="width: 40%;">
      </div>
    </div>
    <span>
      <?php echo _lang('Videos');?>
    </span>
  </li>
  <li>
    <div class="top-info">
      <a href="<?php echo admin_url('users'); ?>" title="" class="sea-square">
        <i class="icon-group">
        </i>
      </a>
      <strong>
        <?php echo _count('users'); ?>
      </strong>
    </div>
    <div class="progress progress-micro">
      <div class="bar" style="width: 40%;">
      </div>
    </div>
    <span>
      <?php echo _lang('Members');?>
    </span>
  </li>
  <li>
    <div class="top-info">
      <a href="<?php echo admin_url('videos'); ?>" title="" class="red-square">
        <i class="icon-eye-open">
        </i>
      </a>
      <strong>
        <?php echo _count('videos','views',true ); ?>
      </strong>
    </div>
    <div class="progress progress-micro">
      <div class="bar" style="width: 40%;">
      </div>
    </div>
    <span>
      <?php echo _lang('Video views');?>
    </span>
  </li>
  <li>
    <div class="top-info">
      <a href="<?php echo admin_url('videos'); ?>" title="" class="green-square">
        <i class="icon-ok">
        </i>
      </a>
      <strong>
        <?php echo _count('likes' ); ?>
      </strong>
    </div>
    <div class="progress progress-micro">
      <div class="bar" style="width: 40%;">
      </div>
    </div>
    <span>
      <?php echo _lang('Video likes');?>
    </span>
  </li>
  <li>
    <div class="top-info">
      <a href="<?php echo admin_url('playlists'); ?>" title="" class="purple-square">
        <i class="icon-fast-forward">
        </i>
      </a>
      <strong>
        <?php echo _count('playlists' ); ?>
      </strong>
    </div>
    <div class="progress progress-micro">
      <div class="bar" style="width: 40%;">
      </div>
    </div>
    <span>
      <?php echo _lang('Playlists');?>
    </span>
  </li>
  <li>
    <div class="top-info">
      <a href="<?php echo admin_url('comments'); ?>" title="" class="blue-square">
        <i class="icon-comment-alt">
        </i>
      </a>
      <strong>
        <?php echo _count('em_comments' ); ?>
      </strong>
    </div>
    <div class="progress progress-micro">
      <div class="bar" style="width: 40%;">
      </div>
    </div>
    <span>
      <?php echo _lang('Comments');?>
    </span>
  </li>
  <li>
    <div class="top-info">
      <a href="<?php echo admin_url('reports'); ?>" title="" class="red-square">
        <i class="icon-exclamation-sign">
        </i>
      </a>
      <strong>
        <?php echo _count('reports' ); ?>
      </strong>
    </div>
    <div class="progress progress-micro">
      <div class="bar" style="width: 40%;">
      </div>
    </div>
    <span>
      <?php echo _lang('Reports');?>
    </span>
  </li>
  
</ul>
</section>
<div class="row-fluid">
<?php
if (is_readable(ABSPATH.'/setup')) {
echo '<div class="msg-warning">Setup folder ('.ABSPATH.'/setup) exists. You should delete it fast!</div>';
}
if (!is_writable(ABSPATH.'/cache')) {
echo '<div class="msg-warning">Cache folder ('.ABSPATH.'/cache)is not writeable</div>';
}
if (!is_writable(ABSPATH.'/'.get_option('mediafolder'))) {
echo '<div class="msg-warning">Media storage folder ('.ABSPATH.'/'.get_option('mediafolder').')is not writeable</div>';
}
if (!is_writable(ABSPATH.'/'.get_option('mediafolder').'/thumbs')) {
echo '<div class="msg-warning">Media thumbs storage folder ('.ABSPATH.'/'.get_option('mediafolder').'/thumbs)is not writeable</div>';
}
if (!is_writable(ABSPATH.'/cache/thumbs')) {
echo '<div class="msg-warning">Thumbs folder ('.ABSPATH.'/cache/thumbs) is not writeable</div>';
}
if (!is_writable(ABSPATH.'/uploads')) {
echo '<div class="msg-warning">Pictures folder ('.ABSPATH.'/uploads)is not writeable</div>';
}
?>				
</div>
<div class="row-fluid">
<section class="panel panel-blue panel2x">
<div class="panel-heading">Recent videos <a href="<?php echo admin_url("videos");?>" class="pull-right pd-l-sm pd-r-sm">View more</a></div>
<div class="scroll-items">
<ul class="list-group">
<?php 
$options = DB_PREFIX."videos.id,".DB_PREFIX."videos.title,".DB_PREFIX."videos.user_id,".DB_PREFIX."videos.thumb,".DB_PREFIX."videos.views,".DB_PREFIX."videos.liked,".DB_PREFIX."videos.duration,".DB_PREFIX."videos.nsfw";
$vq = $db->get_results("select ".$options.", ".DB_PREFIX."users.name as owner FROM ".DB_PREFIX."videos LEFT JOIN ".DB_PREFIX."users ON ".DB_PREFIX."videos.user_id = ".DB_PREFIX."users.id ORDER BY ".DB_PREFIX."videos.id DESC ".this_limit()."");
if($vq) {
foreach ($vq as $video) {
		?>
<li class="list-group-item">
<span class="pull-left mg-t-xs mg-r-md"><img class="avatar avatar-xl " src="<?php echo thumb_fix($video->thumb)?>"></span>
<div class="show no-margin pd-t-xs">
<a href="<?php echo video_url($video->id , $video->title); ?>"><?php echo  stripslashes(_cut($video->title, 46)); ?></a> <span class="pull-right"><?php echo $video->views.' '._lang('views').'</span>'; ?>
<small class="text-muted"><?php echo _lang("by").' <a href="'.profile_url($video->user_id, $video->owner).'" title="'.$video->owner.'">'.$video->owner ?></a> </small>
</div>
</li>  
<?php } 
}
?>                               
 </ul>
 </div>
 </section>

<section class="panel panel-primary panel4x">
<?php $countu = $db->get_row("Select count(*) as nr from ".DB_PREFIX."users");
$users = $db->get_results("select * from ".DB_PREFIX."users order by id DESC ".this_limit()."");
?>
<div class="panel-heading">New users <a href="<?php echo admin_url("users");?>" class="pull-right pd-l-sm pd-r-sm">View all (<?php echo $countu->nr; ?>)</a></div>
<div class="scroll-items">
<ul class="list-group">
 <?php foreach ($users as $u) { ?>
<li class="list-group-item">
<div class="show no-margin pd-t-xs"> <a href="<?php echo profile_url($u->id, $u->name); ?>" target="_blank"><?php echo _html($u->name); ?></a> <small class="pull-right"><?php echo count_uvid($u->id); ?> videos</small></div>
<small class="text-muted">Has <?php echo count_uact($u->id); ?> activities so far</small>
</li>
<?php } ?>
</ul>
</div>
</section>
<section class="panel panel-danger panel4x">
<?php 
 function getpb($url)
      {
          $ch      = curl_init();
          $timeout = 15;
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
          $data = curl_exec($ch);
          curl_close($ch);
          return $data;
      }
$upd = json_decode(getpb("http://get.phpvibe.com/api"), true);	
?>
<div class="panel-heading">Updates <a href="http://get.phpvibe.com" target="_blank" class="pull-right pd-l-sm pd-r-sm">View more</a></div>
<div class="scroll-items">
<ul class="list-group">
<li class="list-group-item">
<div class="show no-margin pd-t-xs"> <a href="http://get.phpvibe.com/buy?id=22" target="_blank"><?php echo _html($upd["cms"]["release"]); ?></a> <small class="pull-right">v<?php echo $upd["cms"]["version"]; ?></small></div>
<small class="text-muted">Current subversion is <?php echo $upd["cms"]["suv"]; ?></small>
</li>
 <?php foreach ($upd["latest"] as $recent) {
$thumb = "http://get.phpvibe.com/".stripslashes($recent["thumb"]);
 ?>
<li class="list-group-item">
<span class="pull-left mg-t-xs mg-r-md">
<img src="<?php echo thumb_fix($thumb); ?>" class="avatar avatar-sm" alt="">
</span>
<div class="show no-margin pd-t-xs"> <a href="http://get.phpvibe.com/buy?id=<?php echo $recent["id"]; ?>" target="_blank"><?php echo _html($recent["name"]); ?></a> <small class="pull-right"><?php echo $recent["buys"]; ?> sales</small></div>
</li>
<?php } ?>
</ul>

</div>
</section>
 <?php } ?>
<div class="row-fluid">
<section class="panel panel-danger ">
<div class="panel-heading">Website activity</div>
<div style="padding:4px 14px;" >
<?php 
$pagestructurex = admin_url()."?p=";
$count = $db->get_row("Select count(*) as nr from ".DB_PREFIX."activity ");
$vq = "Select ".DB_PREFIX."activity.*, ".DB_PREFIX."users.avatar,".DB_PREFIX."users.id as pid, ".DB_PREFIX."users.name from ".DB_PREFIX."activity left join ".DB_PREFIX."users on ".DB_PREFIX."activity.user=".DB_PREFIX."users.id ORDER BY ".DB_PREFIX."activity.id DESC ".this_limit();
include_once(TPL.'/layouts/global_activity.php');	
$pagestructure = canonical().'&p=';
$a = new pagination;	
$a->set_current(this_page());
$a->set_first_page(true);
$a->set_pages_items(7);
$a->set_per_page(bpp());
$a->set_values($count->nr);
$a->show_pages($pagestructurex);

?>
</div>
</div>
</div>			
<?php //End ?>