<div class="video-main">
<h1><?php echo $video_title; ?> </h1>
 <div class="under_video one">
<img src="<?php echo theme("images");?>icons/color/user.png" alt="" class="icon_small" /><span class="v_txt"><a href="<?php echo $sharer_link; ?>" title="<?php echo $sharer; ?>"><?php echo $sharer; ?> </a>  </span>
<img src="<?php echo theme("images");?>icons/color/hourglass2.png" alt="" class="icon_small icon_pad" /><span class="v_txt"><?php echo $video_time; ?>   </span> 
<img src="<?php echo theme("images");?>icons/color/eye.png" alt="" class="icon_small icon_pad " /> <span class="v_txt"><?php echo $video_views; ?> </span> 
<div class="social-like">
<div class="fb-like" data-send="false" data-layout="button_count" data-width="30" data-show-faces="false"></div>
<g:plusone size="medium"></g:plusone>
<a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>
 </div>	
  </div>	
<?php 
if($nsfw < 1 || $user->isAuthorized()) {
echo $vid->getEmbedCode($video_source);
}else {
echo '<a href="'.$site_url.'login.php"><img src="'.theme("images").'nsfw.big.png" style="padding: 15px 64px;"/></a>';
}

?>
 <div class="one">

<ul class="buttonlist">
<li><a href="javascript:void(0)" onclick="javascript:likes.vote( jQuery( this ) , <?php echo $basic_id;?> );" class="specialbtn btn_like32 biglike" id="ilikevideo_<?php echo $basic_id;?>"><span>Like (<?php echo $video_likes; ?>)</span></a></li>
<li><a href="javascript:void(0)" onclick="javascript:likes.vote( jQuery( this ) , <?php echo $basic_id;?> );" class="specialbtn btn_not32 bigdislike" id="ilikevideo_<?php echo $basic_id;?>"><span>Dislike (<?php echo $video_dislikes; ?>)</span></a></li>
<li><a href="#embeder" id="embed" class="btn btn_link"><span>Embed</span></a></li> 
<li><a href="#" id="addtoplaylist" data-dropdown="#dropdown-1" class="btn btn_folder"><span>Collect</span></a></li> 

<li><a href="<?php print $config->site->url; ?>report/<?php echo $basic_id;?>/" class="btn btn_flag"><span>Flag</span></a></li>  
<li style="float:right; margin-right:0px;"><a onclick="window.open('http://www.facebook.com/sharer.php?u=<?php echo $canonical; ?>', 'fb_share', 'menubar=1,resizable=1,width=700,height=350');" class="specialbtn btn_facebook"><span>Share it</span></a></li>     		
 </ul>
<div class="clear"></div>
</div>
<div id="voting_result" style="display:none;"></div>	
<div class="clear"></div>
 <div id="main-description" style="display:block; width:100%;">
<p><?php echo $video_description; ?></p>
<p>Channel: <a href="<?php echo $channel_url;?>"><?php echo $channel; ?></a></p>
<p> Tags:
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
 <p><img src="http://feedmevideos.com/uploads/ads-728.jpg"/></p>
 
 
	 
<div class="clear"></div>


<div class="phpvibe-box">
<div class="box-head-light"><h3>Comments</h3></div>
<div class="box-content grey-bg">
<?php
$object_id = 'video_'.$basic_id; //identify the object which is being commented
echo show_comments($object_id); //load the comments and display  
?>
</div>
</div>
</div>
<div class="video-sidebar">
<img src="http://feedmevideos.com/uploads/kardashian-kollection-sears-ad.jpg"/>
<div id="video-bar ">	
<div id="related_list">
				
<?php echo $idlist; ?>	
</div>
</div>
</div>		
<br/> 
<br />
<div id="embeder" style="display:none; width:400px; height:500px;">
<h2>Share link</h2>
<form class="form">
<textarea><?php echo $canonical; ?></textarea>

</form>
<h2>Link to this</h2>
<form class="form">
<textarea><a href="<?php echo $canonical; ?> "><?php echo $video_title; ?></a></textarea>

</form>
<h2>Embed</h2>
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
<?php 
if($user->isAuthorized()){ 

$playlist_result = dbquery("select * from playlists WHERE owner = '".$user->getId()."' ORDER BY id DESC");
$num_playlists = mysql_num_rows($playlist_result);

?>
<div id="dropdown-1" class="dropdown-menu has-tip">
    <ul>
	<?php 
	
	if ($num_playlists >0) :
	while($row = mysql_fetch_array($playlist_result)) {
    echo '<li><a class="lightbox" href="'.$site_url.'com/addtoplaylist.php?playlist_id='.$row["id"].'&video='.$basic_id.'&pname='.$row["title"].'&lightbox[width]=250&lightbox[height]=60">'.$row["title"].'</a></li>';
	} 
	echo '<li class="divider"></li>
<li><a href="'.$site_url.'myplay/&create=1">New playlist</a></li>';
	endif;
	?>       
    </ul>
</div>
<?php
} else {
	echo '<div id="dropdown-1" class="dropdown-menu has-tip">
    <ul>
<li><a href="'.$site_url.'login.php">Login</a></li>
<li><a href="'.$site_url.'register.php">Register</a></li>
	 </ul>
</div>';
}
?>

</div>   	


