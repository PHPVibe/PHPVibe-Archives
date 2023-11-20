<?php include_once("header.php");
$pageNumber = MK_Request::getQuery('page', 1);	
$pagi_url = $admin_link.'featured.php?page=';
$pagi_current=$pagi_url.$pageNumber;
$BrowsePerPage = 40;
 if(isset($_GET['delete'])){ 
	$del = dbquery("UPDATE videos SET featured = ' ' WHERE id = '".$_GET['delete']."'");
	$message= 'Unfeatured # '.$_GET['delete'];
	 }
?>
	<div id="content">
<div class="box">
<div class="box-header"><h1>Browsing videos</h1></div>
<div class="box-content">
<?php

$nr_query = "SELECT COUNT(*) FROM videos WHERE featured = '1'";
$vbox_result = mysql_query($nr_query);
$numberofresults = mysql_result($vbox_result, 0);


$limit = 'LIMIT ' .($pageNumber - 1) * $BrowsePerPage .',' .$BrowsePerPage; 
$vbox_result=mysql_query("select * from videos WHERE featured = '1' ORDER BY id DESC $limit");		
?>
<div id="large_grid">

            <ul>
<?php

while($video = mysql_fetch_array($vbox_result))
{
$vurl = parse_url($video["thumb"]);

if($vurl['scheme'] !== 'http'){
$video["thumb"] = $config->site->url.$video["thumb"];
}
$url = $site_url.'video/'.$video["id"].'/'.seo_clean_url($video["title"]) .'/';
              echo' <li class="thumbnail" id="'.$video["id"].'">
                    <a href="'.$url.'" target="_blank" title="'.$video["title"].'">	<img src="'.$video["thumb"].'" alt="" style="max-width:200px; height:150px;"/></a>
					<p> <a href="'.$pagi_current.'&delete='.$video["id"].'"title="Unfeature"><i class="icon-star-empty"></i></a>
                   <span>'.$video["title"].'</span>
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