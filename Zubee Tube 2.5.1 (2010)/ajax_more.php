<?php
require_once("config.php");
require_once("mainfile.php");
require_once("includes/db.connection.php");
require_once("includes/db.functions.php");

if(isSet($_POST['lastmsg']))
{
$lastmsg=$_POST['lastmsg'];
$lastmsg=mysql_real_escape_string($lastmsg);
$result=dbquery("select * from timeline where tid<'$lastmsg' order by tid desc limit 25");
while($row = mysql_fetch_array($result)) {
$name = $row['user'];
$tweet = toLink($row['tweets']);
$msg_id = $row['tid'];
echo '<li>';
echo '<a href="'.$site_url.'user/'.$name.'">'.$name.'</a> : ';
echo $tweet;
echo '</li>';
}

//More Button here $msg_id values is a last message id value.
?>
<div id="more<?php echo $msg_id; ?>" class="morebox">
<a href="#" id="<?php echo $msg_id; ?>" class="more">more</a>
</div>
<?php
}
?>