<?php include_once("header.php");
$pageNumber = MK_Request::getQuery('page', 1);	
$channel = MK_Request::getQuery('channel');	
$searched_term = $_GET['s'];
if(empty($searched_term)) {
$searched_term = $_POST['s'];
}
$pagi_url = $admin_link.'youtube_channel.php?&s='.$searched_term.'&channel='.$channel.'&page=';

$pagi_current=$pagi_url.$pageNumber;


$searched_term  = str_replace(" ", "+",$searched_term );
$nb_display=24; //default

$startIndex = $nb_display*$pageNumber-$nb_display+1;
$criteria2['category'] = $searched_term;
$criteria2['start-index'] = $startIndex;
$criteria2['max-results'] = $nb_display;

	$v1 = new Youtube_class();
	$url = $v1->getYoutubeVideosByCategory($criteria2);
	$videosData = $v1->returnYoutubeVideosDatasByURL($url);
	 $nbTotal=$videosData['stats']['totalResults'];
	    if($nbTotal==0) {
			$nbTotal = count($videosData['videos']);
		}
		
			
     
    $start = $nb_display*$pageNumber-$nb_display;
?>
	<div id="content">
<div class="box">
<div class="box-header"><h1>Youtube import : <?php echo $searched_term; ?></h1></div>
<div class="box-content">
<?php

?>
<div id="large_grid">
<ul>
<?php     for($i=0;$i<count($videosData['videos']);$i++) {

$source = 'http://www.youtube.com/watch?v='.$videosData['videos'][$i]['videoid'];
$thumb = 'http://i4.ytimg.com/vi/'.$videosData['videos'][$i]['videoid'].'/0.jpg';
$title = mysql_real_escape_string(cleanInput($videosData['videos'][$i]['title']));
$duration = mysql_real_escape_string(cleanInput($videosData['videos'][$i]['duration']));
$desc = mysql_real_escape_string(cleanInput($videosData['videos'][$i]['description']));
$tags = mysql_real_escape_string(cleanInput($videosData['videos'][$i]['tags']));
$usr = $user->getId();
$nr_query = ("SELECT COUNT(*) FROM videos WHERE source like '".$source."%'");
$result = mysql_query($nr_query);
$checkvideo = mysql_result($result, 0);
$stime = date(DATE_RFC822);
if($checkvideo == "0"):
if($config->site->storethumbs) {
$imageLibObj = new imageLib($thumb);
$imageLibObj -> resizeImage($config->site->wpics, $config->site->hpics);    
$new_image = seo_clean_url($videosData['videos'][$i]['title'].$stime).".png";
$thumb_path = dirname(dirname(__FILE__));
$imageLibObj -> saveImage($thumb_path.'/'.$config->site->mediafolder.'/'.$config->site->thumbsfolder.'/'.$new_image, 100);
$thumb = $site_url.$config->site->mediafolder.'/'.$config->site->thumbsfolder.'/'.$new_image;
}
$insertvideo = dbquery("INSERT INTO videos (`source`, `user_id`, `date`, `thumb`, `title`, `duration`, `tags` , `views` , `liked` , `category`, `description`, `nsfw`) VALUES 
('".$source."', '".$usr."', '".$stime."', '".$thumb."', '".$title ."', '".$duration."', '".$tags."', '1', '0','".$channel."','".$desc."','".$nsfw."')");	
$new_id = mysql_insert_id();
$urlp = $site_url.'video/'.$new_id.'/'.seo_clean_url($title) .'/';
$linkp= "<a href=\"".$urlp."\" target=\"_blank\">View</a> ";
$this_ms = "Added! ".$linkp." <a href=\"videos.php?page=1&delete=".$new_id."\" target=\"_blank\">Delete </a> <a href=\"video_edit.php?id=".$new_id."\" target=\"_blank\">Edit</a>";
endif;
if($checkvideo != "0"):
$this_ms = "Skiped! Already in database";
endif;

 echo '
<li class="thumbnail"><a href="http://www.youtube.com/watch?v='.$videosData['videos'][$i]['videoid'].'" target="_blank" class="lightbox"><img src="http://i4.ytimg.com/vi/'.$videosData['videos'][$i]['videoid'].'/0.jpg" width="120" height="72" alt="'.$videosData['videos'][$i]['title'].'"/></a>
<p> <span>'.$videosData['videos'][$i]['title'].' <br /><br />'.$this_ms .'</span></a></p>
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