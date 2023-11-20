<?php include_once("security.php");
include_once("head.php");
require_once("nocache-youtube.php");


 if(isset($_GET['delete'])){ 
	 $del = dbquery("DELETE from videos WHERE youtube_id = '".$_GET['delete']."'");
	 echo 'You deleted the video with id : '.$_GET['delete'];
	 }
if(isset($_POST['youtube_id'])){ 
if ($_POST['youtube_id'] != "Youtube video id") {
$slider = str_replace("http://www.youtube.com/watch?v=","",$_POST['youtube_id']);
$slider = str_replace("www.youtube.com/watch?v=","",$slider);
$slider = str_replace("youtube.com/watch?v=","",$slider);
$slider = str_replace("Youtube.com/watch?v=","",$slider);

$video_id = $slider;
$v1 	=  new Youtube_class();
$youtube = $v1->getYoutubeVideoDataByVideoId($video_id);
$video_title = $youtube['title'];
$video_description = $youtube['description'];
$video_time = $youtube['duration'];
$video_tags = $youtube['tags'];
$category = $_POST['category'];

$nr_query = ("SELECT COUNT(*) FROM videos WHERE youtube_id = '".$video_id."'");
$result = mysql_query($nr_query);
$checkvideo = mysql_result($result, 0);
if($checkvideo == "0"):
$insertvideo = dbquery("INSERT INTO videos (`youtube_id`, `title`, `duration`, `tags` , `views` , `category`) VALUES ('".addslashes($video_id)."', '".addslashes($video_title)."', '".addslashes($video_time)."', '".addslashes($video_tags)."', '1' , '".addslashes($category)."')");		
endif;
if($checkvideo != "0"):
echo "That video is already in database";
endif;
}
}

if(isset($_POST['q'])){ 
Echo "Importing for ".$_POST['q'];
    $criteria2['q'] = $_POST['q'];
	$criteria2['start-index'] = "0";
	$criteria2['max-results'] = "50";
	$v1 = new Youtube_class();
	$url = $v1->getYoutubeSearchVideosFeeds($criteria2);
	$videosData = $v1->returnYoutubeVideosDatasByURL($url);
	
	//var_dump($videosData);
	
	$pageNumber = $criteria['pageNumber'];
		$nb_display = $criteria['nb_display'];

		
		$nbTotal=$videosData['stats']['totalResults'];
		if($pageNumber=='') $pageNumber = 1;
		
		// patch for favorite's user videos
		if($nbTotal==0) {
			$nbTotal = count($videosData['videos']);
		}
		
		$start = $nb_display*$pageNumber-$nb_display;
		
		$videoType=0; //0=youtube
		
		// display head menu
		$criteria3['nbTotal'] = $nbTotal;
		$criteria3['start'] = $start;
		$criteria3['nb_display'] = $nb_display;
		
		//$this->displayMenuPaginationNumber($criteria3);
		
		//$this->display_pagination($criteria3);
		//echo '<br>';
		
		
		$j = 1;
		for($i=0;$i<count($videosData['videos']);$i++) {
		
			$videoid = $videosData['videos'][$i]['videoid'];
			$full_title = str_replace("\"", "",$videosData['videos'][$i]['title']);
			$duration = $videosData['videos'][$i]['duration'];
			$video_tags = $videosData['tags'];
			
			$nr_query = ("SELECT COUNT(*) FROM videos WHERE youtube_id = '".$videoid."'");
$result = mysql_query($nr_query);
$checkvideo = mysql_result($result, 0);
if($checkvideo == "0"):
$category = $_POST['category'];
$insertvideo = dbquery("INSERT INTO videos (`youtube_id`, `title`, `duration`, `tags` , `views`  , `category`) VALUES ('".addslashes($videoid)."', '".addslashes($full_title)."', '".addslashes($duration)."', '".addslashes($video_tags)."', '1', '".addslashes($category)."')");		
$last_msg .= " Imported id ".$videoid." title: ".$full_title." <br /><hr> ";
endif;
if($checkvideo != "0"):
$last_msg .= " Skiped for already in database -> ".$videoid." <br /><hr> ";
endif;
		}
		
		if(count($videosData['videos'])==0) {
			echo 'No results found';
		}
}

if(isset($_POST['feed'])){ 
Echo "Importing videos  from ".$_POST['feed'];
   	//get video data
	$criteria2['feed'] = $_POST['feed'];
	$criteria2['time'] = $_POST['time'];
	$criteria2['start-index'] = "0";
	$criteria2['max-results'] = "50";
	$v1 = new Youtube_class();
	$url = $v1->getYoutubeStandardVideosFeeds($criteria2);
	$videosData = $v1->returnYoutubeVideosDatasByURL($url);
	
	//var_dump($videosData);
	
	    $pageNumber = $criteria['pageNumber'];
		$nb_display = $criteria['nb_display'];

		
		$nbTotal=$videosData['stats']['totalResults'];
		if($pageNumber=='') $pageNumber = 1;
		
		// patch for favorite's user videos
		if($nbTotal==0) {
			$nbTotal = count($videosData['videos']);
		}
		
		$start = $nb_display*$pageNumber-$nb_display;
		
		$videoType=0; //0=youtube
		
		// display head menu
		$criteria3['nbTotal'] = $nbTotal;
		$criteria3['start'] = $start;
		$criteria3['nb_display'] = $nb_display;	
		
	
		$j = 1;
		for($i=0;$i<count($videosData['videos']);$i++) {
		
			$videoid = $videosData['videos'][$i]['videoid'];
			$full_title = str_replace("\"", "",$videosData['videos'][$i]['title']);
			$duration = $videosData['videos'][$i]['duration'];
			$video_tags = $videosData['tags'];
			
			$nr_query = ("SELECT COUNT(*) FROM videos WHERE youtube_id = '".$videoid."'");
$result = mysql_query($nr_query);
$checkvideo = mysql_result($result, 0);
if($checkvideo == "0"):
$category = $_POST['category'];
$insertvideo = dbquery("INSERT INTO videos (`youtube_id`, `title`, `duration`, `tags` , `views` , `category` ) VALUES ('".addslashes($videoid)."', '".addslashes($full_title)."', '".addslashes($duration)."', '".addslashes($video_tags)."', '1' , '".addslashes($category)."')");		
$last_msg .= " Imported id ".$videoid." title: ".$full_title." <br /><hr> ";
endif;
if($checkvideo != "0"):
$last_msg .= " Skiped for already in database -> ".$videoid." <br /><hr> ";
endif;
		}
		
		if(count($videosData['videos'])==0) {
			echo 'No results found';
		}
}
?>
 <div id="content" class="clear-fix">	 
<div id="left">

 <div class="block">

 <h2>Import single video</h2> 
 <div class="form">
   <form action="import-videos.php" method="post" class="standard clear-fix large">
   <fieldset>
  <div class="clear-fix form-field"></div>         
                    <div class="input-left"><div class="input-right">
					   <dt><label for="youtube_id">
					  <i>Youtube.com/watch?v=<span style="color:red">TxvpctgU_s8</span></i>
					   </label></dt>
					   </div> </div>
					    <div class="input-left"><div class="input-right">
					<dl>
<input type="text" name="youtube_id" id="" size="4" value="Youtube video id" class="data input-text"/>
</dl>
</div></div>
<div class="clear-fix form-field"></div>				
<div class="input-left"><div class="input-right"><dl>
 <dt><label for="category">Category for imported videos:</label></dt>
 </div> </div>
					    <div class="input-left"><div class="input-right">
                        <dd> 
<select name="category"> 						
<?php 
 $chsql = dbquery("SELECT * FROM `channels` order by cat_name ASC");
 echo '
 <option value=""/>None</option>
';
 while($row = mysql_fetch_array($chsql)){
echo '		
<option value="'.$row["cat_id"].'" />'.$row["cat_name"].'</option>';		
}			
?>	
</select>
              </dd>
 </dl></div></div><div class="clear-fix form-field"></div> 
 
<div class="clear-fix form-field field-searchsubmit form-field-submit">
<div class="input-left"><div class="input-right">
 <dl class="submit">
<input type="submit" name="submit" id="submit" value="Import video" />
 </dl>	
</div></div></div><div class="clear-fix form-field"></div>
  </fieldset>
</form>
</div>

 <h2>Import video feed</h2> 
 <div class="form">
   <form action="import-videos.php" method="post" class="standard clear-fix large">
   <fieldset>
<div class="input-left"><div class="input-right">
					   <dt><label for="q">Search word / Tag:
					     </label></dt>
						  </div>
						 </div>
<div class="input-left"><div class="input-right">
<dl>
<input type="text" id="q" name="q" class="data input-text">
</dl>
 </div></div>
 <div class="clear-fix form-field"></div>				
<div class="input-left"><div class="input-right"><dl>
 <dt><label for="category">Category for imported videos:</label></dt>
 </div> </div>
					    <div class="input-left"><div class="input-right">
                        <dd> 
<select name="category"> 						
<?php 
 $chsql = dbquery("SELECT * FROM `channels` order by cat_name ASC");
 echo '
 <option value=""/>None</option>
';
 while($row = mysql_fetch_array($chsql)){
echo '		
<option value="'.$row["cat_id"].'" />'.$row["cat_name"].'</option>';		
}			
?>	
</select>
              </dd>
 </dl></div></div><div class="clear-fix form-field"></div> 
 <div class="clear-fix form-field"></div>  
<div class="clear-fix form-field field-searchsubmit form-field-submit">
<div class="input-left"><div class="input-right">
 <dl class="submit">
<input type="submit" name="submit" id="submit" value="Import this search" />
 </dl>	
 </div></div></div>
 <div class="clear-fix form-field"></div>
  </fieldset>
</form>
</div>
<br />



 <h2>Import from standard feeds</h2> 
  <div class="form">
<form action="import-videos.php" method="post" class="standard clear-fix large">
  <fieldset>
<table>
<tr><td>Feeds: &nbsp;&nbsp;&nbsp;</td><td>
<select id="feed" name="feed"  style="width:140px">
<option value="most_viewed" selected>Most viewed</option>
<option value="top_rated">Top rated</option>
<option value="top_favorites">Top favorites</option>
<option value="most_popular">Most popular</option>
<option value="most_discussed">Most discussed</option>
<option value="most_linked">Most linked</option>
</select></td></tr><tr><td>Time: &nbsp;&nbsp;&nbsp;</td><td>
<select id="time" name="time" style="width:140px">
<option value="today" selected>Today</option>
<option value="this_week">This week</option>
<option value="this_month">This month videos</option>
<option value="all_time">All time</option></select></td></tr></table>
<div class="clear-fix form-field"></div>				
<div class="input-left"><div class="input-right"><dl>
 <dt><label for="category">Category for imported videos:</label></dt>
 </div> </div>
					    <div class="input-left"><div class="input-right">
                        <dd> 
<select name="category"> 						
<?php 
 $chsql = dbquery("SELECT * FROM `channels` order by cat_name ASC");
 echo '
 <option value=""/>None</option>
';
 while($row = mysql_fetch_array($chsql)){
echo '		
<option value="'.$row["cat_id"].'" />'.$row["cat_name"].'</option>';		
}			
?>	
</select>
              </dd>
 </dl></div></div><div class="clear-fix form-field"></div> 
<div class="clear-fix form-field field-searchsubmit form-field-submit">
<div class="input-left"><div class="input-right">
 <dl class="submit">
<input type="submit" name="submit" id="submit" value="Import feed" />
 </dl>	
 </div></div></div>
 <div class="clear-fix form-field"></div>
  </fieldset>
</form>				
</div>
<br/> <br/>

		</div>
		
			</div>	


   <div id="right">
<div class="block block-flushbottom">

    <div class="inner-block">
<h3>Latest actions</h3>
<?php if (!empty($last_msg)) {echo $last_msg; }?>
</div>
</div>
</div>

     </div><!-- end of right content-->

 <?php 
  include_once("foot.php");
 ?>