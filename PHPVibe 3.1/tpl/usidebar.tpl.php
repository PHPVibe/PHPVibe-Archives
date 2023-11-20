<!-- USER's SIDEBAR -->

   <div class="sidebar">
   	<?php 		if($avatar =$user_profile->getAvatar()){
	echo '<a class="lightbox" href="'.$site_url.$user_profile->getAvatar().'"><img src="'.$site_url.'com/timthumb.php?src='.$avatar.'&w=200&crop&q=100" /></a>';
	}
	?>

   <ul class="side-menu">
		<li class="expand">
		<a href="#"><span class="m-icon"><img src="<?php echo w_icons("admin_user");?>"/></span><span class="menu-item"><?php if( $name = $user_profile->getName() ) 	{ echo $name; } else { echo $user_profile->getDisplayName(); } ?></span></a>
			<ul class="acitem">
   <?php if($user->isAuthorized() && !$is_follower && !is_owner($user_profile->getId())){
			echo'<li> <a id="'.$user_profile->getId().'" href="javascript:void(0)" class="bigfollow"><span class="m-icon"><img src="'.w_icons("electricity_plug").'"/></span><span class="menu-item">'.$lang['addf'].'</span></a></li>';
			}
			if($is_followed && !is_owner($user_profile->getId())){
			echo"<li><a href=\"".$site_url."messages.php?method=compose&member=".$user_profile->getId()."\"><span class=\"m-icon\"><img src=\"".w_icons("ichat")."\"/></span><span class=\"menu-item\">".$lang['send-msg']."</span></a></li>";
			}  
		
?>
			</ul>
		</li>
	
</ul>
   <ul class="side-menu">
<?php 
$playlist_result = dbquery("SELECT * FROM `playlists` where owner = '".$user_profile->getId()."' order by id DESC");
if (mysql_num_rows($playlist_result) > 0) { ?>

		<li class="expand">
		<a href="#"><span class="m-icon"><img src="<?php echo w_icons("frames");?>"/></span><span class="menu-item"><?php echo $lang['playlists']; ?></span></a>
		<ul class="acitem">
<?php
$p_f = 1;
while($row = mysql_fetch_array($playlist_result)){
if(empty($row['avatar'])){
$row['avatar'] = theme("images")."guest.png";
}
echo '<li><a href="'.$config->site->url.'playlist/'.$row["id"].'/'.seo_clean_url($row["permalink"]).'/"><span class="m-icon"><img src="'.$site_url.'com/timthumb.php?src='.$row['picture'].'&h=24&w=24&crop&q=100" alt=""></span><span class="menu-item">'.$row["title"].'</span></a></li>';
if($p_f == 10 && mysql_num_rows($playlist_result) > 6) {
echo ' </ul>
		</li> <li>
		<a href="#"><span class="m-icon"><img src="'.w_icons("loading_bar").'"/></span><span class="menu-item">All playlists</span></a>
		<ul class="acitem">';
}
$p_f++;
}
?>
        </ul>
		</li>       
		
<?php } ?>	
<?php
$folow_result = dbquery("SELECT users_friends.uid, users.id, users.display_name, users.avatar FROM users_friends LEFT JOIN users ON users_friends.uid = users.id WHERE users_friends.fid =  '".$user_profile->getId()."' ORDER BY users_friends.uid DESC");
if (mysql_num_rows($folow_result) > 0) { ?>	
  
 
		<li class="expand">
		<a href="#" class="active"><span class="m-icon"><img src="<?php echo w_icons("users_2");?>"/></span><span class="menu-item"><?php echo $lang['following']; ?></span></a>
		<ul class="acitem" style="display: block; ">
<?php
$i_f = 1;
while($following = mysql_fetch_array($folow_result)){
if(empty($following['avatar'])){
$following['avatar'] = theme("images")."guest.png";
}
echo '<li><a href="'.$config->site->url.'user/'.$following["id"].'/'.seo_clean_url($following["display_name"]).'/"><span class="m-icon"><img src="'.$site_url.'com/timthumb.php?src='.$following['avatar'].'&h=24&w=24&crop&q=100" alt=""></span><span class="menu-item">'.$following["display_name"].'</span></a></li>';
if($i_f == 6) {
echo ' </ul>
		</li> <li>
		<a href="#"><span class="m-icon"><img src="'.w_icons("refresh_4").'"/></span><span class="menu-item">More '.$lang['following'].'</span></a>
		<ul class="acitem">';
}
$i_f++;
}
?>
        </ul>
		</li>       
		
		<?php } ?>	
<?php
$fresult = dbquery("SELECT DISTINCT users_friends.fid, users.id, users.display_name, users.avatar FROM users_friends LEFT JOIN users ON users_friends.fid = users.id WHERE uid = '".$user_profile->getId()."' order by  users_friends.fid desc");
if (mysql_num_rows($fresult) > 0) { ?>	
   
		<li class="expand">
		<a href="#" class="active"><span class="m-icon"><img src="<?php echo w_icons("users_2");?>"/></span><span class="menu-item"><?php echo $lang['followers']; ?></span></a>
		<ul class="acitem" style="display: block; ">
<?php
$f_f = 1;
while($row = mysql_fetch_array($fresult)){
if(empty($row['avatar'])){
$row['avatar'] = theme("images")."guest.png";
}
echo '<li><a href="'.$config->site->url.'user/'.$row["id"].'/'.seo_clean_url($row["display_name"]).'/"><span class="m-icon"><img src="'.$site_url.'com/timthumb.php?src='.$row['avatar'].'&h=24&w=24&crop&q=100" alt=""></span><span class="menu-item">'.$row["display_name"].'</span></a></li>';
if($f_f == 6) {
echo ' </ul>
		</li> <li>
		<a href="#"><span class="m-icon"><img src="'.w_icons("refresh_4").'"/></span><span class="menu-item">More '.$lang['followers'].'</span></a>
		<ul class="acitem">';
}
$f_f++;
}
?>
        </ul>
		</li>       
	
<?php } ?>	
		 </ul>	
   </div>
		<!-- SIDEBAR -->