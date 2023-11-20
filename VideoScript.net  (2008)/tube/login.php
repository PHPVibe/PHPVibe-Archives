<?php
include_once("mainfile.php");
require_once("includes/functions.php");
require_once("config.php");

/* Web Intersect Social Network Template System and CMS v1.33
 * Copyright (c) 2010 Adam Khoury
 * Licensed under the GNU General Public License version 3.0 (GPLv3)
 * http://www.webintersect.com/license.php
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 * See the GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Date: October 7, 2010
 *------------------------------------------------------------------------------------------------*/
// Start Session to enable creating the session variables below when they log in
session_start();
// Force script errors and warnings to show on page in case php.ini file is set to not display them
error_reporting(E_ALL);
ini_set('display_errors', '1');
//-----------------------------------------------------------------------------------------------------------------------------------
// Initialize some vars
$errorMsg = '';
$email = '';
$pass = '';
$remember = '';
if (isset($_POST['email'])) {
	
	$email = $_POST['email'];
	$pass = $_POST['pass'];
	if (isset($_POST['remember'])) {
		$remember = $_POST['remember'];
	}
	$email = stripslashes($email);
	$pass = stripslashes($pass);
	$email = strip_tags($email);
	$pass = strip_tags($pass);
	
	// error handling conditional checks go here
	if ((!$email) || (!$pass)) { 

		$errorMsg = 'Please fill in both fields';

	} else { // Error handling is complete so process the info if no errors
		include 'scripts/connect_to_mysql.php'; // Connect to the database
		$email = mysql_real_escape_string($email); // After we connect, we secure the string before adding to query
	    //$pass = mysql_real_escape_string($pass); // After we connect, we secure the string before adding to query
		$pass = md5($pass); // Add MD5 Hash to the password variable they supplied after filtering it
		// Make the SQL query
        $sql = dbquery("SELECT * FROM myMembers WHERE email='$email' AND password='$pass' AND email_activated='1'"); 
		$login_check = mysql_num_rows($sql);
        // If login check number is greater than 0 (meaning they do exist and are activated)
		if($login_check > 0){ 
    			while($row = mysql_fetch_array($sql)){
					
					// Pleae note: Adam removed all of the session_register() functions cuz they were deprecated and
					// he made the scripts to where they operate universally the same on all modern PHP versions(PHP 4.0  thru 5.3+)
					// Create session var for their raw id
					$id = $row["id"];   
					$_SESSION['id'] = $id;
					// Create the idx session var
					$_SESSION['idx'] = base64_encode("g4p3h9xfn8sq03hs2234$id");
                    // Create session var for their username
					$username = $row["username"];
					$_SESSION['username'] = $username;

					dbquery("UPDATE myMembers SET last_log_date=now() WHERE id='$id' LIMIT 1");
        
    			} // close while
	
    			// Remember Me Section
    			if($remember == "yes"){
                    $encryptedID = base64_encode("g4enm2c0c4y3dn3727553$id");
    			    setcookie("idCookie", $encryptedID, time()+60*60*24*100, "/"); // Cookie set to expire in about 30 days
			        setcookie("passCookie", $pass, time()+60*60*24*100, "/"); // Cookie set to expire in about 30 days
    			} 
    			// All good they are logged in, send them to homepage then exit script
    			header("location: index.php?test=$id"); 
    			exit();
	
		} else { // Run this code if login_check is equal to 0 meaning they do not exist
		    $errorMsg = "Incorrect login data, please try again";
		}


    } // Close else after error checks

} //Close if (isset ($_POST['uname'])){

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<link href="style/main.css" rel="stylesheet" type="text/css" />
<script src="js/jquery-1.4.2.js" type="text/javascript"></script>
<title>Log In</title>
<style type="text/css">
<!--
body {
	margin-top: 0px;
}
-->
</style>
<?php include_once "header_template.php"; ?>
<br/> <br /> <br />
<table width="500" align="center" cellpadding="6" style="background-color:#FFF; border:#666 1px solid;">
  <form action="login.php" method="post" enctype="multipart/form-data" name="signinform" id="signinform">
    <tr>
      <td width="23%"><font size="+2">Log In</font></td>
      <td width="77%"><font color="#FF0000"><?php print "$errorMsg"; ?></font></td>
    </tr>
    <tr>
      <td><strong>Email:</strong></td>
      <td><input name="email" type="text" id="email" style="width:60%;" /></td>
    </tr>
    <tr>
      <td><strong>Password:</strong></td>
      <td><input name="pass" type="password" id="pass" maxlength="24" style="width:60%;"/></td>
    </tr>
  <tr>
      <td align="right">&nbsp;</td>
      <td><input name="remember" type="checkbox" id="remember" value="yes" checked="checked" />
        Remember Me</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input name="myButton" type="submit" id="myButton" value="Sign In" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">Forgot your password? <a href="forgot_pass.php">Click Here</a>
  <br /></td>
    </tr>
    <tr>
      <td colspan="2">Need an Account? <a href="register.php">Click Here</a><br />        <br /></td>
    </tr>
  </form>
</table>
<br />
<br />
<br />
<?php include_once "footer_template.php"; ?>
</body>
</html>