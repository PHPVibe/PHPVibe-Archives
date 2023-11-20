<?php include("sidebar.tpl.php"); 
$nr_query = "SELECT COUNT(*) FROM channels";
$result = mysql_query($nr_query);
$numberofresults = mysql_result($result, 0);
$BrowsePerPage = 24;
echo '<div class="main"><div class="phpvibe-box">
<div class="box-head-light"><h3>'.stripslashes($seo_title).'</h3></div>
<div class="box-content">';
echo '<div class="viboxes">
<ul>';
$limit = 'LIMIT ' .($pageNumber - 1) * $BrowsePerPage .',' .$BrowsePerPage; 
$result=mysql_query("select picture,yt_slug,cat_name from channels order by cat_id DESC $limit");
while($rrow = mysql_fetch_array($result)){
    $full_title = $rrow['cat_name'];
	$url = $site_url.'channel/'.$rrow['yt_slug'].'/';
	
	echo '<li>
      <div class="content">	
	 <div class="vibox-thumb">
<a href="'.$url.'" title="'.$full_title.'"><img src="'.$rrow["picture"].'" alt="'.$full_title.'" class="vibox-img"/></a>
 </div>
<div class="pluswrap">
 <div class="topline"><a href="'.$url.'" title="'.$full_title.'">'.$full_title.'</a></div>
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