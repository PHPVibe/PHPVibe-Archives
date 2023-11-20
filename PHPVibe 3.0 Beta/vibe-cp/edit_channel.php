<?php include_once("header.php"); 
if(isset($_POST['cat_id'])){ 
$catid = addslashes($_POST['cat_id']);
$cat_title = addslashes($_POST['title']);
$cat_description = addslashes($_POST['description']);
$yt_slug = addslashes($_POST['youtube']);
$old_child = $_POST['ch1'];
$new_child = $_POST['ch'];
if(!empty($new_child)) {
$child = $new_child;
} else {
$child = $old_child;
}
if (empty($yt_slug)) { 
$insertvideo = dbquery("UPDATE channels SET cat_name = '".$cat_title."', picture = '".$child."',cat_desc = '".$cat_description."'  WHERE cat_id	= '".$catid."'");		
} else {

$insertvideo = dbquery("UPDATE channels SET cat_name = '".$cat_title."', picture = '".$child."', yt_slug = '".$yt_slug."', cat_desc = '".$cat_description."'  WHERE cat_id	= '".$catid."'");		
}
if (empty($yt_slug)) { echo 'The slug for this channel has not been changed. <br />';} 
$message =  'Category  '.$cat_title.' has been updated.';
}
$local_id = $_GET['id'];

 $sql = dbquery("SELECT * FROM `channels` WHERE `cat_id` = '".$local_id."' LIMIT 0,3000");

while($row = mysql_fetch_array($sql)){
   $cat_id = $row["cat_id"];
    $description = $row["cat_desc"];
	$cat_title = $row["cat_name"];
	$attached = $row["yt_slug"];
	$c_child = $row["picture"];

}
?>
	<div id="content">
<div class="box">
<div class="box-header"><h1>Edit channel</h1></div>
<div class="box-content">
<form id="imageform" method="post" enctype="multipart/form-data" action='ajaxchannel.php'>
<input type="file" name="photoimg" id="photoimg" />
</form>
 <form action="edit_channel.php?id=<? echo $local_id;?>" method="post" class="form">
  <input type="hidden" name="cat_id" value="<? echo $local_id;?>" />
<div class="formRow"> 
<label for="title">Channel title:</label>
 <div class="formRight">
 <input type="text" name="title" id="" size="54" value="<? echo $cat_title;?>" />
 <p class="tooltip"> The title of the channel</p>
 </div>
<div class="clear"></div>
</div>
<div class="formRow"> 
<label for="parent">New picture [optional]:</label>
 <div class="formRight">
 <input type="hidden" name="ch1" id="ch1" size="4" value="<?php echo $c_child;?>"/>
<div id='preview'> </div>
  <p class="tooltip"> Picture preview</p>
<div class="clear"></div>
</div>
</div>
<div class="formRow"> 
<label for="slug">SEO slug:</label> 
<div class="formRight">
 <input type="text" name="slug" value="<?php echo $attached; ?>"  class="data input-text" size="54"/>
  <p class="tooltip"> Ex: great-videos , title-of-channel <br /> Leave blank if not sure!</p>
<div class="clear"></div>
</div>
</div>
<div class="formRow"> 						
<label for="description">Description:</label>
<div class="formRight">
<textarea name="description" id="comments" rows="5" cols="36"><? echo $description;?></textarea>
<div class="clear"></div>
</div>
</div>
<div class="formRight">
   <input type="submit" name="submit" id="submit" value="Update channel" />
</div>
                
         </form>
            </div>


<br style="clear:both;">

		
	
</div>	
	</div>
	
<?php include_once("footer.php");?>