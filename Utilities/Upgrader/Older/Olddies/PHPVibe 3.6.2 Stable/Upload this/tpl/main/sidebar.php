<div id="sidebar-wrapper" class="span2 left-sidebar top10 hidden-phone hidden-tablet">
<div id="sidebar"> 
<div class="close-me visible-phone visible-tablet hidden-desktop">
<a id="mobi-hide-sidebar" class="topicon tipN" href="javascript:void(0)" title="<?php echo _lang('Hide'); ?>"><i class="icon-plus"></i></a>
</div>
<?php echo '<div class="searchWidget visible-phone hidden-tablet hidden-desktop" style="margin:10px 6%;">
            <form action="" method="get" id="searchform" onsubmit="location.href=\''.site_url().show.'/\' + encodeURIComponent(this.tag.value).replace(/%20/g, \'+\'); return false;">
                <input type="text" name="tag" id="suggest-videos" value="'._lang("Search videos").'" onfocus="if (this.value == \''._lang("Search videos").'\') {this.value = \'\';}" onblur="if (this.value == \'\') {this.value = \''._lang("Search videos").'\';}" />
             <button type="submit" class="btn btn-primary pull-right"><i class="icon-search"></i></button>
			</form>       
		</div>'
?>
<?php 
//The menu	
echo '<div class="sihead"><a href="'.site_url().channels.'"><h4>'._lang('Video Channels').'</a></h4></div><div class="sidebar-nav blc">'.the_nav().'<div class="clearfix"></div></div>';
if(get_option('musicmenu') == 1 ) {
echo '<div class="sidebar-nav blc"><div class="head"><h4>'._lang('Music Channels').'</h4></div>'.the_nav(2).'<div class="clearfix"></div></div>';
}
if(get_option('imagesmenu') == 1 ) {
echo '<div class="sidebar-nav blc"><div class="head"><h4>'._lang('Image Categories').'</h4></div>'.the_nav(3).'<div class="clearfix"></div></div>';
}
?>
<?php 
$postsx = $db->get_results("select title,pid,pic from ".DB_PREFIX."posts ORDER BY title ASC ".this_limit()."");
 /* The posts lists */
 if($postsx) {
echo '<div class="box"> 
<div class="box-head">
<h4 class="box-heading">'._lang('Latest articles').'</h4>
</div>
	<div class="box-body list">	
	<ul>';
	foreach ($postsx as $px) {
echo '<li><img src="'.thumb_fix($px->pic, true, 23, 23).'"><a href="'.article_url($px->pid, $px->title).'" title="'._html($px->title).'"> '._cut(_html($px->title),19).'</a></li>';

	
	}
echo '<li><i class="icon-folder-close"></i><a href="'.site_url().blog.'" title="'._html($px->title).'"> '._lang("All articles").'</a></li>';

  echo '  </ul>   
    </div>
    </div>';
}
$pagesx = $db->get_results("select title,pid,pic from ".DB_PREFIX."pages WHERE menu = '1' ORDER BY title ASC ".this_limit()."");
 /* The pages lists */
 if($pagesx) {
echo '<div class="box"> 
<div class="box-head">
<h4 class="box-heading">'._lang('Information').'</h4>
</div>
	<div class="box-body list">	
	<ul>';
	foreach ($pagesx as $px) {
echo '<li><img src="'.thumb_fix($px->pic, true, 23, 23).'"><a href="'.page_url($px->pid, $px->title).'" title="'._html($px->title).'"> '._cut(_html($px->title),19).'</a></li>';

	
	}

  echo '  </ul>   
    </div>
    </div>';
}

?>
</div>
</div>