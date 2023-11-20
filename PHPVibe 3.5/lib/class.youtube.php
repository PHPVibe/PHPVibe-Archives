<?php class Youtube_class {
	
	// feedId: top_rated, top_favorites, most_popular, most_popular, most_recent, most_discussed, most_linked, most_responded, recently_featured, watch_on_mobile
	// time: today, this_week, this_month, all_time (all_time is the default parameter if no time selected)
	function getYoutubeStandardVideosFeeds($criteria) {
		$feed = $criteria['feed'];
		$time = $criteria['time'];
		$startIndex = $criteria['start-index'];
		$maxResults = $criteria['max-results'];
		$format = $criteria['format'];
		
		if($feed=='most_recent') $time='';
		
	  	// Default values
	  	if(empty($feed)) $feed='most_popular';
	  	if(empty($format)) $format=5; //5=only videos that can be embedded
	  	
	  	if(isset($criteria['category']) && $criteria['category']!='') $feed .= '_'.$criteria['category'];
	  	
		$url = 'http://gdata.youtube.com/feeds/api/standardfeeds/'.$feed.'?';
		
		if(!empty($time))
			$url .= 'time='.$time.'&';
	  	if(!empty($startIndex))
		  	$url .= 'start-index='.$startIndex.'&';
	  	if(!empty($maxResults))
		  	$url .= 'max-results='.$maxResults.'&';
		if(!empty($format))
		   $url .= 'format='.$format.'&';
		
		if(!get_option('youtubekey')) {
		$url = substr($url,0,-1).'&v=2&alt=jsonc';		
	 } else {
	 	$url = substr($url,0,-1).'&v=2&alt=jsonc&key='.get_option('youtubekey');		
	 }
	 
	 
		return $url;
	}
	
	function getYoutubeVideosByCategory($criteria) {
		$category = $criteria['category'];
		$startIndex = $criteria['start-index'];
		$maxResults = $criteria['max-results'];
		
		$url = 'http://gdata.youtube.com/feeds/api/videos/-/'.$category.'?v=2';
		
		if(!empty($startIndex))
		  $url .= '&start-index='.$startIndex;
		if(!empty($maxResults))
		   $url .= '&max-results='.$maxResults;
		
		return $url.'&alt=jsonc';
	}
	
	function getYoutubeUserFavoriteVideos($criteria) {
		$username = $criteria['username'];
		$startIndex = $criteria['start-index'];
		$maxResults = $criteria['max-results'];
		
		$url = 'http://gdata.youtube.com/feeds/api/users/'.$username.'/favorites?v=2';
		
		if(!empty($startIndex))
		  $url .= '&start-index='.$startIndex;
		if(!empty($maxResults))
		   $url .= '&max-results='.$maxResults;
		if(!empty($criteria['orderby']))
		  $url .= '&orderby='.$criteria['orderby'];   
		
		return $url.'&alt=jsonc';
	}
	
	function getYoutubeUsernameVideos($criteria) {
		$username = $criteria['username'];
		$startIndex = $criteria['start-index'];
		$maxResults = $criteria['max-results'];
		
		$url = 'http://gdata.youtube.com/feeds/api/users/'.$username.'/uploads?';
		
		if(!empty($startIndex))
		  $url .= 'start-index='.$startIndex;
		if(!empty($maxResults))
		   $url .= '&max-results='.$maxResults;
		
		if(!get_option('youtubekey')) {
		$url = $url.'&v=2&alt=jsonc';		
	 } else {
	 	$url = $url.'&v=2&alt=jsonc&key='.get_option('youtubekey');		
	 }
		
		return $url;
	}
	
	// get custom feeds depending on several parameters http://gdata.youtube.com/feeds/api/videos?
	function getYoutubeSearchVideosFeeds($criteria) {
		$url = 'http://gdata.youtube.com/feeds/api/videos?';
		$q = urlencode($criteria['q']);
		$orderby = $criteria['orderby']; // relevance, published, viewCount, rating
		$startIndex = $criteria['start-index'];
		$maxResults = $criteria['max-results'];
		$format = $criteria['format'];
	  	$lr = $criteria['lr']; // fr, en
	  	$safeSearch = $criteria['safeSearch']; //none, moderate, strict
	  	
	  	// Default values
	  	if(empty($format)) $format=5; //5=only videos that can be embedded
	  	if(empty($orderby)) $orderby='relevance';
	  	if(empty($safeSearch)) $safeSearch='none';
	  	if(empty($lr)) $lr='en';  	
	  	if(!empty($q))
		  $url .= 'q='.$q.'&';
		if(!empty($orderby))
		  $url .= 'orderby='.$orderby.'&';
		if(!empty($startIndex))
		  $url .= 'start-index='.$startIndex.'&';
		if(!empty($maxResults))
		   $url .= 'max-results='.$maxResults.'&';
		if(!empty($criteria['author']))
		   $url .= 'author='.$criteria['author'].'&';
		if(!empty($format))
		   $url .= 'format='.$format.'&';
		if(!empty($lr))
		   $url .= 'lr='.$lr.'&';
		if(!empty($safeSearch))
		   $url .= 'safeSearch='.$safeSearch.'&';
		
		//$url = substr($url,0,-1).'&v=2&alt=jsonc';
		
		if(!get_option('youtubekey')) {
		$url = substr($url,0,-1).'&v=2&alt=jsonc';		
	 } else {
	 	$url = substr($url,0,-1).'&v=2&alt=jsonc&key='.get_option('youtubekey');		
	 }
		return $url;  
	}
	
	function getYoutubeRelatedVideos($videoid) {
	   
		$startIndex = "1";
		$maxResults = "20";
		
		$url = 'http://gdata.youtube.com/feeds/api/videos/'.$videoid.'/related?v=2';
		
		if(!empty($startIndex))
		  $url .= '&start-index='.$startIndex;
		if(!empty($maxResults))
		   $url .= '&max-results='.$maxResults;
		
		if(!get_option('youtubekey')) {
		$feedURL = $url.'&v=2&alt=jsonc';		
	 } else {
	 	$feedURL = $url.'&v=2&alt=jsonc&key='.get_option('youtubekey');		
	 }
		  
 
   //return $feedURL;
$content = $this->getDataFromUrl($feedURL);
$content = json_decode($content,true);
$videosList = $content['data']['items'];

return $videosList;
	}
	

	
	function getYoutubeVideoDataByVideoId($videoid) {
	
	 
	 if(!get_option('youtubekey')) {
		$url='http://gdata.youtube.com/feeds/api/videos/'.$videoid.'?v=2&alt=jsonc';	
	 } else {
	 $url='http://gdata.youtube.com/feeds/api/videos/'.$videoid.'?v=2&alt=jsonc&key='.get_option('youtubekey');
	 		
	 }
			
		
		$content = $this->getDataFromUrl($url);
		$content = json_decode($content,true);
		
		
		// returned values
		$videoData['videoid'] = $content['data']['id'];
		$videoData['url'] = $content['data']['player']['default'];
		$videoData['title'] = htmlentities($content['data']['title'], ENT_QUOTES, "UTF-8");
		$videoData['description'] = htmlentities($content['data']['description'], ENT_QUOTES, "UTF-8");
		$videoData['author'] = $content['data']['uploader'];
		$videoData['thumbnail'] = $content['data']['thumbnail']['sqDefault'];
		$videoData['duration'] = $content['data']['duration'];
		$videoData['viewCount'] = $content['data']['viewCount'];
		$videoData['rating'] = $content['data']['rating'];	  
		$taglist = $content['data']['tags'];
		$count = count($taglist);
		for ($i = 0; $i < $count; $i++) {
		$videoData['tags'] .= $taglist[$i].', ';
		}
		
			
	
		return $videoData;
	}
	

	function returnYoutubeVideosDatasByURL($feedURL, $cacheid = NULL, $addDatas=array()) {
$content = $this->getDataFromUrl($feedURL);
			$content = json_decode($content,true);
			$videosDatas = array();
			
			if(isset($content['data']['items'])) {
			$videosList = $content['data']['items'];
			
			for($i=0; $i<count($videosList); $i++) {
				$videosDatas['videos'][$i]['videoid'] = $videosList[$i]['id'];
				$videosDatas['videos'][$i]['url'] = $videosList[$i]['player']['default'];
				$videosDatas['videos'][$i]['title'] = toDB($videosList[$i]['title']);
				$videosDatas['videos'][$i]['description'] = toDb($videosList[$i]['description']);
				$videosDatas['videos'][$i]['author'] = $videosList[$i]['uploader'];
				$videosDatas['videos'][$i]['thumbnail'] = $videosList[$i]['thumbnail']['sqDefault'];
				$videosDatas['videos'][$i]['duration'] = $videosList[$i]['duration'];
				$videosDatas['videos'][$i]['viewCount'] = isset($videosDatas['videos'][$i]['viewCount']) ? $videosList[$i]['viewCount'] : 0;
				//$videosDatas['videos'][$i]['rating'] = $videosList[$i]['rating'];
			}
			
		    $videosDatas['stats']['totalResults'] = $content['data']['totalItems'];
		    $videosDatas['stats']['startIndex'] = $content['data']['startIndex'];
		    $videosDatas['stats']['itemsPerPage'] = $content['data']['itemsPerPage'];
		    $videosDatas['stats']['q'] = isset($addDatas['q']) ? $addDatas['q'] : null; // searched query
		    $videosDatas['stats']['username'] = isset($addDatas['username']) ? $addDatas['username'] : null; // username searched
		    } 
		   
		 return $videosDatas;
	}
	
	function getDataFromUrl($url) {
		$ch = curl_init();
		$timeout = 15;
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
}
/** Extra helpers */

function has_youtube_duplicate($y_id){
global $db;
$y_id = 'youtube.com/watch?v='.$y_id;
$sub = $db->get_row("Select count(*) as nr from ".DB_PREFIX."videos where source  like '%".$y_id."'");
return (bool)$sub->nr;
}
function youtube_import($video=array(), $cat = null, $owner = null) {
global $db;
if(is_null($owner)) {$owner = get_option('importuser','1');}
if(isset($video["videoid"]) && isset($video["title"]) ) {
$video["path"] = 'http://www.youtube.com/watch?v='.$video["videoid"];
$video["thumbnail"] = str_replace('default.jpg','0.jpg', $video["thumbnail"]);
$db->query("INSERT INTO ".DB_PREFIX."videos (`pub`,`source`, `user_id`, `date`, `thumb`, `title`, `duration`, `tags` , `views` , `liked` , `category`, `description`, `nsfw`) VALUES 
('".intval(get_option('videos-initial'))."','".$video["path"]."', '".$owner."', now() , '".$video["thumbnail"]."', '".toDb($video["title"]) ."', '".intval($video["duration"])."', '".toDb(_post('tags'))."', '0', '0','".toDb($cat)."','".toDb($video["description"])."','0')");	
//var_dump($video);
} else {
echo '<p><span class="redText">Missing video id or title </span></p>';
}
}
?>