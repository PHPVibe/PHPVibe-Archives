<?php include_once("header.php"); 
$dbi = new sqli();
if(isset($_POST['title'])){ 

$cat_title = $_POST['title'];
$cat_description = $_POST['description'];
$yt_slug = seo_clean_url($_POST['title']);

$picture = $_POST['ch'];
$child = $_POST['child'];

$insertvideo = dbquery("INSERT INTO channels (`cat_name`, `child_of`, `picture`, `cat_desc`,  `yt_slug`) VALUES ('".addslashes($cat_title)."','".addslashes($child)."', '".addslashes($picture)."' , '".addslashes($cat_description)."', '".addslashes($yt_slug)."')"); 


echo 'Channel  '.$cat_title.' has been created succesfully.';
}
?>
	<div id="content">
<div class="box">
<div class="box-header"><h1>Create a new channel</h1></div>
<div class="box-content">
<form id="imageform" method="post" enctype="multipart/form-data" action='ajaxchannel.php'>
<input type="file" name="photoimg" id="photoimg" />
</form>
 <form action="create_channel.php" method="post" class="form">
<div class="formRow"> 
<label for="title">Channel title:</label>
 <div class="formRight">
 <input type="text" name="title" id="" size="54" value="" />
 <p class="tooltip"> The title of the channel</p>
 </div>
<div class="clear"></div>
</div>
<div class="formRow"> 
<label for="parent">Picture:</label>
 <div class="formRight">
<div id='preview'> </div>
  <p class="tooltip"> Picture preview</p>
<div class="clear"></div>
</div>
</div>
<div class="formRow"> 						
<label for="description">Description:</label>
<div class="formRight">
<textarea name="description" id="comments" rows="5" cols="36"></textarea>
<div class="clear"></div>
</div>
</div>
<div class="formRow"> 						
<label for="description">Child of:</label>
<div class="formRight">
<?php
$sidemenu_channel = "SELECT cat_id, cat_name FROM `channels` order by cat_name desc";
if ($sidecategories = $dbi->query($sidemenu_channel,0)) {
echo '<select name="child"> ';
echo '<option value="" selected=selected>Main channel/None</option>/">';
	foreach ($sidecategories as $row) {
echo '<option value="'.$row["cat_id"].'">'.$row["cat_name"].'</option>/">';
}
echo '</select>';
}
$dbi->disconnect(); ?>
<div class="clear"></div>
</div>
</div>
<div class="formRight">
   <input type="submit" name="submit" id="submit" value="Create channel" />
</div>
                
         </form>
            </div>


<br style="clear:both;">

		
	
</div>	
	</div>
	
<?php include_once("footer.php");?>