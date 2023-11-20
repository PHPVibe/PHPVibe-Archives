<?php
	$config = MK_Config::getInstance();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html id="large" xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<?php print $this->getHead()->render(); ?>
        <link rel="shortcut icon" type="image/x-icon" href="<?php print $this->getThemeDirectory(); ?>img/icon.ico" />
		<link type="text/css" media="screen" rel="stylesheet" href="<?php print $this->getThemeDirectory(); ?>css/reset.css" />
		<link type="text/css" media="screen" rel="stylesheet" href="<?php print $this->getThemeDirectory(); ?>css/screen.css" />
		<link type="text/css" media="screen" rel="stylesheet" href="<?php print $this->getThemeDirectory(); ?>js/jquery.wysiwyg/jquery.wysiwyg.css" />
		<script language="javascript" type="text/javascript" src="<?php print $this->getThemeDirectory(); ?>js/jquery.js"></script>
		<script language="javascript" type="text/javascript" src="<?php print $this->getThemeDirectory(); ?>js/jquery.wysiwyg/jquery.wysiwyg.js"></script>
		<script language="javascript" type="text/javascript" src="<?php print $this->getThemeDirectory(); ?>js/jquery.wysiwyg/controls/wysiwyg.link.js"></script>
		<script language="javascript" type="text/javascript" src="<?php print $this->getThemeDirectory(); ?>js/main.js"></script>
	</head>
	
	<body>
        <div id="user-bar" class="clear-fix">
            <div class="inner">
                <h1><a href=""><?php print $config->instance->name; ?></a></h1>
    
                <ul id="user">
                    <li class="first">Welcome <?php print $this->getUser()->getDisplayName(); ?></li>
                    <li><a href="<?php print $this->uri( array('controller' => 'users', 'method' => 'edit', 'id' => $this->getUser()->getId())); ?>">My account</a></li>
                    <li><a href="<?php print $this->uri( array('controller' => 'account', 'section' => 'log-out' )); ?>">Log out</a></li>
                </ul>
			</div>
		</div>
        <ul id="navigation-main" class="clear-fix">
            <li class="<?php print MK_Request::getParam('controller') === 'dashboard' ? 'selected ' : null; ?>first">
                <a href="<?php print $this->uri(array('controller' => 'dashboard')); ?>" class="main">Dashboard</a>
                <ul id="navigation-sub" class="clear-fix">
                    <li class="first<?php print MK_Request::getParam('section') == 'settings' ? ' selected' : ''; ?>"><a href="<?php print $this->uri( array('controller' => 'dashboard', 'section' => 'settings' ) ); ?>">Settings</a></li>
                    <li class="<?php print MK_Request::getParam('section') == 'backup' ? ' selected' : ''; ?>"><a href="<?php print $this->uri( array('controller' => 'dashboard', 'section' => 'backup' ) ); ?>">Backup</a></li>
                    <li class="<?php print MK_Request::getParam('section') == 'file-manager' ? ' selected' : ''; ?>"><a href="<?php print $this->uri( array('controller' => 'dashboard', 'section' => 'file-manager' ) ); ?>">File Manager</a></li>
                </ul>
            </li>
			<li class=""><a href="channels.php" class="main">Channels</a></li>
<li class=""><a href="create-channel.php" class="main">New Channel</a></li>
<li class=""><a href="videos.php" class="main">Videos</a></li>
<?php
    foreach($this->modules as $module)
    {
		if( $config->core->mode !== MK_Core::MODE_FULL && $module->isCoreModule() )
		{
			continue;
		}
        print '<li class="'.(MK_Request::getParam('controller') == $module->getSlug() ? 'selected ' : null).'">';
        print '<a href="'.$this->uri( array('controller' => $module->getSlug()) ).'" class="main">'.$module->getName().'</a>';
        if( count($module->getSubModules()) > 0 )
        {
            print '<ul id="navigation-sub" class="clear-fix">';
            $counter = 0;
            foreach( $module->getSubModules() as $sub_module )
            {
                $class = array();
				$counter++;
                if($counter === 1) $class[] = 'first';
                if(MK_Request::getParam('section') === $sub_module->getSlug()) $class[] = 'selected';
                print '<li class="'.(implode(' ', $class)).'"><a href="'.$this->uri( array('controller' => $module->getSlug(), 'section' => $sub_module->getSlug() ) ).'">'.$sub_module->getName().'</a></li>';
            }
            print '</ul>';
        }
        print '</li>';
    }
?>
        </ul>

        <div id="content" class="clear-fix">
			<?php print $this->getDisplayOutput(); ?>
		</div>
		
        <div id="footer">
        	<ul class="clear-fix">
			<li class=""><a href="channels.php" >Channels</a></li>
<li class=""><a href="create-channel.php" >New Channel</a></li>
<li class=""><a href="videos.php" >Videos</a></li>
<li><a href="?module_path=users/index" >Users</a>
<li class="version"><a href="<?php print $config->instance->url; ?>"><?php print $config->instance->name; ?> version <?php print $config->instance->version; ?></a><br /><a class="core" href="<?php print $config->core->url; ?>">Running on <?php print $config->core->name; ?> v<?php print $config->core->version; ?></a></li>
            </ul>
        </div>
	</body>
</html>
