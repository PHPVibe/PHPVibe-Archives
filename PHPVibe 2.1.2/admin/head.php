<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html id="large" xmlns="http://www.w3.org/1999/xhtml">

	<head>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<base href="<?php print $config->site->url; ?>admin/" /><title>phpVibe Admin Panel</title>   
		<link rel="shortcut icon" type="image/x-icon" href="application/views/mokoala-default/themes/default/img/icon.ico" />
		<link type="text/css" media="screen" rel="stylesheet" href="application/views/mokoala-default/themes/default/css/reset.css" />
        <link rel="stylesheet" href="<?php print $config->site->url; ?>components/lightbox/themes/default/jquery.lightbox.css"/>
		<link type="text/css" media="screen" rel="stylesheet" href="application/views/mokoala-default/themes/default/css/screen.css" />	   
	   
	   <style>
	   fieldset {
  padding: 1em;
  }
label {
  float:left;
  width:25%;
  margin-right:0.5em;
  padding-top:0.2em;
  text-align:left;
  font-weight:bold;
  }
fieldset { width:94%; display:inline-block; float:left; border:1px dashed #6D7B8D; margin-bottom:4px;
border-radius: 4px;
-webkit-border-radius: 4px;
-moz-border-radius: 4px;
 }
legend {
  padding: 0.2em 0.5em;
  border:1px dashed #F9966B;
  font-size:90%;
  text-align:right;
  }
	   </style>
	   
	   
<script type="text/javascript" src="scripts/jquery.min.js"></script>
<script type="text/javascript" src="scripts/jquery.form.js"></script>
 <script type="text/javascript" >
 $(document).ready(function() { 
		
            $('#photoimg').live('change', function()			{ 
			           $("#preview").html('');
			    $("#preview").html('<img src="loader.gif" alt="Uploading...."/>');
			$("#imageform").ajaxForm({
						target: '#preview'
		}).submit();
		
			});
			$('.lightbox').lightbox();
        }); 
		
</script>
<script type='text/javascript' src='<?php print $config->site->url; ?>components/lightbox/jquery.lightbox.js'></script>
<script language="javascript" type="text/javascript" src="application/views/mokoala-default/themes/default/js/main.js"></script>





		<!--[if lt IE 9]>

	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>

	<![endif]-->





	</head>

	

	<body>
	

        <div id="user-bar" class="clear-fix">

            <div class="inner">

                <h1><a href="">phpVibe Administration</a></h1>

    

                <ul id="user">

                    <li class="first">Welcome <?php echo $user->getDisplayName();?></li>

                    <li><a href="?module_path=users/index/method/edit/id/<?php echo $user->getId();?>">My account</a></li>

                    <li><a href="?module_path=account/log-out">Log out</a></li>

                </ul>
 <div class="searchbar white">

<form role="search" method="get" action="search.php" >

<input type="text" class="filename" value="Video keyword &hellip;" name="search_key" id="search_key" onfocus="if (this.value == 'Video keyword &hellip;') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Video keyword &hellip;';}"/>

<input type="submit" class="button" value="Search"/>

</form>	

<div class="clearfix"></div>

</div>



			</div>

		</div>

        <ul id="navigation-main" class="clear-fix">

            <li class="first">

                <a href="?module_path=dashboard/index" class="main">Dashboard</a>

                <ul id="navigation-sub" class="clear-fix">

                    <li class="first"><a href="?module_path=dashboard/settings">Settings</a></li> 					
					<li class="first"><a href="?module_path=dashboard/file-manager">File Manager</a></li>
					<li class=""><a href="?module_path=backups/index">Backup</a></li>

                </ul>

            </li>

 <li class=""><a href="?module_path=dashboard/settings" class="main">Configuration</a></li>
  <li class=""><a href="home-build.php" class="main">Homepage</a></li>
<li class=""><a href="slider.php" class="main">Slider</a></li>
<li class=""><a href="import-videos.php" class="main">Import Videos</a></li>
<li class=""><a href="videos.php" class="main">Videos</a></li>
<li class=""><a href="channels.php" class="main">Channels</a></li>
<li class=""><a href="create-channel.php" class="main">New Channel</a></li>
<li class=""><a href="featured.php" class="main">Featured</a></li>
<li><a href="?module_path=users/index" class="main">Users</a>
        <ul id="navigation-sub" class="clear-fix">
<li class="first"><a href="?module_path=users/groups">Groups</a></li>
<li class=""><a href="?module_path=users/messages">Messages</a></li>
<li class=""><a href="?module_path=users/meta">Meta</a></li>
        </ul>
</li> 
</ul>

