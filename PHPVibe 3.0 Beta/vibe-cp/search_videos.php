<?php include_once("header.php");
$pageNumber = MK_Request::getQuery('page', 1);	
$qterm = MK_Request::getQuery('s');	
$pagi_url = $admin_link.'search_videos.php?s='.$qterm.'&page=';
$pagi_current=$pagi_url.$pageNumber;
$BrowsePerPage = 32;
 if(isset($_GET['delete'])){ 
	 $del = dbquery("DELETE from videos WHERE id = '".$_GET['delete']."'");
	$message= 'Deleted # '.$_GET['delete'];
	 }
  if(isset($_GET['feature'])){ 
	$del = dbquery("UPDATE videos SET featured = '1' WHERE id = '".$_GET['feature']."'");
	$message= 'Featured # '.$_GET['feature'];
	 }	 
?>
	<div id="content">
<div class="box">
<div class="box-header"><h1>Browsing videos</h1></div>
<div class="box-content">
 <div class="searchWidget">
                    <form action="search_videos.php">
                        <input type="text" name="s" id="s" placeholder="Search videos" />
                        <input type="submit" value="" />
                    </form>
                </div>
<?php
$sql_keyword = CleanInput($qterm);
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
		
?>
<div id="large_grid">

            <ul>
<?php

while($video = mysql_fetch_array($vbox_result))
{
$url = $site_url.'video/'.$video["id"].'/'.seo_clean_url($video["title"]) .'/';
              echo' <li class="thumbnail" id="'.$video["id"].'">
                    <a href="'.$url.'" target="_blank" title="'.stripslashes($video["title"]).'">	<img src="'.$video["thumb"].'" alt="" /></a>
					<p>
                        <a href="'.$pagi_current.'&delete='.$video["id"].'"title="Remove"><i class="icon-trash"></i></a>
                        <a href="'.$pagi_current.'&feature='.$video["id"].'"title="Feature video"><i class="icon-star"></i></a>
                        <a href="video_edit.php?id='.$video["id"].'" title="Edit"><i class="icon-pencil"></i></a>
                        <span>'.stripslashes($video["title"]).'</span>
                    </p>
                    </li>';
	}			
?>
      </ul>

</div>	  

            </div>


<br style="clear:both;">

		
	
</div>	
<?php
echo '<div class="clear"></div>';
$a = new pagination;	
$a->set_current($pageNumber);
$a->set_first_page(true);
$a->set_pages_items(12);
$a->set_per_page($BrowsePerPage);
$a->set_values($exec_nr);
$a->show_pages($pagi_url);
?>
	</div>
	</div>
	
<?php include_once("footer.php");?>