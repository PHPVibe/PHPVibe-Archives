<?php
include_once("./security.php");
include_once("./head.php");
$config = MK_Config::getInstance();
?>


        <div id="content" class="clear-fix">
			<?php print $this->getDisplayOutput(); ?>
		</div>
		
<?php
include_once("./foot.php");
?>
	</body>
</html>
