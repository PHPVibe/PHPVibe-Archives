<?php include_once("../_inc.php");
if (!$user->getGroup()->isAdmin()) {
die("Login first!");
}
include_once("head.php");
	 if(isset($_GET['delete'])){ 
	 $del = dbquery("DELETE from channels WHERE cat_id = '".$_GET['delete']."'");
	 echo 'You deleted the channel with id : '.$_GET['delete'];
	 }
	 ?>
 <div id="content" class="clear-fix">	 


 <div class="block">

 <h2>This are your channels</h2> 

<div class="inner-block" style="width:95%;padding-left:20px;">
					

<table class="table-data" cellspacing="0" cellpadding="0" border="0">

    <thead>

        <tr>

<th class="first center" style="width:5%;">ID</th>
<th class="first" style="width:20%">Title</a></th>
<th style="width:10%">Parent</a></th>
<th style="width:10%">Youtube</a></th>
<th class="last" style="width:10%">Options</th>		</tr>

	</thead>

    <tbody>

	

<?php 
 $chsql = dbquery("SELECT * FROM `channels` order by cat_id ASC");
 while($row = mysql_fetch_array($chsql)){
echo '
<tr class="odd">		
<td class="first center" style="width:5%;">'.$row["cat_id"].'</td>
<td>'.$row["cat_name"].'</td>';
if ($row["child_of"] != "0")
{
echo '<td>'.$row["child_of"].'</td>';
} else 

{
echo '<td>None</td>';

}
if ($row["yt_slug"] != "N")
{
echo '<td>'.$row["yt_slug"].'</td>';
} else 

{
echo '<td>None</td>';

}
echo '
<td class="last options"><a href="edit-channel.php?id='.$row["cat_id"].'" title="Make changes to this record" class="mini-button mini-button-edit">Edit</a> 
<a href="channels.php?delete='.$row["cat_id"].'" title="Are you sure you want to delete this record and all related records?" rel="record delete" class="mini-button mini-button-delete">Delete</a> </td>		

</tr>
';	
}			
?>	



	</tbody>

</table>
</div>	 
     </div><!-- end of right content-->

 <?php 
  include_once("foot.php");
 ?>