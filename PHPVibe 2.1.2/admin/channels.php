<?php include_once("security.php");
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
<th style="width:30%">Picture</a></th>
<th style="width:10%">Slug</a></th>
<th class="last" style="width:20%">Options</th>		</tr>

	</thead>

    <tbody>

	

<?php 
 $chsql = dbquery("SELECT * FROM `channels` order by cat_id ASC");
 while($row = mysql_fetch_array($chsql)){
echo '
<tr class="odd">		
<td class="first center" style="width:5%;">'.$row["cat_id"].'</td>
<td>'.$row["cat_name"].'</td>';
if ($row["picture"] != "0")
{
echo '<td><img src="'.$row["picture"].'"border="0" width="140" height="100"/></td>';
} else 

{
echo '<td>None</td>';

}
if ($row["yt_slug"] != "N")
{
echo '<td><a href="'.$site_url.'channel/'.$row["yt_slug"].'/" target="_blank">'.$row["yt_slug"].'</a></td>';
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