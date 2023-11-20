<?php  error_reporting(0);
// set_include_path('/home/xxxx/public_html/');
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
$routes['members'] 		= "members/\$list";
$routes['channel'] 		= "channel/\$name";
$routes['playlist'] 		= "playlist/\$id/\$name";
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
		$com_handler = "components/search.php";
		$page = "show";
		break;
		
	case "members":
		$com_handler = "components/members.php";
		$page = "members";
		break;
		
	 case "channel":
		$com_handler = "components/channel.php";
		$page = "channel";
		break;	
	 case "playlist":
		$com_handler = "components/playlist.php";
		$page = "playlist";
		break;		
	default:
		 $com_handler = "components/homepage.php";
		 $page = "home";
		break;	
}

include($com_handler);

//Uncomment only for debugging, shows page load
/*
$Cache->ShowStatistics(TRUE);
*/
MK_MySQL::disconnect();
?>