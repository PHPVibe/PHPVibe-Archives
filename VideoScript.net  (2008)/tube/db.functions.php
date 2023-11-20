<?php 
if (eregi("db.functions.php", $_SERVER['PHP_SELF'])) die();

// MySQL database functions
function dbquery($query)
{
	$result = @mysql_query($query);
	if (!$result) {
		echo mysql_error();
		return false;
	} else {
		return $result;
	}
}

function dbcount($field,$table,$conditions="")
{
	$cond = ($conditions ? " WHERE ".$conditions : "");
	$result = @mysql_query("SELECT Count(".$field.") FROM ".$table.$cond);
	if (!$result) {
		echo mysql_error();
		return false;
	} else {
		$rows = mysql_result($result, 0);
		return $rows;
	}
}

function dbrows($query)
{
	$result = @mysql_num_rows($query);
	return $result;
}

function dbarray($query)
{
	$result = @mysql_fetch_assoc($query);
	if (!$result) {
		echo mysql_error();
		return false;
	} else {
		return $result;
	}
}

?>
