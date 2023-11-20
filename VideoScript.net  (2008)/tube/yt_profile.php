<?php 
require_once('mainfile.php');
require_once('includes/functions.php');
$ytusername  = $_REQUEST['who'];

?>
<?php 
 $authorFeed = simplexml_load_file('http://gdata.youtube.com/feeds/api/users/'.$ytusername);  
$authorData = $authorFeed->children('http://gdata.youtube.com/schemas/2007');
	$attrs = $authorData->statistics->attributes();
    $viewCount = $attrs['viewCount']; 
	$subscriberCount = $attrs['subscriberCount']; 
	
// Show Template
if($template != "") {
	if(is_file('templates/'.$template.'/yt_profile.php')) {
		require_once('templates/'.$template.'/yt_profile.php');
	} else {
		die("Your template appears to be corrupt. Try re-uploading the folder.".'/templates/'.$template);
	}
} else {
	die("Your default template doesn't appear to be set.");
}


?>
 <?php 
ob_end_flush();
?>