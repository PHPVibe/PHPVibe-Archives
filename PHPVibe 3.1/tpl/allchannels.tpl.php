<?php include("sidebar.tpl.php"); 
$numberofresults = dbcount("*","channels");
$BrowsePerPage = $config->video->bpp;
echo '<div class="main"><div class="block_title"><h2>'.stripslashes($seo_title).'</h2><div class="section-split"></div></div>';
echo '<div class="list-video" style="margin:10px 20px;min-width:800px;float:left;display:inline-block;clear:both;">';
$limit = 'LIMIT ' .($pageNumber - 1) * $BrowsePerPage .',' .$BrowsePerPage; 
$result="select * from channels order by cat_id DESC $limit";
if ($categs = $dbi->query($result, 0)) {
foreach ($categs as $rrow) {
    $full_title = $rrow['cat_name'];
	$title = $full_title;
	$url = $site_url.'channel/'.$rrow['yt_slug'].'/';
	
	echo '<div id="video-'.$rrow["cat_id"].'" class="video">
<div class="thumb">
		<a class="clip-link" data-id="'.$rrow["cat_id"].'" title="'.$full_title.'" href="'.$url.'">
			<span class="clip">
				<img src="'.$rrow["picture"].'" alt="'.$full_title.'" /><span class="vertical-align"></span>
			</span>		
		</a>		
	</div>	
	<div class="data">
<h2 class="title"><a href="'.$url.'" title="'.$full_title.'">'.$title.'</a></h2>	
<div class="desc">'.strip_tags(stripslashes($rrow["cat_desc"])).'</div>';
echo '</div>';
$vid_result="select * from videos WHERE `category` = ".$rrow["cat_id"]." order by ID DESC limit 0,12";
if ($cboxes = $dbi->query($vid_result, 60,'somecat_'.$rrow["cat_id"])) {
echo '<div class="boxed-minilist" data-view="boxed-minilist">'; 
foreach ($cboxes as $video) {
			$title = stripslashes(substr($video["title"], 0, 29));
			$full_title = stripslashes(str_replace("\"", "",$video["title"]));			
			$url = $site_url.'video/'.$video["id"].'/'.seo_clean_url($full_title) .'/';
			
		
echo '
<div id="video-'.$video["id"].'" class="smallvideo">
<div class="thumb">
		<a class="clip-link" data-id="'.$video["id"].'" title="'.$full_title.'" href="'.$url.'">
			<span class="clip">
				<img src="'.$video["thumb"].'" alt="'.$full_title.'" /><span class="vertical-align"></span>
			</span>
							
			
		</a>
		 <span class="timer">'.sec2hms($video["duration"]).'</span>
	</div>	
	</div>
';
}
echo '</div>';
}

}
}
echo '</div>
';
?>



<?php
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