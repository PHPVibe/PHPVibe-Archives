<?php
include("usidebar.tpl.php");
$BrowsePerPage = 20;
$nr_query = "SELECT COUNT(*) FROM likes WHERE uid ='".$router->fragment(1)."' and type ='like'";
$vbox_result = mysql_query($nr_query);
$numberofresults = mysql_result($vbox_result, 0);
$limit = 'LIMIT ' .($pageNumber - 1) * $BrowsePerPage .',' .$BrowsePerPage; 
$vbox_result=mysql_query("select likes.vid, videos.* from likes LEFT JOIN videos ON likes.vid =videos.id WHERE likes.uid ='".$router->fragment(1)."' and likes.type ='like' ORDER BY id DESC $limit");
$u_canonical = $site_url.'user/'.$user_profile->getId().'/'.seo_clean_url($user_profile->getDisplayName()) .'/';
$h1 = $user_profile->getDisplayName()."'s liked ".$lang['videos']." | <a href=\"".$u_canonical."\">more... </a>";


$box_title = ucfirst($h1);
?>

<div class="main">

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
