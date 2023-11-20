
<?php
require_once("../config.php");
require_once("../db.connection.php");
require_once("../db.functions.php");
if($_POST['msg_id'])
{
$id=$_POST['msg_id'];
$id = mysql_escape_String($id);
$sql = "delete from messages where msg_id='$id'";
dbquery( $sql);
}
?>