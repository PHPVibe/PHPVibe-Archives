<?php include("usidebar.tpl.php");
$BrowsePerPage = $config->video->bpp / 2;
 $CCOUNT     = 3;
//start feed
$limit = 'LIMIT ' .($pageNumber - 1) * $BrowsePerPage .',' .$BrowsePerPage; 
$newsq="select * from user_wall where u_id = '".$user_profile->getId()."' order by msg_id desc $limit";
$username = $user_profile->getDisplayName();
$avatar = $user_profile->getAvatar();
$cu_id = $user_profile->getId();
$u_cannonical = $site_url.'user/'.$user_profile->getId().'/'.seo_clean_url($username).'/';
$qt = 0;
echo '  <div class="main"><div class="block_title"><h2>'.$username.'</h2><div class="section-split"></div></div>';
$numberofresults = dbcount("*","videos","user_id ='".$user_profile->getId()."'");
$newsq ="select * from videos WHERE user_id ='".$user_profile->getId()."' ORDER BY id DESC $limit";
if ($result = $dbi->query($newsq, $qt)) {
echo '<div class="list-video" style="margin:10px 5px;width:500px; float:left;display:inline-block;">';

	foreach ($result as $video) {

			$title = stripslashes(substr($video["title"], 0, 109));
			$full_title = stripslashes(str_replace("\"", "",$video["title"]));			
			$url = $site_url.'video/'.$video["id"].'/'.seo_clean_url($full_title) .'/';
			
		
echo '
<div id="video-'.$video["id"].'" class="video">
<div class="thumb">
		<a class="clip-link" data-id="'.$video["id"].'" title="'.$full_title.'" href="'.$url.'">
			<span class="clip">
				<img src="'.$video["thumb"].'" alt="'.$full_title.'" /><span class="vertical-align"></span>
			</span>
							
			<span class="overlay"></span>
		</a>
		 <span class="timer">'.sec2hms($video["duration"]).'</span>
	</div>	
	<div class="data">
			<h2 class="title"><a href="'.$url.'" title="'.$full_title.'">'.$title.'</a></h2>	
<p class="meta">
				<span class="author">Added by <a href="'.$u_cannonical.'" title="'.$username.'" rel="author">'.$username.'</a></span>
				<span class="time">'.time_ago($video["date"]).'</span>
			</p>			
			<p class="stats"><span class="views"><i class="count">'.$video["views"].'</i> </span><span class="likes"><i class="count">'.$video["liked"].'</i></span></p>
			<div class="desc">'.substr(strip_tags(stripslashes($video["description"])), 0, 200).'</div></div>';
$object_id = 'video_'.$video["id"]; //identify the object which is being commented
echo show_comments($object_id); //load the comments and display  
			echo '
		
	</div>
';
}
}
$dbi->disconnect();
?>
</div>
<?php

$ulikes="select likes.vid, videos.*,users.display_name from likes LEFT JOIN videos ON likes.vid =videos.id LEFT JOIN users ON videos.user_id =users.id WHERE likes.uid ='".$cu_id."' and likes.type ='like' ORDER BY id DESC limit 0,1000";
$qtl = 0;
$qtln = 'likes_'.$cu_id;
if ($result = $dbi->query($ulikes, $qtl, $qtln)) {
?>

 <div id="userflow" class="video-sidebar">
 <?php echo '<div class="black_bt"><h2>'.$lang['likes'].'</h2></div>'; ?>
 <div class="carousel-wrap">
		<div class="items">
			<ul class="slider-pagination">
							
 <?php

	foreach ($result as $related) {
	$new_seo_url = $site_url.'video/'.$related['id'].'/'.seo_clean_url($related['title']) .'/';
echo '
					<li data-id="'.$related['id'].'" class="item-post">
				<div class="inner">
					
	<div class="thumb">
		<a class="clip-link" data-id="'.$related['id'].'" title="'.stripslashes($related['title']).'" href="'.$new_seo_url.'">
			<span class="clip">
				<img src="'.$related['thumb'].'" alt="'.stripslashes($related['title']).'" /><span class="vertical-align"></span>
			</span>
							
			<span class="overlay"></span>
		</a>
	</div>			
					<div class="data">
						<h2 class="title"><a href="'.$new_seo_url.'" rel="bookmark" title="'.stripslashes($related['title']).'">'.stripslashes($related['title']).'</a></h2>
			
						<p class="meta">
							<span class="time">'.$lang['by'].' '.stripslashes($related['display_name']).'</span>
						</p>
					</div>
				</div>
				</li>
		
	';
	}

?>
		
							</ul>
		</div><!-- end .items -->
		
		<a class="prev" href="#"></a>
		<a class="next" href="#"></a>
	</div><!-- end .carousel-wrap -->
	</div><!-- end .carousel -->
<div class="clear">	</div>	
</div>
<?php 
}
$dbi->disconnect();
echo '<div class="clear"></div>';
$a = new pagination;	
$a->set_current($pageNumber);
$a->set_first_page(true);
$a->set_pages_items(6);
$a->set_per_page($BrowsePerPage);
$a->set_values($numberofresults);
$a->show_pages($pagi_url);

echo '<br style="clear:all" /></div>';
?>
</div>
</div>
        