<?php
require_once("com/youtube_api.php");
$basic_id = $Info->Get("id");

//check if videos is stored in mysql
if (is_numeric($basic_id)) {
//get data from the database or cache file
   $Cache->SetTtl(600000);
   $cache_file= "video_".$basic_id;  	
   if(!$sql_array = $Cache->Load("$cache_file")){
$sql = dbquery("SELECT * FROM `videos` WHERE `id` = ".$Info->Get("id")." LIMIT 0, 1");
$sql_array = dbarray($sql);
if(!empty($sql)):
$Cache->Save($sql_array, "$cache_file");
endif;
}

	$video_id = $sql_array["youtube_id"];	
    $video_description  = $sql_array["description"];
	$video_views = $sql_array["views"];
	$video_title = $sql_array["title"];
	$video_tags = $sql_array["tags"];
	$video_time = $sql_array["duration"];
	$video_likes = $sql_array["liked"];
	$category = $sql_array["category"];
	$featured = $sql_array["featured"];

	
if(isset($category) && !empty($category)):
$csql = dbquery("SELECT cat_name, yt_slug FROM `channels` WHERE `cat_id` = '".$category."' LIMIT 0,1");
while($row = dbarray($csql)){
$chan_url = $site_url.'channel/'.$row["yt_slug"].'/';
$channel =  '<a href="'.$chan_url.'"><span style="color:#259ae0;">'.$row["cat_name"].'</span></a>';
}
endif;	
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
// Misc SEO datas
$canonical = $site_url.'video/'.$basic_id.'/'.seo_clean_url($video_title) .'/';
$seo_title = $video_title .$lang['video-aft-title'];
$seo_description = substr($video_description, 0, 160);

// Render templates

include_once("tpl/header.php");
include_once("tpl/video.tpl.php");
include_once("tpl/footer.php");


//Case storage is on: if we have a youtube id we need to check and save the video
if ($config->video->storage == "2" && !is_numeric($basic_id) && !empty($video_title) ) {
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
//Update views and set a new count if you choosed to store them and the user watches via Youtube data
if ($config->video->storage == "2" && !is_numeric($basic_id) ) {
$increasevideo = dbquery("UPDATE videos SET views = views+1 WHERE youtube_id = '".$basic_id."';");
}
?>