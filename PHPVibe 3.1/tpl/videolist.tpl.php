<?php include("sidebar.tpl.php");
$BrowsePerPage = $config->video->bpp;
$options = "id,title,thumb,views,liked,duration,nsfw";
switch($router->fragment(1)){
case "most-viewed":
$numberofresults = dbcount("*","videos","views > 1");
$limit = 'LIMIT ' .($pageNumber - 1) * $BrowsePerPage .',' .$BrowsePerPage; 
$vbox_result="select ".$options." from videos WHERE views > 1 ORDER BY views DESC $limit";
$h1 = $lang['most-viewed'];
$focus = "views";
$icon= "trend";

break;	

case "most-liked":
$numberofresults = dbcount("*","videos","liked > 0");
$limit = 'LIMIT ' .($pageNumber - 1) * $BrowsePerPage .',' .$BrowsePerPage; 
$vbox_result="select ".$options." from videos WHERE liked > 0 ORDER BY liked DESC $limit";
$h1 = $lang['most-liked'];
$focus = "liked";
$icon= "heart";
break;	
case "featured":
$numberofresults = dbcount("*","videos","featured = '1'");
$limit = 'LIMIT ' .($pageNumber - 1) * $BrowsePerPage .',' .$BrowsePerPage; 
$vbox_result="select ".$options." from videos WHERE featured = '1' ORDER BY id DESC $limit";
$h1 = $lang['featured'];
break;	
default:
		

$numberofresults = dbcount("*","videos");
$limit = 'LIMIT ' .($pageNumber - 1) * $BrowsePerPage .',' .$BrowsePerPage; 
$vbox_result="select ".$options." from videos ORDER BY id DESC $limit";		
$h1 = $lang['browse'];	
break;	
}
$box_title = "";
?>

<div class="main">
<?php echo '<div class="block_title"><h2>'.stripslashes(ucfirst($h1)).'</h2></div>';?>
<div class="loop-actions"><div class="view">
<a href="#" title="Normal Thumbnails" data-type="boxed-small" class="boxed-small-link current"><i></i></a>
<a href="#" title="Mini Thumbnails" data-type="boxed-mini" class="boxed-mini-link"><i></i></a>
<a href="#" title="Big Thumbnails" data-type="boxed-medium" class="boxed-medium-link"><i></i></a>
</div><!-- end .view -->
</div><!-- end .loop-actions -->	

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