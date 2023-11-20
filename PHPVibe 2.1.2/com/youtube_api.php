<?php

class Youtube_class {
	
	// feedId: top_rated, top_favorites, most_viewed, most_popular, most_recent, most_discussed, most_linked, most_responded, recently_featured, watch_on_mobile
	// time: today, this_week, this_month, all_time (all_time is the default parameter if no time selected)
	function getYoutubeStandardVideosFeeds($criteria) {
		$feed = $criteria['feed'];
		$time = $criteria['time'];
		$category = $criteria['category'];
		$startIndex = $criteria['start-index'];
		$maxResults = $criteria['max-results'];
		$format = $criteria['format'];
		
		if($feed=='most_recent') $time='';
		
	  	// Default values
	  	if(empty($feed)) $feed='most_popular';
	  	if(empty($format)) $format=5; //5=only videos that can be embedded
	  	
	  	if($category!='') $feed .= '_'.$category;
	  	
		$url = 'http://gdata.youtube.com/feeds/api/standardfeeds/'.$feed.'?';
		
		if(!empty($time))
			$url .= 'time='.$time.'&';
	  	if(!empty($startIndex))
		  	$url .= 'start-index='.$startIndex.'&';
	  	if(!empty($maxResults))
		  	$url .= 'max-results='.$maxResults.'&';
		if(!empty($format))
		   $url .= 'format='.$format.'&';
		
		if(!$config->video->devkey) {
		$url = substr($url,0,-1).'&v=2&alt=jsonc';		
	 } else {
	 	$url = substr($url,0,-1).'&v=2&alt=jsonc&key='.$config->video->devkey;		
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
		
		if(!$config->video->devkey) {
		$url = $url.'&v=2&alt=jsonc';		
	 } else {
	 	$url = $url.'&v=2&alt=jsonc&key='.$config->video->devkey;		
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
		$author = $criteria['author'];
	  	$format = $criteria['format'];
	  	$lr = $criteria['lr']; // fr, en
	  	$safeSearch = $criteria['safeSearch']; //none, moderate, strict
	  	
	  	// Default values
	  	if(empty($format)) $format=5; //5=only videos that can be embedded
	  	if(empty($orderby)) $orderby='relevance';
	  	if(empty($safeSearch)) $safeSearch='none';
	  	//if(empty($lr)) $lr='en';
	  	
	  	if(!empty($q))
		  $url .= 'q='.$q.'&';
		if(!empty($orderby))
		  $url .= 'orderby='.$orderby.'&';
		if(!empty($startIndex))
		  $url .= 'start-index='.$startIndex.'&';
		if(!empty($maxResults))
		   $url .= 'max-results='.$maxResults.'&';
		if(!empty($author))
		   $url .= 'author='.$author.'&';
		if(!empty($format))
		   $url .= 'format='.$format.'&';
		if(!empty($lr))
		   $url .= 'lr='.$lr.'&';
		if(!empty($safeSearch))
		   $url .= 'safeSearch='.$safeSearch.'&';
		
		//$url = substr($url,0,-1).'&v=2&alt=jsonc';
		
		if(!$config->video->devkey) {
		$url = substr($url,0,-1).'&v=2&alt=jsonc';		
	 } else {
	 	$url = substr($url,0,-1).'&v=2&alt=jsonc&key='.$config->video->devkey;		
	 }
		return $url;  
	}
	
	function getYoutubeRelatedVideos($videoid) {
	    global $VidCache;
	    $VidCache->SetTtl(600000);
        $cache_file= "rel_".$videoid;  	
		if(!$videosList = $VidCache->Load("$cache_file")){
		$startIndex = "1";
		$maxResults = "20";
		
		$url = 'http://gdata.youtube.com/feeds/api/videos/'.$videoid.'/related?v=2';
		
		if(!empty($startIndex))
		  $url .= '&start-index='.$startIndex;
		if(!empty($maxResults))
		   $url .= '&max-results='.$maxResults;
		
		if(!$config->video->devkey) {
		$feedURL = $url.'&v=2&alt=jsonc';		
	 } else {
	 	$feedURL = $url.'&v=2&alt=jsonc&key='.$config->video->devkey;		
	 }
		  
 
   //return $feedURL;
$content = $this->getDataFromUrl($feedURL);
$content = json_decode($content,true);
$videosList = $content['data']['items'];
if(!empty($videosList)):
$VidCache->Save($videosList, "$cache_file");
endif;
}
return $videosList;
	}
	

	
	function getYoutubeVideoDataByVideoId($videoid) {
	global $VidCache;
	$VidCache->SetTtl(600000);	
	
	 $cache_file= "data_".$videoid;  
	 
	 if(!$config->video->devkey) {
		$url='http://gdata.youtube.com/feeds/api/videos/'.$videoid.'?v=2&alt=jsonc';	
	 } else {
	 $url='http://gdata.youtube.com/feeds/api/videos/'.$videoid.'?v=2&alt=jsonc&key='.$config->video->devkey;
	 		
	 }
	if(!$videoData = $VidCache->Load("$cache_file")){	
		
		
		
		$content = $this->getDataFromUrl($url);
		$content = json_decode($content,true);
		
		
		// returned values
		$videoData['videoid'] = $content['data']['id'];
		$videoData['url'] = $content['data']['player']['default'];
		$videoData['title'] = $content['data']['title'];
		$videoData['description'] = $content['data']['description'];
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
		
			
		if(!empty($videoData)):
$VidCache->Save($videoData, "$cache_file");
endif;
	}	
		return $videoData;
	}
	

	function returnYoutubeVideosDatasByURL($feedURL, $cacheid = NULL, $addDatas=array()) {
	global $FeedCache;
	
		$q = $addDatas['q'];
		$username = $addDatas['username'];		
		//echo $cacheid;
		
		if(!is_null($cacheid)) {
		 $cache_file = $cacheid;
		} else {
      parse_str( parse_url( $feedURL, PHP_URL_QUERY ), $my_vars );
      $c_ind = $my_vars['start-index']; 
      $q_ind = $my_vars['q'];  
      $r_ind = $my_vars['max-results']; 
	   $r_usr = $my_vars['username'];
	  
		$FeedCache->SetTtl(86400);	
		
		if(!empty( $q_ind)):
        $cache_file= "js_".$q_ind."_".$c_ind."_". $r_ind;  
		elseif (!empty($username)) :
		$cache_file= "ju_".$username."_".$c_ind."_". $r_ind;  
		else:
		$cache_file=$feedURL;
		endif;
		
		}
		
		
		if(!$videosDatas = $FeedCache->Load("$cache_file")){
		
		
			
			$content = $this->getDataFromUrl($feedURL);
			$content = json_decode($content,true);
			
			$videosList = $content['data']['items'];
			
			for($i=0; $i<count($videosList); $i++) {
				$videosDatas['videos'][$i]['videoid'] = $videosList[$i]['id'];
				$videosDatas['videos'][$i]['url'] = $videosList[$i]['player']['default'];
				$videosDatas['videos'][$i]['title'] = $videosList[$i]['title'];
				$videosDatas['videos'][$i]['description'] = $videosList[$i]['description'];
				$videosDatas['videos'][$i]['author'] = $videosList[$i]['uploader'];
				$videosDatas['videos'][$i]['thumbnail'] = $videosList[$i]['thumbnail']['sqDefault'];
				$videosDatas['videos'][$i]['duration'] = $videosList[$i]['duration'];
				$videosDatas['videos'][$i]['viewCount'] = $videosList[$i]['viewCount'];
				$videosDatas['videos'][$i]['rating'] = $videosList[$i]['rating'];
			}
			
		    $videosDatas['stats']['totalResults'] = $content['data']['totalItems'];
		    $videosDatas['stats']['startIndex'] = $content['data']['startIndex'];
		    $videosDatas['stats']['itemsPerPage'] = $content['data']['itemsPerPage'];
		    $videosDatas['stats']['q'] = $q; // searched query
		    $videosDatas['stats']['username'] = $username; // username searched
		    
		   
		
if(count($videosDatas) > 1):
$FeedCache->Save($videosDatas, "$cache_file");
endif;

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

?>