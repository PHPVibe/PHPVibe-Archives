<div class="clear"></div>
	
	<div class="video-player-wrapper" id="video-player-wrapper">

		<div class="video-player">

			<div class="suggestions">

	<div class="re-video-items">	
<?php
echo $related;
?>	

			</div>
</div>
<div id="playlistPlayer">
<div id="videoPlayer" class="swf-container">
<iframe width="671" height="366" src="http://www.youtube.com/embed/<?php echo $video_id; ?>?rel=0&amp;hd=1" frameborder="0"></iframe>
</div>
<p><img src="http://videoinedit.com/test_banner.jpg"/></p>
</div>
</div>
</div>
<section id="wrapper">
<div id="video_btn" class="column-half">
<ul>
	<li><a id="embed" href="#embedcodediv" class="btn_smallwhite ico_link"> Embed video</a></li>
	<li><a id="repeat" href="http://www.youtube.com/watch?v=<?php echo $video_id; ?>" class="btn_smallwhite ico_action">Repeat</a></li>
	<li><a id="like" href="#" onClick=";return false;" class="btn_smallwhite ico_heart">Like</a></li>

</ul>
</div>	
<div id="video_socialbox" class="column-half column-last">
<ul>
<li> <div class="fb-like" data-send="false" data-layout="box_count" data-width="50" data-show-faces="false" data-font="verdana"></div></li>
	<li><a href="https://twitter.com/share" class="twitter-share-button" data-count="vertical" data-via="Marius_SEO">Tweet</a><script type="text/javascript" src="//platform.twitter.com/widgets.js"></script></li>
	<li><g:plusone size="tall"></g:plusone></li>
	</ul>
</div>
<div class="clear"></div>
	<div id="voting_result" style="display:none;"></div>		 
<div class="column-full">
<br />		
	
<div class="column-half">
<div class="box one" style="margin-left:5px;">
<div class="header">
<h2>Description</h2>
<span class="toggle"></span>
</div>			

<div class="content padding">

<?php 
echo '<h3>'.$video_title.'</h3>';
echo $video_description ; 

?>
  </div>
</div>
<div class="box one" style="margin-left:5px;">
<div class="header">
<h2>Video tags</h2>
<span class="toggle"></span>
</div>			

<div class="content padding">
  <div class="video_tag_cloud">
  	
<?php 

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
</div>
<div class="column-half column-last">
<div class="box one" style="margin-right:4px;">
<div class="header">
<h2>Our friends say</h2>
<span class="toggle"></span>
</div>			

<div class="content padding">
<?php
$object_id = 'video_'.$video_id; //identify the object which is being commented
include("./components/loadComments.php"); //load the comments and display   
?>
<div class="clear"></div>		
</div>

</div>
<div class="box one" style="margin-right:4px;">
<div class="header">
<h2>Guest comments</h2>
<span class="toggle"></span>
</div>			

<div class="content padding">

<div class="fb-comments" data-href="<?php echo $canonical;?>" data-num-posts="4" data-width="460" ></div>
<div class="clear"></div>		
</div>

</div>
</div>

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
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=100493036705353";
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
