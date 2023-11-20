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
		
		$url = substr($url,0,-1).'&v=2&alt=jsonc';
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
		
		return $url.'&v=2&alt=jsonc';
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
	  	if(empty($safeSearch)) $safeSearch='strict';
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
		
		$url = substr($url,0,-1).'&v=2&alt=jsonc';
		return $url;  
	}
	
	function getYoutubeRelatedVideos($videoid) {
	    global $Cache;
	    $Cache->SetTtl(86400);
        $cache_file= "rel_".$videoid;  	
		if(!$rstring = $Cache->Load("$cache_file")){
		$startIndex = "1";
		$maxResults = "20";
		
		$url = 'http://gdata.youtube.com/feeds/api/videos/'.$videoid.'/related?v=2';
		
		if(!empty($startIndex))
		  $url .= '&start-index='.$startIndex;
		if(!empty($maxResults))
		   $url .= '&max-results='.$maxResults;
		
		$feedURL =  $url.'&alt=jsonc';
 
   //return $feedURL;
$content = $this->getDataFromUrl($feedURL);
$content = json_decode($content,true);
$videosList = $content['data']['items'];
 //return count($videosList);
 
 for($i=0; $i<count($videosList); $i++) {
				$new_yt = $videosList[$i]['id'];
				$new_title = $videosList[$i]['title'];
				$small_title = substr($new_title, 0, 40);				
				$new_description = substr($new_title, 0, 90);
				$new_seo_url = $site_url.'video/'.$new_yt.'/'.seo_clean_url($new_title) .'/';
	            $new_duration = $videosList[$i]['duration'];
				
				$idlist .= '
	
<div class="re-video-item" id="re-video-'.$new_id.'" title="'.$new_title.'">
<div class="re-video-item">
<div class="re-video-thumb">      
<a class="re-video-thumb-url" href="'.$new_seo_url.'" style="width: 112px; height:84px;"><img src="'.Get_Thumb($new_yt).'" width="112" height="84" alt="" /></a>
<span class="re-video-durationHMS">'.sec2hms($new_duration).'</span>                   
</div>
<div class="re-video-summary">
<div class="re-video-title">
<a href="'.$new_seo_url.'">'.$small_title.'</a>
</div>        
<div class="re-video-details small">               
<div class="re-video-lastupdated">'.$new_description .'</div>
 </div>
 </div>
<div class="clr"></div>
</div>
</div><!---end-->
	';
			}
			
$rstring = $idlist;
$Cache->Save($rstring, "$cache_file");
}

return $rstring;
	}
	
	function getYoutubeVideoDataByVideoId($videoid) {
		
		$url='http://gdata.youtube.com/feeds/api/videos/'.$videoid.'?v=2&alt=jsonc';
		
		
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
		return $videoData;
	}
	
	// http://gdata.youtube.com/feeds/api/standardfeeds/top_favorites
	function returnYoutubeVideosDatasByURL($feedURL,$addDatas=array()) {
		$q = $addDatas['q'];
		$username = $addDatas['username'];
		
		if($feedURL!='') {
			
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
		    
		    return $videosDatas;
		}
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