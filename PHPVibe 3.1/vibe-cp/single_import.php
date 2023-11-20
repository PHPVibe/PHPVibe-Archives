<?php include_once("security.php");
if(isset($_REQUEST['id'])){ 
$id = mysql_real_escape_string(cleanInput($_REQUEST['id']));
$source = 'http://www.youtube.com/watch?v='.$id;
$nr_query = ("SELECT COUNT(*) FROM videos WHERE source like '".$source."%'");
$result = mysql_query($nr_query);
$checkvideo = mysql_result($result, 0);
if($checkvideo < 1){
$v1 	=  new Youtube_class();
$youtube = $v1->getYoutubeVideoDataByVideoId($id);

$channel = cleanInput($_REQUEST['channel']);
$thumb = 'http://i4.ytimg.com/vi/'.$id.'/0.jpg';
$title = mysql_real_escape_string(cleanInput($youtube['title']));
$duration = mysql_real_escape_string(cleanInput($youtube['duration']));
$desc = mysql_real_escape_string(cleanInput($youtube['description']));
$tags = mysql_real_escape_string(cleanInput($youtube['tags']));
$usr = $user->getId();
$time = date(DATE_RFC822);
$imageLibObj = new imageLib($thumb);
$imageLibObj->resizeImage($config->site->wpics, $config->site->hpics);    
$new_image = seo_clean_url($youtube['title'].$time).".png";
$thumb_path = dirname(dirname(__FILE__));
$imageLibObj -> saveImage($thumb_path.'/'.$config->site->mediafolder.'/'.$config->site->thumbsfolder.'/'.$new_image, 100);
$thumb = $site_url.$config->site->mediafolder.'/'.$config->site->thumbsfolder.'/'.$new_image;
$insertvideo = dbquery("INSERT INTO videos (`source`, `user_id`, `date`, `thumb`, `title`, `duration`, `tags` , `views` , `liked` , `category`, `description`, `nsfw`) VALUES 
('".$source."', '".$usr."', '".$time."', '".$thumb."', '".$title ."', '".$duration."', '".$tags."', '1', '0','".$channel."','".$desc."','".$nsfw."')");	

echo '<div>'.$title.' was saved </div>';
} else {
echo "<div>Skiped! Already in database</div>";
}
} else {
echo '<div> There was an error saving...invalid id reported by Youtube</div>';
}
?>