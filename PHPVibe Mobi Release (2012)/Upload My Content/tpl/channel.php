<?php if(isset($_GET["name"])):
$channel = $_GET["name"]; 
else: include_once("channels.php"); 
exit;
endif;

$time = $_GET["time"];
$pageNumber=$_GET["p"];
if($pageNumber=='') $pageNumber = 1; //default
if($nb_display=='') $nb_display=10; //default
$startIndex = $nb_display*$pageNumber-$nb_display+1;
$criteria2['category'] = $channel;
$criteria2['time'] = $time;
$criteria2['start-index'] = $startIndex;
$criteria2['max-results'] = $nb_display;
$v1 = new Youtube_class();
$url = $v1->getYoutubeVideosByCategory($criteria2);
$c_id = $channel.".".$time.".".$startIndex.".". $nb_display; 
$videosData = $v1->returnYoutubeVideosDatasByURL($url,$c_id);

include_once("header.php"); 
?>      
    <!-- start page -->
    <div class="page">
    <div class="bredcrumbs">
					<ul>
						<li><a href="<?php echo $site_url;?>"><?php echo $small_title; ?></a></li>
						<li><a href="<?php echo $site_url;?>?sk=channel"><?php echo $channel; ?></a></li>
					</ul>
					<div class="clearfix"></div>
				</div>	  
    		
            <div class="phpvibe-box">
					<div class="box-head-light"><h3><?php echo $lang['channel'].": ".$channel; ?></h3></div>
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
$pagi_url = $site_url.'?sk=channel&name='.$channel.'&p=';
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
            
            
            
            
      