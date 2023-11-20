<?php $basic_id = cleanInput($router->fragment(1));
$width = 728;
$height = 366;
$vid = new phpVibe($width, $height);
function render_video($code) {
global $width,$height;
 //just in case this failed on submit
		$embed = preg_replace('/width="([0-9]+)"/i', 'width="##videoW##"', $code);
		$embed = preg_replace('/height="([0-9]+)"/i', 'height="##videoH##"', $embed);
		$embed = preg_replace('/value="(window|opaque|transparent)"/i', 'value="transparent"', $embed);
		$embed = preg_replace('/wmode="(.*?)"/i', 'wmode="transparent"', $embed);
		$embed = preg_replace('/width=([0-9]+)/i', 'width=##videoW##', $embed);
		$embed = preg_replace('/height=([0-9]+)/i', 'height=##videoH##', $embed);
		//add new size
		$postembed = str_replace("##videoW##",$width,$embed);
        $postembed = str_replace("##videoH##",$height,$postembed);
		
return $postembed;
}

//get video data from the database
$sql = "SELECT videos.*, channels.cat_name,channels.yt_slug, users.display_name, users.avatar FROM `videos` 
LEFT JOIN channels ON videos.category =channels.cat_id
LEFT JOIN users ON videos.user_id = users.id
WHERE videos.`id` = '".$basic_id."' limit 0,1";


if( $config->cache->video ) { $qt =$config->cache->time; } else { $qt = 0; }
if ($row = $dbi->singlequery($sql, $qt, $basic_id)) { 
//assign custom variables
	$video_source = $row["source"];	
	$vurl = parse_url($row["thumb"]);
    if($vurl['scheme'] !== 'http'){ $row["thumb"] = $config->site->url.$row["thumb"]; }
	$video_thumb = $row["thumb"];	
    $video_description  = twitterify(stripslashes($row["description"]));
	$video_date = $row["date"];
	$video_views = $row["views"];
	$video_title = stripslashes($row["title"]);
	$video_tags = $row["tags"];
	$video_time = sec2hms($row["duration"]);
	$video_likes = $row["liked"];
	$video_dislikes = $row["disliked"];	
	$nsfw = $row["nsfw"];	
	$featured = $row["featured"];
	$sharer_id = $row["user_id"];
	$sharer = $row["display_name"];
	$sharer_pic = $row["avatar"];
	$channel = $row["cat_name"];
	$channel_id = $row["category"];
	$channel_slug = $row["yt_slug"];
	$sharer_link = $site_url."user/".$sharer_id."/".seo_clean_url($sharer)."/";
	$channel_url = $site_url."channel/".$channel_slug."/";
	$embed = stripslashes($row["embed"]);
	$embedvideo				=  !empty($embed) ? render_video($embed) : $vid->getEmbedCode($video_source);


//start related
$the_relq = "SELECT videos.title,videos.id,videos.views,videos.thumb,videos.duration,users.display_name FROM videos LEFT JOIN users ON videos.user_id = users.id where videos.category ='".$channel_id."' and videos.id != '".$basic_id."' ORDER BY rand() LIMIT 0,26";


//end related

// Misc SEO datas
$canonical = $site_url.'video/'.$basic_id.'/'.seo_clean_url($video_title) .'/';
$postvid = str_replace("##user##",$sharer,$config->seo->postvideo);
$postvid = str_replace("##site_name##",$config->site->name,$postvid);
$seo_title = $config->seo->prevideo.$video_title.$postvid;
$seo_description = strip_tags(substr($video_description, 0, 160));
$dbi->disconnect();

} else {
die("Video not found");
}
// Render templates
include_once("tpl/header.php");
include_once("tpl/video.tpl.php");
include_once("tpl/footer.php");
?>