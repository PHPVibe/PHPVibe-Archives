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
 // This file should not remain on your server beyond successful installation and configuration
 // After it is used and your site is configured... remove this file from the server
?>
<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
if (isset ($_POST['db_host'])){ $db_host = $_POST['db_host']; $db_username = $_POST['db_username']; $db_pass = $_POST['db_pass']; $db_name = $_POST['db_name']; $autoEmail = $_POST['autoEmail']; $adminEmail = $_POST['adminEmail']; $adminPass = $_POST['adminPass']; $adminPass2 = $_POST['adminPass2']; if(!mysql_connect("$db_host","$db_username","$db_pass")) { $errorMsg = 'ERROR: Your MySQL database Host, Username, or Password is wrong. Fix and try again.'; } else if (!mysql_select_db("$db_name")) { $errorMsg = 'ERROR: Your MySQL database name is wrong(field 4). Fix and try again.'; } else { echo '<h1>Your Configuration Results</h1>'; mysql_connect("$db_host","$db_username","$db_pass") or die ("Error 328: Could Not Connect to the Database!"); mysql_select_db("$db_name") or die ("Error 329: Could Not Find a Database By That Name!"); $target_file = "scripts/connect_to_mysql.php";$target_file_data = '<?php
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
mysql_connect("' . $db_host . '","' . $db_username . '","' . $db_pass . '") or die (mysql_error());
mysql_select_db("' . $db_name . '") or die (mysql_error());
?>'; $handle = fopen($target_file, "w"); fwrite($handle, $target_file_data); fclose($handle);  $table1 = "CREATE TABLE myMembers (
		 		 id int(11) NOT NULL auto_increment,
				 username varchar(255) NOT NULL,
		 		 firstname varchar(255) NOT NULL,
		 		 lastname varchar(255) NOT NULL,
				 gender enum('m','f') NOT NULL default 'm',
				 birthday date NOT NULL default '0000-00-00',
		 		 country varchar(255) NOT NULL,
		 		 state varchar(255) NOT NULL,
		 		 city varchar(255) NOT NULL,
		 		 email varchar(255) NOT NULL,
		 		 password varchar(255) NOT NULL,
				 ipaddress varchar(255) NOT NULL,
		 		 sign_up_date date NOT NULL default '0000-00-00',
		 		 last_log_date date NOT NULL default '0000-00-00',
		 		 bio_body text NULL,
		 		 website varchar(255) NULL,
		 		 youtube varchar(255) NULL,
				 facebook varchar(255) NULL,
				 twitter varchar(255) NULL,
				 friend_array text NULL,
		 		 account_type enum('a','b','c') NOT NULL default 'a',
		 		 email_activated enum('0','1') NOT NULL default '0',
		 		 PRIMARY KEY (id),
		 		 UNIQUE KEY email (email)
		 		 ) "; $table2 = "CREATE TABLE blabbing (
		 		 id int(11) NOT NULL auto_increment,
		 		 mem_id int(11) NOT NULL,
		 		 the_blab varchar(255) NOT NULL,
		 		 blab_date datetime NOT NULL default '0000-00-00 00:00:00',
		 		 PRIMARY KEY (id)
		 		 ) "; $table3 = "CREATE TABLE admin (
		 		 id int(11) NOT NULL auto_increment,
				 email varchar(255) NOT NULL,
				 password varchar(255) NOT NULL,
		 		 admin_type enum('a','b','c') NOT NULL default 'a',
				 autoemail varchar(255) NOT NULL,
		 		 creation_date datetime NOT NULL default '0000-00-00 00:00:00',
		 		 PRIMARY KEY (id)
		 		 ) "; $table4 = "CREATE TABLE friends_requests (
		 		 id int(11) NOT NULL auto_increment,
				 mem1 int(11) NOT NULL,
				 mem2 int(11) NOT NULL,
		 		 timedate datetime NOT NULL,
		 		 PRIMARY KEY (id)
		 		 ) "; $table5 = "CREATE TABLE private_messages (
		 		 id int(11) NOT NULL auto_increment,
				 to_id int(11) NOT NULL,
				 from_id int(11) NOT NULL,
		 		 time_sent datetime NOT NULL,
				 subject varchar(255) NULL,
				 message text NULL,
				 opened enum('0','1') NOT NULL,
				 recipientDelete enum('0','1') NOT NULL,
				 senderDelete enum('0','1') NOT NULL,
		 		 PRIMARY KEY (id)
		 		 ) "; 
if (dbquery($table1)){ echo "Your myMembers table has been created successfully!<br /><br />"; } else { echo "CRITICAL ERROR: myMembers table has not been created for an unknown reason.<br /><br />"; } if (dbquery($table2)){ echo "Your blabbing table has been created successfully!<br /><br />"; } else { echo "CRITICAL ERROR: blabbing table has not been created for an unknown reason.<br /><br />"; } if (dbquery($table3)){ echo "Your admin table has been created successfully!<br /><br />"; } else { echo "CRITICAL ERROR: admin table has not been created for an unknown reason.<br /><br />"; } if (dbquery($table4)){ echo "Your friends_requests table has been created successfully!<br /><br />"; } else { echo "CRITICAL ERROR: friends_requests table has not been created for an unknown reason.<br /><br />"; } if (dbquery($table5)){ echo "Your private_messages table has been created successfully!<br /><br />"; } else { echo "CRITICAL ERROR: private_messages table has not been created for an unknown reason.<br /><br />"; } $db_password = md5($adminPass);  $adminInsert = "INSERT INTO admin (email, password, admin_type, autoemail, creation_date) VALUES('$adminEmail','$db_password','c','$autoEmail',now() )"; if (dbquery($adminInsert)){ echo "Your Administrator details have been placed into the Admin table successfully!<br /><br />"; } else { echo "CRITICAL ERROR: Admin email and password have not been set for an unknown reason.<br /><br />"; } echo '<hr /><h1>IMPORTANT:</h1> If you see no error warnings above your site is configured and ready to gather members. Remove the configure.php file from the server since it is no longer needed and could pose a security risk if left in place.<br /><br /> After you delete configure.php from the server, <a href="index.php">click here to head to your homepage</a>. All done!'; exit(); } } else { $errorMsg = "";$db_host = "";$db_username = "";$db_pass = "";$db_name = "";$autoEmail = "";$adminEmail = "";$adminPass = "";$adminPass2 = "";}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="Description" content="Register to yourdomain" />
<meta name="Keywords" content="register, yourdomain" />
<meta name="rating" content="General" />
<title>Configure Your Site</title>
<link href="style/main.css" rel="stylesheet" type="text/css" />
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<script src="js/jquery-1.4.2.js" type="text/javascript"></script>
<style type="text/css">
<!--
.style26 {color: #FF0000}
.style28 {font-size: 14px}
.brightRed {
	color: #F00;
}
.textSize_9px {
	font-size: 9px;
}
.hiddenDiv{
display:none;
}
-->
</style>
<script language="javascript" type="text/javascript"> $(document).ready(function() { $(".toggle").click(function () { if ($(this).next().is(":hidden")) { $(this).next().slideDown("fast"); } else { $(this).next().slideUp("fast") } }); }); function valConf() { var valid = true; var db_host = $("#db_host"); var db_username = $("#db_username"); var db_pass = $("#db_pass"); var db_name = $("#db_name"); var autoEmail = $("#autoEmail"); var adminEmail = $("#adminEmail"); var adminPass = $("#adminPass"); var adminPass2 = $("#adminPass2"); if (db_host.val() == "" || db_username.val() == "" || db_pass.val() == "" || db_name.val() == "" || autoEmail.val() == "" || adminEmail.val() == "" || adminPass.val() == "" || adminPass2.val() == "") { $("#formStatus").text("You cannot leave any fields blank").show().fadeOut(7000); valid = false; } else if (adminPass.val() != adminPass2.val()) { $("#formStatus").text("Your password fields do not match").show().fadeOut(7000); valid = false; } else { document.configForm.submit(); } return valid; }</script>
</head>
<body>
<div align="center"><img src="images/logo1.png" alt="Web Intersect Website Home Page" width="197" height="104" border="0" /></div>
<table class="mainBodyTable" border="0" align="center" cellpadding="0" cellspacing="0">
 <tr>
    <td width="738" valign="top">
      
        <h2 style="margin-left:40px;">Configure Your Social Site First Thing</h2>
      
      <table width="768" align="center" cellpadding="5">
        <script language="JavaScript" type="text/javascript"> document.write('<form name="configForm" id="configForm" action="configure.php" method="post" enctype="multipart/form-data" onsubmit="return valConf();">');</script>
          <tr>
            <td colspan="2"><font color="#FF0000"><strong><?php print "$errorMsg"; ?></strong></font></td>
          </tr>
          <tr>
            <td colspan="2"><h3 style="display:inline;">Enter your MySQL Database Connection Information </h3> [ <span class="toggle"><a href="#" onclick="return false" style="cursor:pointer;">what is this?</a></span> ]
            <div class="hiddenDiv" style="border:#999 1px solid; background-color:#FFF; padding:10px;">
            If you are unsure what data to place in the following four(4) fields used for connecting to your MySQL database, follow the lesson referenced below and make sure you can connect using that test script. Then simply place the data you used to get that test script working, into these 4 fields and continue</span>:<br />
            <br />
            Tutorial and MySQL connection example&nbsp;&nbsp;&bull;&nbsp;<a href="http://www.developphp.com/view_lesson.php?v=248" target="_blank">Connecting to Your Database</a><br />
            <br />
            You have to supply this data in order for the system to run. It requires one MySQL database.
<br />

            </div>
            </td>
          </tr>          
          <tr>
            <td width="139" align="right" class="alignRt">Database host:<span class="brightRed"> *</span></td>
            <td><input name="db_host" type="text" class="formFields" id="db_host" value="<?php print "$db_host"; ?>" size="48" maxlength="88" /></td>
          </tr>
          <tr>
            <td align="right" class="alignRt">Database Username:<span class="brightRed"> *</span></td>
            <td><input name="db_username" type="text" class="formFields" id="db_username" value="<?php print "$db_username"; ?>" size="48" maxlength="64" /></td>
          </tr>                    
          <tr>
            <td align="right" class="alignRt">Database Password:<span class="brightRed"> *</span></td>
            <td><input name="db_pass" type="text" class="formFields" id="db_pass" value="<?php print "$db_pass"; ?>" size="48" maxlength="36" /></td>
          </tr>
          <tr>
            <td align="right" class="alignRt">Database name: <span class="brightRed">*</span></td>
            <td><input name="db_name" type="text" class="formFields" id="db_name" value="<?php print "$db_name"; ?>" size="48" maxlength="64" /></td>
          </tr>
          <tr>
            <td colspan="2"><h3 style="display:inline;"><br />
              <br />
              Enter ther Site's Auto Email Address </h3>
               [ <span class="toggle"><a href="#" onclick="return false" style="cursor:pointer;">what is this?</a></span> ]
              <div class="hiddenDiv" style="border:#999 1px solid; background-color:#FFF; padding:10px;">This email is used as the sender address for all automated email sending from your site. <br />
                <br />
              For instance when people join your site they get an account activation email sent to them automatically. Or when they forget their login credentials and use the forgot password form. <br />
              <br />
              Must be a valid and working email address different from your Administrator Account email below.
              </div>
              </td>
          </tr>   
          <tr>
            <td align="right" class="alignRt">Auto Email Address: <span class="brightRed">*</span></td>
            <td><input name="autoEmail" type="text" class="formFields" id="autoEmail" value="<?php print "$autoEmail"; ?>" size="32" maxlength="36" /></td>
          </tr>
          <tr>
            <td colspan="2"><h3 style="display:inline;"><br />
              <br />
              Establish the Administrator Account Login Credentials Here</h3>
               [ <span class="toggle"><a href="#" onclick="return false" style="cursor:pointer;">what is this?</a></span> ]
              <div class="hiddenDiv" style="border:#999 1px solid; background-color:#FFF; padding:10px;">This is the account for managing the site as the super administrator. You may want this to be a private email address that nobody knows, and a password nobody can guess. <br />
<br />
This information can be changed later if needed from within your PHPMyAdmin program on the host server.
              </div>
              </td>
          </tr>   
          <tr>
            <td align="right" class="alignRt">Admin Email Address: <span class="brightRed">*</span></td>
            <td><input name="adminEmail" type="text" class="formFields" id="adminEmail" value="<?php print "$adminEmail"; ?>" size="32" maxlength="36" /></td>
          </tr>     
          <tr>
            <td align="right" class="alignRt">Admin Password: <span class="brightRed">*</span></td>
            <td><input name="adminPass" type="password" class="formFields" id="adminPass" value="<?php print "$adminPass"; ?>" size="32" maxlength="20" /></td>
          </tr>
          <tr>
            <td align="right" class="alignRt">Confirm Password: <span class="brightRed">*</span></td>
            <td><input name="adminPass2" type="password" class="formFields" id="adminPass2" value="<?php print "$adminPass2"; ?>" size="32" maxlength="20" /></td>
          </tr>                       
          <tr>
            <td>&nbsp;</td>
            <td><p><span id="formStatus" style="color:#F00; font-size:16px; font-weight:bold;"></span><br />
            <script language="JavaScript" type="text/javascript"> document.write('<input type="submit" name="Submit" value="Submit Configurations and Test Database Connectivity" onsubmit="return valConf();"/>');</script>
              
              <br />
            </p></td>
          </tr>
          <script language="JavaScript" type="text/javascript"> document.write('</form>');</script>
        
      </table>
      <br />
      <br /></td>
  </tr>
</table>
<?php include_once "footer_template.php"; ?>
</body>
</html>