<?php
// functions
include_once("youtube_class.php");
include_once("youtube_data.php");
include_once("vbox_general_functions_class.php");
include_once("vbox_display_class.php");
include_once("vbox_class.php");


if($pageNumber=='') $pageNumber = 1; //default
if($nb_display=='') $nb_display=10; //default
$startIndex = $nb_display*$pageNumber-$nb_display+1;

if($display_type=='') $display_type=1;

//search videos
if($type==1) {
	
	//get video data
	$criteria2['q'] = $q;
	$criteria2['start-index'] = $startIndex;
	$criteria2['max-results'] = $nb_display;
	$v1 = new Youtube_class();
	$url = $v1->getYoutubeSearchVideosFeeds($criteria2);
	$videosData = $v1->returnYoutubeVideosDatasByURL($url);
	
	//display video data
	$vb2 = new Vbox_display_class;
	$criteria3['type'] = $display_type;
	$criteria3['pageNumber'] = $pageNumber;
	$criteria3['nb_display'] = $nb_display;
	echo $vb2->displayVideosList($videosData, $criteria3);
}

//videos by username
else if($type==2) {
	//get video data
	$criteria2['username'] = $username;
	$criteria2['start-index'] = $startIndex;
	$criteria2['max-results'] = $nb_display;
	$v1 = new Youtube_class();
	$url = $v1->getYoutubeUsernameVideos($criteria2);
	$videosData = $v1->returnYoutubeVideosDatasByURL($url);
	
	//display video data
	$vb2 = new Vbox_display_class;
	$criteria3['type'] = $display_type;
	$criteria3['pageNumber'] = $pageNumber;
	$criteria3['nb_display'] = $nb_display;
	echo $vb2->displayVideosList($videosData, $criteria3);
}

//featured videos
else if($type==3) {
	//get video data
	$criteria2['feed'] = $feed;
	$criteria2['time'] = $time;
	$criteria2['start-index'] = $startIndex;
	$criteria2['max-results'] = $nb_display;
	$v1 = new Youtube_class();
	$url = $v1->getYoutubeStandardVideosFeeds($criteria2);
	$videosData = $v1->returnYoutubeVideosDatasByURL($url);
	
	//display video data
	$vb2 = new Vbox_display_class;
	$criteria3['type'] = $display_type;
	$criteria3['pageNumber'] = $pageNumber;
	$criteria3['nb_display'] = $nb_display;
	echo $vb2->displayVideosList($videosData, $criteria3);
}

//favorite videos
else if($type==4) {
	//get video data
	$criteria2['username'] = $username;
	$criteria2['start-index'] = $startIndex;
	$criteria2['max-results'] = $nb_display;
	$v1 = new Youtube_class();
	$url = $v1->getYoutubeUserFavoriteVideos($criteria2);
	$videosData = $v1->returnYoutubeVideosDatasByURL($url);
	
	//display video data
	$vb2 = new Vbox_display_class;
	$criteria3['type'] = $display_type;
	$criteria3['pageNumber'] = $pageNumber;
	$criteria3['nb_display'] = $nb_display;
	echo $vb2->displayVideosList($videosData, $criteria3);
}

else if($type==5) {
	//get video data
	$criteria2['category'] = $category;
	$criteria2['start-index'] = $startIndex;
	$criteria2['max-results'] = $nb_display;
	$v1 = new Youtube_class();
	$url = $v1->getYoutubeVideosByCategory($criteria2);
	$videosData = $v1->returnYoutubeVideosDatasByURL($url);
	
	//display video data
	$vb2 = new Vbox_display_class;
	$criteria3['type'] = $display_type;
	$criteria3['pageNumber'] = $pageNumber;
	$criteria3['nb_display'] = $nb_display;
	echo $vb2->displayVideosList($videosData, $criteria3);
}

?>