<?php
require_once("core/youtube/youtube_class.php");
$basic_id = $Info->Get("id");
//check if videos is stored in mysql
if (is_numeric($basic_id)) {
//get data from the database
$sql = dbquery("SELECT * FROM `videos` WHERE `id` = ".$Info->Get("id")." LIMIT 0, 1");
while($row = mysql_fetch_array($sql)){
	$video_id = $row["youtube_id"];	
    $video_description  = $row["description"];
	$video_views = $row["views"];
	$video_title = $row["title"];
	$video_tags = $row["tags"];
	$video_time = $row["duration"];
	$video_likes = $row["liked"];
	}

$v1 	=  new Youtube_class();
$youtube = $v1->getYoutubeVideoDataByVideoId($video_id);
$related = $v1->getYoutubeRelatedVideos($video_id);

if (empty($video_description)) :
$video_description = $youtube['description'];
endif;
} else {
// get data directly from Youtube
$video_id  = $Info->Get("id");
$v1 	=  new Youtube_class();
$youtube = $v1->getYoutubeVideoDataByVideoId($video_id);
$related = $v1->getYoutubeRelatedVideos($video_id);

//apply data to template
$video_title = $youtube['title'];
$video_description = $youtube['description'];
$video_time = $youtube['duration'];
$video_tags = $youtube['tags'];

}
// Misc datas
$canonical = $site_url.'video/'.$basic_id.'/'.seo_clean_url($video_title) .'/';
$seo_title = $video_title;
$seo_description = substr($video_description, 0, 160);

// Render templates
include_once("tpl/header.php");
include_once("tpl/video.tpl.php");
include_once("tpl/footer.php");

//Case storage is on: if we have a youtube id we need to check and save the video
if ($config->video->storage == "2" && !is_numeric($basic_id) ) {
$nr_query = ("SELECT COUNT(*) FROM videos WHERE youtube_id = '".$basic_id."'");
$result = mysql_query($nr_query);
$checkvideo = mysql_result($result, 0);
if($checkvideo == "0"):
$insertvideo = dbquery("INSERT INTO videos (`youtube_id`, `title`, `duration`, `tags` , `views` ) VALUES ('".addslashes($video_id)."', '".addslashes($video_title)."', '".addslashes($video_time)."', '".addslashes($video_tags)."', '1')");		
endif;
}
//Update views and set a new count if you choosed to store them
if ($config->video->storage == "2" && is_numeric($basic_id) ) {
$increasevideo = dbquery("UPDATE videos SET views = views+1 WHERE id = '".$basic_id."';");
}
?>