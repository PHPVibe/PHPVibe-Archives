<?php
$pageNumber = MK_Request::getQuery('page', 1);
$q = $router->fragment(1);
$qterm = str_replace(" ", "+",$q);

$sql_keyword = mysql_real_escape_string(cleanInput($q));
$BrowsePerPage = 20;
if(strlen($sql_keyword) > 3) {
$nr_query = "SELECT COUNT(*) FROM videos WHERE MATCH (title,description,tags) AGAINST('".$sql_keyword."')";
$result = mysql_query($nr_query);
$exec_nr = mysql_result($result, 0);
$limit = 'LIMIT ' .($pageNumber - 1) * $BrowsePerPage .',' .$BrowsePerPage; 
$result1 = "SELECT *, MATCH(title,description,tags) AGAINST ('".$sql_keyword."') AS score from videos WHERE MATCH (title,description,tags) AGAINST('".$sql_keyword."') order by score desc ".$limit."";
} else {
$nr_query = "SELECT COUNT(*) FROM videos WHERE title like '%".$sql_keyword."%' or description like '%".$sql_keyword."%' or tags like '%".$sql_keyword."%'";
$result = mysql_query($nr_query);
$exec_nr = mysql_result($result, 0);
$limit = 'LIMIT ' .($pageNumber - 1) * $BrowsePerPage .',' .$BrowsePerPage; 
$result1 = "SELECT * FROM videos WHERE title like '%".$sql_keyword."%' or description like '%".$sql_keyword."%' or tags like '%".$sql_keyword."%' order by views desc ".$limit."";
}
$vbox_result = dbquery($result1);


$pagi_url = $site_url.'show/'.$qterm.'/&page=';
$a = new pagination;	
$a->set_current($pageNumber);
$a->set_first_page(true);
$a->set_pages_items(12);
$a->set_per_page($BrowsePerPage);
$a->set_values($exec_nr);
$seo_title = $lang['show-pre-title']." ".ucfirst($q)." ".$lang['show-aft-title'];
$seo_description = $lang['show-desc'] ." ".ucfirst($q);
include_once("tpl/header.php");
include_once("tpl/search.tpl.php");
include_once("tpl/footer.php");




if(($config->video->tags == "1") &&(!is_numeric($q))):
 //Update Tags
 $tag = ucfirst($q);
  if($tag != "" && ereg("/",$tag) == 0):
	
		$check = dbrows(dbquery("SELECT tagid FROM tags WHERE tag='".$tag."'"));
		if($check == 0):
			dbquery("INSERT INTO tags VALUES (NULL, '".$tag."', '1')");
		else:
			dbquery("UPDATE tags SET tcount=tcount+1 WHERE tag='".$tag."'");
		endif;
	endif;
 endif;



?>