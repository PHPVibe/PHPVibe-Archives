<?php 
require_once('mainfile.php');
require_once("apifunctions.php");

$indexterm = "MTV EMA";
	// feed details
	$details = '<?xml version="1.0" encoding="iso-8859-1"?>';
	$details .= '<urlset>';
     
      // set feed URL
        $feedURL = 'http://gdata.youtube.com/feeds/api/standardfeeds/most_viewed?time=today';
      $feedURL = preg_replace('/&/', '&amp', $feedURL);
	  //echo $feedURL;
      // read feed into SimpleXML object
      $sxml = simplexml_load_file($feedURL);
	   foreach ($sxml->entry as $entry) {
	   
      
    // get nodes in media: namespace for media information
      $media = $entry->children('http://search.yahoo.com/mrss/');
      
      // get video player URL
      $attrs = $media->group->player->attributes();
      $watch = $attrs['url']; 
      
      // get video thumbnail
      $attrs = $media->group->thumbnail[0]->attributes();
      $thumbnail = $attrs['url']; 
            
      // get <yt:duration> node for video length
      $yt = $media->children('http://gdata.youtube.com/schemas/2007');
      $attrs = $yt->duration->attributes();
      $length = $attrs['seconds']; 
      
      // get <yt:stats> node for viewer statistics
      $yt = $entry->children('http://gdata.youtube.com/schemas/2007');
      $attrs = $yt->statistics->attributes();
      $viewCount = $attrs['viewCount']; 
      
      // get <gd:rating> node for video ratings
      $gd = $entry->children('http://schemas.google.com/g/2005'); 
      if ($gd->rating) {
        $attrs = $gd->rating->attributes();
        $rating = $attrs['average']; 
      } else {
        $rating = 0; 
      } 

		
	
	//get the latest top videos from all categories
	
	
	
       
        
       $video_id = str_replace('http://www.youtube.com/watch?v=', '',$watch);
	   $video_id = str_replace('&feature=youtube_gdata', '',$video_id);
	   $video_id = str_replace('_player', '',$video_id);
       $play_link = Friendly_URL($video_id);
	   
		$details .= '<video> 
		<videourl>'.$site_url.'video/'.$video_id.'</videourl>
		<videoid>'.$video_id.'</videoid>
		<videotitle>'. htmlspecialchars($media->group->title) .'</videotitle>  
		<videotime>'.$length.'</videotime> 
		<videocat>'.htmlspecialchars($curentcat).'</videocat> 
		
				</video>';

}
	
	$details .= '</urlset>';
	
	// output
	//echo $details;
	$file_handle = fopen('cache/index.xml','w'); 
fwrite($file_handle,$details); 
fclose($file_handle); ?>