<? 
function redirect($url)
{
header('HTTP/1.1 301 Moved Permanently');
header('Location: '.$url);
exit();
}
if ($_GET['video_id'] == "") { redirect($site_url); } {
require_once("_inc.php");
require_once("library/video.func.php");

$default_channel = "8";


$video_id = str_replace('_player','',$_GET['video_id']);	

$video_id = str_replace('/','',$_GET['video_id']);
// check if the video exists
$saveq = dbquery("SELECT * FROM videos WHERE youtube_id = '".$video_id."'");
$checkvideo = dbrows($saveq);

        if($checkvideo == 0):
include_once("library/grab.inc.php");
// attempt to check the channel for this video

$savec = dbquery("SELECT cat_id FROM channels WHERE yt_slug = '".$category_slug."' limit 0,1");
$checkc = dbrows($savec);
 if($checkc == 0):
 $acategory = $default_channel;
 else:
 while($row = mysql_fetch_array($savec)){ 
$acategory = $row["cat_id"];

 }
  endif;

//finally save the video
       $thetitle = str_replace("'", "-", $video->title);
	    $insertvideo = dbquery("INSERT INTO videos (`youtube_id`, `title`, `duration`,`description`, `tags` , `category`, `views` ) VALUES ('".addslashes($video_id)."', '".addslashes($thetitle)."', '".addslashes($video->length)."','".addslashes($description)."', '".addslashes($save_tags)."', '".addslashes($acategory)."', '1')");		
		$saverq = dbquery("SELECT * FROM videos WHERE youtube_id = '".$video_id."'");
while($row = mysql_fetch_array($saverq)){ 
$new_video_id = $row["id"];
$new_video_name = $row["title"];
$new_seo_url = $site_url.'video/'.$new_video_id.'/'.seo_clean_url($new_video_name) .'/';
}
Header( "HTTP/1.1 301 Moved Permanently" ); 
Header( "Location: $new_seo_url" ); 
//if the video it's already in the database, just redirect to the local url	
else:
while($row = mysql_fetch_array($saveq)){ 
$new_video_id = $row["id"];
$new_video_name = $row["title"];
$new_seo_url = $site_url.'video/'.$new_video_id.'/'.seo_clean_url($new_video_name) .'/';
}
redirect($new_seo_url); 
endif;
	}

ob_end_flush();

?>

