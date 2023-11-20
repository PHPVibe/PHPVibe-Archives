<?php require_once('settings.php'); 
//load Youtube API class
require_once('youtube_api.php'); 
// Define cache and set expiery time (in seconds)
require_once("cache.php");
$Cache = new CacheSys("cache/", 43200);
$Cache->SetTtl(43200);


// Define wich template page to load
switch($_GET["sk"]){
case "videos":
		$com_handler = "tpl/videos.php";
		$page = "videos";
		break;
case "video":
		$com_handler = "tpl/video.php";
		$page = "video";
		break;	
case "channel":
		$com_handler = "tpl/channel.php";
		$page = "channel";
		break;			
default:
		 $com_handler = "tpl/homepage.php";
		 $page = "home";
		break;	
}

require_once($com_handler);


?>