<?php  error_reporting(0);
//Vital file include
include("phpvibe.php");
$router = uri::getInstance();
	
// Define wich page to load
switch($router->component()){
	case "video":
		$com_handler = "components/video_wrapper.php";
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
		
	case "myplay":
		$com_handler = "components/manage-playlist.php";
		$page = "myplay";
		$reqform = true;
		break;
		
	case "playmanager":
		$com_handler = "components/manage-pvids.php";
		$page = "myplay";
		$reqform = true;
		break;
	
		
	case "submit":
		$com_handler = "components/submit.php";
		$page = "submit";
		$reqform = true;
		break;		
	case "upload":
		$com_handler = "components/uploader.php";
		$page = "upload";		
		break;		
	case "manage":
		$com_handler = "components/manager.php";
		$page = "upload";
		$reqform = true;
		break;	
	case "playlists":
		$com_handler = "components/allplaylists.php";
		$page = "playlists";
		break;	
	
case "wall":
		$com_handler = "components/wall.php";
		$page = "wall";
		break;		
		
	default:
		 $com_handler = "components/homepage.php";
		 $page = "home";
		 $canonical = $site_url;
		break;	
}

include($com_handler);

//Uncomment only for debugging, shows page load
/*
$Cache->ShowStatistics(TRUE);
*/
MK_MySQL::disconnect();
?>