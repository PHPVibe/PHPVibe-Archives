<?php  error_reporting(E_ALL); 
//Vital file include
require_once("load.php");

$db->query("INSERT INTO ".DB_PREFIX."images (id,media,token,pub,user_id,date,featured,private,source,title,thumb,description,tags,category,views,liked,disliked,nsfw,privacy)
  SELECT id,media,token,pub,user_id,date,featured,private,source,title,thumb,description,tags,category,views,liked,disliked,nsfw,privacy FROM ".DB_PREFIX."videos where source like '%localimage%'"); 
//$db->query("DELETE from ".DB_PREFIX."videos where media = 3");
echo "Images moved to new table...<br>";

echo "<pre>";
$db->debug();
echo "</pre>";
?>