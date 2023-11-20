<?php include_once("security.php");
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
echo 'Category  '.$cat_title.' has been updated.';
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
 include_once("head.php");
	 
	 ?>
 <div id="content" class="clear-fix">	 
<div id="left">

 <div class="block">

 <h2>Edit channel: <? echo $cat_title;?> </h2> 

    <div class="inner-block">
 <div style="width:500px; margin:10px;">

<form id="imageform" method="post" enctype="multipart/form-data" action='ajaxchannel.php'>
Upload and replace image <input type="file" name="photoimg" id="photoimg" />
</form>
</div>
 <div class="form">
         <form action="edit-channel.php?id=<?php echo $cat_id;?>" method="post" class="standard clear-fix large">
                <fieldset>
						 <input type="hidden" name="cat_id" value="<? echo $local_id;?>" />

                    <div class="input-left"><div class="input-right"><dl>
                        <dt><label for="title">Channel title:</label></dt>
                        <dd><input type="text" name="title" id="" size="54" value="<? echo $cat_title;?>" class="data input-text" /></dd>
                    </dl></div></div><div class="clear-fix form-field"></div>
<div class="input-left"><div class="input-right">
Old picture: <br />

<img src="<?php echo $c_child;?>" border="0" width="200" height="200"/>
</div></div><div class="clear-fix form-field"></div>
 <div class="input-left"><div class="input-right">
<input type="hidden" name="ch1" id="ch1" size="4" value="<?php echo $c_child;?>"/>
<dl>
 <dt><label for="parent">New Picture:</label></dt>
                        <dd> 
<div id='preview'>
</div>
              </dd>
 </dl></div></div><div class="clear-fix form-field"></div>  
          <div class="input-left"><div class="input-right"><dl>
                        <dt><label for="youtube">Slug:</label></dt>
                        <dd> 
						
						 <input type="text" name="youtube" value="<?php echo $attached; ?>"  class="data input-text" size="54"/>

						
              </dd>
                    </dl></div></div>
					
					<div class="clear-fix form-field"></div>         
                    <div class="input-left"><div class="input-right"><dl>
                        <dt><label for="description">Description:</label></dt>
                        <dd><textarea class="data input-textarea input-textarea-small" name="description" id="comments" rows="5" cols="36"><? echo $description;?></textarea></dd>
                    </dl></div></div><div class="clear-fix form-field"></div>  
<div class="clear-fix form-field field-searchsubmit form-field-submit"><div class="input-left"><div class="input-right">					
                     <dl class="submit">
                    <input type="submit" name="submit" id="submit" value="Save changes" />
					    </div></div></div>
                     </dl></div></div><div class="clear-fix form-field"></div>
                     
                     
                    
                </fieldset>
                
         </form>
         </div>  	 
     </div><!-- end of right content-->

   <div id="right">
<div class="block block-flushbottom">

    <div class="inner-block">
<h3>Channels</h3>
<table class="table-data table-supplement">
<thead>
<tr>
<th style="width:85%;">List of channels</th>
<th style="width:15%;">&nbsp;</th>
</tr>
</thead>
<tbody>
<?php
$cchsql = dbquery("SELECT * FROM `channels` order by cat_name ASC");
while($row = mysql_fetch_array($cchsql)){
echo '
<tr class="first">
<td><strong>'.$row["cat_name"].' </strong> (id : '.$row["cat_id"].') <br />   Slug: '.$row["yt_slug"].' </td>	
<td class="options"><a class="mini-button" href="edit-channel.php?id='.$row["cat_id"].'">Edit</a></td>
</tr>

';		
}			
?>	

</tbody>
</table>
	</div>
	</div>
  </div>
  </div>  
   </div>
      </div> 
 <?php 
  include_once("foot.php");
 ?>