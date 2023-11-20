<?php
	$config = MK_Config::getInstance();
?>
<div class="block">
    <h2><?php print $this->module->getName(); ?></h2>
    <h3>Restore backup from <?php print $this->backup->renderDateTime(); ?></h3>
    <p>Recovering a backup <strong>will drop all tables in your selected database</strong> and can take a while depending on the number of files and size of the database. It's important that you do not close your browser during a recovery as it may result in permanent data loss.</p>
<?php
	print $this->form;
?>
</div>