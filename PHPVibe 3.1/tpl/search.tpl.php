<?php include("sidebar.tpl.php");
$box_title = ucfirst($q);
echo '<div class="main">';
if ($numberofresults > 0) {
include("video_box.tpl.php");
echo '<div class="clear"></div>';
} else {
echo '<center>No local results found for '.ucfirst($qterm).'</center>';
}
if($config->video->api == "1") {
$searched_term  = str_replace(" ", "+",$q );
$nb_display=25;

$startIndex = $nb_display*$pageNumber-$nb_display+1;
$criteria2['q'] = $searched_term;
$criteria2['start-index'] = $startIndex;
$criteria2['max-results'] = $nb_display;
$criteria2['orderby'] = 'viewCount';
$v1 = new Youtube_class();
$url = $v1->getYoutubeSearchVideosFeeds($criteria2);
$videosData = $v1->returnYoutubeVideosDatasByURL($url);
$nbTotal=$videosData['stats']['totalResults'];
 if($nbTotal==0) { 			$nbTotal = count($videosData['videos']); 		}
$start = $nb_display*$pageNumber-$nb_display;
 
echo '
<div class="block_title"><h3>'.ucfirst($qterm).' suggestions</h3></div>
<div class="boxed-mini" data-view="boxed-mini">';


 for($i=0;$i<count($videosData['videos']);$i++) {
 $submit_it = base64_encode('http://www.youtube.com/watch?v='.$videosData['videos'][$i]['videoid']);
 $submit_it = $site_url."com/preview.php?vid=".$submit_it;
$url = $submit_it.'&lightbox[width]=750&lightbox[height]=500&lightbox[modal]=true';
 echo '
<div id="video-'.$videosData['videos'][$i]["videoid"].'" class="video">
<div class="thumb">
		<a class="clip-link lightbox" data-id="'.$videosData['videos'][$i]["videoid"].'" title="'.$videosData['videos'][$i]['title'].'" href="'.$url.'">
			<span class="clip">
				<img src="http://i4.ytimg.com/vi/'.$videosData['videos'][$i]['videoid'].'/0.jpg" alt="'.$videosData['videos'][$i]['title'].'" /><span class="vertical-align"></span>
			</span>
							
			<span class="overlay"></span>
		</a>
		 <span class="timer">'.sec2hms($videosData['videos'][$i]['duration']).'</span>
	</div>	
	<div class="data">
			<h2 class="title"><a href="'.$url.'" title="'.$videosData['videos'][$i]['title'].'" class="lightbox">'.$videosData['videos'][$i]['title'].'</a></h2>						
		</div>	
	</div>
';
}

}
echo '<div class="clear"></div></div>';
$a->show_pages($pagi_url);
echo '<div class="clear"></div>';
?>
</div>