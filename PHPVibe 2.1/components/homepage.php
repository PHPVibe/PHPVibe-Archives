<?php
include_once("tpl/header.php");
$Cache->SetTtl(3600);
 if(!$Cache->Start("homepage")){ 
include_once("embed/AutoEmbed.class.php");
$AE = new AutoEmbed();
$slideql = dbquery("SELECT * FROM `slider` order by id desc LIMIT 0, 6");
while($row = mysql_fetch_array($slideql)){
	$youtube_link .= "http://www.youtube.com/watch?v=".$row["yt_id"].", ";
	$youtube_image .= "http://i4.ytimg.com/vi/".$row["yt_id"]."/default.jpg, "; 
}
include_once("tpl/homepage.tpl.php");
} 
echo $Cache->Stop();
include_once("tpl/footer.php");

?>