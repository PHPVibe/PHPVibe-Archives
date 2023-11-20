<div class="video-main">
<?php 
if(nsfilter()) { ?>
<div class="nsfwcontrol">
<?php echo $lang['filter_explain']; ?>
<br /> <br /> 
<a class="buttonS bRed" href="<?php echo $canonical; ?>&filter=off"><span><?php echo $lang['filteroff']; ?></span></a>   <?php echo $lang['underq']; ?> <a class="buttonS bLightBlue" href="<?php echo $site_url; ?>"><span><?php echo $lang['backh']; ?></span></a>
</div>
<?php } else { ?>

<div id="videoplayer" style="width:<?php echo $width ;?>px;">
	
<div class="social-like">
<a href="http://pinterest.com/pin/create/button/?url=<?php echo $canonical; ?>&media=<?php echo $video_thumb; ?>&description=<?php echo $video_title;?>! " class="pin-it-button" count-layout="vertical"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>
<div class="fb-like" data-send="false" data-layout="box_count" data-width="40" data-show-faces="false"></div>
<div class="g-plusone" data-size="tall"></div>
<a href="https://twitter.com/share" class="twitter-share-button" data-count="vertical">Tweet</a>
 </div>	
 <div class="head-data">
			<h1 class="title"><a href="<?php echo $canonical; ?>" title="<?php echo $video_title; ?>"><?php echo $video_title; ?></a></h1>	
<p class="meta">
				<span class="author">Added by <a href="<?php echo $sharer_link; ?>" title="Marius" rel="author"><?php echo $sharer; ?></a></span> | 
				<span class="time"><?php echo time_ago($video_date); ?></span>
			</p>			
			<p class="stats"><span class="views"><i class="count"><?php echo $video_views; ?></i> </span><span class="likes"><i class="count"><?php echo $video_likes; ?></i></span></p>
<div class="clear"></div>
			</div>	
<?php echo $embedvideo;  ?>
<div class="buttons" style="margin-left:-5px!important;">
  <div class="dropdown">
    <a href="#" class="button"><span class="icon icon191"></span><span class="label"><?php echo $sharer; ?></span><span class="toggle"></span></a>
    <div class="dropdown-slider">
      <a href="<?php echo $sharer_link; ?>" class="ddm"><span class="icon icon64"></span><span class="label"><?php echo $sharer; ?></span></a>
      <a href="#" class="ddm"><span class="icon icon104"></span><span class="label">Likes</span></a>
     </div> <!-- /.dropdown-slider -->
  </div> <!-- /.dropdown -->
    <a href="javascript:void(0)" id="<?php echo $basic_id; ?>" class="button left addlike"><span class="icon icon101"></span><span class="label">Like (<?php echo $video_likes; ?>)</span></a>
  
  <a href="javascript:void(0)" id="<?php echo $basic_id; ?>" class="button middle adddislike"><span class="icon icon100"></span><span class="label"><?php echo $video_dislikes; ?></span></a>
    <a href="#embeder" id="embed" class="button middle"><span class="icon icon25"></span></a>

  <div class="dropdown ">
    <a href="#" class="button right"><span class="icon icon142"></span><span class="toggle"></span><span class="label">Add to playlist</span></a>
    <div class="dropdown-slider right">
	<?php 
if($user->isAuthorized()){ 

$playlist_result = dbquery("select * from playlists WHERE owner = '".$user->getId()."' ORDER BY id DESC");
$num_playlists = mysql_num_rows($playlist_result);
	
	if ($num_playlists >0) :
	while($row = mysql_fetch_array($playlist_result)) {
    echo '<a class="ddm lightbox" href="'.$site_url.'com/addtoplaylist.php?playlist_id='.$row["id"].'&video='.$basic_id.'&pname='.$row["title"].'&lightbox[width]=250&lightbox[height]=60"><span class="label">'.$row["title"].'</span></a></li>';
	} 
	endif;
	echo '
<a href="'.$site_url.'myplay/&create=1" class="ddm"><span class="label">Create playlist</span></a>';
	
	?>       
  
<?php
} else {
	echo '
<a class="ddm href="'.$site_url.'login.php"><span class="label">Login</span></a>
<a class="ddm" href="'.$site_url.'register.php"><span class="label">Register</span></a>
	';
}
?>
    
    </div> <!-- /.dropdown-slider -->
  </div> <!-- /.dropdown -->
  </div> <!-- /.buttons -->
<div id="voting_result" style="display:none;"></div>	

<div class="clear"></div>
 <div id="main-description" style="display:block; width:100%;">
<p><?php echo $video_description; ?></p>
<p><?php echo $lang['channel']; ?>: <a href="<?php echo $channel_url;?>"><?php echo $channel; ?></a></p>
<p> <?php echo $lang['vitags']; ?>:
<?php 	
$keywords_array = explode(', ', $video_tags);
if (count($keywords_array) > 0):
foreach ($keywords_array as $keyword):
if ($keyword != ""):
$qterm = seo_clean_url($keyword);
$k_url = $site_url.'show/'.$qterm.'/';
echo "<a href='".$k_url."'>".$keyword."</a> , ";
endif;
endforeach;
endif;
 ?>
 </p>
	<div class="bottom-gradient"></div>	
 </div>
<div class="clear"></div>
<?php
$object_id = 'video_'.$basic_id; //identify the object which is being commented
echo show_comments($object_id); //load the comments and display  
if(!$user->isAuthorized()) {
echo '   <center>';
if($config->site->facebook->login) 		{
   echo '
   <a href="'.$config->site->url.'login.php?platform=facebook"><img src="'.$config->site->url.'tpl/images/fb-signin.png" alt="Connect with Fb" /></a>';
   }
    if($config->site->twitter->login) {
    echo '
   <a href="'.$config->site->url.'login.php?platform=twitter"><img src="'.$config->site->url.'tpl/images/tw-signin.png" alt="Connect with Twitter"/></a>';
   }
   ?>
</center>
<?php } ?>
</div>
		
 <?php } ?>
 <div id="video-sidebar" class="video-sidebar">
 <div class="carousel-wrap">
		<div class="items">
			<ul class="slider-pagination">
							
 <?php
if ($result = $dbi->query($the_relq, $qt, 'rel_'.$basic_id)) {
	foreach ($result as $related) {
	$vurl = parse_url($related["thumb"]);

if($vurl['scheme'] !== 'http'){
$related["thumb"] = $config->site->url.$related["thumb"];
}
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
<br style="clear:both;" />		
 </div>

<br/> 
<br />
<div id="embeder" style="display:none; width:400px; height:500px;">
<h2>Link</h2>
<form class="form">
<textarea><?php echo $canonical; ?></textarea>

</form>
<h2>Link (html)</h2>
<form class="form">
<textarea><a href="<?php echo $canonical; ?> "><?php echo $video_title; ?></a></textarea>

</form>
<h2><?php echo $lang['embed']; ?></h2>
<form class="form">
<textarea><?php echo $vid->getEmbedCode($video_source);?> <p><small><a href="<?php echo $canonical; ?> "><?php echo $video_title; ?></a> </small></p></textarea>

</form>
</div>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {return;}
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=<?php print $config->site->facebook->app_id; ?>";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>


</div>   	


</div>   	