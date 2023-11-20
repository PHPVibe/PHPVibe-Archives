<?php 
// Start Session First Thing
session_start(); 
//------ CHECK IF THE USER IS LOGGED IN OR NOT AND GIVE APPROPRIATE OUTPUT -------
$logOptions = ''; // Initialize the logOptions variable that gets printed to the page
// If the session variable and cookie variable are not set this code runs
if (!isset($_SESSION['idx'])) { 
  if (!isset($_COOKIE['idCookie'])) {
     $logOptions = ' <p><a href="' . $site_url . 'register.php">Register Account</a>
	 &nbsp;&nbsp;&nbsp; 
	 <a href="' . $site_url . 'login.php">Log In</a> </p>';
	// echo $logOptions;
   }
}
// If session ID is set for logged in user without cookies remember me feature set
if (isset($_SESSION['idx'])) { 
    
	$decryptedID = base64_decode($_SESSION['idx']);
	$id_array = explode("p3h9xfn8sq03hs2234", $decryptedID);
	$logOptions_id = $id_array[1];
    $logOptions_username = $_SESSION['username'];
    $logOptions_username = substr('' . $logOptions_username . '', 0, 15); // cut user name down in length if too long
	
	// Check if this user has any new PMs and construct which envelope to show
	$sql_pm_check = dbquery("SELECT id FROM private_messages WHERE to_id='$logOptions_id' AND opened='0' LIMIT 1");
	$num_new_pm = mysql_num_rows($sql_pm_check);
	if ($num_new_pm > 0) {
		$PM_envelope = $num_new_pm;
		
	} else {
		$PM_envelope = $num_new_pm;
			
	}
    // Ready the output for this logged in user
     $logOptions = ' <p> 
	 <a href="'.$site_url.'profile.php?id=' . $logOptions_id . '">Profile</a> &nbsp;
	 <a href="'.$site_url.'edit_profile.php">Account Options</a> &nbsp;
<a href="'.$site_url.'pm_inbox.php">Inbox ('.$PM_envelope.')</a> &nbsp;
<a href="'.$site_url.'pm_sentbox.php">Sent Msg.</a>&nbsp;
<a href="'.$site_url.'logout.php">Log Out</a> </p>';
	//echo $logOptions;
} else if (isset($_COOKIE['idCookie'])) {// If id cookie is set, but no session ID is set yet, we set it below and update stuff
	
	$decryptedID = base64_decode($_COOKIE['idCookie']);
	$id_array = explode("nm2c0c4y3dn3727553", $decryptedID);
	$userID = $id_array[1]; 
	$userPass = $_COOKIE['passCookie'];
	// Get their user first name to set into session var
    $sql_uname = dbquery("SELECT username FROM myMembers WHERE id='$userID' AND password='$userPass' LIMIT 1");
	$numRows = mysql_num_rows($sql_uname);
	if ($numRows == 0) {
		echo 'Something appears wrong with your stored log in credentials. <a href="login.php">Log in again here please</a>';
		exit();
	}
    while($row = mysql_fetch_array($sql_uname)){ 
	    $username = $row["username"];
	}

    $_SESSION['id'] = $userID; // now add the value we need to the session variable
	$_SESSION['idx'] = base64_encode("g4p3h9xfn8sq03hs2234$userID");
    $_SESSION['username'] = $username;

    $logOptions_id = $userID;
    $logOptions_uname = $username;
    $logOptions_uname = substr('' . $logOptions_uname . '', 0, 15); 
    ///////////          Update Last Login Date Field       /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    dbquery("UPDATE myMembers SET last_log_date=now() WHERE id='$logOptions_id'"); 
    // Ready the output for this logged in user
    // Check if this user has any new PMs and construct which envelope to show
	$sql_pm_check = dbquery("SELECT id FROM private_messages WHERE to_id='$logOptions_id' AND opened='0' LIMIT 1");
	$num_new_pm = mysql_num_rows($sql_pm_check);
	if ($num_new_pm > 0) {
		$PM_envelope = $num_new_pm;
		
	} else {
		$PM_envelope = $num_new_pm;
		
	}
	// Ready the output for this logged in user
     $logOptions = ' 
	 <p><a href="'.$site_url.'profile.php?id=' . $logOptions_id . '">Profile</a>
	 |
<a href="'.$site_url.'edit_profile.php">Account Options</a> &nbsp;
<a href="'.$site_url.'pm_inbox.php">Inbox Inbox ('.$PM_envelope.')</a> &nbsp;
<a href="'.$site_url.'pm_sentbox.php">Sent Msg.</a>&nbsp;
<a href="'.$site_url.'logout.php">Log Out</a> </p>';
	//echo $logOptions;
}
?>

