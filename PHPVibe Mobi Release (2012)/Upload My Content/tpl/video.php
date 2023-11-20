<?php  /* check for a valid video id */
if(isset($_GET["vid"])) : $video_id = $_GET["vid"]; 
else: include_once("404.php"); endif;
/* once we have an id we load the page and get the data from Youtube/Cache */
$v1 	=  new Youtube_class();
$youtube = $v1->getYoutubeVideoDataByVideoId($video_id);
/* Attempt to fecth related videos */
$related = $v1->getYoutubeRelatedVideos($video_id);

include_once("header.php"); ?>       
    <!-- start page -->
    <div class="page">
    <div class="bredcrumbs">
					<ul>
							<li><a href="<?php echo $site_url;?>"><?php echo $small_title; ?></a></li>
						<?php if(!empty($youtube['title'])) { ?>
						<li><a href=""><?php echo $youtube['title'];?></a></li>
						<?php } else { ?>
						<li><a href="<?php echo $site_url;?>"><?php echo  $lang['video'];?></a></li>
						<?php }?>
						
					</ul>
					<div class="clearfix"></div>
				</div>	
<div class="phpvibe-box">
			<div class="box-head-light"><h3><?php echo $youtube['title'];?></h3></div>
					<div class="box-content">				
    		<iframe style="width:100%; min-height:170px; height:auto!important;" src="http://www.youtube.com/embed/<?php echo $video_id;?>?rel=0&showsearch=0&showinfo=0&modestbranding=1&wmode=transparent" frameborder="0"></iframe>
         
		  <div class="under_video">
		  <img src="img/icons/iconlist-people.png" alt="" class="icon_small" /><?php echo $youtube['author'] ?>   <img src="img/icons/iconlist-time.png" alt="" class="icon_small icon_pad" /><?php echo sec2hms($youtube['duration']) ?>  <img src="img/icons/iconlist-check.png" alt="" class="icon_small icon_pad " /> <?php echo $youtube['viewCount'] ?> <img src="img/icons/iconlist-love.png" alt="" class="icon_small icon_pad " /> <?php echo $youtube['likeCount']; ?> 
		 </div>
		<div style="width:100%;text-align: center;"> <img src="img/icons/iconlist-light.png" alt="" class="icon_small" /><a id="description" href="#"><?php echo  $lang['showmore'];?></a></div>
		   <div id="main-description">
		   <?php echo $youtube['description']; ?> <br />
		   
		    <?php echo $youtube['tags']; ?>
		   </div>
		  </div>
</div>		  
			<div class="phpvibe-box">
					<div class="box-head-light"><h3><?php echo  $lang['relatedvideos'];?></h3></div>
					<div class="box-content">
                	<?php  for($i=0; $i<count($related); $i++) {	
                        echo '
                        <div class="vid-container">
                        	<a href="'.$site_url.'?sk=video&vid='.$related[$i]['id'].'"><img class="vid-photo" src="http://i4.ytimg.com/vi/'.$related[$i]['id'].'/default.jpg" width="120" height="72" alt="'.$related[$i]['title'].'"/></a>
                        <a href="'.$site_url.'?sk=video&vid='.$related[$i]['id'].'"> '.$related[$i]['title'].'</a><br />
						<img src="img/icons/iconlist-time.png" alt="" class="icon_small icon_pad" />'.sec2hms($related[$i]['duration']).' <img src="img/icons/iconlist-check.png" alt="" class="icon_small icon_pad" /> '.$related[$i]['viewCount'].'
                            <div class="clear"></div>
                        </div>
                        ';
                        }	?>
                </div>
      </div>
    
            <?php include_once("footer.php"); ?>              
            
            
    