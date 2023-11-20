<?php
include("sidebar.tpl.php");
?>
<?php
$BrowsePerPage = 20;

switch($router->fragment(1)){
case "most-viewed":
$nr_query = "SELECT COUNT(*) FROM videos WHERE views > 1";
$vbox_result = mysql_query($nr_query);
$numberofresults = mysql_result($vbox_result, 0);
$limit = 'LIMIT ' .($pageNumber - 1) * $BrowsePerPage .',' .$BrowsePerPage; 
$vbox_result=mysql_query("select * from videos WHERE views > 1 ORDER BY views DESC $limit");
$h1 = $lang['most-viewed'];
$focus = "views";
$icon= "trend";

break;	

case "most-liked":

$nr_query = "SELECT COUNT(*) FROM videos WHERE liked > 3";
$vbox_result = mysql_query($nr_query);
$numberofresults = mysql_result($vbox_result, 0);


$limit = 'LIMIT ' .($pageNumber - 1) * $BrowsePerPage .',' .$BrowsePerPage; 
$vbox_result=mysql_query("select * from videos WHERE liked > 3 ORDER BY liked DESC $limit");
$h1 = $lang['most-liked'];
$focus = "liked";
$icon= "heart";
break;	
case "featured":

$nr_query = "SELECT COUNT(*) FROM videos WHERE featured = '1'";
$vbox_result = mysql_query($nr_query);
$numberofresults = mysql_result($vbox_result, 0);


$limit = 'LIMIT ' .($pageNumber - 1) * $BrowsePerPage .',' .$BrowsePerPage; 
$vbox_result=mysql_query("select * from videos WHERE featured = '1' ORDER BY id DESC $limit");
$h1 = $lang['featured'];
break;	
default:
		

$nr_query = "SELECT COUNT(*) FROM videos";
$vbox_result = mysql_query($nr_query);
$numberofresults = mysql_result($vbox_result, 0);


$limit = 'LIMIT ' .($pageNumber - 1) * $BrowsePerPage .',' .$BrowsePerPage; 
$vbox_result=mysql_query("select * from videos ORDER BY id DESC $limit");		
$h1 = $lang['browse'];	
break;	
}
$box_title = ucfirst($h1);
?>

<div class="main">

<?php
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