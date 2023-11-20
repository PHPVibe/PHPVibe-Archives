<?php
include("../phpvibe.php");
if(isset($_GET['id']) && isset($_GET['action']) && $user->isAuthorized())
{
$id = mysql_escape_string($_GET['id']);
	switch($_GET['action']){
	case "aprove":
	$query = "update users_friends set status = '1' where id = '".$id."'";
	dbquery($query);
	echo "<div class=\"success-box\">You have accepted this friend request.</div>";
	break;
	case "deny":
	$c_user = $user->getId();
	$sql = "delete from users_friends where id='$id' and uid='$c_user'";
    mysql_query( $sql);
	echo "<div class=\"alert-box\">Friend request has been deleted.</div>";
	break;


}
}
MK_MySQL::disconnect();
?>