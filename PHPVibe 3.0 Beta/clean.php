<?php require_once("phpvibe.php");
$vbox_result=mysql_query("SELECT DISTINCT user FROM  `users_meta` WHERE  `value` LIKE  '%[url=%' or `value` LIKE  '%ANTISPAM%' LIMIT 0 , 30000000");
while($group = mysql_fetch_array($vbox_result))
{
 $del = dbquery("DELETE from users WHERE id = '".$group["user"]."'");
	  $del2 = dbquery("DELETE from users_meta WHERE user = '".$group["user"]."'");
	$message= 'Deleted user # '.$group["user"];
	}
?>