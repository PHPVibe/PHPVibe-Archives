<?php include_once("security.php");
include_once("head.php");
if(isset($_POST['search_key'])):
$keyword = $_POST['search_key'];
else:
$keyword = $_GET['search_key'];
endif;
 
$sql_keyword = $keyword;
$sql = dbquery("SELECT id FROM videos WHERE title LIKE '%" .$sql_keyword. "%' OR description LIKE '%" .$sql_keyword. "%' OR tags LIKE '%" .$sql_keyword. "%' ORDER BY id DESC"); 
$nr = mysql_num_rows($sql); 
//echo $sql_keyword;
	 ?>
 <div id="content" class="clear-fix">	 



 <div class="block">
 <div class="inner-block" style="width:95%;padding-left:20px;">
 <h2>Search results for <?php echo $sql_keyword;?> </h2> 

<table class="table-data" cellspacing="0" cellpadding="0" border="0">

    <thead>

        <tr>

<th class="first center" style="width:5%;">ID</th>
<th class="first" style="width:20%">Title</a></th>
<th style="width:10%">Thumb</a></th>
<th style="width:3%">Views</a></th>
<th style="width:3%">Likes</a></th>
<th class="last" style="width:14%">Options</th>		</tr>

	</thead>

    <tbody>

	

<?php 

$BrowsePerPage = 20;
$lastPage = ceil($nr / $BrowsePerPage);
if (isset($_GET['page'])) { 
    $pn = preg_replace('#[^0-9]#i', '', $_GET['page']); 
} else { 
    $pn = 1;
} 
$limit = 'LIMIT ' .($pn - 1) * $BrowsePerPage .',' .$BrowsePerPage; 
$in_order = " ORDER BY CASE WHEN title like '" .$sql_keyword. "%' THEN 0
               WHEN title like '% %" .$sql_keyword. "% %' THEN 1			   
               WHEN title like '%" .$sql_keyword. "' THEN 2
			   WHEN title like '%" .$sql_keyword. "%' THEN 3
               ELSE 4
          END, title";
$result = dbquery("SELECT id, youtube_id, title,views,liked FROM videos WHERE title LIKE '%" .$sql_keyword. "%' OR description LIKE '%" .$sql_keyword. "%' OR tags LIKE '%" .$sql_keyword. "%'".$in_order." ".$limit.""); 
while($row=mysql_fetch_array($result)) {
echo '
<tr class="odd">		
<td class="first center" style="width:5%;">'.$row["id"].'</td>
<td>'.$row["title"].'</td>
<td><a href="http://www.youtube.com/watch?v='.$row["youtube_id"].'" class="lightbox"><img src="http://i4.ytimg.com/vi/'.$row["youtube_id"].'/default.jpg"/></a></td>
<td>'.$row["views"].'</td>
<td>'.$row["liked"].'</td>';

echo '
<td class="last options">
<a href="videos.php?feat='.$row["id"].'" title="Feature this record" class="mini-button mini-button-edit">Set as Featured</a> <br /> <br />
<a href="edit-video.php?id='.$row["id"].'" title="Make changes to this record" class="mini-button mini-button-edit">Edit</a> 
<a href="videos.php?delete='.$row["id"].'" title="Are you sure you want to delete this video?" rel="record delete" class="mini-button mini-button-delete">Delete</a> </td>		

</tr>
';	
}			
?>	



	</tbody>

</table>
<br/> <br/>
<div class="clear-fix">
<?php
include '../components/pagination.php';
$url = $config->site->url.'admin/search.php?key='.$keyword.'&page=';


$a = new pagination;	

$a->set_current($pn);

$a->set_pages_items(5);

$a->set_per_page(20);

$a->set_values($nr);

$a->show_pages($url);
     ?>	
	 
</div>	 
</div>
     </div><!-- end of right content-->

 <?php 
  include_once("foot.php");
 ?>