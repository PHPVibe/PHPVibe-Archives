    <!-- Main Content -->
    <section id="wrapper">		
    	<!-- Featured -->

<div class="one last" style="padding-top:5px; overflow:hidden;" >

<?php
$o_url = $site_url.'user/'.$playlist_owner.'/'.seo_clean_url($playlist_owner_name) .'/';

 ?>

				 
<div class="profile-toolbox-bl" id="miniheader">
    <div class="profile-toolbox-br">
        <div class="profile-toolbox-tl">
            <div style="float: left; padding: 5px">
			<?php  if(!empty($playlist_owner_avatar)):  
?>
				<div style="float: left; width: 40px;">
				    <a href="<?php print $o_url; ?>">
						<img src="<?php print $site_url.'com/timthumb.php?src='.$playlist_owner_avatar.'&w=90&h=46&crop&q=100';?>" alt="User 19" class="cAvatar" />
					</a>
				</div>
				<?php endif; ?>
				<div style="margin: 0 0 0 100px;">
					<div><strong><span class="profile-toolbox-name"><?php print $playlist_owner_name; ?></span></strong></div>
					<?php print $lang['playlist']; ?>: <?php print $playlist_name; ?>
				</div>
			</div>			
			<div style="float:right;">
				<ul class="small-button" style="padding-top:5px;">
					 <li><a class="button big red icon mailopened" href="<?php print $site_url; ?>messages.php?method=compose&member=<?php print $playlist_owner; ?>"><?php print $lang['send-msg']; ?></a>
					</li>
					  <li><a class="button big red icon newspaper" href="<?php print $o_url; ?>&sk=wall"><?php print $lang['wall']; ?></a>
					</li>
					 <li><a class="button big red icon play" href="<?php print $o_url; ?>&sk=video"><?php print $lang['videos']; ?></a>
					</li>
					 <li><a class="button big red icon heart" href="<?php print $o_url; ?>&sk=likes"><?php print $lang['likes']; ?></a>
					</li>
				</ul>
			</div>
			<div style="clear: both;"></div>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?php print $config->site->url; ?>components/player/swfobject.js"></script>
<div id="mediaspace" style="width:955px; margin:0 auto; padding:1px;">
You need to have the <a href="http://www.macromedia.com/go/getflashplayer">Flash Player</a> installed and a browser with JavaScript support.
</div>



<script type='text/javascript'>

  var so = new SWFObject('<?php print $config->site->url; ?>components/player/player.swf','mpl','955','400','9');
  so.addParam('allowfullscreen','true');
  so.addParam('allowscriptaccess','always');
  so.addParam('wmode','opaque');  
  so.addVariable('playlistfile','<?php print $config->site->url; ?>xml_playlist.php?id=<?php print $Info->Get("id"); ?>');
  so.addVariable('skin','<?php print $config->site->url; ?>components/player/stormtrooper.zip');
  so.addVariable('image',' <?php print $config->site->url.$playlist_picture; ?>');
  so.addVariable('controlbar','bottom');  
  so.addVariable('playlistsize','300');  
  so.addVariable('playlist','right');  
  so.addVariable('repeat','list');  
  so.addVariable('hd.file','');
  so.addVariable('autostart','false');
  so.addVariable('dock', 'true');
  so.addVariable('youtube.quality','large');
  so.addVariable('plugins', 'hd-1,like-1,timeslidertooltipplugin-2');
  so.addVariable('stretching','fill');
  so.write('mediaspace');

</script>
         
<div class="one" style="margin:15px;width:960px; overflow:hidden;">
<div class="one_fifth">

<?php
 if(!empty($playlist_owner_avatar)):
print '<a href="'.$o_url.'"><img src="'.$site_url.'com/timthumb.php?src='.$playlist_owner_avatar.'&w=160&crop&q=100" /></a>'; 
endif;
print '<center><a href="'.$o_url.'"><h2>'.$playlist_owner_name.'</h2></a></center>';
?>
</div>
<div class="two_fifth">


 <div class="p-box-text">
<span class="social-arrow"></span>
<span class="p-box-descrip"> <h1> <?php print $playlist_name; ?> </h1></span>
<span class="p-box-count"><?php print $playlist_description; ?></span>
</div>
<div id="video_socialbox">
<ul>
<li> <div class="fb-like" data-send="false" data-layout="box_count" data-width="50" data-show-faces="false" data-font="verdana"></div></li>
	<li><a href="https://twitter.com/share" class="twitter-share-button" data-count="vertical" data-via="Marius_SEO">Tweet</a><script type="text/javascript" src="//platform.twitter.com/widgets.js"></script></li>
	<li><g:plusone size="tall"></g:plusone></li>
	</ul>
</div>
</div>

<div class="two_fifth last">
<?php
if(!$user->isAuthorized())
	{ ?>
	<p>To comment please login/register.</p>
<a class="get-in" href='<?php print $config->site->url; ?>login.php'><img src="<?php print $config->site->url; ?>tpl/images/light/t-button.png"/></a>
<a class="get-in" href='<?php print $config->site->url; ?>login.php'><img src="<?php print $config->site->url; ?>tpl/images/light/fb-button.png"/></a>


<?php }
$object_id = 'playlist_'.$Info->Get("id"); //identify the object which is being commented
include("./components/loadComments.php"); //load the comments and display  
echo ShowComments($video_id); 
?>

</div>
</div>
<div class="clear" style="height:15px;"></div>
		<h2 class="title-line alignright"><?php echo $playlist_owner_name; ?>'s <?php print $lang['playlists']; ?></h2>
		<div class="clear" style="height:10px;"></div>
		 <div id="channel-box" style="padding:10px 25px;">
		<?php
$playlist_result = dbquery("SELECT * FROM `playlists` where owner = '".$playlist_owner."' order by id DESC");
$iup = 1; 
while($rrow = mysql_fetch_array($playlist_result)){
 if (!empty($rrow['permalink'])) :
	$p_url = $site_url.'playlist/'.$rrow['id'].'/'.seo_clean_url($rrow['permalink']).'/';
 else : 	
 $p_url = $site_url.'playlist/'.$rrow['id'].'/'.seo_clean_url($rrow['title']).'/';
 endif;
 if (($iup % 4 == 0)) { $the_float ="last";} else { $the_float ="";}
	$playlists_output.= ' <div class="channel-box '.$the_float.'">';
	$playlists_output.= '<div class="overflow-hidden"><a href="'.$p_url.'"  title="'.$rrow['title'].'">
<span class="channel-box-hover"><span class="hover-video"></span></span>
</a><img src="'.$site_url.'com/timthumb.php?src='.$rrow['picture'].'&h=150&w=220&crop&q=100" alt="'.$rrow['title'].'"/>
</div>
<div class="box-body">
<h2 class="box-title"><a href="'.$p_url.'" rel="bookmark" title="'.$rrow['title'].'">'.$rrow['title'].'</a></h2>
</div>
</div>';
	$iup++;	
	}
	
	print $playlists_output;
 
 ?>


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
</div>