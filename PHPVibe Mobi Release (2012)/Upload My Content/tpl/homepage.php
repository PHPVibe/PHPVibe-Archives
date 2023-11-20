<?php include_once("header.php"); ?>   
  
    <!-- start page -->
    <div class="page">

<div class="bredcrumbs">
					<ul>
						<li><a href="<?php echo $site_url;?>"><?php echo $small_title; ?></a></li>
						
					</ul>
					<div class="clearfix"></div>
				</div>	
            
<div class="phpvibe-box">
	<div class="box-head"><h3><?php echo  $lang['welcome']; ?></h3></div>
	<div class="box-content">
            <!-- start list -->
           	 <ul class="listcontent">
<li><a href="<?php echo $site_url;?>?sk=channel"><img src="<?php echo $site_url;?>img/bigicons/play.png" width="23" height="23" alt="icon" class="m-icon"/><b><?php echo  $lang['browsechannels']; ?></b></a></li>
<li><a href="<?php echo $site_url;?>?sk=videos"><img src="<?php echo $site_url;?>img/bigicons/bell2.png" width="23" height="23" alt="icon" class="m-icon"/><b><?php echo  $lang['most_recent']; ?> <span><?php echo  $lang['new']; ?></span> </b></a></li>
<li><a href="<?php echo $site_url;?>?sk=videos&list=top_rated&time=today"><img src="<?php echo $site_url;?>img/bigicons/like.png" width="23" height="23" alt="icon" class="m-icon"/><b><?php echo  $lang['top_rated']; ?> <?php echo  $lang['today']; ?> <span class="red"><?php echo  $lang['hot']; ?></span> </b></a></li>
<li><a href="<?php echo $site_url;?>?sk=videos&list=most_viewed&time=today"><img src="<?php echo $site_url;?>img/bigicons/preview.png" width="23" height="23" alt="icon" class="m-icon"/><b><?php echo  $lang['most_viewed']; ?> <?php echo  $lang['today']; ?> <span class="red"><?php echo  $lang['hot']; ?></span></b></a></li>
<li><a href="<?php echo $site_url;?>?sk=videos&list=top_favorites&time=today"><img src="<?php echo $site_url;?>img/bigicons/heart.png" width="23" height="23" alt="icon" class="m-icon"/><b><?php echo  $lang['top_favorites']; ?> <?php echo  $lang['today']; ?> </b></a></li>
<li><a href="<?php echo $site_url;?>?sk=videos&list=most_popular&time=today"><img src="<?php echo $site_url;?>img/bigicons/cup.png" width="23" height="23" alt="icon" class="m-icon"/><b><?php echo  $lang['most_popular']; ?> <?php echo  $lang['today']; ?></a></li>
<li><a href="<?php echo $site_url;?>?sk=videos&list=most_discussed&time=today"><img src="<?php echo $site_url;?>img/bigicons/speech.png" width="23" height="23" alt="icon" class="m-icon"/><b><?php echo  $lang['most_discussed']; ?> <?php echo  $lang['today']; ?> </b></a></li>
<li><a href="<?php echo $site_url;?>?sk=videos&list=most_viewed&time=this_week"><img src="<?php echo $site_url;?>img/bigicons/play2.png" width="23" height="23" alt="icon" class="m-icon"/><b><?php echo  $lang['most_viewed']; ?> <?php echo  $lang['this_week']; ?></b></a></li>
<li><a href="<?php echo $site_url;?>?sk=videos&list=top_rated&time=this_week"><img src="<?php echo $site_url;?>img/bigicons/podium.png" width="23" height="23" alt="icon" class="m-icon"/><b><?php echo  $lang['top_rated']; ?> <?php echo  $lang['this_week']; ?> </b></a></li>
<li><a href="<?php echo $site_url;?>?sk=videos&list=most_viewed&time=this_month"><img src="<?php echo $site_url;?>img/bigicons/record.png" width="23" height="23" alt="icon" class="m-icon"/><b><?php echo  $lang['most_viewed']; ?> <?php echo  $lang['this_month']; ?></b></a></li>
<li><a href="<?php echo $site_url;?>?sk=videos&list=top_rated&time=this_month"><img src="<?php echo $site_url;?>img/bigicons/loading.png" width="23" height="23" alt="icon" class="m-icon"/><b><?php echo  $lang['top_rated']; ?> <?php echo  $lang['this_month']; ?> </b></a></li>
<li><a href="<?php echo $site_url;?>?sk=videos&list=most_viewed&time=all_time"><img src="<?php echo $site_url;?>img/bigicons/refresh.png" width="23" height="23" alt="icon" class="m-icon"/><b><?php echo  $lang['most_viewed']; ?> <?php echo  $lang['all_time']; ?></b></a></li>
<li><a href="<?php echo $site_url;?>?sk=videos&list=top_rated&time=all_time"><img src="<?php echo $site_url;?>img/bigicons/repeat.png" width="23" height="23" alt="icon" class="m-icon"/><b><?php echo  $lang['top_rated']; ?> <?php echo  $lang['all_time']; ?> </b></a></li>

              </ul>
            <!-- end list -->
			<div class="clearfix"></div>
	</div>
	</div>  
	
<?php if($enable_albums == true) { ?>	
<div class="phpvibe-box">
<div class="box-head-light"><h3><?php echo  $lang['pictures']; ?></h3></div>
<div class="box-content"> 
<ul class="listcontent">
			<li><a href="<?php echo $site_url;?>albums.php"><img src="img/bigicons/view.png" width="23" height="23" alt="icon" class="m-icon"/><b><?php echo  $lang['allalbums']; ?></b></a></li>
			<li><a href="<?php echo $site_url;?>albums.php?album=<?php echo $featuredalbum;?>"><img src="img/bigicons/photos.png" width="23" height="23" alt="icon" class="m-icon"/><b><?php  echo str_replace("-", " " ,$featuredalbum);?> <span class="red"><?php echo  $lang['hot']; ?></span></b></a></li>
		    
<?php if($show_featured == true && !empty($featuredalbum)) {
		$album	= $featuredalbum;
echo '</ul>
<ul id="Gallery" class="gallery">';

	$imagesArr	= array();
	if(file_exists('albums/'.$album)){
		$files = array_slice(scandir('albums/'.$album), 2);
		if(count($files)){
		$i=1;
			foreach($files as $file){
							
				echo '<li><a href="'.$site_url.'albums/'.$album.'/'.$file.'"><img src="'.$site_url.'thumb.php?src=/albums/'.$album.'/'.$file.'&h=100&w=100&crop&q=100" alt="'.$file.'"/></a></li>';
				if($i == 3) : break; endif;
				$i++;
				}
			}
		}
echo ' </ul>
<script type="text/javascript">
$(document).ready(function(){

	var myPhotoSwipe = $("#Gallery a").photoSwipe({ enableMouseWheel: false , enableKeyboard: false });

}); 
</script>
';	
} else {
echo '</ul>';
}
}
?>
  </div></div>         
<?php include_once("footer.php"); ?>         
            
    