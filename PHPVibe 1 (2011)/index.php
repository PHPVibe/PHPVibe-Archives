<?php
require_once("_inc.php");
require_once("library/video.func.php");
$head_title = array();
$head_desc = array();
$head_title[] = 'Welcome to phpVibe\'s Demo'; 
$head_desc[] = 'This shows you how phpVibe Basic Works'; 
include_once("tpl/php/global_header.php");
if ($_GET['nochanell'] == "1") { echo "<center><h1>Hmm...that channel looks empty, try the search ;)</h1></center>";}
?>

<div class="clearfix" id="main-content">
<div class="col col9">
  <div class="col-bkg clearfix">

	<h2><?php echo __("Recent videos");?></h2>
<div class="vibe_contain">
 <ul>
<?php 
if(!$string = $Cache->Load("mainvideosindex")){
                     $string = '';			 
					 $sql = dbquery("SELECT * FROM videos WHERE views > 1 ORDER BY id DESC LIMIT 0,12");
	
					 while($row = mysql_fetch_array($sql)){
	$new_id = $row["id"];	
	$new_yt = $row["youtube_id"];
	$new_title = $row["title"];
	$small_title = substr($new_title, 0, 50);  
    $new_description = $row["description"];
	$new_seo_url = $site_url.'video/'.$new_id.'/'.seo_clean_url($new_title) .'/';
	$new_duration = $row["duration"];
	
  $string .='<li>
                        	<div class="vibekeep">
                            	<a href="'.$new_seo_url.'"><img src="http://i4.ytimg.com/vi/'.$new_yt.'/default.jpg" width="147" height="99" alt="" />
                                	<span class="time">'.sec2hms($new_duration).'</span>
                                </a>
                            	<a href="http://www.youtube.com/watch?v='.$new_yt.'" title="'.$small_title.' on '.$config->site->name.'" class="addtoplaylist"><img src="'. $config->site->url.'tpl/images/plusicon.png" alt="" /></a>
                            </div>
							<div class="clear"></div>

                        	<p class="ttle"><a class="tip_trigger"  href="'.$new_seo_url.'">'.$small_title.' <span class="tip" style="width: 450px;"><img src="http://i4.ytimg.com/vi/'.$new_yt.'/default.jpg" style="float: left; margin-right: 20px;" alt="" /> 
 '.$new_description.'</span></a></p>
							
                        </li>';
						}
 $Cache->Save($string, "mainvideosindex");
}
echo $string;
?>
 </ul>



                </div>			
	

<h2>
<?php echo __("Most liked videos");?>
</h2>
<div class="vibe_contain">
 <ul>
<?php 
if(!$string = $Cache->Load("likedvideosindex")){
                     $string = '';			 
					 $sql = dbquery("SELECT * FROM videos WHERE views > 1 ORDER BY liked DESC LIMIT 0,16");
	
					 while($row = mysql_fetch_array($sql)){
	$new_id = $row["id"];	
	$new_yt = $row["youtube_id"];
	$new_title = $row["title"];
	$small_title = substr($new_title, 0, 50);  
    $new_description = $row["description"];
	$new_seo_url = $site_url.'video/'.$new_id.'/'.seo_clean_url($new_title) .'/';
	$new_duration = $row["duration"];
	
  $string .='<li>
                        	<div class="vibekeep">
                            	<a href="'.$new_seo_url.'"><img src="http://i4.ytimg.com/vi/'.$new_yt.'/default.jpg" width="147" height="99" alt="" />
                                	<span class="time">'.sec2hms($new_duration).'</span>
                                </a>
                            	<a href="http://www.youtube.com/watch?v='.$new_yt.'" title="'.$small_title.' on '.$config->site->name.'" class="addtoplaylist"><img src="'. $config->site->url.'tpl/images/plusicon.png" alt="" /></a>
                            </div>
							<div class="clear"></div>

                        	<p class="ttle"><a class="tip_trigger"  href="'.$new_seo_url.'">'.$small_title.' <span class="tip" style="width: 450px;"><img src="http://i4.ytimg.com/vi/'.$new_yt.'/default.jpg" style="float: left; margin-right: 20px;" alt="" /> 
 '.$new_description.'</span></a></p>
							
                        </li>';
						}
 $Cache->Save($string, "likedvideosindex");
}
echo $string;
?>
 </ul>



                </div>	


<h2><?php echo __("Most viewed videos");?></h2>
<div class="vibe_contain">
 <ul>
<?php 
if(!$string = $Cache->Load("viewedvideosindex")){
                     $string = '';			 
					 $sql = dbquery("SELECT * FROM videos WHERE views > 1 ORDER BY views DESC LIMIT 0,16");
	
					 while($row = mysql_fetch_array($sql)){
	$new_id = $row["id"];	
	$new_yt = $row["youtube_id"];
	$new_title = $row["title"];
	$small_title = substr($new_title, 0, 50);  
    $new_description = $row["description"];
	$new_seo_url = $site_url.'video/'.$new_id.'/'.seo_clean_url($new_title) .'/';
	$new_duration = $row["duration"];
	
  $string .='<li>
                        	<div class="vibekeep">
                            	<a href="'.$new_seo_url.'"><img src="http://i4.ytimg.com/vi/'.$new_yt.'/default.jpg" width="147" height="99" alt="" />
                                	<span class="time">'.sec2hms($new_duration).'</span>
                                </a>
                            	<a href="http://www.youtube.com/watch?v='.$new_yt.'" title="'.$small_title.' on '.$config->site->name.'" class="addtoplaylist"><img src="'. $config->site->url.'tpl/images/plusicon.png" alt="" /></a>
                            </div>
							<div class="clear"></div>

                        	<p class="ttle"><a class="tip_trigger"  href="'.$new_seo_url.'">'.$small_title.' <span class="tip" style="width: 450px;"><img src="http://i4.ytimg.com/vi/'.$new_yt.'/default.jpg" style="float: left; margin-right: 20px;" alt="" /> 
 '.$new_description.'</span></a></p>
							
                        </li>';
						}
 $Cache->Save($string, "viewedvideosindex");
}
echo $string;
?>
 </ul>



                </div>					
  </div>

</div>

<?php      
include_once("sidebar.php");
include_once("tpl/php/footer.php");
?>