<?php
$yt_data = grab_video("http://www.youtube.com/watch?v=".$video_id);

						if(strpos($yt_data[0], 'xml') !== FALSE)
						{
							$arr_length = count($yt_data);
							for($i = 0; $i < $arr_length; $i++)
							{
								$yt_data[$i] = str_replace( array("\n", "\t", "\r"), '', $yt_data[$i]);
								if(preg_match('/<yt:noembed/', $yt_data[$i]) != 0)
								{
									$condition = 2;
									break;
								}
								
								if(preg_match('/<yt:private/', $yt_data[$i]) != 0)
								{
									$condition = 2;
									break;
								}
								
								if(preg_match('/<media:restriction(.*?)>/', $yt_data[$i]) != 0)
								{
									$condition = 3;
									break;
								}
								
								if(preg_match('/<yt:state name=\'(3|deleted|rejected|failed)\' reasonCode=\'(.*?)\'(.*)>(.*?)<\/yt:state>/', $yt_data[$i], $matches) != 0)
								{
									$condition = 2;							
									
									break;
								}

							}
						}
						else
						{
							$condition = 2;
						}
						
						if(!$condition)
						{
							$condition = 1;
						}
						
//echo $condition;

// set video data feed URL

$feedURL = 'http://gdata.youtube.com/feeds/api/videos/'.$video_id;

// read feed into SimpleXML object

$entry = simplexml_load_file($feedURL);

$video = parseVideoEntry($entry);	

$meta_description = str_replace('"', '-', $video->description);

$meta_description = substr($meta_description, 0, 150);  

$description = $video->description;
$category = $video->CategoryName;
$category_slug = $video->CategoryTerm;
$video_views = $video->viewCount;
$video_yt_rate = $video->rating;
$video_time = number_format( $video->length/60, 2 );
$save_tags = $video->keywords;

if (filterBadWords($config->site->banned, $video->title) != 0) {
header("Location: ../../index.php?bad=1"); 
exit("Bad word found in title");
}
if (filterBadWords($config->site->banned, $description) != 0) {
header("Location: ../../index.php?bad=1"); 
exit("Bad word found in title");
}
?>