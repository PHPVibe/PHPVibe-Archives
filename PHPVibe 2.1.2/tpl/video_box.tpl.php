<?php
$limit =  $row["total"];


if($iden == "most_viewed"):
$vbox_result = dbquery("select * from videos WHERE views > 0 ORDER BY views DESC limit 0,$limit");

elseif($iden == "top_rated"):
$vbox_result = dbquery("select * from videos WHERE liked > 0 ORDER BY liked DESC limit 0, $limit");

elseif($iden == "featured"):
$vbox_result = dbquery("select * from videos WHERE featured = '1' ORDER BY id DESC limit 0, $limit");

else:
$vbox_result = dbquery("select * from videos WHERE views > 0 ORDER BY id DESC limit 0, $limit");

endif;

echo '<h2 class="title-line alignright">'.stripslashes($row["title"]).'</h2>';
echo '<div class="viboxes">
<ul>';


$j = 1;

while($row = mysql_fetch_array($vbox_result))
{
		    $local_id =  $row["id"];
			$videoid = $row["youtube_id"];
			$videoThumbnail = 'http://i4.ytimg.com/vi/'.$videoid.'/0.jpg';
			$title = substr($row["title"], 0, 29);
			$full_title = str_replace("\"", "",$row["title"]);
			//$med_title = substr($videosData['videos'][$i]['title'], 0, 30);
			$url = $site_url.'video/'.$local_id.'/'.seo_clean_url($full_title) .'/';
			$duration = $row["duration"];
			$viewCount = $row["views"];
			
			if (($j % 3 == 0)) { $the_float ="class=\"last\"";} else { $the_float ="";}
			
			
echo '<li style="margin-right:30px; margin-bottom:18px;" '.$the_float.'>
      <div class="content" style="width:200px;">
	  <div class="preview" style="height:125px;">
	  <div class="picture">
	  <div class="alpha">';
echo '<a href="'.$url.'" title="'.$full_title.'"><img src="'.$videoThumbnail.'" alt="'.$full_title.'" class ="resizeme" style="width:200px; height:125px;" /></a></div>';
echo '<div class="date"><div class="button-group"><a class="button red small icon clock" href="'.$url.'" >'.sec2hms($duration).'</a><a class="button red small icon trend" href="'.$url.'" >'.$viewCount.'</a><a class="button red small icon refresh repeat" href="http://www.youtube.com/watch?v='.$videoid.'">Now</a></div></div></div></div>
<div class="title"><a href="'.$url.'" title="'.$full_title.'">'.$title.'</a></div>
</div>
</li>
';
$j++;
		}

?>