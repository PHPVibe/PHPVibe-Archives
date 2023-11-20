<?php if(isset($_GET["list"])) : $feed = $_GET["list"]; 
else: $feed= "most_recent"; endif;

$time = $_GET["time"];
$pageNumber=$_GET["p"];
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
if(empty($_GET["time"])):	  
$pagi_url = $site_url.'?sk=videos&list='.$feed.'&p=';
else:
$pagi_url = $site_url.'?sk=videos&list='.$feed.'&time='.$time.'&p=';
endif;
include_once("header.php"); 
?>      
    <!-- start page -->
    <div class="page">
    <div class="bredcrumbs">
					<ul>
						<li><a href="<?php echo $site_url;?>"><?php echo $small_title; ?></a></li>
						<?php if(empty($_GET["time"])):	?>
						<li><a href="<?php echo $pagi_url."1"; ?>"><?php echo  $lang[$feed]; ?></a></li>
						<?php else:	?>
						<li><a href="<?php echo $pagi_url."1"; ?>"><?php echo  $lang[$feed]; ?> <?php echo  $lang[$_GET["time"]]; ?></a></li>
						<?php endif; ?>
					</ul>
					<div class="clearfix"></div>
				</div>	  
    		
            <div class="phpvibe-box">
					<div class="box-head-light"><h3><?php echo $lang[$feed]; ?> <?php if(!empty($_GET["time"])) : echo  $lang[$_GET["time"]]; endif; ?></h3></div>
					<div class="box-content">
                	<?php 
        $nbTotal=$videosData['stats']['totalResults'];
		if($pageNumber=='') $pageNumber = 1;					
        $start = $nb_display*$pageNumber-$nb_display;  
     for($i=0;$i<count($videosData['videos']);$i++) {
                        echo '
                        <div class="vid-container">
                        	<a href="'.$site_url.'?sk=video&vid='.$videosData['videos'][$i]['videoid'].'"><img class="vid-photo" src="http://i4.ytimg.com/vi/'.$videosData['videos'][$i]['videoid'].'/default.jpg" width="120" height="72" alt="'.$videosData['videos'][$i]['title'].'"/></a>
                        <a href="'.$site_url.'?sk=video&vid='.$videosData['videos'][$i]['videoid'].'"> '.$videosData['videos'][$i]['title'].'</a><br />
						<img src="img/icons/iconlist-time.png" alt="" class="icon_small icon_pad" />'.sec2hms($videosData['videos'][$i]['duration']).' <img src="img/icons/iconlist-check.png" alt="" class="icon_small icon_pad" /> '.$videosData['videos'][$i]['viewCount'].'
                            <div class="clear"></div>
                        </div>
                        ';
                        
                        }	?>  
                       
                </div>
      </div>
  	  <?php

include 'pagination.php';
$a = new pagination;	
$a->set_current($pageNumber);
$a->set_first_page(false);
$a->set_pages_items(5);
$a->set_per_page($nb_display);
$a->set_values($nb_total);
$a->show_pages($pagi_url);
?>    
       <?php include_once("footer.php"); ?>       
            
            
            
            
      