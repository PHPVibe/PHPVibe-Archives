<?php include_once("security.php");
if(isset($_REQUEST['id'])){ 
$v1 	=  new Youtube_class();
$youtube = $v1->getYoutubeVideoDataByVideoId($_REQUEST['id']);
$id = mysql_real_escape_string(cleanInput($_REQUEST['id']));
$source = 'http://www.youtube.com/watch?v='.$id;
$thumb = 'http://i4.ytimg.com/vi/'.$id.'/0.jpg';
$title = mysql_real_escape_string(cleanInput($youtube['title']));
$duration = mysql_real_escape_string(cleanInput($youtube['duration']));
$desc = mysql_real_escape_string(cleanInput($youtube['description']));
$tags = mysql_real_escape_string(cleanInput($youtube['tags']));
$channel = '';
$usr = $user->getId();
$insertvideo = dbquery("INSERT INTO videos (`source`, `user_id`, `date`, `thumb`, `title`, `duration`, `tags` , `views` , `liked` , `category`, `description`, `nsfw`) VALUES 
('".$source."', '".$usr."', '".$time."', '".$thumb."', '".$title ."', '".$duration."', '".$tags."', '1', '0','".$channel."','".$desc."','".$nsfw."')");	

echo '<div>'.$title.' was saved </div>';

} else {
echo '<div> There was an error saving...invalid id reported by Youtube</div>';
}
?>