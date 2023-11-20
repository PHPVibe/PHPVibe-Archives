<?php
require_once("_inc.php");
require_once("library/video.func.php");
$sql = dbquery("SELECT id FROM videos where views > 2 ORDER BY id DESC"); 
$nr = mysql_num_rows($sql);
if (isset($_GET['pn'])) { 
    $pn = preg_replace('#[^0-9]#i', '', $_GET['pn']); 
} else { 
    $pn = 1;
} 
$BrowsePerPage = 40;
$lastPage = ceil($nr / $BrowsePerPage);
$head_title = array();
$head_desc = array();
$head_title[] = 'Most Viewed Videos. Page '.$pn.' of '.$lastPage; 
$head_desc[] = 'Showing the most viewed videos. Curent Page it\'s '.$pn; 
include_once("tpl/php/global_header.php");
?>
<div class="clearfix" id="main-content">
<div class="col col9">
  <div class="col-bkg clearfix">
    <h1><?php echo __("Most Viewed Videos");?></h1>

<div class="vibe_contain">
 <ul>
<?php 
$limit = 'LIMIT ' .($pn - 1) * $BrowsePerPage .',' .$BrowsePerPage; 
 $sql = dbquery("SELECT * FROM videos WHERE views > 2 ORDER BY views DESC $limit");
 while($row = mysql_fetch_array($sql)){
	$new_id = $row["id"];	
	$new_yt = $row["youtube_id"];
	$new_title = $row["title"];
	$small_title = substr($new_title, 0, 50);  
    $new_description = $row["description"];
	$new_seo_url = $site_url.'video/'.$new_id.'/'.seo_clean_url($new_title) .'/';
	$new_duration = $row["duration"];
	$new_viewes = $row["views"];
	
  $string .='<li>
                        	<div class="vibekeep">
                            	<a href="'.$new_seo_url.'"><img src="http://i4.ytimg.com/vi/'.$new_yt.'/default.jpg" width="147" height="99" alt="" />
                                	<span class="time">'.sec2hms($new_duration).'</span>
									<span class="iviewed">'.$new_viewes.' '.__("views").'</span>
                                </a>
                            	<a href="http://www.youtube.com/watch?v='.$new_yt.'" title="'.$small_title.' on '.$config->site->name.'" class="addtoplaylist"><img src="'. $config->site->url.'tpl/images/plusicon.png" alt="" /></a>
                            </div>
							<div class="clear"></div>

<p class="ttle"><a class="tip_trigger"  href="'.$new_seo_url.'">'.$small_title.' <span class="tip" style="width: 450px;"><img src="http://i4.ytimg.com/vi/'.$new_yt.'/default.jpg" style="float: left; margin-right: 20px;" alt="" /> 
 '.$new_description.'</span></a></p>							
                        </li>';
						}

echo $string;
?>
 </ul>



                </div>		

<?php
   include 'library/pagination.php';
   $url = $config->site->url.'viewed/page-';


$a = new pagination;	

$a->set_current($pn);

$a->set_pages_items(12);

$a->set_per_page($BrowsePerPage);

$a->set_values($nr);

$a->show_pages($url);
     ?>				
  </div>

</div>
<?php      
include_once("sidebar.php");
include_once("tpl/php/footer.php");
?>