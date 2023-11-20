<?php
include("../phpvibe.php");
if($_POST['msg_id'])
{
$c_user = $user->getId();
$id=$_POST['msg_id'];
$id = mysql_escape_String($id);
$sql = "delete from user_wall where msg_id='$id' and u_id='$c_user'";
mysql_query( $sql);
}
?>