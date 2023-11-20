<?php include("sidebar.tpl.php"); 
$nr_query = "SELECT COUNT(*) FROM playlists";
$result = mysql_query($nr_query);
$numberofresults = mysql_result($result, 0);
$BrowsePerPage = 24;
echo '<div class="main"><div class="phpvibe-box">
<div class="box-head-light"><h3>'.stripslashes($seo_title).'</h3></div>
<div class="box-content">';
echo '<div class="viboxes">
<ul>';
$limit = 'LIMIT ' .($pageNumber - 1) * $BrowsePerPage .',' .$BrowsePerPage; 
$vbox_result=mysql_query("SELECT playlists.*, (SELECT COUNT(*) FROM playlist_data WHERE playlist_data.playlist = playlists.id) AS number FROM playlists $limit");

while($video = mysql_fetch_array($vbox_result))
{
			$title = stripslashes(substr($video["title"], 0, 29));
			$full_title = stripslashes(str_replace("\"", "",$video["title"]));			
			$url = $site_url.'playlist/'.$video["id"].'/'.seo_clean_url($full_title) .'/';
		
echo '<li>
      <div class="content">	
	 <div class="vibox-thumb">
<a href="'.$url.'" title="'.$full_title.'"><img src="'.$video["picture"].'" alt="'.$full_title.'" class="vibox-img"/></a>
 <span class="timer">'.$video["number"].'</span>
 </div>
<div class="pluswrap">
 <div class="topline"><a href="'.$url.'" title="'.$full_title.'">'.$title.'</a></div>
</div>
</div>
	
</li>';
}
echo '</ul>
</div>
<br style="clear:both;"/>
</div>
</div>
';
?>



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