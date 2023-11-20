<?php include_once("security.php");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="X-UA-Compatible" content="IE=7" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Admin </title>	
		<style type="text/css" media="all">
	@import url("css/style.css");
	@import url("css/formalize.css");
	@import url("css/checkboxes.css");
	</style>
<link rel="stylesheet" href="<?php echo $config->site->url; ?>components/lightbox/themes/default/jquery.lightbox.css"/>
 <script type="text/javascript" src="<?php echo admin_panel(); ?>js/jquery-1.6.1.min.js"></script>
 <script type='text/javascript' src='<?php echo $config->site->url; ?>components/lightbox/jquery.lightbox.min.js'></script>
 <script type="text/javascript" src="<?php echo admin_panel(); ?>js/jquery.google_menu.js"></script>
 <script type="text/javascript" src="<?php echo admin_panel(); ?>js/jquery.selectskin.js"></script>
 <script type="text/javascript" src="<?php echo admin_panel(); ?>js/jquery.fileinput.js"></script>
 <script type="text/javascript" src="<?php echo admin_panel(); ?>js/jquery.checkboxes.js"></script> 
 <script type="text/javascript" src="<?php echo admin_panel(); ?>js/jquery.form.js"></script>  
 <script type="text/javascript" src="<?php echo admin_panel(); ?>js/custom.js"></script>
 <base href="<?php echo admin_panel(); ?>" />

</head>
<body>
<div class="menu">
	<ul>
	  <li class="current">	  <a target="_blank" href="<?php echo $site_url; ?>"><< Preview site</a>	  </li>
      <li class="single-link"> <a href="<?php echo admin_panel(); ?>settings.php">Configuration panel</a>	</li>	
	  <li class="single-link">		<a href="<?php echo admin_panel(); ?>users.php">Users</a> </li>
	  <li class="single-link">		<a href="<?php echo admin_panel(); ?>videos.php">Videos</a>	</li>	
     <li class="single-link last_li current">	<a target="_blank" href="<?php echo $site_url.'user/'.$user->getId().'/'.seo_clean_url($user->getDisplayName()) .'/'; ?>">Hi, <?php echo $user->getDisplayName();?></a></li>
	</ul>
</div>
	<div class="clear"></div>
	<div id="sidebar">
<ul id="nav">
			<li><a href="<?php echo admin_panel(); ?>settings.php"><img src="img/icons/add.png" alt="" />Settings</a></li>
			<li><a href="<?php echo admin_panel(); ?>homepage.php"><img src="img/icons/clipboard.png" alt="" />Homepage builder</a></li>			
			<li><a href="#" class="collapse"><img src="img/icons/preview.png" alt="" />Video section</a>			
			<ul>
			       	<li><a href="<?php echo admin_panel(); ?>videos.php">Manage videos</a></li>
					<li><a href="<?php echo admin_panel(); ?>featured.php">Featured videos</a></li>
					<li><a href="<?php echo admin_panel(); ?>submit.php">Add video</a></li>
					<li><a href="<?php echo admin_panel(); ?>youtube.php">Youtube Mass-Import</a></li>
				</ul>			
			</li>
			<li><a href="#" class="collapse"><img src="img/icons/frames.png" alt="" />Channels</a>			
			<ul>
					<li><a href="<?php echo admin_panel(); ?>channels.php">Manage channels</a></li>
					<li><a href="<?php echo admin_panel(); ?>create_channel.php">Create channel</a></li>
					
				</ul>			
			</li>
			<li><a href="<?php echo admin_panel(); ?>playlists.php"><img src="img/icons/imagesList.png" alt="" />Manage playlists</a></li>									
			<li><a href="<?php echo admin_panel(); ?>users.php"><img src="img/icons/users.png" alt="" />Users</a></li>
			<li><a href="<?php echo admin_panel(); ?>comments.php"><img src="img/icons/pencil.png" alt="" /> Comments</a></li>
            <li><a href="<?php echo admin_panel(); ?>walls.php"> <img src="img/icons/list.png" alt="" />Wall spy</a></li>
			<li><a href="messages.php"><img src="img/icons/bubbles2.png" alt="" /> Messages spy</a></li>
		</ul>
		
 </div><!-- #sidebar ends -->
	