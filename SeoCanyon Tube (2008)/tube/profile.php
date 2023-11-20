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
include_once("mainfile.php");
require_once("includes/functions.php");
// Include the class files for auto making links out of full URLs and for Time Ago date formatting
include_once("wi_class_files/autoMakeLinks.php");
include_once ("wi_class_files/agoTimeFormat.php");
// Create the two new objects before we can use them below in this script
$activeLinkObject = new autoActiveLink;
$myObject = new convertToAgo;
?>
<?php 
// ------- INITIALIZE SOME VARIABLES ---------
// they must be initialized in some server environments or else errors will get thrown
$id = "";
$username = "";
$firstname = "";
$lastname = "";
$mainNameLine = "";
$country = "";	
$state = "";
$city = "";
$zip = "";
$bio_body = "";
$website = "";
$youtube = "";
$facebook = "";
$twitter = "";
$twitterWidget = "";
$locationInfo = "";
$user_pic = "";
$blabberDisplayList = "";
$interactionBox = "";
$cacheBuster = rand(999999999,9999999999999); // Put on an image URL will help always show new when changed
// ------- END INITIALIZE SOME VARIABLES ---------

// ------- ESTABLISH THE PAGE ID ACCORDING TO CONDITIONS ---------
if (isset($_GET['id'])) {
	 $id = preg_replace('#[^0-9]#i', '', $_GET['id']); // filter everything but numbers
} else if (isset($_SESSION['idx'])) {
	 $id = $logOptions_id;
} else {
   header("location: index.php");
   exit();
}
// ------- END ESTABLISH THE PAGE ID ACCORDING TO CONDITIONS ---------

// ------- FILTER THE ID AND QUERY THE DATABASE --------
$id = preg_replace('#[^0-9]#i', '', $id); // filter everything but numbers on the ID just in case
$sql = dbquery("SELECT * FROM myMembers WHERE id='$id' LIMIT 1"); // query the member
// ------- FILTER THE ID AND QUERY THE DATABASE --------

// ------- MAKE SURE PERSON EXISTS IN DATABASE ---------
$existCount = mysql_num_rows($sql); // count the row nums
 if ($existCount == 0) { // evaluate the count
	 header("location: index.php?msg=user_does_not_exist");
     exit();
}
// ------- END MAKE SURE PERSON EXISTS IN DATABASE ---------

// ------- WHILE LOOP FOR GETTING THE MEMBER DATA ---------
while($row = mysql_fetch_array($sql)){ 
    $username = $row["username"];
	$firstname = $row["firstname"];
	$lastname = $row["lastname"];
	$country = $row["country"];	
	$state = $row["state"];
	$city = $row["city"];
	$sign_up_date = $row["sign_up_date"];
    $sign_up_date = strftime("%b %d, %Y", strtotime($sign_up_date));
	$last_log_date = $row["last_log_date"];
    $last_log_date = strftime("%b %d, %Y", strtotime($last_log_date));	
	$bio_body = $row["bio_body"];	
	$bio_body = str_replace("&#39;", "'", $bio_body);
	$bio_body = stripslashes($bio_body);
	$website = $row["website"];
	$youtube = $row["youtube"];
	$facebook = $row["facebook"];
	$twitter = $row["twitter"];
	$friend_array = $row["friend_array"];
	///////  Mechanism to Display Pic. See if they have uploaded a pic or not  //////////////////////////
	$check_pic = "members/$id/image01.jpg";
	$default_pic = "members/0/image01.jpg";
	if (file_exists($check_pic)) {
    $user_pic = "<img src=\"$check_pic?$cacheBuster\" width=\"218px\" />"; 
	} else {
	$user_pic = "<img src=\"$default_pic\" width=\"218px\" />"; 
	}
	///////  Mechanism to Display Real Name Next to Username - real name(username) //////////////////////////
	if ($firstname != "") {
        $mainNameLine = "$firstname $lastname ($username)";
		$username = $firstname;
	} else {
		$mainNameLine = $username;
	}
	///////  Mechanism to Display Youtube channel link or not  //////////////////////////
	if ($youtube == "") {
    $youtube = "";
	} else {
	$ytusername = $youtube;
	$youtube = '<br /><br /><img src="images/youtubeIcon.jpg" width="18" height="12" alt="Youtube Channel for ' . $username . '" /> <strong>YouTube Channel:</strong><br /><a href="http://www.youtube.com/user/' . $youtube . '" target="_blank">youtube.com/' . $youtube . '</a>';
	}
    ///////  Mechanism to Display Facebook Profile link or not  //////////////////////////
	if ($facebook == "") {
    $facebook = "";
	} else {
	$facebook = '<br /><br /><img src="images/facebookIcon.jpg" width="18" height="12" alt="Facebook Profile for ' . $username . '" /> <strong>Facebook Profile:</strong><br /><a href="http://www.facebook.com/profile.php?id=' . $facebook . '" target="_blank">profile.php?id=' . $facebook . '</a>';
	}
	    ///////  Mechanism to Display Website URL or not  //////////////////////////
	if ($website == "") {
    $website = "";
	} else {
	$website = '<br /><br /><img src="images/websiteIcon.jpg" width="18" height="12" alt="Website URL for ' . $username . '" /> <strong>Website:</strong><br /><a href="http://' . $website . '" target="_blank">' . $website . '</a>'; 
	}
	///////  Mechanism to Display About me text or not  //////////////////////////
	if ($bio_body == "") {
    $bio_body = "";
	} else {
	$bio_body = '<strong>' . $bio_body . '</strong>'; 
	}
	///////  Mechanism to Display Location Info or not  //////////////////////////
	if ($country == "" && $state == "" && $city == "") {
    $locationInfo = "";
	} else {
	$locationInfo = "$city &middot; $state<br />$country ".'<a href="#" onclick="return false" onmousedown="javascript:toggleViewMap(\'google_map\');">view map</a>'; 
	}
} // close while loop
// ------- END WHILE LOOP FOR GETTING THE MEMBER DATA ---------

// ------- POST NEW BLAB TO DATABASE ---------
$blab_outout_msg = "";
if (isset($_POST['blab_field']) && $_POST['blab_field'] != "" && $_POST['blab_field'] != " "){
	
	 $blabWipit = $_POST['blabWipit'];
     $sessWipit = base64_decode($_SESSION['wipit']);
	 if (!isset($_SESSION['wipit'])) {
		 
	 } else if ($blabWipit == $sessWipit) {
	 	 // Delete any blabs over 50 for this member
	 	 $sqlDeleteBlabs = dbquery("SELECT * FROM blabbing WHERE mem_id='$id' ORDER BY blab_date DESC LIMIT 50");
	 	 $bi = 1;
		  while ($row = mysql_fetch_array($sqlDeleteBlabs)) {
		 	 $blad_id = $row["id"];
			  if ($bi > 20) {
			  	 $deleteBlabs = dbquery("DELETE FROM blabbing WHERE id='$blad_id'");
		 	 }
		 	 $bi++;
		  }
		  // End Delete any blabs over 20 for this member
	 	 $blab_field = $_POST['blab_field'];
	 	 $blab_field = stripslashes($blab_field);
	 	 $blab_field = strip_tags($blab_field);
	 	 $blab_field = mysql_real_escape_string($blab_field);
	 	 $blab_field = str_replace("'", "&#39;", $blab_field);
	 	 $sql = dbquery("INSERT INTO blabbing (mem_id, the_blab, blab_date) VALUES('$id','$blab_field', now())") or die (mysql_error());
	 	 $blab_outout_msg = "";
	 	 }
}
// ------- END POST NEW BLAB TO DATABASE ---------

// ------- MEMBER BLABS OUTPUT CONSTRUCTION ---------
///////  Mechanism to Display Pic
	if (file_exists($check_pic)) {
    $blab_pic = '<div style="overflow:hidden; height:40px;"><a href="profile.php?id=' . $id . '"><img src="' . $check_pic . '" width="40px" border="0" /></a></div>'; 
	} else {
	$blab_pic = '<div style="overflow:hidden; height:40px;"><a href="profile.php?id=' . $id . '"><img src="' . $default_pic . '" width="40px" border="0" /></a></div>'; 
	}
///////  END Mechanism to Display Pic	
$sql_blabs = dbquery("SELECT id, mem_id, the_blab, blab_date FROM blabbing WHERE mem_id='$id' ORDER BY blab_date DESC LIMIT 20");

while($row = mysql_fetch_array($sql_blabs)){
	
	$blabid = $row["id"];
	$uid = $row["mem_id"];
	$the_blab = $row["the_blab"];
	$the_blab = ($activeLinkObject -> makeActiveLink($the_blab));
	$blab_date = $row["blab_date"];
	$convertedTime = ($myObject -> convert_datetime($blab_date));
    $whenBlab = ($myObject -> makeAgo($convertedTime));
	
				$blabberDisplayList .= '
			        <table style="background-color:#FFF; border:#999 1px solid; border-top:none;" cellpadding="5" width="100%">
					<tr>
					<td width="10%" valign="top">' . $blab_pic . '</td>
					<td width="90%" valign="top" style="line-height:1.5em;"><span class="greenColor textsize10">' . $whenBlab . ' <a href="profile.php?id=' . $uid . '">' . $username . '</a> said:</span><br />
            ' . $the_blab . '</td>
            </tr></table>';
	
}
// ------- END MEMBER BLABS OUTPUT CONSTRUCTION ---------

// ------- ESTABLISH THE PROFILE INTERACTION TOKEN ---------
$thisRandNum = rand(9999999999999,999999999999999999);
$_SESSION['wipit'] = base64_encode($thisRandNum); // Will always overwrite itself each time this script runs
// ------- END ESTABLISH THE PROFILE INTERACTION TOKEN ---------

// ------- EVALUATE WHAT CONTENT TO PLACE IN THE MEMBER INTERACTION BOX -------------------
// initialize some output variables
$friendLink = "";
$the_blab_form = "";
if (isset($_SESSION['idx']) && $logOptions_id != $id) { // If SESSION idx is set, AND it does not equal the profile owner's ID

	// SQL Query the friend array for the logged in viewer of this profile if not the owner
	$sqlArray = dbquery("SELECT friend_array FROM myMembers WHERE id='" . $logOptions_id ."' LIMIT 1"); 
	while($row=mysql_fetch_array($sqlArray)) { $iFriend_array = $row["friend_array"]; }
	 $iFriend_array = explode(",", $iFriend_array);
	if (in_array($id, $iFriend_array)) { 
	    $friendLink = '<a href="#" class="large glowbutton blue" onclick="return false" onmousedown="javascript:toggleInteractContainers(\'remove_friend\');">Remove Friend</a>';
	} else {
	    $friendLink = '<a href="#" class="large glowbutton blue" onclick="return false" onmousedown="javascript:toggleInteractContainers(\'add_friend\');">Add as Friend</a>';	
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$interactionBox = '<br /><br /><div class="interactionLinksDiv">
		   ' . $friendLink . ' 
           <a href="#" class="large glowbutton red" onclick="return false" onmousedown="javascript:toggleInteractContainers(\'private_message\');">Send Msg</a>
          </div><br />';
		  $the_blab_form = '';
} else if (isset($_SESSION['idx']) && $logOptions_id == $id) { // If SESSION idx is set, AND it does equal the profile owner's ID
	$interactionBox = '<br /><br /><div class="interactionLinksDiv">
           <a href="#" class="large glowbutton pink" onclick="return false" onmousedown="javascript:toggleInteractContainers(\'friend_requests\');">Friend Requests</a>
          </div><br />';
		  $the_blab_form = ' ' . $blab_outout_msg . '
          <div style="background-color:#eeeeee; border:#999 1px solid; padding:8px;">
          <form action="profile.php" method="post" enctype="multipart/form-data" name="blab_from">
          <textarea name="blab_field" rows="3" style="width:99%;"></textarea>
		  <input name="blabWipit" type="hidden" value="' . $thisRandNum . '" />
          <strong>What\'s on your mind? ' . $username . '</strong> (220 char max) <input class="large glowbutton pink" name="submit" type="submit" value="Share" />
          </form></div>';
} else { // If no SESSION id is set, which means we have a person who is not logged in
	$interactionBox = '<div style="border:#CCC 1px solid; padding:5px; background-color:#E4E4E4; color:#999; font-size:11px;">
           <a href="register.php">Sign Up</a> or <a href="login.php">Log In</a> to interact with ' . $username . '
          </div>';
		  $the_blab_form = '<div style="background-color:#BDF; border:#999 1px solid; padding:8px;">
          <textarea name="blab_field" rows="3" style="width:99%;"></textarea>
          <a href="register.php">Sign Up</a> or <a href="login.php">Log In</a> to write on ' . $username . '\'s Board
          </div>';
}
// ------- END EVALUATE WHAT CONTENT TO PLACE IN THE MEMBER INTERACTION BOX -------------------

// ------- POPULATE FRIEND DISPLAY LISTS IF THEY HAVE AT LEAST ONE FRIEND -------------------
$friendList = "";
$friendPopBoxList = "";
if ($friend_array  != "") { 
	// ASSEMBLE FRIEND LIST AND LINKS TO VIEW UP TO 6 ON PROFILE
	$friendArray = explode(",", $friend_array);
	$friendCount = count($friendArray);
    $friendArray6 = array_slice($friendArray, 0, 6);
	
	$friendList .= '<div><h4>' . $username . '\'s Friends (<a href="#" onclick="return false" onmousedown="javascript:toggleViewAllFriends(\'view_all_friends\');">' . $friendCount . '</a>)</h4></div>';
    $i = 0; // create a varible that will tell us how many items we looped over 
	 $friendList .= '<div class="infoBody" style="border-bottom:#666 1px solid;"><table id="friendTable" align="center" cellspacing="4"></tr>'; 
    foreach ($friendArray6 as $key => $value) { 
        $i++; // increment $i by one each loop pass 
		$check_pic = 'members/' . $value . '/image01.jpg';
		    if (file_exists($check_pic)) {
				$frnd_pic = '<a href="profile.php?id=' . $value . '"><img src="' . $check_pic . '" width="54px" border="1"/></a>';
		    } else {
				$frnd_pic = '<a href="profile.php?id=' . $value . '"><img src="members/0/image01.jpg" width="54px" border="1"/></a> &nbsp;';
		    }
			$sqlName = dbquery("SELECT username, firstname FROM myMembers WHERE id='$value' LIMIT 1") or die ("Sorry we had a mysql error!");
		    while ($row = mysql_fetch_array($sqlName)) { $friendUserName = substr($row["username"],0,12); $friendFirstName = substr($row["firstname"],0,12);}
			if (!$friendUserName) {$friendUserName = $friendFirstName;} // If username is blank use the firstname... programming changes in v1.32 call for this
			if ($i % 6 == 4){
				$friendList .= '<tr><td><div style="width:56px; height:68px; overflow:hidden;" title="' . $friendUserName . '">
				<a href="profile.php?id=' . $value . '">' . $friendUserName . '</a><br />' . $frnd_pic . '
				</div></td>';  
			} else {
				$friendList .= '<td><div style="width:56px; height:68px; overflow:hidden;" title="' . $friendUserName . '">
				<a href="profile.php?id=' . $value . '">' . $friendUserName . '</a><br />' . $frnd_pic . '
				</div></td>'; 
			}
    } 
	 $friendList .= '</tr></table>
	 <div align="right"><a href="#" onclick="return false" onmousedown="javascript:toggleViewAllFriends(\'view_all_friends\');">view all</a></div>
	 </div>'; 
	// END ASSEMBLE FRIEND LIST... TO VIEW UP TO 6 ON PROFILE
	// ASSEMBLE FRIEND LIST AND LINKS TO VIEW ALL(50 for now until we paginate the array)
	$i = 0;
	$friendArray50 = array_slice($friendArray, 0, 50);
	$friendPopBoxList = '<table id="friendPopBoxTable" width="100%" align="center" cellpadding="6" cellspacing="0">';
	foreach ($friendArray50 as $key => $value) { 
        $i++; // increment $i by one each loop pass 
		$check_pic = 'members/' . $value . '/image01.jpg';
		    if (file_exists($check_pic)) {
				$frnd_pic = '<a href="profile.php?id=' . $value . '"><img src="' . $check_pic . '" width="54px" border="1"/></a>';
		    } else {
				$frnd_pic = '<a href="profile.php?id=' . $value . '"><img src="members/0/image01.jpg" width="54px" border="1"/></a> &nbsp;';
		    }
			$sqlName = dbquery("SELECT username, firstname, country, state, city FROM myMembers WHERE id='$value' LIMIT 1") or die ("Sorry we had a mysql error!");
		    while ($row = mysql_fetch_array($sqlName)) { $funame = $row["username"]; $ffname = $row["firstname"]; $fcountry = $row["country"]; $fstate = $row["state"]; $fcity = $row["city"]; }
			if (!$funame) {$funame = $ffname;} // If username is blank use the firstname... programming changes in v1.32 call for this
				if ($i % 2) {
					$friendPopBoxList .= '<tr bgcolor="#F4F4F4"><td width="14%" valign="top">
					<div style="width:56px; height:56px; overflow:hidden;" title="' . $funame . '">' . $frnd_pic . '</div></td>
				     <td width="86%" valign="top"><a href="profile.php?id=' . $value . '">' . $funame . '</a><br /><font size="-2"><em>' . $fcity . '<br />' . $fstate . '<br />' . $fcountry . '</em></font></td>
				    </tr>';  
				} else {
				    $friendPopBoxList .= '<tr bgcolor="#E0E0E0"><td width="14%" valign="top">
					<div style="width:56px; height:56px; overflow:hidden;" title="' . $funame . '">' . $frnd_pic . '</div></td>
				     <td width="86%" valign="top"><a href="profile.php?id=' . $value . '">' . $funame . '</a><br /><font size="-2"><em>' . $fcity . '<br />' . $fstate . '<br />' . $fcountry . '</em></font></td>
				    </tr>';  
				}
    } 
	$friendPopBoxList .= '</table>';
	// END ASSEMBLE FRIEND LIST AND LINKS TO VIEW ALL(50 for now until we paginate the array)
}
// ------- END POPULATE FRIEND DISPLAY LISTS IF THEY HAVE AT LEAST ONE FRIEND -------------------



// Show Template

if(isset($template)):

	if(is_file('templates/'.$template.'/profile.php')):

		require_once('templates/'.$template.'/profile.php');

	else:

		die("Your template appears to be corrupt. Try re-uploading the folder.".'/templates/'.$template.'/index.php');

	endif;

else:

	die("Your default template doesn't appear to be set.");

endif;

  


ob_end_flush();
?>