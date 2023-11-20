<?php
header("Content-Type: application/xml; charset=UTF-8");
@include('config.php');
@include('mainfile.php');

	// feed details
	$details = '<?xml version="1.0" encoding="UTF-8" ?>
			<rss version="2.0">
				<channel>
					<title>'.$site_title .'</title>
					<link>'.$site_url.'</link>
					<description>'.$site_description.'</description>
					<language>en</language>';
					
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
      $feedURL = "http://gdata.youtube.com/feeds/api/videos/-/".$c['term']."?max-results=10&orderby=".$index_orderby."&time=today";
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
        
       $video_id = str_replace('http://www.youtube.com/watch?v=', '',$watch);
	   $video_id = str_replace('&feature=youtube_gdata', '',$video_id);
       $play_link = Friendly_URL($video_id);
		$details .= '<item>
				<title>'. htmlspecialchars($media->group->title) .'</title>
				<link>'.$play_link.'</link>
				<guid isPermaLink="false">'.$site_url.'show_video.php?video_id='.$video_id.'</guid>
				<description><![CDATA[Watch '. htmlspecialchars($media->group->description) .']]></description>
				</item>';
}
}
	
	$details .= '</channel>
				</rss>';
	
	// output
	echo $details;
?>