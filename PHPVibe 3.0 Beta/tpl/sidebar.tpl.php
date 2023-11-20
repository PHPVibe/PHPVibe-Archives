<!-- SIDEBAR -->

   <div class="sidebar">
   <?php if(!$user->isAuthorized()){
   echo '
   <center>
   <a href="'.$config->site->url.'login.php?platform=facebook"><img src="'.$config->site->url.'tpl/images/fb-signin.png" alt="Connect with Fb" /></a>
   <a href="'.$config->site->url.'login.php?platform=twitter"><img src="'.$config->site->url.'tpl/images/tw-signin.png" alt="Connect with Twitter"/></a>
   </center>';
   } elseif( $user->getGroup()->getAccessLevel() >= $config->video->submit) {
   echo '<center>   <a href="'.$config->site->url.'submit/" class="red icon coolbtn"><img src="'.theme("images").'icons/upload.png"/>Submit video</a>  </center>';
   }
   ?>

   <ul class="side-menu">
		<li class="expand">
			<ul class="acitem">
			<li> <a href="<?php echo $config->site->url; ?>videos/browse/"><span class="m-icon"><img src="<?php echo w_icons("month_calendar");?>"/></span><span class="menu-item"><?php echo $lang['browse']; ?></span></a><li>

            <li><a href="<?php echo $config->site->url; ?>videos/most-viewed/"><span class="m-icon"><img src="<?php echo w_icons("preview");?>"/></span><span class="menu-item"><?php echo $lang['most-viewed']; ?></span></a></li>
			<li><a href="<?php echo $config->site->url; ?>videos/most-liked/"><span class="m-icon"><img src="<?php echo w_icons("facebook_like");?>"/></span><span class="menu-item"><?php echo $lang['most-liked']; ?></span></a></li> 	
			<li><a href="<?php echo $config->site->url; ?>videos/featured/"><span class="m-icon"><img src="<?php echo w_icons("cup");?>"/></span><span class="menu-item"><?php echo $lang['featured']; ?></span></a></li> 	
			<li> <a href="<?php echo $config->site->url; ?>playlists/"><span class="m-icon"><img src="<?php echo w_icons("archive");?>"/></span><span class="menu-item">Playlists</span></a></li>
			</ul>
		</li>
</ul>	

<a href="<?php echo $config->site->url; ?>channel/list-all/" class="categories"><span class="m-icon"><img src="<?php echo w_icons("film_strip_2");?>"/></span><span class="menu-item">Channels</span></a>
<ul class="side-menu-online">
<?php
$sidemenu_channel = dbquery("SELECT picture, cat_name, yt_slug FROM `channels` order by cat_id desc");
while($row = mysql_fetch_array($sidemenu_channel)){
echo '<li><a href="'.$config->site->url.'channel/'.$row["yt_slug"].'/"><span class="was-online"><img src="'.$site_url.'com/timthumb.php?src='.$row['picture'].'&h=30&w=30&crop&q=100" alt=""></span><span class="name-online">'.$row["cat_name"].'</span></a></li>';

}
?>
               
		</ul>	

  <a href="<?php echo $config->site->url; ?>members/" class="categories"><span class="m-icon"><img src="<?php echo w_icons("users_2");?>"/></span><span class="menu-item">Community</span></a>
 <ul class="side-menu-online">
<?php
$qqquery = "select display_name,id,avatar,lastlogin from users where avatar != \"\" order by lastlogin desc limit 0,10";
$os = mysql_query($qqquery) or die(mysql_error());
$side_i = 1;
while($row = mysql_fetch_array($os)){
$my_u_url = $site_url.'user/'.$row['id'].'/'.seo_clean_url($row['display_name']) .'/';
echo '<li><a href="'.$my_u_url.'"><span class="was-online"><img src="'.$site_url.'com/timthumb.php?src='.$row['avatar'].'&h=30&w=30&crop&q=100" alt=""></span><span class="name-online">'.$row["display_name"].'</span></a></li>';
$side_i++;
}
?>
               
		</ul>	      

	</div>
		<!-- SIDEBAR -->