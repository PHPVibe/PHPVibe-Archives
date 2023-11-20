<?php
	$config = MK_Config::getInstance();
?>
<div class="block">
    <h2>Dashboard / Backup</h2>
    <p>Use the form below to create a backup of your current database &amp; files. Depending on how many files there are and how big your database is this process can take a long time!</p>
    
    <h3>Create backup for <?php print date($config->site->datetime_format); ?></h3>
<?php
print $this->form;
?>
</div>
