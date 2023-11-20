<?php 

if (eregi("db.connection.php", $_SERVER['PHP_SELF'])) die();



// Establish mySQL database connection

function dbconnect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME)

{

	$dbc = @mysql_connect($DB_HOST, $DB_USER, $DB_PASS);

	$dbs = @mysql_select_db($DB_NAME);

	if (!$dbc) {

		die("<div style='font-family:Verdana;font-size:11px;text-align:center;'><b>Unable to establish connection to MySQL</b><br>".mysql_errno()." : ".mysql_error()."</div>");

	} elseif (!$dbs) {

		die("<div style='font-family:Verdana;font-size:11px;text-align:center;'><b>Unable to select MySQL database</b><br>".mysql_errno()." : ".mysql_error()."</div>");

	}

}



$establish_connection = dbconnect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
//
//if($_SESSION['id']){
	//$session = mysql_query("SELECT * FROM members WHERE id = '$_SESSION[id]' AND password = '$_SESSION[password]'");
//	$session = mysql_fetch_array($session);
//}
//
?>