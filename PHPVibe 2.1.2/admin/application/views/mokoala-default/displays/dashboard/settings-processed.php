
<div class="block">
    <h2>Dashboard / Settings</h2>
<?php
	foreach( $this->messages as $message )
	{
		print '<p class="simple-message simple-message-'.$message->getType().'">'.$message->getMessage().'</p>';
	}
?>
</div>