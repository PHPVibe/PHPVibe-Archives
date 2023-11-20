<div class="block">
    <h2><?php print $this->module->getName(); ?><?php print $this->title ? ' / '.$this->title : ''; ?></h2>
<?php
	foreach( $this->messages as $message )
	{
		print '<p class="simple-message simple-message-'.$message->getType().'">'.$message->getMessage().'</p>';
	}
?>
</div>
