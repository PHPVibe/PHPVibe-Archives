<?php
header("Content-Type: application/xml; charset=UTF-8");
@include('config.php');
@include('mainfile.php');

	// feed details
	$details = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:video="http://www.google.com/schemas/sitemap-video/1.1"> ';
					
    // set URL for XML feed containing category list
    $catURL = 'http://gdata.youtube.com/schemas/2007/categories.cat';
    
    // retrieve category list using atom: namespace
    // note: you can cache this list to improve performance, 
    // as it doesn't change very often!
    $cxml = simplexml_load_file($catURL);
    $cxml->registerXPathNamespace('atom', 'http://www.w3.org/2005/Atom');
    $categories = $cxml->xpath('//atom:category');
	
    
    // iterate over category list
    foreach ($categories as $c) {
      // for each category    
      // set feed URL
      $feedURL = "http://gdata.youtube.com/feeds/api/videos/-/".$c['term']."?max-results=25&orderby=".$index_orderby."&time=today";
      $feedURL = preg_replace('/&/', '&amp', $feedURL);
	  //echo $feedURL;
      // read feed into SimpleXML object
      $sxml = simplexml_load_file($feedURL);
      
      // get summary counts from opensearch: namespace
      $counts = $sxml->children('http://a9.com/-/spec/opensearchrss/1.0/');
      $total = $counts->totalResults; 
  

		
	
	//get the latest top videos from all categories
	 foreach ($sxml->entry as $entry) {
        // get nodes in media: namespace for media information
        $media = $entry->children('http://search.yahoo.com/mrss/');
        
        // get video player URL
        $attrs = $media->group->player->attributes();
        $watch = $attrs['url']; 
		// get <yt:duration> node for video length
        $yt = $media->children('http://gdata.youtube.com/schemas/2007');
        $attrs = $yt->duration->attributes();
        $length = $attrs['seconds']; 
        
        // get <gd:rating> node for video ratings
        $gd = $entry->children('http://schemas.google.com/g/2005'); 
        if ($gd->rating) {
          $attrs = $gd->rating->attributes();
          $rating = $attrs['average']; 
        } else {
          $rating = 0; 
        }
        
       $video_id = str_replace('http://www.youtube.com/watch?v=', '',$watch);
	   $video_id = str_replace('&feature=youtube_gdata', '',$video_id);
       $play_link = Friendly_URL($video_id);
	   
		$details .= '<url> 
		<loc>'.$site_url.'video/'.$video_id.'</loc>
		<video:video>
		     <video:content_loc>'.$site_url.'/embed/player.swf?file=http://www.youtube.com/watch?v='.$video_id.'</video:content_loc>
		     <video:player_loc allow_embed="yes" autoplay="ap=1">'.$site_url.'/embed/player.swf?file=http://www.youtube.com/watch?v='.$video_id.'</video:player_loc>
			 <video:thumbnail_loc>'.$site_url.'media.php?type=big&amp;id='.$video_id.'</video:thumbnail_loc>
			 <video:title>'. htmlspecialchars($media->group->title) .'</video:title>
			 <video:description><![CDATA[Watch '. htmlspecialchars($media->group->description) .']]> </video:description>
			 <video:rating> '.$rating.'</video:rating>
			 <video:category>'.htmlentities($c['label'], ENT_QUOTES).'</video:category>
			 <video:family_friendly>yes</video:family_friendly>   
			 <video:duration>'.$length.'</video:duration> 
				 
		 </video:video> 
				</url>';
}
}
	
	$details .= '</urlset>';
	
	// output
	echo $details;
?>