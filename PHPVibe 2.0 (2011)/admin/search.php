<?php include_once("../_inc.php");
if (!$user->getGroup()->isAdmin()) {
die("Login first!");
}
include_once("head.php");
if(isset($_POST['search_key'])):
$keyword = $_POST['search_key'];
else:
$keyword = $_GET['key'];
endif;
 
$sql_keyword = $keyword;
$sql = dbquery("SELECT id FROM videos WHERE title LIKE '%" .$sql_keyword. "%' OR description LIKE '%" .$sql_keyword. "%' OR tags LIKE '%" .$sql_keyword. "%' ORDER BY id DESC"); 
$nr = mysql_num_rows($sql); 
	 ?>
 <div id="content" class="clear-fix">	 

 <h2>Videos which contain <?php echo $keyword; ?></h2> 

<form action="search.php" method="post" class="standard clear-fix large">
			<div class="input-left">
<div class="input-right">
            <input type="text" name="search_key" class="input-text" value="search videos by title" onclick="this.value=''" /> 
			</div>
			</div>
            </form>         		

 <div class="block">
 <div class="inner-block" style="width:95%;padding-left:20px;">


<table class="table-data" cellspacing="0" cellpadding="0" border="0">

    <thead>

        <tr>

<th class="first center" style="width:5%;">ID</th>
<th class="first" style="width:20%">Title</a></th>
<th style="width:10%">Views</a></th>
<th style="width:10%">Likes/Dislikes</a></th>
<th class="last" style="width:10%">Options</th>		</tr>

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
               ELSE 3
          END, title";
$result = dbquery("SELECT id, title,views,liked,disliked FROM videos WHERE title LIKE '%" .$sql_keyword. "%' OR description LIKE '%" .$sql_keyword. "%' OR tags LIKE '%" .$sql_keyword. "%'".$in_order." ".$limit.""); 
while($row=mysql_fetch_array($result)) {
echo '
<tr class="odd">		
<td class="first center" style="width:5%;">'.$row["id"].'</td>
<td>'.$row["title"].'</td>
<td>'.$row["views"].'</td>
<td>'.$row["liked"].' / '.$row["disliked"].'</td>';

echo '
<td class="last options"><a href="edit-video.php?id='.$row["id"].'" title="Make changes to this record" class="mini-button mini-button-edit">Edit</a> 
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
include '../library/pagination.php';
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