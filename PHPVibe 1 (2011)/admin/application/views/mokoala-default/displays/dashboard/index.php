<div class="block">
    <h2>Your Dashboard</h2>
	
    <p>
	
<?php 
$sql = dbquery("SELECT id FROM videos ORDER BY id DESC"); 
$nr = mysql_num_rows($sql);
echo 'You have '.$nr.' videos. <a href="videos.php">Manage videos >></a>';
?>
<?php 
$sql = dbquery("SELECT cat_id FROM channels ORDER BY cat_id DESC"); 
$nr = mysql_num_rows($sql);
echo ' and '.$nr.' channels. <a href="channels.php">Manage channels >></a>';
?>	
	
	</p>
	
	
<?php
if( count($this->message_list) > 0 )
{
	foreach( $this->message_list as $message )
	{
		print '<p class="simple-message simple-message-'.$message['type'].'">'.$message['message'].'</p>';
	}
}
?>
</div>
