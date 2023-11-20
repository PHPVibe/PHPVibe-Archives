<?php include_once("./com/youtube_api.php");
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
	$c_id = "js_".$q."_".$startIndex."_". $nb_display; 
	$videosData = $v1->returnYoutubeVideosDatasByURL($url,$c_id);
	
	//display video data
	
	$criteria3['type'] = $display_type;
	$criteria3['pageNumber'] = $pageNumber;
	$criteria3['nb_display'] = $nb_display;
	echo showVideoList($videosData, $criteria3);
}

//videos by username
else if($type==2) {
	//get video data
	$criteria2['username'] = $username;
	$criteria2['start-index'] = $startIndex;
	$criteria2['max-results'] = $nb_display;
	$v1 = new Youtube_class();
	$url = $v1->getYoutubeUsernameVideos($criteria2);
	$c_id = "ju_".$username."_".$startIndex."_". $nb_display; 
	$videosData = $v1->returnYoutubeVideosDatasByURL($url,$c_id);
	
	//display video data
	
	$criteria3['type'] = $display_type;
	$criteria3['pageNumber'] = $pageNumber;
	$criteria3['nb_display'] = $nb_display;
	echo showVideoList($videosData, $criteria3);
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
	$c_id = "jfd_".$feed."_".$time."_".$startIndex."_". $nb_display; 
	$videosData = $v1->returnYoutubeVideosDatasByURL($url,$c_id);
	
	//display video data
	
	$criteria3['type'] = $display_type;
	$criteria3['pageNumber'] = $pageNumber;
	$criteria3['nb_display'] = $nb_display;
	echo showVideoList($videosData, $criteria3);
}

//favorite videos
else if($type==4) {
	//get video data
	$criteria2['username'] = $username;
	$criteria2['start-index'] = $startIndex;
	$criteria2['max-results'] = $nb_display;
	$v1 = new Youtube_class();
	$url = $v1->getYoutubeUserFavoriteVideos($criteria2);
	$c_id = "jfav_". $username."_".$startIndex."_". $nb_display; 
	$videosData = $v1->returnYoutubeVideosDatasByURL($url,$c_id);
	
	//display video data
	
	$criteria3['type'] = $display_type;
	$criteria3['pageNumber'] = $pageNumber;
	$criteria3['nb_display'] = $nb_display;
	echo showVideoList($videosData, $criteria3);
}

else if($type==5) {
	//get video data
	$criteria2['category'] = $category;
	$criteria2['start-index'] = $startIndex;
	$criteria2['max-results'] = $nb_display;
	$v1 = new Youtube_class();
	$url = $v1->getYoutubeVideosByCategory($criteria2);
	$c_id = "jcat_".$category."_".$startIndex."_". $nb_display; 
	$videosData = $v1->returnYoutubeVideosDatasByURL($url);
	
	//display video data
	
	$criteria3['type'] = $display_type;
	$criteria3['pageNumber'] = $pageNumber;
	$criteria3['nb_display'] = $nb_display;
	echo showVideoList($videosData, $criteria3);
}

?>