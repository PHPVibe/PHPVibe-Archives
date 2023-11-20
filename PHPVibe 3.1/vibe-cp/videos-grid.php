<?php $killform = true;
include_once("header.php");
$pageNumber = MK_Request::getQuery('page', 1);	
$pagi_url = $admin_link.'videos-grid.php?page=';
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
 if(isset($_POST['videos'])){ 
 $fields =$_POST['videos'];
 if (count($fields) > 0) { 
for ($i=0;$i<count($fields);$i++) { 
$del = dbquery("DELETE from videos WHERE id = '".$fields[$i]."'");
}
}
}
 
?>
	<div id="content">

<form action="" method="post">
    <div class="box">
  <div class="box-header">
 <div style="width:150px; padding:6px;float:left;"><input type="submit" name="submit" id="submit" class="" value="Delete selected" /></div><h1>Video Manager</h1> 
  </div>

  <table class="datatable" id="vidtable">
    <thead>
      <tr>
	  <th width="26px">-</th>
        <th width="26px">ID</th>
        <th width="116px" class="sorting_disabled">Thumb</th>
        <th>Video Title</th>
        <th width="100px" class="sorting_disabled">Actions</th>
      </tr>
    </thead>
	
	<?php
$vbox_result=mysql_query("select * from videos ORDER BY id DESC");		

while($video = mysql_fetch_array($vbox_result))
{
$vurl = parse_url($video["thumb"]);

if($vurl['scheme'] !== 'http'){
$video["thumb"] = $config->site->url.$video["thumb"];
}
$url = $site_url.'video/'.$video["id"].'/'.seo_clean_url($video["title"]) .'/';
              echo'  <tr>
			  <td><input type="checkbox" name="videos[]" value="'.$video["id"].'"></td>
			  <td>'.$video["id"].'</td>
                    <td><a href="'.$url.'" target="_blank" title="'.stripslashes($video["title"]).'">	<img src="'.$video["thumb"].'" alt="" style="width:110px;height:auto;" /></a></td>
					<td>'.stripslashes($video["title"]).'</td>
					 <td>
                        <a href="'.$pagi_current.'&delete='.$video["id"].'"title="Remove"><i class="icon-trash"></i></a>
                        <a href="'.$pagi_current.'&feature='.$video["id"].'"title="Feature video"><i class="icon-star"></i></a>
                        <a href="video_edit.php?id='.$video["id"].'" title="Edit"><i class="icon-pencil"></i></a>
                        
                    </td>
                     </tr>';
	}			
?>
     
    </tbody>

	</table>
</div>
     </form> 
      </div>

  
<br style="clear:both;">

	
	</div>
	
<?php include_once("footer.php");?>