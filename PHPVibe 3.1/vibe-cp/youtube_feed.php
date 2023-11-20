<?php include_once("header.php");
$pageNumber = MK_Request::getQuery('page', 1);	
$channel = MK_Request::getQuery('channel');	
if(isset($_GET["list"])) { $feed = $_GET["list"]; }else { $feed= $_POST['list']; }
if(empty($feed)) {$feed = 'most_viewed';}

if(isset($_GET["time"])) { $time = $_GET["time"]; }else { $time = $_POST['time']; }
if(empty($_GET["time"])){ $time='today';}
$searched_term  = str_replace(" ", "+",$searched_term );
$nb_display=24; //default
$pagi_url = $admin_link.'youtube_feed.php?list='.$feed.'&time='.$time.'&page=';
$pagi_current=$pagi_url.$pageNumber;
$startIndex = $nb_display*$pageNumber-$nb_display+1;
$criteria2['feed'] = $feed;
$criteria2['time'] = $time;
$criteria2['start-index'] = $startIndex;
$criteria2['max-results'] = $nb_display;
$v1 = new Youtube_class();
$url = $v1->getYoutubeStandardVideosFeeds($criteria2);


	$videosData = $v1->returnYoutubeVideosDatasByURL($url);
	 $nbTotal=$videosData['stats']['totalResults'];
	    if($nbTotal==0) {
			$nbTotal = count($videosData['videos']);
		}
		
			
     
    $start = $nb_display*$pageNumber-$nb_display;
?>
	<div id="content">
<div class="box">
<div class="box-header"><h1>Youtube import : <?php echo $feed; ?></h1></div>
<div class="box-content">
<?php

?>
<div id="large_grid">
<ul>
<?php     for($i=0;$i<count($videosData['videos']);$i++) {
 echo '
<li class="thumbnail"><a href="http://www.youtube.com/watch?v='.$videosData['videos'][$i]['videoid'].'" target="_blank" class="lightbox"><img src="http://i4.ytimg.com/vi/'.$videosData['videos'][$i]['videoid'].'/0.jpg" width="120" height="72" alt="'.$videosData['videos'][$i]['title'].'"/></a>
<p><a href="'.admin_panel().'single_import.php?id='.$videosData['videos'][$i]['videoid'].'&channel='.$channel.'&lightbox[width]=250&lightbox[height]=60" title="Import this video" class="lightbox" id="'.$videosData['videos'][$i]['videoid'].'"><i class="icon-plus"></i></a>
  <span>'.$videosData['videos'][$i]['title'].' <br /><br /><a href="http://www.youtube.com/watch?v='.$videosData['videos'][$i]['videoid'].'" target="_blank">Preview on Youtube</a></span></a></p>
</li>
';
}	?>  	
 </ul>
</div>	  

            </div>


<br style="clear:both;">

		
	
</div>	
<?php
echo '<div class="clear"></div>';
$a = new pagination;	
$a->set_current($pageNumber);
$a->set_first_page(true);
$a->set_pages_items(12);
$a->set_per_page($nb_display);
$a->set_values(1000);
$a->show_pages($pagi_url);
?>
	</div>
	</div>
	
<?php include_once("footer.php");?>