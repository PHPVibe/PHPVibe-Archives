<?php
	$session = MK_Session::getInstance();
?>
<div class="block">
<h2>Installation</h2>
    <h3>Step 4: Summary</h3>
    <p>Take a quick look at the information below, to make sure you've entered everything correctly, then just click 'Finish' and you're all done.</p>
    <h4>Database</h4>
	<dl class="clear-fix">
		<dt>Host</dt>
		<dd><?php print $session->install['db.host']; ?></dd>
		<dt>Name</dt>
		<dd><?php print $session->install['db.name']; ?></dd>
		<dt>Username</dt>
		<dd><?php print $session->install['db.username']; ?></dd>
		<dt>Password</dt>
		<dd>********</dd>
	</dl>
    <h4>Site Details</h4>
    <dl class="clear-fix">
		<dt>Site Name</dt>
		<dd><?php print $session->install['site.name']; ?></dd>
		<dt>Admin Email</dt>
		<dd><?php print $session->install['site.email']; ?></dd>
		<dt>Site URL</dt>
		<dd><?php print $session->install['site.url']; ?></dd>
	</dl>
    <h4>Your account</h4>
    <dl class="clear-fix">
		<dt>Display name</dt>
		<dd><?php print $session->user['display_name']; ?></dd>
		<dt>Email</dt>
		<dd><?php print $session->user['email']; ?></dd>
		<dt>Password</dt>
		<dd>********</dd>
	</dl>
<?php print $this->install_form; ?>
</div>
