<?php include_once("security.php");
include_once("head.php");
 if(isset($_GET['delete'])){ 
	 $del = dbquery("DELETE from slider WHERE id = '".$_GET['delete']."'");
	 echo 'You deleted the slide with id : '.$_GET['delete'];
	 }
if(isset($_POST['image'])){ 
$image = str_replace("../", "", $_POST['image']);
$h2 = $_POST['h2'];
$h3 = $_POST['h3'];
$link = $_POST['link'];



$insertvideo = dbquery("INSERT INTO slider(`h2`,`h3`,`image`,`link`) VALUES ('".addslashes($h2)."','".addslashes($h3)."','".addslashes($image)."','".addslashes($link)."')"); 
echo "Video slide inserted successfull";
}

?>
 <div id="content" class="clear-fix">	 
<div id="left">

 <div class="block">

 <h2>Add a new slide</h2> 
 <div style="width:500px; margin:10px;">

<form id="imageform" method="post" enctype="multipart/form-data" action='ajaximage.php'>
Upload your image <input type="file" name="photoimg" id="photoimg" />
</form>
<div id='preview'>
</div>


</div>
 
 

<div class="inner-block" style="width:600px;padding-left:5px;">
					


<table class="table-data" cellspacing="0" cellpadding="0" border="0">

    <thead>

        <tr>

<th class="first center" style="width:5%;">ID</th>
<th class="first" style="width:35%">Video</a></th>
<th class="last" style="width:20%">Options</th>		</tr>

	</thead>

    <tbody>

	

<?php 

$chsql = dbquery("SELECT * FROM `slider` order by id DESC");

 while($row = mysql_fetch_array($chsql)){
echo '
<tr class="odd">		
<td class="first center" style="width:5%;">'.$row["id"].'</td>
<td>
<p><a href="../'.$row["image"].'" target="_blank"><img src=\'../'.$row["image"].'\'  width="200" heaight="200" class=\'preview\'></a></p>
<p>'.stripslashes($row["h2"]).' / '.stripslashes($row["h3"]).'</p>
<p><a href="'.$row["link"].'" target="_blank">'.$row["link"].'</a></p>

</td>

';
echo '
<td class="last options">
<a href="slider.php?delete='.$row["id"].'" title="Are you sure you want to delete this video?" class="mini-button mini-button-delete">Delete</a> </td>		

</tr>
';	
}			
?>	



	</tbody>

</table>
<br/> <br/>

		</div>
</div>
</div>
 <div id="right">
<div class="block block-flushbottom">

    <div class="inner-block">
<h3>This videos have most views (for consideration)</h3>
<center>
<?php 
$result=mysql_query("select youtube_id, views from videos WHERE views > 3 ORDER BY views DESC limit 0,8");
while($row = mysql_fetch_array($result))
{
echo "<strong>ID: </strong>".$row["youtube_id"]." <br />";
$videoThumbnail = 'http://i4.ytimg.com/vi/'.$row["youtube_id"].'/default.jpg';
echo '<img src="'.$videoThumbnail.'" /><br />';
echo "has ".$row["views"]." views <hr><br />";
}

?>
</center>
</div>
</div>
</div>
     </div><!-- end of right content-->

 <?php 
  include_once("foot.php");
 ?>