<? 
require_once('mainfile.php');

$username  = $_REQUEST['who'];

// Let's get user data

$profilesql = dbquery("SELECT * FROM users WHERE uname = '".$username."'");
$row = mysql_fetch_array($profilesql);

$avatar = $row['uimg'];
$the_avatar = str_replace("_bigger","",$avatar);
$big_avatar = str_replace("_normal","",$the_avatar);
$city = $row['uloc'];

$details = $row['uabout'];

$blog = $row['uweb'];

$tweets = $row['utweet'];

$followers = $row['ufollow'];

  
// Show Template
if(isset($template)):
	if(is_file('templates/'.$template.'/t_user.php')):
		require_once('templates/'.$template.'/t_user.php');
	else:
		die("Your template appears to be corrupt. Try re-uploading the folder.".'/templates/'.$template.'/index.php');
	endif;
else:
	die("Your default template doesn't appear to be set.");
endif;
  

  
ob_end_flush();
?>