<?php
	$config = MK_Config::getInstance();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html id="small" xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<?php print $this->getHead()->render(); ?>
        <link rel="shortcut icon" type="image/x-icon" href="<?php print $this->getThemeDirectory(); ?>img/icon.ico" />
		<link type="text/css" media="screen" rel="stylesheet" href="<?php print $this->getThemeDirectory(); ?>css/reset.css" />
		<link type="text/css" media="screen" rel="stylesheet" href="<?php print $this->getThemeDirectory(); ?>css/screen.css" />
		<link type="text/css" media="screen" rel="stylesheet" href="<?php print $this->getThemeDirectory(); ?>css/small.css" />
		<link type="text/css" media="screen" rel="stylesheet" href="<?php print $this->getThemeDirectory(); ?>js/jquery.wysiwyg/jquery.wysiwyg.css" />
		<script language="javascript" type="text/javascript" src="<?php print $this->getThemeDirectory(); ?>js/jquery.js"></script>
		<script language="javascript" type="text/javascript" src="<?php print $this->getThemeDirectory(); ?>js/jquery.wysiwyg/jquery.wysiwyg.js"></script>
		<script language="javascript" type="text/javascript" src="<?php print $this->getThemeDirectory(); ?>js/jquery.wysiwyg/controls/wysiwyg.link.js"></script>
		<script language="javascript" type="text/javascript" src="<?php print $this->getThemeDirectory(); ?>js/main.js"></script>
	</head>
	
	<body>
        <div id="header">
            <h1>
                <a href=""><?php print $config->instance->name; ?></a>
            </h1>
        </div>
        <div id="content">
            <?php print $this->getDisplayOutput(); ?>
            <p id="footer"><a class="core" href="<?php print $config->core->url; ?>">Running on <?php print $config->core->name; ?> v<?php print $config->core->version; ?></a></p>
        </div>

	</body>
</html>
