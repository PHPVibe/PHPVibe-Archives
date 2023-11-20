<?php include("usidebar.tpl.php");
$BrowsePerPage = $config->video->bpp;
$tmp_id = cleanInput($router->fragment(1));
$numberofresults = dbcount("*","playlist_data ","playlist ='".$tmp_id."'");
$limit = 'LIMIT ' .($pageNumber - 1) * $BrowsePerPage .',' .$BrowsePerPage; 
$vbox_result="select playlist_data.video_id, videos.* from playlist_data LEFT JOIN videos ON playlist_data.video_id =videos.id WHERE playlist_data.playlist ='".$tmp_id."' ORDER BY id DESC $limit";
$u_canonical = $site_url.'user/'.$user_profile->getId().'/'.seo_clean_url($user_profile->getDisplayName()) .'/';
$h1 = $playlist_name ;


$box_title = '';
?>

<div class="main">
  <div class="head-data" style="padding: 3px 10px;">
			<h1 class="title"><?php echo $h1; ?></h1>	
<p class="meta">
				<span class="author"><?php echo $lang['by']; ?> <a href="<?php echo $site_url."user/".$user_profile->getId().'/'.seo_clean_url($user_profile->getDisplayName()); ?>" title="<?php echo $user_profile->getDisplayName(); ?>" rel="author"><?php echo $user_profile->getDisplayName(); ?></a></span> 
				
			</p>			
			<p class="stats"><span class="views"><i class="count"><?php echo $playlist_views; ?></i> </span></p>
<div class="clear"></div>
<p><i><?php echo $playlist_description; ?></i></p>
<div class="clear"></div>
			</div>	

<?php
include("video_box.tpl.php");
echo '<div class="clear"></div>';
$a = new pagination;	
$a->set_current($pageNumber);
$a->set_first_page(true);
$a->set_pages_items(12);
$a->set_per_page($BrowsePerPage);
$a->set_values($numberofresults);
$a->show_pages($pagi_url);
?>
</div>