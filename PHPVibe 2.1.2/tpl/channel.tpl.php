    <!-- Main Content -->
    <section id="wrapper">		
    	<!-- Featured -->

<br />
 <!--BEGIN .pager description -->
                <div class="pager-description">

                    <p class="title"><?php print $channel_name; ?> <?php print $lang['channel']; ?></p>
                    <span class="accent-line goright"></span>
                
               
                </div>
				 <!--END .pager-description -->
<br />
<div class="page_wrap">
<div class="page_container box_alignleft sidebox">

<?php


$nr_query = "SELECT COUNT(*) FROM videos WHERE `category` = ".$channel_id;
$result = mysql_query($nr_query);
$numberofresults = mysql_result($result, 0);
$BrowsePerPage = 33;

$limit = 'LIMIT ' .($pageNumber - 1) * $BrowsePerPage .',' .$BrowsePerPage; 
$result=mysql_query("select * from videos WHERE `category` = ".$channel_id." order by ID DESC $limit");
?>
<div class="viboxes">
<ul>
<?php
$j = 1;
while($row = mysql_fetch_array($result))
{
		    $local_id =  $row["id"];
			$videoid = $row["youtube_id"];
			$videoThumbnail = 'http://i4.ytimg.com/vi/'.$videoid.'/0.jpg';
			$title = substr($row["title"], 0, 29);
			$full_title = str_replace("\"", "",$row["title"]);
			//$med_title = substr($videosData['videos'][$i]['title'], 0, 30);
			$url = $site_url.'video/'.$local_id.'/'.seo_clean_url($full_title) .'/';
			$duration = $row["duration"];
			$likeCount = $row["liked"];
			
			if (($j % 3 == 0)) { $the_float ="class=\"last\"";} else { $the_float ="";}
			
			
echo '<li style="margin-right:30px; margin-bottom:18px;" '.$the_float.'>
      <div class="content" style="width:200px;">
	  <div class="preview" style="height:125px;">
	  <div class="picture">
	  <div class="alpha">';
echo '<a href="'.$url.'" title="'.$full_title.'"><img src="'.$videoThumbnail.'" alt="'.$full_title.'" class ="resizeme" style="width:200px; height:125px;" /></a></div>';
echo '<div class="date"><div class="button-group"><a class="button red small icon clock" href="'.$url.'" >'.sec2hms($duration).'</a>  <a class="button red small icon heart" href="'.$url.'" >'.$likeCount.'</a><a class="button red small icon refresh repeat" href="http://www.youtube.com/watch?v='.$videoid.'">Now</a></div></div></div></div>
<div class="title"><a href="'.$url.'" title="'.$full_title.'">'.$title.'</a></div>
</div>
</li>
';
$j++;
		}
?>
</ul>
</div>

<?php
echo '<div class="clear"></div>';
$a = new pagination;	
$a->set_current($pageNumber);
$a->set_first_page(true);
$a->set_pages_items(12);
$a->set_per_page($BrowsePerPage);
$a->set_values($numberofresults);
$a->show_pages($pagi_url);
?>
</div>
</div>

<?php
include("sidebar.tpl.php");
?>



</div>