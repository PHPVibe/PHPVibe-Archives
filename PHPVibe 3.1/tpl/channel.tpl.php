<?php include("sidebar.tpl.php");
$BrowsePerPage = $config->video->bpp;
$orderby = MK_Request::getQuery('orderby');
$numberofresults = dbcount("*","videos","category ='".$channel_id."'");
$limit = 'LIMIT ' .($pageNumber - 1) * $BrowsePerPage .',' .$BrowsePerPage; 
if ($orderby == "liked" || $orderby == "views" ) {
$pagi_url = $site_url.'channel/'.$router->fragment(1).'/&orderby='.$orderby.'&page=';
$vbox_result="select * from videos WHERE `category` = ".$channel_id." order by $orderby DESC $limit";
} else {
$pagi_url = $site_url.'channel/'.$router->fragment(1).'/&page=';
$vbox_result="select * from videos WHERE `category` = ".$channel_id." order by ID DESC $limit";
}
$box_title = '';
echo '<div class="main">';
?>

<div class="main">
<?php echo '<div class="block_title"><h2>'.stripslashes(ucfirst($channel_name)).'</h2></div>';?>

<div class="loop-actions">
<span class="orderby"> 
<a href="<?php echo $this_url;?>&orderby=views" class="views"><i>Views</i></a>
<span class="order-asc"></span>
<a href="<?php echo $this_url;?>&orderby=liked"class="likes"><i>Likes</i></a>
<span class="order-asc"></span>
</span>
<div class="view">
<a href="#" title="Normal Thumbnails" data-type="boxed-small" class="boxed-small-link current"><i></i></a>
<a href="#" title="Mini Thumbnails" data-type="boxed-mini" class="boxed-mini-link"><i></i></a>
<a href="#" title="Big Thumbnails" data-type="boxed-medium" class="boxed-medium-link"><i></i></a>
</div><!-- end .view -->
</div><!-- end .loop-actions -->

<?php 
echo '<div class="section-split"></div>';
$childs = dbcount("*","channels","child_of ='".$channel_id."'"); 
if ($childs > 0 ) { 
echo '<div class="list-video" style="margin:10px 20px;min-width:800px;float:left;display:inline-block;clear:both;">';
$child_channel = "SELECT picture,yt_slug, cat_name FROM `channels` WHERE child_of ='".$channel_id."' order by cat_name desc";
if ($sidechild = $dbi->query($child_channel,0)) {
echo '<div class="boxed-minilist" data-view="boxed-minilist">'; 

	foreach ($sidechild as $video) {
			$title = stripslashes(substr($video["cat_name"], 0, 29));
			$full_title = stripslashes(str_replace("\"", "",$video["cat_name"]));			
			$url = $site_url.'channel/'.$video["cat_name"].'/';
			
		
echo '
<div class="smallvideo">
<div class="thumb">
		<a class="clip-link"" title="'.$full_title.'" href="'.$url.'">
			<span class="clip">
				<img src="'.$video["picture"].'" alt="'.$full_title.'" /><span class="vertical-align"></span>
			</span>
							
			
		</a>
		 <span class="timer">'.$video["cat_name"].'</span>
	</div>	
	</div>
';
}
echo '</div> </div><div style="clear:both;"></div>';
}
$dbi->disconnect(); 
echo '<div class="section-split"></div>';
}
?>
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
