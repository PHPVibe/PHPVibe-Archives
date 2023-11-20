<?php include_once("security.php");
include_once("head.php");
 if(isset($_GET['delete'])){ 
	 $del = dbquery("UPDATE videos SET featured = ' ' WHERE id = '".$_GET['delete']."'");
	 
	 
	 echo 'You unfeatured the video with id : '.$_GET['delete'];
	 }

?>
 <div id="content" class="clear-fix">	 


 <div class="block">

					


<table class="table-data" cellspacing="0" cellpadding="0" border="0">

    <thead>

        <tr>

<th class="first center" style="width:5%;">ID</th>
<th class="first" style="width:35%">Video</a></th>
<th class="last" style="width:20%">Options</th>		</tr>

	</thead>

    <tbody>

	

<?php 

$chsql = dbquery("SELECT * FROM `videos` WHERE featured = '1' order by id DESC");

 while($row = mysql_fetch_array($chsql)){
echo '
<tr class="odd">		
<td class="first center" style="width:5%;">'.$row["id"].'</td>
<td>
<a href="http://www.youtube.com/watch?v='.$row["youtube_id"].'" class="lightbox"><img src="http://i4.ytimg.com/vi/'.$row["youtube_id"].'/default.jpg"/></a>
<br /> '.$row["title"].'
</td>

';
echo '
<td class="last options">
<a href="featured.php?delete='.$row["id"].'" title="Are you sure you want to unfeature this video?" rel="record delete" class="mini-button mini-button-delete">Remove featured</a> </td>		

</tr>
';	
}			
?>	



	</tbody>

</table>
<br/> <br/>

		</div>


     </div><!-- end of right content-->

 <?php 
  include_once("foot.php");
 ?>