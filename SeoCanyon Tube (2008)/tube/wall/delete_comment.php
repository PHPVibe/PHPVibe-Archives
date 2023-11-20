
<?php
require_once("../config.php");
require_once("../db.connection.php");
require_once("../db.functions.php");
if($_POST['com_id'])
{
$id=$_POST['com_id'];
$id = mysql_escape_String($id);
$sql = "delete from comments where com_id='$id'";
dbquery( $sql);
}
?>