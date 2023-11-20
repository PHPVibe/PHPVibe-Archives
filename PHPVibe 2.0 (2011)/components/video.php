<?php
require_once("core/youtube/youtube_class.php");
$basic_id = $Info->Get("id");

if (is_numeric($basic_id)) {

$sql = dbquery("SELECT * FROM `videos` WHERE `id` = ".$Info->Get("id")." LIMIT 0, 1");

while($row = mysql_fetch_array($sql)){
	$video_id = $row["youtube_id"];	
    $video_description  = $row["description"];
	$catid = $row["category"];
	$video_views = $row["views"];
	$video_title = $row["title"];
	$video_tags = $row["tags"];
	$video_time = $row["duration"];
	$video_likes = $row["liked"];
	$video_dislikes = $row["disliked"];
}


$v1 	=  new Youtube_class();
$youtube = $v1->getYoutubeVideoDataByVideoId($video_id);
$related = $v1->getYoutubeRelatedVideos($video_id);

}
else {
$video_id  = $Info->Get("id");
$v1 	=  new Youtube_class();
$youtube = $v1->getYoutubeVideoDataByVideoId($video_id);
$related = $v1->getYoutubeRelatedVideos($video_id);


//apply compatibility
$video_id = $Info->Get("id");
$video_title = $youtube['title'];
$video_description = $youtube['description'];
$video_time = $youtube['duration'];
$video_tags = $youtube['tags'];

}
$canonical = $site_url.'video/'.$basic_id.'/'.seo_clean_url($video_title) .'/';
$seo_title = $video_title;
$seo_description = substr($video_description, 0, 160);

include_once("tpl/header.php");
include_once("tpl/video.tpl.php");
include_once("tpl/footer.php");
?>