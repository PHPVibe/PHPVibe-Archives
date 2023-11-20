<?php include_once("header.php");
$dbi = new sqli();
$pageNumber = MK_Request::getQuery('page', 1);	
$pagi_url = $admin_link.'channels.php?page=';
$pagi_current=$pagi_url.$pageNumber;
$BrowsePerPage = 16;
 if(isset($_GET['delete'])){ 
	 $del = dbquery("DELETE from channels WHERE cat_id = '".$_GET['delete']."'");
	$message= 'Deleted channel # '.$_GET['delete'];
	 }

?>
	<div id="content">
<div class="box">
<div class="box-header"><h1>Browsing channels</h1></div>
<div class="box-content">
<?php

$nr_query = "SELECT COUNT(*) FROM channels";
$vbox_result = mysql_query($nr_query);
$numberofresults = mysql_result($vbox_result, 0);


$limit = 'LIMIT ' .($pageNumber - 1) * $BrowsePerPage .',' .$BrowsePerPage; 
$vbox_result=mysql_query("select * from channels ORDER BY cat_id DESC $limit");		
?>
<div id="large_grid">

            <ul>
<?php

while($video = mysql_fetch_array($vbox_result))
{
$url = $site_url.'channel/'.$video["yt_slug"] .'/';
              echo' <li class="thumbnail" id="'.$video["id"].'">
                    <a href="'.$url.'" target="_blank" title="'.stripslashes($video["cat_name"]).'">	<img src="'.$video["picture"].'" alt="" style="max-width:200px; height:150px;" /></a>
					<p>
                        <a href="'.$pagi_current.'&delete='.$video["cat_id"].'"title="Remove"><i class="icon-trash"></i></a>
                        <a href="edit_channel.php?id='.$video["cat_id"].'" title="Edit"><i class="icon-pencil"></i></a>
                        <span>'.stripslashes($video["cat_name"]);
						if(!is_null($video["child_of"])) {
						$child="select cat_name from channels where cat_id = '".$video["child_of"]."'";	
						if ($crow = $dbi->singlequery($child,0)) { 
						echo ' | Child of <b>'.$crow["cat_name"].'</b>';} }
						echo'</span>
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