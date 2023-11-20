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
	     /*see if it's restricted 
    $app = $entry->children('http://purl.org/atom/app#');

        if ($app->control) {
        $search_result[$i]['access'] = 1; 
        } else {
          $search_result[$i]['access'] = 0; 
        }
		
		$yt = $entry->children('http://search.yahoo.com/mrss/');
	if ($yt->noembed) {
        $search_result[$i]['access'] = 1; 
        } else {
          $search_result[$i]['access'] = 0; 
        }
	*/
        $media = $entry->children('http://search.yahoo.com/mrss/');
        
        // get video player URL
        $attrs = $media->group->player->attributes();
        $search_result[$i]['watch'] = $attrs['url']; 
        
        // get video thumbnail
        $attrs = $media->group->thumbnail[0]->attributes();
        $search_result[$i]['thumbnail'] = $attrs['url']; 
		
		// get video state
		

        // get <yt:duration> node for video length
        $yt = $media->children('http://gdata.youtube.com/schemas/2007');
        $attrs = $yt->duration->attributes();
        $search_result[$i]['duration'] = $attrs['seconds']; 
        
		

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
	  
	  // get video category
      $attrs = $media->group->category[0]->attributes();
      $obj->CategoryName = $attrs['label']; 
	  
	   // get video category slug
      $obj->CategoryTerm = $media->group->category[0];  
	  
      // get <yt:duration> node for video length
      $yt = $media->children('http://gdata.youtube.com/schemas/2007');
      $attrs = $yt->duration->attributes();
      $obj->length = $attrs['seconds']; 
      
      // get <yt:stats> node for viewer statistics
      $yt = $entry->children('http://gdata.youtube.com/schemas/2007');
      $attrs = $yt->statistics->attributes();
      $obj->viewCount = $attrs['viewCount']; 
   
	   
	   $yt= $entry->children('http://schemas.google.com/g/2005'); 
      if ($yt->noembed) { 
        $obj->embed = false;  
      } else {
       
 $obj->embed = true;		
      }
	  if ($yt->private) {
   $obj->private = true;
  } else {
   $obj->private = false;
  }
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
// create the tag cloud
function TagCloud($nr)
{
global $Cache;
$cache_tags = 'tagcloud_'.$nr;
if(!$string = $Cache->Load("$cache_tags")){
                     $string = '';
	$result = dbquery("SELECT tag FROM tags WHERE tag != '' ORDER BY tcount DESC LIMIT 0,".$nr);

	$tags = "";

	while ($info = dbarray($result)):

		$tags .= $info['tag'].", ";

	endwhile;
    $tags_array = explode(', ', $tags);
    foreach($tags_array as $tag):
	global $site_url;
	if (!empty($tag)):
   $taglink = str_replace(' ', '+', $tag);
 $string .='<li><a href="'.$site_url.'show/'.$taglink.'">'.$tag.'</a></li>'; 
endif; 
endforeach;
 $Cache->Save($string, "$cache_tags");
}
echo $string;
      		

}

// end the tag cloud


function VideoTagCloud($nr)
{
global $Cache;
$cache_v_tags = 'videotagcloud_'.$nr;
if(!$string = $Cache->Load("$cache_v_tags")){
                     $string = '';

$tg_sql = dbquery("SELECT DISTINCT tags FROM videos ORDER BY views DESC LIMIT 0,".$nr);
	$tags = "";
					 while ($info = dbarray($tg_sql)):

		$tags .= $info['tags'].", ";

	endwhile;
 $the_tags = explode(', ', $tags);
 $the_tags = array_unique($the_tags);
 //echo $the_tags;
 foreach($the_tags as $tag):
	global $site_url;
	if (!empty($tag)):
   $taglink = str_replace(' ', '+', $tag);
$string .='<li><a href="'.$site_url.'show/'.$taglink.'">'.$tag.'</a></li>';  
endif;  
endforeach;
	$Cache->Save($string, "$cache_v_tags");
}
echo $string;
      		

}

// end the tag cloud

?>