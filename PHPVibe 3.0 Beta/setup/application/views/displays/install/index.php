<div class="block clear-fix">
<h2>Installation</h2>
<h3>Requirements</h3>
<p>Before we get started there are a few things we need to check, to ensure everything is in ready for installation!</p>
<?php
	$status = true;
	foreach($this->messages as $message)
	{
		if( $message->getType() != 'success' )
		{
			$status = false;
		}
?>
<p class="simple-message simple-message-<?php print $message->getType(); ?>"><?php print $message->getMessage(); ?></p>
<?php
	}

	if($status === true){
?>
<div class="clear-fix form-field-link field-nextfinish">
    <div class="input-left">
        <div class="input-right">
            <a href="<?php print $this->uri( array('controller' => 'install', 'section' => 'step-1') ); ?>">Proceed</a>
        </div>
    </div>
</div>
<?php
	}else{
?>
<div class="clear-fix form-field-link field-prev1">
    <div class="input-left">
        <div class="input-right">
            <a href="<?php print $this->uri( array('controller' => 'install', 'section' => 'index') ); ?>">Try again</a>
        </div>
    </div>
</div>
<?php
	}
?>
</div>

