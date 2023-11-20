<?php
	$config = MK_Config::getInstance();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html id="small" xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<?php print $this->getHead()->render();
$tmp_i_url = explode( '/', $config->site->base_href );
		array_pop($tmp_i_url); array_pop($tmp_i_url);
		$tmp_i_url = implode('/', $tmp_i_url).'/'; ?>
		
		<style type="text/css" media="all">
	@import url("<?php echo $tmp_i_url; ?>vibe-cp/css/style.css");
	@import url("<?php echo $tmp_i_url; ?>vibe-cp/css/formalize.css");
	@import url("<?php echo $tmp_i_url; ?>vibe-cp/css/checkboxes.css");
	</style>
	 <script type="text/javascript" src="<?php echo $tmp_i_url; ?>vibe-cp/js/jquery-1.6.1.min.js"></script>
 <script type="text/javascript" src="<?php echo $tmp_i_url; ?>vibe-cp/js/jquery.selectskin.js"></script>
 <script type="text/javascript" src="<?php echo $tmp_i_url; ?>vibe-cp/js/jquery.fileinput.js"></script>
 <script type="text/javascript" src="<?php echo $tmp_i_url; ?>vibe-cp/js/jquery.checkboxes.js"></script> 
  <script type="text/javascript" src="<?php echo $tmp_i_url; ?>vibe-cp/js/custom.js"></script>


		
        
	</head>
	
	<body>
        <div id="content">
		<div class="widget" style="width:700px;">
 <div class="title"><img src="<?php echo $tmp_i_url; ?>vibe-cp/img/icons/preview.png" alt="" class="titleIcon" /><h6><?php print $config->instance->name; ?> Installation</h6></div>
 <div class="body textL">

            <?php print $this->getDisplayOutput(); ?>
			</div>
			</div>
            <p id="footer"><a class="core" href="<?php print $config->core->url; ?>">Running on <?php print $config->core->name; ?> v<?php print $config->core->version; ?></a></p>
        </div>

	</body>
</html>
