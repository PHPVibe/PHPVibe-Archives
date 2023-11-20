<?php echo '<div class="phpvibe-box">
<div class="box-head-light"><h3>'.stripslashes($box_title).'</h3></div>
<div class="box-content">';
echo '<div class="viboxes">
<ul>';

while($video = mysql_fetch_array($vbox_result))
{
			$title = stripslashes(substr($video["title"], 0, 29));
			$full_title = stripslashes(str_replace("\"", "",$video["title"]));			
			$url = $site_url.'video/'.$video["id"].'/'.seo_clean_url($full_title) .'/';
			if ($video["nsfw"] == 1 ){
			$video["thumb"] = theme("images")."nsfw.small.png";
			}
		
echo '<li>
      <div class="content">	
	 <div class="vibox-thumb">
<a href="'.$url.'" title="'.$full_title.'"><img src="'.$video["thumb"].'" alt="'.$full_title.'" class="vibox-img"/></a>
 <span class="timer">'.sec2hms($video["duration"]).'</span>
 </div>
<div class="pluswrap">
 <div class="topline"><a href="'.$url.'" title="'.$full_title.'">'.$title.'</a></div>
 <div class="subline"> <div class="viewer">'.$video["views"].' </div> <div class="bigplus">'.$video["liked"].'</div> </div>
           </div>
	</div>	
	
</li>';
}
echo '</ul></div>
<br style="clear:both;"/>
</div>
</div>';
?>