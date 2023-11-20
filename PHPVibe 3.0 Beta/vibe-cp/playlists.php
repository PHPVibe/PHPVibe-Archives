<?php include_once("header.php");
$pageNumber = MK_Request::getQuery('page', 1);	
$pagi_url = $admin_link.'playlists.php?page=';
$pagi_current=$pagi_url.$pageNumber;
$BrowsePerPage = 16;
 if(isset($_GET['delete'])){ 
	 $del = dbquery("DELETE from playlists WHERE id = '".$_GET['delete']."'");
	$message= 'Deleted playlists # '.$_GET['delete'];
	 }

?>
	<div id="content">
<div class="box">
<div class="box-header"><h1>Browsing playlists</h1></div>
<div class="box-content">
<?php

$nr_query = "SELECT COUNT(*) FROM playlists";
$vbox_result = mysql_query($nr_query);
$numberofresults = mysql_result($vbox_result, 0);


$limit = 'LIMIT ' .($pageNumber - 1) * $BrowsePerPage .',' .$BrowsePerPage; 
$vbox_result=mysql_query("select * from playlists ORDER BY id DESC $limit");		
?>
<div id="large_grid">

            <ul>
<?php

while($video = mysql_fetch_array($vbox_result))
{
$url = $site_url.'playlist/'.$video["id"] .'/'.seo_clean_url($video["title"]) .'/';
              echo' <li class="thumbnail" id="'.$video["id"].'">
                    <a href="'.$url.'" target="_blank" title="'.stripslashes($video["title"]).'">	<img src="'.$video["picture"].'" alt="" /></a>
					<p>
                        <a href="'.$pagi_current.'&delete='.$video["id"].'"title="Remove"><i class="icon-trash"></i></a>
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
$a->set_values($numberofresults);
$a->show_pages($pagi_url);
?>
	</div>
	</div>
	
<?php include_once("footer.php");?>