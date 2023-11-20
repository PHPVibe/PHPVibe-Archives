<?php
include("sidebar.tpl.php");
$nr_query = "SELECT COUNT(*) FROM videos WHERE `category` = ".$channel_id;
$result = mysql_query($nr_query);
$numberofresults = mysql_result($result, 0);
$BrowsePerPage = 24;

$limit = 'LIMIT ' .($pageNumber - 1) * $BrowsePerPage .',' .$BrowsePerPage; 
$vbox_result=mysql_query("select * from videos WHERE `category` = ".$channel_id." order by ID DESC $limit");
$box_title = ucfirst($channel_name);
echo '<div class="main">';
include("video_box.tpl.php");
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
