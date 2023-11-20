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
$parse = parse_url(site_url()); 
if($parse['path'] != "/") {
echo '<div class="msg-hint">Seems phpVibe it\'s installed in a folder. We suggest you use a subdomain or domain for a smooth experience.  </div><div class="msg-info"> But, if folder is your option please remember to edit the root/.httaccess file and change RewriteBase / to RewriteBase '.$parse['path'].' for url rewrited to work, else it will return 404</div>';
}
if (!extension_loaded('mbstring')) { 
echo '<div class="msg-hint">Seems your host misses the mbstring extension. This is not an error, but you may see weird characters when cutting uft-8 titles  </div>';
 }
?>				
</div>
<div class="row-fluid">
		    	<form class="search widget" action="" method="get" onsubmit="location.href='<?php echo admin_url('search-videos'); ?>&key=' + encodeURIComponent(this.key.value); return false;">
		    		<div class="autocomplete-append">			   
			    		<input type="text" name="key" placeholder="Search video..." id="key" />
			    		<input type="submit" class="btn btn-info" value="Search" />
			    	</div>
		    	</form>
</div>
<div class="row-fluid">

<div class="box-element span6">
					<div class="box-head-light"><i class="icon-comments-alt"></i><h3>Recent comments</h3></div>
					<div class="box-content">
						<?php 
						$html = '';
						$comments   = $db->get_results("SELECT ".DB_PREFIX."em_comments . * , ".DB_PREFIX."em_likes.vote , ".DB_PREFIX."users.name, ".DB_PREFIX."users.avatar
FROM ".DB_PREFIX."em_comments
LEFT JOIN ".DB_PREFIX."em_likes ON ".DB_PREFIX."em_comments.id = ".DB_PREFIX."em_likes.comment_id
LEFT JOIN ".DB_PREFIX."users ON ".DB_PREFIX."em_comments.sender_id = ".DB_PREFIX."users.id
ORDER BY  ".DB_PREFIX."em_comments.id desc limit 0,40");
if($comments) {
      
    $html = '<div class="comment-list block full">';
	 foreach( $comments as $comment) {
    $html .= ' <article id="comment-id-'.$comment->id.'" class="comment-item media arrow-left">
<a class="pull-left thumb-small com-avatar" href="'.profile_url($comment->sender_id,$comment->name).'"><img src="'.thumb_fix($comment->avatar).'"></a>
<section class="media-body panel">
<header class="panel-heading clearfix">
<a href="'.profile_url($comment->sender_id,$comment->name).'">'.print_data(stripslashes($comment->name)).'</a> - '.time_ago($comment->created).' <span class="text-muted m-l-small pull-right" id="iLikeThis_'.$comment->id.'"></span>
</header>
<div>'.print_data(stripslashes($comment->comment_text)).'</div>
                
              </section>
</article>
';
}
 $html .= '</div>';

}

echo '<div class="scroll-items">'.$html.'</div>';					
?>
</div>
 <div class="box-bottom clearfix"> <a class="btn btn-primary btn-mini pull-right" href="<?php echo admin_url();?>?sk=comments">Manage comments</a> </div>

				</div>
<div class="box-element span6">
<div class="box-head-light"><h3><i class="icon-film"></i><h3>Recent videos</h3></div>
<div class="box-content nopad">
<div class="scroll-items">
<ul>
<?php 
$options = DB_PREFIX."videos.id,".DB_PREFIX."videos.title,".DB_PREFIX."videos.user_id,".DB_PREFIX."videos.thumb,".DB_PREFIX."videos.views,".DB_PREFIX."videos.liked,".DB_PREFIX."videos.duration,".DB_PREFIX."videos.nsfw";
$vq = $db->get_results("select ".$options.", ".DB_PREFIX."users.name as owner FROM ".DB_PREFIX."videos LEFT JOIN ".DB_PREFIX."users ON ".DB_PREFIX."videos.user_id = ".DB_PREFIX."users.id ORDER BY ".DB_PREFIX."videos.id DESC ".this_limit()."");
if($vq) {
foreach ($vq as $video) {
		?>
<li>
<div class="avatar"><img alt="" src="<?php echo thumb_fix($video->thumb)?>"></div>
<div class="info">
<a href="<?php echo video_url($video->id , $video->title); ?>"><?php echo  stripslashes(_cut($video->title, 46)); ?></a> <br>
<?php echo _lang("by").' <a href="'.profile_url($video->user_id, $video->owner).'" title="'.$video->owner.'">'.$video->owner.'</a> <span class="pull-right">'.$video->views.' '._lang('views').'</span>'; ?>
</div>
</li>  
<?php } 
}
?>                               
 </ul>
 </div>
 </div>
 <div class="box-bottom clearfix"> <a class="btn btn-primary btn-mini pull-right" href="<?php echo admin_url();?>?sk=videos">Manage videos</a> </div>
</div>				
</div>
			
<?php //End ?>