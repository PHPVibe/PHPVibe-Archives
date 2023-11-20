<?php
require_once("phpvibe.php");
require_once("com/youtube_api.php");
$playlist_id = MK_Request::getQuery('id');

echo '<rss version="2.0" xmlns:media="http://search.yahoo.com/mrss/" xmlns:jwplayer="http://developer.longtailvideo.com/trac/"> 
  <channel> 
<title>Playlist</title> ';
$l_result=dbquery("SELECT videos FROM playlists where id = '".$playlist_id."'");

 while ($info = dbarray($l_result)):
$vid .= $info['videos'];
endwhile;
$vid_array = explode(',', $vid);
$vid_array = array_filter($vid_array);
$vid_array = array_unique($vid_array);

//var_dump($vid_array);
foreach($vid_array as $liked){	
if (!is_null($liked) && ($liked != "")) :
$v1 	=  new Youtube_class();
$youtube = $v1->getYoutubeVideoDataByVideoId($liked);

 $this_vid_title = $youtube['title'];
 $this_vid_link = "http://www.youtube.com/watch?v=".$liked;
 $this_vid_thumb = "http://i2.ytimg.com/vi/".$liked."/0.jpg";
  echo '
   <item> 
      <title>'.$this_vid_title.'</title> 
      <media:content url="'.$this_vid_link.'" /> 
      <media:thumbnail url="'.$this_vid_thumb.'" />
      <description>'.$this_vid_title.' video.</description>
    </item>
	';
else: continue;
endif;
 }
echo '
  </channel> 
</rss>';

?>