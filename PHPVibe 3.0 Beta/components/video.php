<?php $basic_id = $router->fragment(1);
$width = "728";
$height = "366";
$vid = new phpVibe($width, $height);
if(MK_Request::getPost('playlist_id')){ 
$add_it = ','.MK_Request::getPost('video');
$p_id = MK_Request::getPost('playlist_id');
$insertvideo = dbquery("update playlists set videos=concat(videos,'".$add_it."') where owner = '".$user->getId()."' and id='".$p_id."'"); 

}
//check if video is is numeric
if (is_numeric($basic_id)) {
//get video data from the database
$sql = dbquery("SELECT videos.*, channels.cat_name,channels.yt_slug, users.display_name, users.avatar FROM `videos` 
LEFT JOIN channels ON videos.category =channels.cat_id
LEFT JOIN users ON videos.user_id = users.id
WHERE videos.`id` = '".$basic_id."' limit 0,1");
$row = dbarray($sql);

//assign custom variables
	$video_source = $row["source"];	
	$video_thumb = $row["thumb"];	
    $video_description  = stripslashes($row["description"]);
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
	
//if used complex related
if ($config->video->storage == "2") {	

$VidCache->SetTtl(600000);
$cache_file= "re_".$basic_id;  	
if(!$idlist = $VidCache->Load("$cache_file")){
$related_query =  strip_common($video_title);
$ord_1 = count($related_query) *2 + 1;
$ord_2 = count($related_query) + 1;
$i_num = 1;
foreach($related_query as $word) {
if($i_num > 1) {
$related_sql .= "UNION";
}
$related_sql .= "
SELECT title,id,views,thumb,duration, ".$ord_1." AS relevance FROM videos WHERE title like '%".addslashes($word)."%' UNION
SELECT title,id,views,thumb,duration, ".$ord_2." AS relevance FROM videos WHERE tags like '%".addslashes($word)."%'
";
$i_num++;
$ord_1--;
$ord_2--;
}

$the_relq = "SELECT title,id,views,thumb,duration, sum(relevance) FROM (".$related_sql.") results GROUP BY title, id ORDER BY relevance desc LIMIT 0,16";
$query_it = dbquery($the_relq);
while($related = mysql_fetch_array($query_it)){
$new_seo_url = $site_url.'video/'.$related['id'].'/'.seo_clean_url($related['title']) .'/';
$idlist .= '
		<div class="this_video clearfix">
			<div class="this_thumb"><a href="'.$new_seo_url.'"><img src="'.$related['thumb'].'" alt="'.stripslashes($related['title']).'" style="width: 120px; height:65px; border: 0;" /></a><span>'.sec2hms($related['duration']).'</span></div>
			<a href="'.$new_seo_url.'" class="video-title">'.stripslashes($related['title']).'</a>
			<p class="video_views">'.$related['views'].' <span>views</span></p>
			
		</div>
	';
}
if(!empty($idlist)):
$VidCache->Save($idlist, "$cache_file");
endif;
}
}else{
//if used simple related
$the_relq = "SELECT title,id,views,thumb,duration FROM videos where category ='".$channel_id."' and id != '".$basic_id."' ORDER BY views desc LIMIT 0,16";
$query_it = dbquery($the_relq);
while($related = mysql_fetch_array($query_it)){
$new_seo_url = $site_url.'video/'.$related['id'].'/'.seo_clean_url($related['title']) .'/';
$idlist .= '
		<div class="this_video clearfix">
			<div class="this_thumb"><a href="'.$new_seo_url.'"><img src="'.$related['thumb'].'" alt="'.stripslashes($related['title']).'" style="width: 120px; height:65px; border: 0;" /></a><span>'.sec2hms($related['duration']).'</span></div>
			<a href="'.$new_seo_url.'" class="video-title">'.stripslashes($related['title']).'</a>
			<p class="video_views">'.$related['views'].' <span>views</span></p>
			
		</div>
	';
}

}
// Misc SEO datas
$canonical = $site_url.'video/'.$basic_id.'/'.seo_clean_url($video_title) .'/';
$seo_title = $video_title .$lang['video-aft-title'];
$seo_description = strip_tags(substr($video_description, 0, 160));

// Render templates

include_once("tpl/header.php");
include_once("tpl/video.tpl.php");
include_once("tpl/footer.php");


//Update views and count this view

$increasevideo = dbquery("UPDATE videos SET views = views+1 WHERE id = '".$basic_id."';");
} else {
//Wrong id, redirect
echo 'Wrong video link.';
echo '<script type="text/javascript"> 
window.location = "'.$site_url.'"
</script>';
}
?>