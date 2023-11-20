<?php
include("usidebar.tpl.php");
$BrowsePerPage = 20;
$nr_query = "SELECT COUNT(*) FROM playlist_data WHERE playlist ='".$router->fragment(1)."'";
$vbox_result = mysql_query($nr_query);
$numberofresults = mysql_result($vbox_result, 0);
$limit = 'LIMIT ' .($pageNumber - 1) * $BrowsePerPage .',' .$BrowsePerPage; 
$vbox_result=mysql_query("select playlist_data.video_id, videos.* from playlist_data LEFT JOIN videos ON playlist_data.video_id =videos.id WHERE playlist_data.playlist ='".$router->fragment(1)."' ORDER BY id DESC $limit");
$u_canonical = $site_url.'user/'.$user_profile->getId().'/'.seo_clean_url($user_profile->getDisplayName()) .'/';
$h1 = $playlist_name ;


$box_title = ucfirst($h1);
?>

<div class="main">
 <div class="userRow">
  <a href="<?php echo $site_url; ?><?php echo $playlist_picture; ?>" class="lightbox" title=""><img src="<?php echo $site_url; ?>com/timthumb.php?src=<?php echo $playlist_picture; ?>&w=50&crop&q=50" alt="" style="float:left!important; padding-left:5px;" /></a>
  <ul class="leftList">
  <li><a href="<?php echo $u_canonical; ?>" title=""><strong><?php echo $user_profile->getDisplayName(); ?></strong></a></li>
  <li><a href="<?php echo $site_url."videos-by/".$user_profile->getId(); ?>">Videos</a> | <a href="<?php echo $site_url."likes/".$user_profile->getId(); ?>">Likes</a></li>
  </ul>
  <ul class="rightList">
   <li><a href="<?php echo $u_canonical; ?>" title=""><strong><?php echo $playlist_name; ?></strong></a></li>
  <li><?php echo $playlist_description; ?></li>
 </ul>
   <ul class="rightOpList">
   <li><strong><?php echo $playlist_views; ?></strong></li> <li>views </li>
    </ul>
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