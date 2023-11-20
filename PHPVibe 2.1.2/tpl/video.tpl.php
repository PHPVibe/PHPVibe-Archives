<div class="clear"></div>
	
<div class="video-player-wrapper" id="video-player-wrapper">

<div class="video-player">
<div class="suggestions">
<div class="re-video-items">	
<?php

 //return count($related);
 
 for($i=0; $i<count($related); $i++) {
				$new_yt = $related[$i]['id'];
				$new_title = $related[$i]['title'];
				$small_title = substr($new_title, 0, 40);				
				$new_description = substr($new_title, 0, 90);
				$new_seo_url = $site_url.'video/'.$new_yt.'/'.seo_clean_url($new_title) .'/';
	            $new_duration = $related[$i]['duration'];
				
				$idlist .= '
	
<div class="re-video-item" id="re-video-'.$new_id.'" title="'.$new_title.'">
<div class="re-video-item">
<div class="re-video-thumb">      
<a class="re-video-thumb-url" href="'.$new_seo_url.'" style="width: 112px; height:84px;"><img src="'.Get_Thumb($new_yt).'" width="112" height="84" alt="" /></a>
<span class="re-video-durationHMS">'.sec2hms($new_duration).'</span>                   
</div>
<div class="re-video-summary">
<div class="re-video-title">
<a href="'.$new_seo_url.'">'.$small_title.'</a>
</div>        
<div class="re-video-details small">               
<div class="re-video-lastupdated">'.$new_description .'</div>
 </div>
 </div>
<div class="clr"></div>
</div>
</div><!---end-->
	';
			}
			
print $idlist;

?>	
</div>
</div>
<div id="playlistPlayer">
<div id="videoPlayer" class="swf-container">
<h1><?php 
if(isset($channel) && !empty($channel)):
echo '<span style="color:#259ae0;"> '.$channel.'! </span>';
endif;
echo  $video_title;

?> </h1>
<?php
if ($config->video->player == "1") :
echo '<iframe width="671" height="366" src="http://www.youtube.com/embed/'.$video_id.'?rel=0&amp;hd=1&amp;wmode=transparent" frameborder="0"></iframe>';
 else:  ?>
<script type="text/javascript" src="<?php print $config->site->url; ?>components/player/swfobject.js"></script>
<div id="mediaspace">
You need to have the <a href="http://www.macromedia.com/go/getflashplayer">Flash Player</a> installed and a browser with JavaScript support.
</div>
<script type='text/javascript'>
  var so = new SWFObject('<?php print $config->site->url; ?>components/player/player.swf','mpl','671','366','9');
  so.addParam('allowfullscreen','true');
  so.addParam('allowscriptaccess','always');
  so.addParam('wmode','opaque');
  so.addVariable('file','http://www.youtube.com/watch?v=<?php echo $video_id; ?>');
  so.addVariable('image','http://i2.ytimg.com/vi/<?php echo $video_id; ?>/0.jpg');
  so.addVariable('skin','<?php print $config->site->url; ?>components/player/stormtrooper.zip');
  so.addVariable('controlbar','over');
  so.addVariable('logo.file','<?php print $config->site->url; ?>components/player/playerlogo.png');
  so.addVariable('logo.link','<?php echo $canonical;?>');
  so.addVariable('autostart','true');
  so.addVariable('logo.hide','false');
  so.addVariable('logo.position','top-right');
//so.addVariable('stretching','fill');
so.write('mediaspace');
</script>	
<?php
endif; 
?>

</div>
<p><?php print $ad_under_video ; ?></p>
</div>
</div>
</div>
<section id="wrapper">
<div id="video_btn" class="two_third">
<ul>
	<li><a id="embed" href="#embedcodediv" class="btn_smallwhite ico_link"> <?php print $lang['embed']; ?></a></li>
	<li><a id="repeat" href="http://www.youtube.com/watch?v=<?php echo $video_id; ?>" class="btn_smallwhite ico_action"><?php print $lang['repeat']; ?></a></li>
	<li><a id="like" href="#" onClick=";return false;" class="btn_smallwhite ico_heart"><?php print $lang['like']; ?></a></li>
	<li><a id="playlist_btn" href="#" onClick=";return false;" class="btn_smallwhite ico_heart">Add to Playlist</a></li>
</ul>
</div>	
<div id="video_socialbox" class="one_third last">
<ul>
<li> <div class="fb-like" data-send="false" data-layout="box_count" data-width="50" data-show-faces="false" data-font="verdana"></div></li>
	<li><a href="https://twitter.com/share" class="twitter-share-button" data-count="vertical" data-via="Marius_SEO">Tweet</a><script type="text/javascript" src="//platform.twitter.com/widgets.js"></script></li>
	<li><g:plusone size="tall"></g:plusone></li>
	</ul>
</div>
<div class="clear"></div>
<div id="playlist_container" class="one last" style="display:none; padding-bottom:20px; border-bottom: solid 3px #b01e33;">
<?php 
if($user->isAuthorized())
	{ 

$me=$user->getId();
$playlist_result = dbquery("select * from playlists WHERE owner = '".$me."' ORDER BY id DESC");
$num_playlists = mysql_num_rows($playlist_result);
?>
<form id="playlistform" action="<?php echo $site_url;?>com/add_to.php" method="post" class="styled-form" style="width:90%!important; padding:10px;">
<input type="hidden" id="video" name="video" value="<?php echo $video_id; ?>" />
<div class="row inner_labels">
<span class="label">Select a playlist:</span>
<?php
if ($num_playlists >0) :

while($row = mysql_fetch_array($playlist_result)) {
echo '
								<input type="radio" id="playlist_id" name="playlist_id" value="'.$row["id"].'" />

								<label for="'.$row["id"].'">'.$row["title"].'</label>

							';
}
else:
echo '<div class="info-box"><a href="'.$site_url.'create-playlist.php">Please create a playlist first >></a></div> ';
endif;
?>
	</div>
<div style="display:none;">
 <input type="submit" name="submit" id="submit" value="Add video" />
 </div>
</form>
<br/> <div id="preview"></div><br /> <br />
<?php } else {
?>
<div class="alert-box">
Please login or register to create an playlist.</div>
<?php
} ?>
</div>		 

	<div id="voting_result" style="display:none;"></div>		 

<div class="one" style="padding-left:12px;">	
<div class="two_fifth">

<br/>

<?php 

if (!empty($featured) && ($featured == "1")):
echo '[<a href="'.$site_url.'videos/featured/">'.ucfirst($lang['featured']).'</a>] <br />  ';
endif;

echo '<h3>'.$video_title.'</h3>';


?>
<br/>
 <div class="xtoggle one"><h4><img src="<?php print $config->site->url; ?>/tpl/images/icons/link2.png"/>Video tags</h4>
<div class="xtoggle-content" data-show="false">
<?php 
echo ' <div class="video_tag_cloud one">';
  	
$keywords_array = explode(', ', $video_tags);
if (count($keywords_array) > 0):
foreach ($keywords_array as $keyword):
if ($keyword != ""):
$qterm = str_replace(" ", "+",$keyword);
$k_url = $site_url.'show/'.$qterm.'/';
echo "<a href='".$k_url."'>".$keyword."</a>";
endif;
endforeach;
endif;
 ?>
</div> 
</div> 
</div> 
<div class="xtoggle one"><h4><img src="<?php print $config->site->url; ?>/tpl/images/icons/info.png"/><?php print $lang['videscription']; ?></h4>
<div class="xtoggle-content" data-show="false">
<?php echo " <br /> <p>".$video_description."</p>" ;  ?>
</div> 
</div> 
<div class="xtoggle one"><h4><img src="<?php print $config->site->url; ?>/tpl/images/icons/facebook.png"/>Facebook comments</h4>
<div class="xtoggle-content" data-show="false" style="min-height:200px">
<div class="fb-comments" data-href="<?php echo $canonical;?>" data-num-posts="4" data-width="364" ></div>

</div> 
</div> 


<div class="clear" style="height:10px;"></div>	

</div>	
<div class="two_fifth">
<?php
if(!$user->isAuthorized())
	{ ?>
	<p>To comment please login/register.</p>
<a class="get-in" href='<?php print $config->site->url; ?>login.php'><img src="<?php print $config->site->url; ?>tpl/images/light/t-button.png"/></a>
<a class="get-in" href='<?php print $config->site->url; ?>login.php'><img src="<?php print $config->site->url; ?>tpl/images/light/fb-button.png"/></a>


<?php }
$object_id = 'video_'.$video_id; //identify the object which is being commented
include("./components/loadComments.php"); //load the comments and display  
echo ShowComments($video_id); 
?>
<br />
<div class="clear"></div>	
</div>
<div class="one_fifth last">
<center><?php echo $ad_profile_page; ?></center>
</div>
</div>	
<div class="clear"></div>		
		</div>
<br/> 
<br />
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
</div>   	

<div class="box one" id="embedcodediv" style="display:none; width:290px;">
<div class="header">
<h2>Embed the video</h2>
</div>			

<div class="content padding">

	Link to it: <br />
	<input name="txt" value="<?php echo $canonical;?>" type="text" class="form-input"/>
<br/> <br/> 
	<p>Embed it:</p>
	<br />
	<textarea  class="form-input" cols="20" rows="2" style="width:260px; height:50px; font-size:11px;" maxlength="1045" >
<iframe width="671" height="366" src="http://www.youtube.com/embed/<?php echo $video_id; ?>?rel=0&amp;hd=1" frameborder="0"></iframe>
<br/> <small>As seen on : <a href="<?php echo $canonical;?>"><?php echo $video_title; ?></a></small> 
</textarea>
	
	</div>
	</div>
