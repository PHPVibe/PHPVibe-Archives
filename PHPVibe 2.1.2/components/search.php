<?php
$pageNumber = MK_Request::getQuery('page', 1);
$q = $Info->Get("term");
$qterm = str_replace(" ", "+",$Info->Get("term"));

if($config->video->searchmode == "2") {
//start sql mode
$sql_keyword = $qterm;
$BrowsePerPage = 30;

$nr_query = "SELECT COUNT(*) FROM videos WHERE title LIKE '%" .$sql_keyword. "%' OR description LIKE '%" .$sql_keyword. "%' OR tags LIKE '%" .$sql_keyword. "%'";
$result = mysql_query($nr_query);
$exec_nr = mysql_result($result, 0);

$limit = 'LIMIT ' .($pageNumber - 1) * $BrowsePerPage .',' .$BrowsePerPage; 
$in_order = "ORDER BY CASE WHEN title like '" .$sql_keyword. "%' THEN 1
                WHEN title like '%" .$sql_keyword. "%' THEN 2
               WHEN tags like '%" .$sql_keyword. "%' THEN 3
               WHEN description like '%" .$sql_keyword. "' THEN 4
               ELSE 5
          END, title";
$result1 = "SELECT id, youtube_id, title,duration FROM videos WHERE title LIKE '%" .$sql_keyword. "%' OR description LIKE '%" .$sql_keyword. "%' OR tags LIKE '%" .$sql_keyword. "%' ".$in_order." ".$limit; 
$result = dbquery($result1);


$pagi_url = $site_url.'show/'.$qterm.'/&page=';
include 'pagination.php';
$a = new pagination;	
$a->set_current($pageNumber);
$a->set_first_page(true);
$a->set_pages_items(12);
$a->set_per_page($BrowsePerPage);
$a->set_values($exec_nr);
$seo_title = $lang['show-pre-title']." ".ucfirst($Info->Get("term"))." ".$lang['show-aft-title'];
$seo_description = $lang['show-desc'] ." ".ucfirst($Info->Get("term"));
include_once("tpl/header.php");
include_once("tpl/search_sql.tpl.php");
include_once("tpl/footer.php");

} else {
//start youtube mode
$type = "1";
$display_type = "1";
$nb_display = "30";

$pagi_url = $site_url.'show/'.$qterm.'/&page=';
include 'pagination.php';
$a = new pagination;	
$a->set_current($pageNumber);
$a->set_first_page(true);
$a->set_pages_items(12);
$a->set_per_page($nb_display);
$a->set_values(420);
$seo_title = $lang['show-pre-title']." ".ucfirst($Info->Get("term"))." ".$lang['show-aft-title'];
$seo_description = $lang['show-desc'] ." ".ucfirst($Info->Get("term"));

include_once("tpl/header.php");
include_once("tpl/search.tpl.php");
include_once("tpl/footer.php");

} 


if(($config->video->tags == "1") &&(!is_numeric($Info->Get("term")))):
 //Update Tags
 $tag = ucfirst($Info->Get("term"));
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