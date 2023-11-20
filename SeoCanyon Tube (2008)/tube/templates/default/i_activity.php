<?php

// Create the two objects before we can use them below in this script
$activeLinkObject = new autoActiveLink;
$myObject = new convertToAgo;

$sql_blabs = dbquery("SELECT id, mem_id, the_blab, blab_date FROM blabbing ORDER BY blab_date DESC LIMIT 6");

$blabberDisplayList = ""; // Initialize the variable here

while($row = dbarray($sql_blabs)){
	
	$blabid = $row["id"];
	$uid = $row["mem_id"];
	$the_blab = $row["the_blab"];
	$the_blab = ($activeLinkObject -> makeActiveLink($the_blab));
	$blab_date = $row["blab_date"];
	$convertedTime = ($myObject -> convert_datetime($blab_date));
    $whenBlab = ($myObject -> makeAgo($convertedTime));
	//$blab_date = strftime("%b %d, %Y %I:%M:%S %p", strtotime($blab_date));
	// Inner sql query
	$sql_mem_data = dbquery("SELECT id, username, firstname, lastname FROM myMembers WHERE id='$uid' LIMIT 1");
	while($row = dbarray($sql_mem_data)){
			$uid = $row["id"];
			$username = $row["username"];
			$firstname = $row["firstname"];
			if ($firstname != "") {$username = $firstname; } // (I added usernames late in  my system, this line is not needed for you)
			///////  Mechanism to Display Pic. See if they have uploaded a pic or not  //////////////////////////
			$ucheck_pic = "members/$uid/image01.jpg";
			$udefault_pic = "members/0/image01.jpg";
			if (file_exists($ucheck_pic)) {
			$blabber_pic = '<div style="overflow:hidden; width:40px; height:40px;"><img src="' . $ucheck_pic . '" width="40px" border="0" /></div>'; // forces picture to be 100px wide and no more
			} else {
			$blabber_pic = "<img src=\"$udefault_pic\" width=\"40px\" height=\"40px\" border=\"0\" />"; // forces default picture to be 100px wide and no more
			}
	
			$blabberDisplayList .= '
      			<table width="100%" align="center" cellpadding="4" bgcolor="#CCCCCC">
        <tr>
          <td width="7%" bgcolor="#FFFFFF" valign="top"><a href="profile.php?id=' . $uid . '">' . $blabber_pic . '</a>
          </td>
          <td width="93%" bgcolor="#EFEFEF" style="line-height:1.5em;" valign="top"><span class="greenColor textsize10"><a href="profile.php?id=' . $uid . '">' . $username . '</a> said: </span><br />
          ' . $the_blab . '</td>
        </tr>
      </table>';
	 
			}
	
}
 echo $blabberDisplayList;
?>