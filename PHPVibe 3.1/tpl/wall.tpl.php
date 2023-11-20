<?php include("sidebar.tpl.php");
$BrowsePerPage = $config->video->bpp / 2;
$CCOUNT     = 3;
//unset jwplayer as it cause conflict
$config->video->player = "1";
$width = 328;
$height = 206;
$vid = new phpVibe($width, $height);
function shutAutoplay ($source) {
/*shutsdown autoplay for Youtube, Vimeo, Metacafe videos */
$source = str_replace("true", "false",$source);
$source = str_replace("&amp;autoplay=1", "",$source);
$source = str_replace("&autoplay=1", "",$source);
$source = str_replace("autoPlay=yes", "autoPlay=no",$source);
return $source;
}
//start feed
$limit = 'LIMIT ' .($pageNumber - 1) * $BrowsePerPage .',' .$BrowsePerPage; 
if($user->isAuthorized()) {
$numberofresults = dbcount("*","user_wall","u_id ='".$user->getId()."' or u_id in(SELECT users_friends.id FROM users_friends WHERE users_friends.fid='".$user->getId()."')");
$newsq ="select user_wall.*, users.* from user_wall LEFT JOIN users ON user_wall.u_id = users.id WHERE user_wall.u_id ='".$user->getId()."' or user_wall.u_id in(SELECT users_friends.id FROM users_friends WHERE users_friends.fid='".$user->getId()."') ORDER BY user_wall.msg_id DESC $limit";
$qt = 0;
$xfeed= 'feed'.$pageNumber.'by'.$user->getId();
} else {
$numberofresults = dbcount("*","user_wall");
$newsq ="select user_wall.*, users.* from user_wall LEFT JOIN users ON user_wall.u_id = users.id ORDER BY user_wall.msg_id DESC $limit";
$qt = 600;
$xfeed= 'guestfeed'.$pageNumber;
}


$qt = 0;
echo '  <div class="main">'; 
echo '<div class="newsfeed" style="margin:10px 5px;width:500px; float:left;display:inline-block;">';
	if($user->isAuthorized()) {
?>

 <div class="enterMessage">
 <form method="post" name="form" action="">
            <input type="text" id="update" name="enterMessage" placeholder="<?php echo $lang['sup'];  ?>" />
            <div class="sendStatus">
                <a href="#" title="" class="attachPhoto"></a>               
                <input type="submit" name="sendMessage" class="buttonS bLightBlue" value="<?php echo $lang['post-now'];  ?>" id="update_button"/>
            </div>
				</form>
        </div>
		
<?php
	echo ' <div class="mythumb">
			<span class="clip">
				<img src="'.$site_url.'com/timthumb.php?src='.$user->getAvatar().'&h=50&w=50&crop&q=100" alt="'.$title.'" /><span class="vertical-align"></span>
			</span>				
	</div>	
<div class="picsShare"></div>		
			';
				
}
if ($result = $dbi->query($newsq, $qt,$xfeed)) {


	foreach ($result as $video) {

			$username = $video["display_name"];			
			$u_cannonical = $site_url.'user/'.$video["id"].'/'.seo_clean_url($video["display_name"]);
			$url = $site_url.'status/'.$video["msg_id"].'/';
			$title = substr(strip_tags(stripslashes($video["message"])), 0, 200);
		
echo '
<div id="status-'.$video["msg_id"].'" class="status">
<div class="thumb">
		<a class="clip-link" data-id="'.$video["msg_id"].'" title="'.$username.'" href="'.$u_cannonical.'">
			<span class="clip">
				<img src="'.$site_url.'com/timthumb.php?src='.$video["avatar"].'&h=50&w=50&crop&q=100" alt="'.$title.'" /><span class="vertical-align"></span>
			</span>
							
			
		</a>
	</div>	
	<div class="data">
			<h2 class="title"><a href="'.$url.'" title="'.$title.'">'.$title.'</a></h2>	<p class="meta">
				<span class="author">Added by <a href="'.$u_cannonical.'" title="'.$username.'" rel="author">'.$username.'</a></span>
				| <span class="time">'.time_ago($video["time"]).'</span>
			</p>';
			if(!empty($video["att"]) && $vid->isValid($video["att"])) {
			  echo '<div class="media">'.shutAutoplay($vid->getEmbedCode($video["att"])).'</div>';
			}
			if(!empty($video["picture"])) {
			  echo '<div class="media"><a href="'.$video["picture"].'" class="lightbox"><img src="'.$video["picture"].'"/></a></div>';
			}
			echo '<div class="desc">'.strip_tags(stripslashes($video["message"])).'';
			if ($video["id"] == $user->getId() ) {
		echo '<div class="btnBottom">	<a href="'.$site_url.'ajax/status_edit.php?id='.$video["msg_id"].'&lightbox[width]=500&lightbox[height]=120&amp;lightbox[modal]=true" class="button left lightbox"><span class="icon icon145"></span></a>
		<a href="#" id="'.$video["msg_id"].'" class="button right deletebox"><span class="icon icon186"></span></a>
		</div>
		';
  }
		echo '	</div></div>';
$object_id = 'status_'.$video["msg_id"]; //identify the object which is being commented
echo show_comments($object_id); //load the comments and display  
			echo '
		
	</div>
';
}
}
if($user->isAuthorized()) {
$ulikes="select videos.*, users.display_name from videos LEFT JOIN users ON videos.user_id = users.id WHERE user_id in (SELECT users_friends.id FROM users_friends WHERE users_friends.fid='".$user->getId()."') ORDER BY videos.id DESC limit 0,30";
?>
</div>
 <div id="userflow" class="video-sidebar">
 <?php echo '<div class="black_bt"><h2>'.$lang['videos'].' '.$lang['from-friends'].'</h2></div>'; ?>
 <div class="carousel-wrap">
		<div class="items">
			<ul class="slider-pagination">
							
 <?php
if ($result = $dbi->query($ulikes, 0)) {
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
}
$dbi->disconnect();
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
        