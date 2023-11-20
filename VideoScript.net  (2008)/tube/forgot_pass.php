<?php
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
 // Start_session, check if user is logged in or not, and connect to the database all in one included file
require_once("mainfile.php");
require_once("includes/functions.php");
// ----------------------------------------------------------------------------------------------------------------------------------------
$outputForUser = "";
if ($_POST['email'] != "") {

       $email = $_POST['email'];
       $email   = strip_tags($email);
	   $email= eregi_replace("`", "", $email);
	   $email = mysql_real_escape_string($email);
       $sql = dbquery("SELECT * FROM myMembers WHERE email='$email' AND email_activated='1'"); 
       $emailcheck = mysql_num_rows($sql);
       if ($emailcheck == 0){
       
              $outputForUser = '<font color="#FF0000">There is no account with that info<br />
                                                                                     in our records, please try again.';

       } else {
				 
				$emailcut = substr($email, 0, 4); // Takes first four characters from the user email address
				$randNum = rand(); 
                $tempPass = "$emailcut$randNum"; 
				$hashTempPass = md5($tempPass);

                @dbquery("UPDATE myMembers SET password='$hashTempPass' where email='$email'") or die("cannot set your new password");

                $headers ="From: $adminEmail\n"; // $adminEmail is established in [ scripts/connect_to_mysql.php ]
                $headers .= "MIME-Version: 1.0\n";
                $headers .= "Content-type: text/html; charset=iso-8859-1 \n";
                $subject ="Login Password Generated";

                $body="<div align=center><br>----------------------------- New Login Password --------------------------------<br><br><br>
                Your New Password for our site is: <font color=\"#006600\"><u>$tempPass</u></font><br><br />
				</div>";

				if(mail($email,$subject,$body,$headers)) {

								$outputForUser = "<font color=\"#006600\"><strong>Your New Login password has been emailed to you.</strong></font>";
				} else {
							   
								$outputForUser = '<font color="#FF0000">Password Not Sent.<br /><br />
                                                                                               Please Contact Us...</font>';
				}
				
     }

} else {
 
   $outputForUser = 'Enter your email address into the field below.';

}
////////////////////////////////////////////////////////////////////
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Forgot Password</title>
<link href="style/main.css" rel="stylesheet" type="text/css" />
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<script src="js/jquery-1.4.2.js" type="text/javascript"></script>
</head>

<body>
<?php include_once "header_template.php"; ?>
<table class="mainBodyTable" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="738" valign="top"><br />
      <table width="600" align="center" cellpadding="4" cellspacing="4">
        <form action="forgot_pass.php" method="post" enctype="multipart/form-data" name="newpass" id="newpass">
          <tr>
            <td valign="top" style="line-height:1.5em;"><p align="left"><strong>Forgot or lost your Password? <br />
              <br />
              </strong><br />
              <br />
            </p></td>
            <td valign="top" style="line-height:1.5em;">A new login password  will be made for you.<br />
              <br />
              <br />
              <?php print "$outputForUser"; ?></td>
          </tr>
          <tr>
            <td><div align="right" class="style3">Enter your Email Address Here:</div></td>
            <td><input name="email" type="text" id="email" size="38" maxlength="56" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input type="submit" name="Submit" value="Get Password" /></td>
          </tr>
        </form>
      </table>
    <br /></td>
   
  </tr>
</table>
<?php include_once "footer_template.php"; ?>
</body>
</html>
