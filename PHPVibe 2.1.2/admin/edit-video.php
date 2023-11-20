<?php include_once("security.php");
if (!$user->getGroup()->isAdmin()) {
die("Login first!");
}
if(isset($_POST['video_id'])){ 

$video_id = addslashes($_POST['video_id']);
$title = addslashes($_POST['title']);
$description = addslashes($_POST['description']);
$tags = addslashes($_POST['tags']);
$views = addslashes($_POST['views']);
$liked = addslashes($_POST['liked']);
$disliked = addslashes($_POST['disliked']);
$category = addslashes($_POST['cat']);

$insertvideo = dbquery("UPDATE videos SET title = '".$title."', description = '".$description."',tags = '".$tags."',views = '".$views."',liked = '".$liked."',disliked = '".$disliked."',category = '".$category."'  WHERE id	= '".$video_id."'");		


echo $title.' has been updated.';
}

$local_id = $_GET['id'];

 $sql = dbquery("SELECT * FROM `videos` WHERE `id` = '".$local_id."' LIMIT 0,3000");

while($row = mysql_fetch_array($sql)){
   $yt_id = $row["youtube_id"];
   $title = $row["title"];
   $description = $row["description"];
   $tags = $row["tags"];
   $category = $row["category"];
   $views = $row["views"];
   $liked = $row["liked"];
   $disliked = $row["disliked"];


}
 include_once("head.php");
	 
	 ?>
 <div id="content" class="clear-fix">	 
<div id="left">

 <div class="block">

 <h2>Edit Video: <? echo $title;?> </h2> 
 
     <div class="inner-block">
	 <div style="padding-left:30px;">
<iframe class="youtube-player" type="text/html" width="340" height="185" src="http://www.youtube.com/embed/<?php echo $yt_id;?>" frameborder="0">
</iframe>
</div>
 <div class="form">
         <form action="edit-video.php?id=<?php echo $local_id;?>" method="post" class="standard clear-fix large">
                <fieldset>
 <input type="hidden" name="video_id" value="<? echo $local_id;?>" />

<div class="input-left">
<div class="input-right">
<dl>
<dt><label for="title">Title:</label></dt>
 <dd><input type="text" name="title" id="" size="54" value="<? echo $title;?>" class="data input-text" /></dd>
</dl>
</div>
</div>
<div class="clear-fix form-field"></div>
<div class="input-left">
<div class="input-right">
<dl>
 <dt><label for="title">Tags (comma separated):</label></dt>
 <dd><input type="text" name="tags" id="" size="54" value="<? echo $tags;?>" class="data input-text" /></dd>
</dl>
</div>
</div>	
<div class="clear-fix form-field"></div>				
<div class="input-left">
<div class="input-right">
<dl>
<dt><label for="title">Views:</label></dt>
 <dd><input type="text" name="views" id="" size="54" value="<? echo $views;?>" class="data input-text" /></dd>
</dl>
</div>
</div>		
<div class="clear-fix form-field"></div>				
<div class="input-left">
<div class="input-right">
<dl>
<dt><label for="title">Liked:</label></dt>
<dd><input type="text" name="liked" id="" size="54" value="<? echo $liked;?>" class="data input-text" /></dd>
</dl>
</div>
</div>	
<div class="clear-fix form-field"></div>				
<div class="input-left">
<div class="input-right">
<dl>
<dt><label for="title">Disliked:</label></dt>
 <dd><input type="text" name="disliked" id="" size="54" value="<? echo $disliked;?>" class="data input-text" /></dd>
</dl>
</div>
</div>					
<div class="clear-fix form-field"></div>
<div class="input-left"><div class="input-right"><dl>
 <dt><label for="parent">Category:</label></dt>
                        <dd> 
<select name="cat"> 						
<?php 
 $chsql = dbquery("SELECT * FROM `channels` order by cat_name ASC");
 echo '
 <option value="'.$category.'"/>Keep Curent ('.$category.')</option>
';
 while($row = mysql_fetch_array($chsql)){
echo '		
<option value="'.$row["cat_id"].'" />'.$row["cat_name"].' ('.$row["cat_id"].')</option>';		
}			
?>	
</select>
              </dd>
 </dl></div></div><div class="clear-fix form-field"></div>  
<div class="clear-fix form-field"></div>         
<div class="input-left"><div class="input-right"><dl>
<dt><label for="description">Description:</label></dt>
<dd><textarea class="data input-textarea input-textarea-small" name="description" id="comments" rows="5" cols="36"><? echo $description;?></textarea></dd>
</dl></div></div>
<div class="clear-fix form-field"></div>  
<div class="clear-fix form-field field-searchsubmit form-field-submit"><div class="input-left"><div class="input-right">					
                     <dl class="submit">
                    <input type="submit" name="submit" id="submit" value="Save changes" />
					    </div></div></div>
                     </dl></div></div><div class="clear-fix form-field"></div>
                     
                     
                    
                </fieldset>
                
         </form>
         </div>  	 
     </div><!-- end of right content-->


  </div>  
   </div>
      </div> 
 <?php 
  include_once("foot.php");
 ?>