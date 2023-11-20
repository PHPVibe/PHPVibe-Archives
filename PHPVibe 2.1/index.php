<?php 
error_reporting(E_ALL);
//Vital file include
include("phpvibe.php");
// Include routing class
include("components/core/urlRooter.php");


// Define components routes
$routes['video'] 		= "video/\$id/\$name";
$routes['user'] 	    = "user/\$id/\$name";
$routes['status'] 		= "status/\$id";
$routes['videos'] 		= "videos/\$list";
$routes['playlist'] 		= "playlist/\$id/\$title";
$routes['show'] 		= "show/\$term";
// Handle routing
$Info = ModRewriter::Route($routes);

// If the page is not found
if(!$Info){
	echo "404 Not found";
	exit();
}

// Define wich page to load
switch($Info->Get(0)){
	case "video":
		$com_handler = "components/video.php";
		$page = "video";
		break;
		
	case "user":
		$com_handler = "components/user.php";
		$page = "user";
		break;
		
	case "status":
		$com_handler = "components/status.php";
		$page = "status";
		break;
		
	case "videos":
		$com_handler = "components/video-list.php";
		$page = "videolist";
		break;	
		
	case "playlist":
		$com_handler = "components/playlist.php";
		$page = "playlist";
		break;
    case "show":
		$com_handler = "components/show.php";
		$page = "show";
		break;
		
	default:
		 $com_handler = "components/homepage.php";
		 $page = "home";
		break;	
}

include($com_handler);
$Cache->SetVerbose(TRUE);
MK_MySQL::disconnect();
?>