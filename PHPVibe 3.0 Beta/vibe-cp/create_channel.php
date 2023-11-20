<?php include_once("header.php"); 
if(isset($_POST['title'])){ 

$cat_title = $_POST['title'];
$cat_description = $_POST['description'];
if(isset($_POST['slug']) && !empty($_POST['slug'])) {
$yt_slug = seo_clean_url($_POST['slug']); } else {
$yt_slug = seo_clean_url($_POST['title']);
}
$child = $_POST['ch'];


$insertvideo = dbquery("INSERT INTO channels (`cat_name`, `picture`, `cat_desc`,  `yt_slug`) VALUES ('".addslashes($cat_title)."', '".addslashes($child)."' , '".addslashes($cat_description)."', '".addslashes($yt_slug)."')"); 


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
<label for="slug">Permalink:</label> 
<div class="formRight">
 <input type="text" name="slug" value=""  class="data input-text" size="54"/>
  <p class="tooltip"> Ex: great-videos , title-of-channel <br /> Leave blank if not sure!</p>
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
<div class="formRight">
   <input type="submit" name="submit" id="submit" value="Create channel" />
</div>
                
         </form>
            </div>


<br style="clear:both;">

		
	
</div>	
	</div>
	
<?php include_once("footer.php");?>