<div id="footer">
        	<ul class="clear-fix">
<li class=""><a href="videos.php" >Videos</a></li>
<li><a href="?module_path=users/index" >Users</a></li>
<li><a href="?module_path=dashboard/settings" class="main">Configuration</a></li>
<li class="version"><a href="<?php print $config->instance->url; ?>"><?php print $config->instance->name; ?> version <?php print $config->instance->version; ?></a><br /><a class="core" href="<?php print $config->core->url; ?>">Running on <?php print $config->core->name; ?> v<?php print $config->core->version; ?></a></li>
            </ul>
        </div>

	</body>

</html>
<?php 
//MK_MySQL::disconnect();
?>