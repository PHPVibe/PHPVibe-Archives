<div class="sidebar">
<?php if(!$user->isAuthorized()){
  
    if($config->site->facebook->login) 		{
   echo '
   <center>
   <a href="'.$config->site->url.'login.php?platform=facebook"><img src="'.$config->site->url.'tpl/images/fb-signin.png" alt="Connect with Fb" /></a>
    </center>';
   }
   if($config->site->twitter->login) {
    echo '
	 <center>
	<a href="'.$config->site->url.'login.php?platform=twitter"><img src="'.$config->site->url.'tpl/images/tw-signin.png" alt="Connect with Twitter"/></a>
   </center>';
   }
   } else{

	echo '<div class="sidename">
	<img src="'.$site_url.'com/timthumb.php?src='.$user->getAvatar().'&w=190&crop&q=100" /><div class="namecap">';
 if( $name = $user->getName() ) 	{ echo $name; } else { echo $user->getDisplayName(); } ?>
</div>
 </div>
 <?php  }    ?>


<a href="<?php echo $config->site->url; ?>channel/list-all/" class="categories"><span class="m-icon"><img src="<?php echo w_icons("film_strip_2");?>"/></span><span class="menu-item"><?php echo $lang['channels']; ?></span></a>
<ul class="side-menu">

<?php
$cqt = 600;
$sidemenu_channel = "SELECT picture, cat_name, yt_slug FROM `channels` WHERE child_of IS NULL order by cat_name desc";
if ($sidecategories = $dbi->query($sidemenu_channel, $cqt, 'catsbar')) {
	foreach ($sidecategories as $row) {
echo '<li><a href="'.$config->site->url.'channel/'.$row["yt_slug"].'/"><span class="m-icon"><img src="'.$site_url.'com/timthumb.php?src='.$row['picture'].'&h=24&w=24&crop&q=100" alt=""></span><span class="menu-item">'.$row["cat_name"].'</span></a></li>';
}
}
$dbi->disconnect();
?>
               

</ul>	
  <a href="<?php echo $config->site->url; ?>members/" class="categories"><span class="m-icon"><img src="<?php echo w_icons("users_2");?>"/></span><span class="menu-item"><?php echo $lang['community']; ?></span></a>
 <ul class="side-menu">
<?php
$usquery = "select display_name,id,avatar,lastlogin from users where avatar != \"\" order by lastlogin desc limit 0,10";
if ($sideusers = $dbi->query($usquery, $cqt, 'usersbar')) {
	foreach ($sideusers as $row) {
$my_u_url = $site_url.'user/'.$row['id'].'/'.seo_clean_url($row['display_name']) .'/';
if(empty($row['avatar'])) {$row['avatar'] = 'images/userPic.png';}
echo '<li><a href="'.$my_u_url.'"><span class="m-icon"><img src="'.$site_url.'com/timthumb.php?src='.$row['avatar'].'&h=24&w=24&crop&q=100" alt=""></span><span class="menu-item">'.$row["display_name"].'</span></a></li>';
}
}
$dbi->disconnect();
?>
               
		</ul>	      

	</div>
		<!-- SIDEBAR -->