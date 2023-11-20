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
session_start();
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////                ERROR HANDLING AND LOW LEVEL SECURITY CHECKS                      //////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$thisWipit = $_POST['thisWipit'];
$sessWipit = base64_decode($_SESSION['wipit']);
/* echo $_SESSION['wipit'] . ' | ' . $_SESSION['id'] . ' | ' . $_POST['senderID'];
exit(); */
// If session variable for wipit is not set OR if session id is not set
if (!isset($_SESSION['wipit']) || !isset($_SESSION['id'])) {
	echo  '<img src="images/round_error.png" alt="Error" width="31" height="30" /> &nbsp; <strong>Your session expired from inactivity. Please refresh your browser and continue.</strong>';
    exit();
}
// else if session id IS NOT EQUAL TO the posted variable for sender ID
else if ($_SESSION['id'] != $_POST['senderID']) {
	echo  '<img src="images/round_error.png" alt="Error" width="31" height="30" /> &nbsp;  <strong>Forged submission</strong>';
    exit();
}
// else if session wipit variable IS NOT EQUAL TO the posted wipit variable
else if ($sessWipit != $thisWipit) {
	echo  '<img src="images/round_error.png" alt="Error" width="31" height="30" /> &nbsp;  <strong>Forged submission</strong>';
    exit();
}
// else if either wipit variables are empty
else if ($thisWipit == "" || $sessWipit == "") {
	echo  '<img src="images/round_error.png" alt="Error" width="31" height="30" /> &nbsp;  <strong>Missing Data</strong>';
    exit();
}
require_once "../scripts/connect_to_mysql.php"; // <<---- Require connection to database here
// PREVENT DOUBLE POSTS /////////////////////////////////////////////////////////////////////////////
$checkuserid = $_POST['senderID'];
$prevent_dp = dbquery("SELECT id FROM private_messages WHERE from_id='$checkuserid' AND time_sent between subtime(now(),'0:0:20') and now()");
$nr = mysql_num_rows($prevent_dp);
if ($nr > 0){
	echo '<img src="images/round_error.png" alt="Error" width="31" height="30" /> &nbsp;  You must wait 20 seconds between your private message sending.';
	exit();
}
///////////////////////////////////////////////////////////////////////////////////////
// PREVENT MORE THAN 30 IN ONE DAY FROM THIS MEMBER  /////////////////////////////////////////////////////////////////////////////
$sql = dbquery("SELECT id FROM private_messages WHERE from_id='$checkuserid' AND DATE(time_sent) = DATE(NOW()) LIMIT 40");
$numRows = mysql_num_rows($sql);
if ($numRows > 30) {
	echo '<img src="images/round_error.png" alt="Error" width="31" height="30" /> &nbsp;  You can only send 30 Private Messages per day.';
    exit();
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////                                                    PARSE THE MESSAGE                                                 //////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Process the message once it has been sent 
if (isset($_POST['message'])) { 
  // Escape and prepare our variables for insertion into the database 
  // This is also where you would run any sort of editing, such as BBCode parsing 
  $to = preg_replace('#[^0-9]#i', '', $_POST['rcpntID']); 
  $from = preg_replace('#[^0-9]#i', '', $_POST['senderID']); 
  //$toName = preg_replace('#[^A-Za-z0-9]#i', '', $_POST['rcpntName']); 
  //$fromName = preg_replace('#[^A-Za-z0-9]#i', '', $_POST['senderName']); 
  $sub = htmlspecialchars($_POST['subject']); // Convert html tags and such to html entities which are safer to store and display
  $msg = htmlspecialchars($_POST['message']); // Convert html tags and such to html entities which are safer to store and display
  $sub  = mysql_real_escape_string($sub); // Just in case anything malicious is not converted, we escape those characters here
  $msg  = mysql_real_escape_string($msg); // Just in case anything malicious is not converted, we escape those characters here
  // Handle all pm form specific error checking here 
  if (empty($to) || empty($from) || empty($sub) || empty($msg)) { 
    echo '<img src="images/round_error.png" alt="Error" width="31" height="30" /> &nbsp;  Missing Data to continue';
	exit();
  } else { 
		// Delete the message residing at the tail end of their list so they cannot archive more than 100 PMs ------------------
        $sqldeleteTail = dbquery("SELECT * FROM private_messages WHERE to_id='$to' ORDER BY time_sent DESC LIMIT 0,100"); 
        $dci = 1;
        while($row = mysql_fetch_array($sqldeleteTail)){ 
                $pm_id = $row["id"];
				if ($dci > 99) {
					$deleteTail = dbquery("DELETE FROM private_msg WHERE id='$pm_id'"); 
				}
				$dci++;
        }
        // End delete any comments past 100 off of the tail end -------------  
		
    // INSERT the data into your table now
    $sql = "INSERT INTO private_messages (to_id, from_id, time_sent, subject, message) VALUES ('$to', '$from', now(), '$sub', '$msg')"; 
    if (!dbquery($sql)) { 
	    echo '<img src="images/round_error.png" alt="Error" width="31" height="30" /> &nbsp;  Could not send message! An insertion query error has occured.';
	    exit();
    } else { 
	    // Check accountOptions table to see if we can email alert them 
		// (NOT MADE YET BY ADAM, HE WILL MAKE ACCOUNT OPTIONS TABLE SOON)
      /*   $sqlCheckOptions = dbquery("SELECT pm_mail_able FROM accountOptions WHERE uid='$to' LIMIT 1"); 
        while($row = mysql_fetch_array($sqlCheckOptions)){ 
                $pm_mail_able = $row["pm_mail_able"];
				if ($pm_mail_able == "1") {
					// email them here
					// Get the recipient's email address from DB
					$sqlemailaddy= dbquery("SELECT email FROM myMembers WHERE id='$to' LIMIT 1"); 
					while($row = mysql_fetch_array($sqlemailaddy)){ $recipient_email = $row["email"];}
					// End Get the recipient's email address from DB
					// Send email alert to profile owner telling they have private message
					$eto = "$recipient_email";
					$efrom = "you@yourdotcom.com";
					$esubject = "You have a private message at our website";
					//Begin Email Message
					$emessage = "Hi $toName,

					This is an automated message to let you know that $fromName just sent you a private message:

					Message Subject: $sub

					Click your envelope on top here to view your inbox: http://www.webintersect.com";
					//end of message
					$eheaders  = "From: $efrom\r\n";
					$eheaders .= "Content-type: text\r\n";
					mail($eto, $esubject, $emessage, $eheaders);
					//end of send email to profile owner
				} // close if
         } // close while */
        // End Check Profile Options table to see if we can email alert them ----------------------------------------------------------	  
		// Send back to sent box
		echo '<img src="images/round_success.png" alt="Success" width="31" height="30" /> &nbsp;&nbsp;&nbsp;<strong>Message sent successfully</strong>';
		exit();
    } // close else after the sql DB INSERT check
  } // Close if (empty($sub) || empty($msg)) { 
} // Close if (isset($_POST['message'])) { 
?>