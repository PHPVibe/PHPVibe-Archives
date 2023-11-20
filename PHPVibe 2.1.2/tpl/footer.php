<?php
$cachefoot = seo_clean_url($lang['home']). "-footer";
 if(!$Cache->Start("$cachefoot")){  
?>
<div class="clear"></div>
<center><?php print $ad_footer; ?></center>
<!-- Footer -->
    	<footer id="footer">
    		<span class="left-footer">
    			    		&copy; <?php echo date("Y");?>	<a href="<?php print $config->site->url; ?>"><?php print $config->site->name; ?></a>
    			    		    			    		<br />Powered by <a class="signature" href="<?php print $config->core->url; ?>">  <?php print $config->core->name; ?> v<?php print $config->core->version; ?></a>

							</span>
    		<span class="right-footer">
			<a href="http://www.youtube.com" target="_blank" title="This application utilizes Youtube API"><img src="<?php print $config->site->url; ?>/tpl/images/ytp_powered_by.png" border="0"/></a>
    			    		
							</span>
							
			
    	</footer>
		
		<div id="footmenu_wrapper">
			<div id="footmenu" class="nav_up bar_nav round_all clearfix">
		
				<ul class="round_all clearfix">
					<li class="round_left"><a href="<?php print $config->site->url; ?>">
						<img src="<?php print $config->site->url; ?>components/sherpa/images/icons/white/bended_arrow_left.png">
						<?php print $lang['home']; ?>
						<span class="icon">&nbsp;</span></a>
						</li>
	<li class=""><a href="<?php print $config->site->url; ?>">
						<img src="<?php print $config->site->url; ?>components/sherpa/images/icons/white/Globe.png">
						<?php print $lang['select-language']; ?>
						<span class="icon">&nbsp;</span></a>
					<ul>
					<li><a href="<?php print $config->site->url; ?>?lang=en">
						<img src="<?php print $config->site->url; ?>components/sherpa/images/cflags/us.png">
						English</a>
					</li> 
					<li><a href="<?php print $config->site->url; ?>?lang=ro">
						<img src="<?php print $config->site->url; ?>components/sherpa/images/cflags/ro.png">
						Romanian</a>
					</li> 
					<li><a href="<?php print $config->site->url; ?>?lang=it">
						<img src="<?php print $config->site->url; ?>components/sherpa/images/cflags/it.png">
						Italian</a>
					</li> 
					<li><a href="<?php print $config->site->url; ?>?lang=tr">
						<img src="<?php print $config->site->url; ?>components/sherpa/images/cflags/tr.png">
					Turkysh</a>
					</li> 
					<li><a href="<?php print $config->site->url; ?>?lang=dk">
						<img src="<?php print $config->site->url; ?>components/sherpa/images/cflags/dk.png">
					Danish</a>
					</li> 
					<li><a href="<?php print $config->site->url; ?>?lang=de">
						<img src="<?php print $config->site->url; ?>components/sherpa/images/cflags/de.png">
					German</a>
					</li> 
					</ul>
					</li>

					<li><a href="">
						<img src="<?php print $config->site->url; ?>components/sherpa/images/icons/white/film_strip_2.png">
						Videos
						<span class="icon">&nbsp;</span></a>
					<ul>
	<li><a href="<?php print $config->site->url; ?>videos/featured/">
						<img src="<?php print $config->site->url; ?>components/sherpa/images/icons/white/Headphones.png">
						<?php print $lang['featured']; ?></a>
					</li> 	
		<li><a href="<?php print $config->site->url; ?>videos/browse/">
						<img src="<?php print $config->site->url; ?>components/sherpa/images/icons/white/stop_watch.png">
						<?php print $lang['browse']; ?></a>
					</li> 						

	<li><a href="<?php print $config->site->url; ?>videos/most-viewed/">
						<img src="<?php print $config->site->url; ?>components/sherpa/images/icons/white/Preview.png">
						<?php print $lang['most-viewed']; ?></a>
					</li> 			
	<li><a href="<?php print $config->site->url; ?>videos/most-liked/">
						<img src="<?php print $config->site->url; ?>components/sherpa/images/icons/white/Cup.png">
						<?php print $lang['most-liked']; ?></a>
					</li> 	
					
				<li><a href="#"><?php print $lang['most-searched']; ?>
								<img src="<?php print $config->site->url; ?>components/sherpa/images/icons/white/battery_full.png">
								<span class="icon">&nbsp;</span></a>
								<ul>
								<?php 
$tg_sql = dbquery("SELECT tag FROM `tags` order by tcount DESC LIMIT 0, 11");
$MS_tags = "";
while ($info = dbarray($tg_sql)):
$MS_tags .= $info['tag'].", ";
endwhile;
$MS_array = explode(', ', $MS_tags);
if (count($MS_array) > 0):
foreach ($MS_array as $keyword):
if ($keyword != ""):
$qterm = str_replace(" ", "+",$keyword);
$k_url = $site_url.'show/'.$qterm.'/';
echo "<li><a href='".$k_url."'>".$keyword." </a></li>";
endif;
endforeach;
endif;
 ?>
									
								</ul>
							</li>
							
				<li><a href="<?php print $config->site->url; ?>videos/shared/">
						<img src="<?php print $config->site->url; ?>components/sherpa/images/icons/white/Megaphone.png">
						<?php print $lang['shared-videos']; ?></a>
					</li> 
				</ul>
				</li> 

					
<li><a href="<?php print $config->site->url; ?>channel/list-all/">
						<img src="<?php print $config->site->url; ?>components/sherpa/images/icons/white/Battery.png">
						Channels<span class="icon">&nbsp;</span></a>
					<ul>
					<?php $csql = dbquery("SELECT cat_name, yt_slug FROM `channels`");
while($row = mysql_fetch_array($csql)){
$channel_name =  $row["cat_name"];
$channel_id = $row["yt_slug"];

echo '

<li><a href="'.$config->site->url.'channel/'.$row["yt_slug"].'/">
						<img src="'.$config->site->url.'components/sherpa/images/icons/white/film_strip_2.png">
						'.$row["cat_name"].'</a>
					</li> 	
';

}
?>
					
					</ul>
					</li> 	
<li><a href="<?php print $config->site->url; ?>playlist/0/playlists/">
						<img src="<?php print $config->site->url; ?>components/sherpa/images/icons/white/Archive.png">
						Playlists</a>
</li>		
				
<li><a href="<?php print $config->site->url; ?>members/newest/">
						<img src="<?php print $config->site->url; ?>components/sherpa/images/icons/white/users_2.png">
						<?php print $lang['members']; ?></a>
					</li> 	
	<?php
if(!$user->isAuthorized())
	{ ?>				
<li><a href="<?php print $config->site->url; ?>login.php">
						<img src="<?php print $config->site->url; ?>components/sherpa/images/icons/white/Footprints.png">
						<?php print $lang['login']; ?></a>
					</li> 	
<li><a href="<?php print $config->site->url; ?>register.php">
						<img src="<?php print $config->site->url; ?>components/sherpa/images/icons/white/electricity_plug.png">
						<?php print $lang['register']; ?></a>
					</li> 	
<?php } ?>					
<li class="send_right">
<img src="<?php print $config->site->url; ?>tpl/images/light/logo-footer.png" border="0">

						</li>


				</ul>
			</div>
		</div>

    	<div class="clear"></div>
    	
    	
    </section>
<?php }   ?>
	
<script type="text/javascript" src="<?php print $config->site->url; ?>components/sherpa/scripts/sherpa_ui.js"></script>
<script type='text/javascript' src='<?php print $config->site->url; ?>tpl/js/jquery.custom.js'></script>
 <!-- the mousewheel plugin -->
<script type="text/javascript" src="<?php print $config->site->url; ?>tpl/js/jquery.mousewheel.js"></script>
<?php if($page == "video") { ?>
<!-- the jScrollPane script -->
<script type="text/javascript" src="<?php print $config->site->url; ?>tpl/js/jquery.jscrollpane.min.js"></script>
<script type="text/javascript" src="<?php print $config->site->url; ?>tpl/js/scroll-startstop.events.jquery.js"></script>
<script type='text/javascript' src='<?php print $config->site->url; ?>tpl/js/videoscroll.js'></script>
<?php } ?>
<?php if($page == "video") { ?>
<script type="text/javascript">
jQuery(document).ready(function(){	
	$('#like').click(function(){
		var b = "<?php echo $basic_id;?>";
		var dataString = 'val=' + b;
		$.post("components/voting.php?"+ dataString, {
		}, function(response){
			$('#voting_result').fadeIn();
			$('#voting_result').html($(response).fadeIn('slow').delay(2500).fadeOut());
});
	});	
});	
</script>
<?php } ?>

  <?php if(($page == "user" ) && ($user_profile->getId() == $user->getId())) { ?>
<script type="text/javascript">
$(function() {
$(".wall_update").click(function() {
var element = $(this);
var boxval = $("#content").val();
var dataString = 'content='+ boxval;
if(boxval=='')
{
alert("Please Enter Some Text");
}
else  {
	$("#flash").show();
	$("#flash").fadeIn(400).html('<img src="ajax.gif" align="absmiddle">&nbsp;<span class="loading">Loading Update...</span>');

$.ajax({
type: "POST",
  url: "components/update_status.php",
   data: dataString,
  cache: false,
  success: function(html){
  $("ul#update").prepend(html);
  $("ul#update li:first").slideDown("slow");
   document.getElementById('content').value='';
   $('#content').value='';
   $('#content').focus();
  $("#flash").hide();
  }
 });
}
return false;
	});
// Delete Wall Update
$('.delete_update').live("click",function() {
var ID = $(this).attr("id");
var dataString = 'msg_id='+ ID;
if(confirm("Sure you want to delete this update? There is NO undo!"))
{
$.ajax({
		type: "POST",
  url: "components/delete_update.php",
   data: dataString,
  cache: false,
  success: function(html){
    alert("Done! Your status has been deleted!"); 
  }
 });
}
});
});
</script>
<?php } ?>
<script type="text/javascript">
jQuery(document).ready(function(){
 $('.repeat,#repeat').live('click', function(ev) {
    var video = $(this).attr('href');
    $.lightbox('<?php print $config->site->url; ?>components/player/player.swf', {
	    width: 640,
        height: 360,		
        force: 'flash',	
        flashvars: 'file='+video+'&autostart=true&repeat=always&logo.file=<?php print $config->site->url; ?>components/player/playerlogo.png&logo.link=<?php print $config->site->url; ?>&logo.hide=false&logo.position=bottom-left&skin=<?php print $config->site->url; ?>components/player/stormtrooper.zip&stretching=fill'
      });
      
      ev.preventDefault();
    
    });
	 });
</script>
			<?php 
//print custom styles or codes added from admin (if any)
if(!empty($config->site->footerc)) {print html_back($config->site->footerc); }
?>	
</body>  
</html>