<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html id="large" xmlns="http://www.w3.org/1999/xhtml">

	<head>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<base href="<?php print $config->site->url; ?>admin/" /><title>phpVibe Admin Panel</title>   
		<link rel="shortcut icon" type="image/x-icon" href="application/views/mokoala-default/themes/default/img/icon.ico" />

		<link type="text/css" media="screen" rel="stylesheet" href="application/views/mokoala-default/themes/default/css/reset.css" />

		<link type="text/css" media="screen" rel="stylesheet" href="application/views/mokoala-default/themes/default/css/screen.css" />

		<link type="text/css" media="screen" rel="stylesheet" href="application/views/mokoala-default/themes/default/js/jquery.wysiwyg/jquery.wysiwyg.css" />

		<script language="javascript" type="text/javascript" src="application/views/mokoala-default/themes/default/js/jquery.js"></script>

		<script language="javascript" type="text/javascript" src="application/views/mokoala-default/themes/default/js/jquery.wysiwyg/jquery.wysiwyg.js"></script>

		<script language="javascript" type="text/javascript" src="application/views/mokoala-default/themes/default/js/jquery.wysiwyg/controls/wysiwyg.link.js"></script>

		<script language="javascript" type="text/javascript" src="application/views/mokoala-default/themes/default/js/main.js"></script>

	</head>

	

	<body>
	

        <div id="user-bar" class="clear-fix">

            <div class="inner">

                <h1><a href="">Video CP</a></h1>

    

                <ul id="user">

                    <li class="first">Welcome <?php echo $user->getDisplayName();?></li>

                    <li><a href="?module_path=users/index/method/edit/id/<?php echo $user->getId();?>">My account</a></li>

                    <li><a href="?module_path=account/log-out">Log out</a></li>

                </ul>

			</div>

		</div>

        <ul id="navigation-main" class="clear-fix">

            <li class="first">

                <a href="?module_path=dashboard/index" class="main">Dashboard</a>

                <ul id="navigation-sub" class="clear-fix">

                    <li class="first"><a href="?module_path=dashboard/settings">Settings</a></li> 					
					<li class=""><a href="?module_path=dashboard/file-manager">File Manager</a></li>
					<li class=""><a href="?module_path=backups/index">Backup</a></li>

                </ul>

            </li>


<li class=""><a href="channels.php" class="main">Channels</a></li>
<li class=""><a href="create-channel.php" class="main">New Channel</a></li>
<li class=""><a href="videos.php" class="main">Videos</a></li>
<li><a href="?module_path=users/index" class="main">Users</a>
        <ul id="navigation-sub" class="clear-fix">
<li class="first"><a href="?module_path=users/groups">Groups</a></li>
<li class=""><a href="?module_path=users/messages">Messages</a></li>
<li class=""><a href="?module_path=users/meta">Meta</a></li>
        </ul>
</li> 
</ul>

