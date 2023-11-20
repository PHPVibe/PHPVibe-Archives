<?php include_once("security.php");
if (!$user->getGroup()->isAdmin()) {
die("Login first!");
}
include_once("head.php");
	 if(isset($_GET['delete'])){ 
	 $del = dbquery("DELETE from videos WHERE id = '".$_GET['delete']."'");
	 echo 'You deleted the channel with id : '.$_GET['delete'];
	 }
	 ?>
 <div id="content" class="clear-fix">	 

 <h2>This are your videos</h2> 

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
$sql = dbquery("SELECT id FROM videos ORDER BY id DESC"); 
$nr = mysql_num_rows($sql);
$BrowsePerPage = 20;
$lastPage = ceil($nr / $BrowsePerPage);
if (isset($_GET['page'])) { 
    $pn = preg_replace('#[^0-9]#i', '', $_GET['page']); 
} else { 
    $pn = 1;
} 
$limit = 'LIMIT ' .($pn - 1) * $BrowsePerPage .',' .$BrowsePerPage; 
$chsql = dbquery("SELECT * FROM `videos` order by id DESC $limit");

 while($row = mysql_fetch_array($chsql)){
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
include '../components/pagination.php';
$url = $config->site->url.'admin/videos.php?page=';


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