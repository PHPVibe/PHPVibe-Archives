<?php require_once('settings.php'); 
//load Youtube API class
require_once('youtube_api.php'); 
// Define cache and set expiery time (in seconds)
require_once("cache.php");
$Cache = new CacheSys("cache/", 43200);
$Cache->SetTtl(43200);
$feed= "most_recent";
if($pageNumber=='') $pageNumber = 1; //default
if($nb_display=='') $nb_display=10; //default
$startIndex = $nb_display*$pageNumber-$nb_display+1;
$criteria2['feed'] = $feed;
$criteria2['time'] = $time;
$criteria2['start-index'] = $startIndex;
$criteria2['max-results'] = $nb_display;
$v1 = new Youtube_class();
$url = $v1->getYoutubeStandardVideosFeeds($criteria2);
$c_id = $feed.".".$time.".".$startIndex.".". $nb_display; 
$videosData = $v1->returnYoutubeVideosDatasByURL($url,$c_id);

echo'<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0">
<channel>
';
echo '
<title>'.$seo_title.'</title>
<description>'.$seo_desc.'</description>
<link>'.$site_url.'</link>
';

        $nbTotal=$videosData['stats']['totalResults'];
		if($pageNumber=='') $pageNumber = 1;					
        $start = $nb_display*$pageNumber-$nb_display; 
	$time = ""; 	
     for($i=0;$i<count($videosData['videos']);$i++) {
	 $desc = $lang['video']. " : ".$videosData['videos'][$i]['title'];
	 
	  
	  $pieces = explode("T",  $videosData['videos'][$i]['updated']);
	  $xtime = str_replace ("Z","", $pieces[1]);
	  $time = str_replace (".000","", $xtime);	
	  $date = $pieces[0];
	  
       // Correct the invalid order of the date
$date_parts = array_reverse(explode("-", $date));
$date = implode('-', $date_parts);

// Set up the format
$timestamp = strtotime($date . " " . $time);
$rss_datetime = date(DATE_RFC2822, $timestamp);
	  
	 echo '
	 <item>
<title>'.$videosData['videos'][$i]['title'].'</title>
<link><![CDATA['.$site_url.'?sk=video&vid='.$videosData['videos'][$i]['videoid'].']]></link>
<guid><![CDATA['.$site_url.'?sk=video&vid='.$videosData['videos'][$i]['videoid'].']]></guid>
<pubDate>'.$rss_datetime.'</pubDate>
<description>[CDATA['.$desc.' ]]</description>
</item>
	 
	 ';
}	
echo'</channel>
</rss>';						
						
?>      