<?php
function listByTag ($tag, $start, $max) {
	$feedURL = 'http://gdata.youtube.com/feeds/api/videos?vq='.$tag.'&format=5&start-index='.$start.'&max-results='.$max;
	//echo $feedURL;
	$xml = simplexml_load_file($feedURL);
	$video_array = array();
	
	$counts = $xml->children('http://a9.com/-/spec/opensearchrss/1.0/');
    $video_array['total'] = (int) $counts->totalResults; 
    $video_array['startOffset'] = (int) $counts->startIndex; 
    $video_array['endOffset'] = (int) ($video_array['startOffset']-1) + $counts->itemsPerPage;
	
	$i = 0;
	$search_result = array();
	 foreach ($xml->entry as $entry) {
        // get nodes in media: namespace for media information
        $media = $entry->children('http://search.yahoo.com/mrss/');
        
        // get video player URL
        $attrs = $media->group->player->attributes();
        $search_result[$i]['watch'] = $attrs['url']; 
        
        // get video thumbnail
        $attrs = $media->group->thumbnail[0]->attributes();
        $search_result[$i]['thumbnail'] = $attrs['url']; 
        
        // get <yt:duration> node for video length
        $yt = $media->children('http://gdata.youtube.com/schemas/2007');
        $attrs = $yt->duration->attributes();
        $search_result[$i]['duration'] = $attrs['seconds']; 
        
        // get <yt:stats> node for viewer statistics
        $yt = $entry->children('http://gdata.youtube.com/schemas/2007');
        //$attrs = $yt->statistics->attributes();
        //$search_result[$i]['viewCount'] = $attrs['viewCount']; 
      
        // get <gd:rating> node for video ratings
        $gd = $entry->children('http://schemas.google.com/g/2005'); 
        if ($gd->rating) {
          $attrs = $gd->rating->attributes();
          $search_result[$i]['rating'] = $attrs['average']; 
        } else {
          $search_result[$i]['rating'] = 0; 
        }

        // get video ID
        $arr = explode('/',$entry->id);
        $search_result[$i]['id'] = $arr[count($arr)-1];
		
		$search_result[$i]['title'] = $media->group->title;
		$search_result[$i]['description'] = $media->group->description;
		
		$i++;
		
	}
	
	$test[0] = $video_array;
	$test[1] = $search_result;
	
	return $test;

}
///////////////////////

function standardfeed($type, $start, $max) {

	$feedURL = 'http://gdata.youtube.com/feeds/api/standardfeeds/'.$type.'?format=5&start-index='.$start.'&max-results='.$max;
	//echo $feedURL;
	$xml = simplexml_load_file($feedURL);
	$video_array = array();
	
	$counts = $xml->children('http://a9.com/-/spec/opensearchrss/1.0/');
    $video_array['total'] = (int) $counts->totalResults; 
    $video_array['startOffset'] = (int) $counts->startIndex; 
    $video_array['endOffset'] = (int) ($video_array['startOffset']-1) + $counts->itemsPerPage;
	
	$i = 0;
	$search_result = array();
	 foreach ($xml->entry as $entry) {
        // get nodes in media: namespace for media information
        $media = $entry->children('http://search.yahoo.com/mrss/');
        
        // get video player URL
        $attrs = $media->group->player->attributes();
        $search_result[$i]['watch'] = $attrs['url']; 
        
        // get video thumbnail
        $attrs = $media->group->thumbnail[0]->attributes();
        $search_result[$i]['thumbnail'] = $attrs['url']; 
        
        // get <yt:duration> node for video length
        $yt = $media->children('http://gdata.youtube.com/schemas/2007');
        $attrs = $yt->duration->attributes();
        $search_result[$i]['duration'] = $attrs['seconds']; 
        
        // get <yt:stats> node for viewer statistics
        $yt = $entry->children('http://gdata.youtube.com/schemas/2007');
        //$attrs = $yt->statistics->attributes();
        //$search_result[$i]['viewCount'] = $attrs['viewCount']; 
      
        // get <gd:rating> node for video ratings
        $gd = $entry->children('http://schemas.google.com/g/2005'); 
        if ($gd->rating) {
          $attrs = $gd->rating->attributes();
          $search_result[$i]['rating'] = $attrs['average']; 
        } else {
          $search_result[$i]['rating'] = 0; 
        }

        // get video ID
        $arr = explode('/',$entry->id);
        $search_result[$i]['id'] = $arr[count($arr)-1];
		
		$search_result[$i]['title'] = $media->group->title;
		$search_result[$i]['description'] = $media->group->description;
		
		$i++;
		
	}
	
	$test[0] = $video_array;
	$test[1] = $search_result;
	
	return $test;


}

function indexpagefeed($type, $start, $max) {

	$feedURL = 'http://gdata.youtube.com/feeds/api/standardfeeds/'.$type.'?time=today&format=5&start-index='.$start.'&max-results='.$max;
	//echo $feedURL;
	$xml = simplexml_load_file($feedURL);
	$video_array = array();
	
	$counts = $xml->children('http://a9.com/-/spec/opensearchrss/1.0/');
    $video_array['total'] = (int) $counts->totalResults; 
    $video_array['startOffset'] = (int) $counts->startIndex; 
    $video_array['endOffset'] = (int) ($video_array['startOffset']-1) + $counts->itemsPerPage;
	
	$i = 0;
	$search_result = array();
	 foreach ($xml->entry as $entry) {
        // get nodes in media: namespace for media information
        $media = $entry->children('http://search.yahoo.com/mrss/');
        
        // get video player URL
        $attrs = $media->group->player->attributes();
        $search_result[$i]['watch'] = $attrs['url']; 
        
        // get video thumbnail
        $attrs = $media->group->thumbnail[0]->attributes();
        $search_result[$i]['thumbnail'] = $attrs['url']; 
        
        // get <yt:duration> node for video length
        $yt = $media->children('http://gdata.youtube.com/schemas/2007');
        $attrs = $yt->duration->attributes();
        $search_result[$i]['duration'] = $attrs['seconds']; 
        
        // get <yt:stats> node for viewer statistics
        $yt = $entry->children('http://gdata.youtube.com/schemas/2007');
        //$attrs = $yt->statistics->attributes();
        //$search_result[$i]['viewCount'] = $attrs['viewCount']; 
      
        // get <gd:rating> node for video ratings
        $gd = $entry->children('http://schemas.google.com/g/2005'); 
        if ($gd->rating) {
          $attrs = $gd->rating->attributes();
          $search_result[$i]['rating'] = $attrs['average']; 
        } else {
          $search_result[$i]['rating'] = 0; 
        }

        // get video ID
        $arr = explode('/',$entry->id);
        $search_result[$i]['id'] = $arr[count($arr)-1];
		
		$search_result[$i]['title'] = $media->group->title;
		$search_result[$i]['description'] = $media->group->description;
		
		$i++;
		
	}
	
	$test[0] = $video_array;
	$test[1] = $search_result;
	
	return $test;


}
///////////////////////

function parseVideoEntry($entry) {      
      $obj= new stdClass;
      
      // get author name and feed URL
      $obj->author = $entry->author->name;
      $obj->authorURL = $entry->author->uri;
      
      // get nodes in media: namespace for media information
      $media = $entry->children('http://search.yahoo.com/mrss/');
      $obj->title = $media->group->title;
      $obj->description = $media->group->description;
	  $obj->keywords = $media->group->keywords;
      
      // get video player URL
      $attrs = $media->group->player->attributes();
      $obj->watchURL = $attrs['url']; 
      
      // get video thumbnail
      $attrs = $media->group->thumbnail[0]->attributes();
      $obj->thumbnailURL = $attrs['url']; 
            
      // get <yt:duration> node for video length
      $yt = $media->children('http://gdata.youtube.com/schemas/2007');
      $attrs = $yt->duration->attributes();
      $obj->length = $attrs['seconds']; 
      
      // get <yt:stats> node for viewer statistics
      $yt = $entry->children('http://gdata.youtube.com/schemas/2007');
      $attrs = $yt->statistics->attributes();
      $obj->viewCount = $attrs['viewCount']; 
      
      // get <gd:rating> node for video ratings
      $gd = $entry->children('http://schemas.google.com/g/2005'); 
      if ($gd->rating) { 
        $attrs = $gd->rating->attributes();
        $obj->rating = $attrs['average']; 
      } else {
        $obj->rating = 0;         
      }
        
      // get <gd:comments> node for video comments
      $gd = $entry->children('http://schemas.google.com/g/2005');
      if ($gd->comments->feedLink) { 
        $attrs = $gd->comments->feedLink->attributes();
        $obj->commentsURL = $attrs['href']; 
        $obj->commentsCount = $attrs['countHint']; 
      }
      
      // get feed URL for video responses
      $entry->registerXPathNamespace('feed', 'http://www.w3.org/2005/Atom');
      $nodeset = $entry->xpath("feed:link[@rel='http://gdata.youtube.com/schemas/2007#video.responses']"); 
      if (count($nodeset) > 0) {
        $obj->responsesURL = $nodeset[0]['href'];      
      }
         
      // get feed URL for related videos
      $entry->registerXPathNamespace('feed', 'http://www.w3.org/2005/Atom');
      $nodeset = $entry->xpath("feed:link[@rel='http://gdata.youtube.com/schemas/2007#video.related']"); 
      if (count($nodeset) > 0) {
        $obj->relatedURL = $nodeset[0]['href'];      
      }
    
      // return object to caller  
      return $obj;      
    }   


?>