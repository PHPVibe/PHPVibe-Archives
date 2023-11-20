<?php include_once("../_inc.php");
if (!$user->getGroup()->isAdmin()) {
die("Login first!");
}
if(isset($_POST['title'])){ 

$cat_title = $_POST['title'];
$cat_description = $_POST['description'];
$yt_slug = $_POST['youtube'];
$child = $_POST['ch'];


$insertvideo = dbquery("INSERT INTO channels (`cat_name`, `child_of`, `cat_desc`,  `yt_slug`) VALUES ('".addslashes($cat_title)."', '".addslashes($child)."' , '".addslashes($cat_description)."', '".addslashes($yt_slug)."')"); 


echo 'Channel  '.$cat_title.' has been created succesfully.';
}
 include_once("head.php");
	 
	 ?>
 <div id="content" class="clear-fix">	 
<div id="left">

 <div class="block">

 <h2>Add a new channel:</h2> 

    <div class="inner-block">

 <div class="form">
         <form action="create-channel.php" method="post" class="standard clear-fix large">
                <fieldset>
                    <div class="input-left"><div class="input-right"><dl>
                        <dt><label for="title">Channel title:</label></dt>
                        <dd><input type="text" name="title" id="" size="54" value="<? echo $cat_title;?>" class="data input-text" /></dd>
                    </dl></div></div><div class="clear-fix form-field"></div>
<div class="input-left"><div class="input-right"><dl>
 <dt><label for="parent">Parent category:</label></dt>
                        <dd> 
<select name="ch"> 						
<?php 
 $chsql = dbquery("SELECT * FROM `channels` order by cat_name ASC");
 echo '
<option value="N"/>None (Main Level)</option>';
 while($row = mysql_fetch_array($chsql)){
echo '		
<option value="'.$row["cat_id"].'" />'.$row["cat_name"].'</option>';		
}			
?>	
</select>
              </dd>
 </dl></div></div><div class="clear-fix form-field"></div>  
          <div class="input-left"><div class="input-right"><dl>
                        <dt><label for="youtube">Youtube category:</label></dt>
                        <dd> 
<select name="youtube"> 						
<?php 
 $csql = dbquery("SELECT * FROM `categories` order by cat_name ASC");
 echo '
<option value="N"/>None (independent)</option>';
 while($row = mysql_fetch_array($csql)){
echo '		
<option value="'.$row["yt_slug"].'" />'.$row["cat_name"].'</option>';		
}			
?>	
</select>
              </dd>
                    </dl></div></div><div class="clear-fix form-field"></div>         
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
<td><strong>'.$row["cat_name"].' </strong> (id : '.$row["cat_id"].') <br />  Child of : '.$row["child_of"].' <br /> Yt: '.$row["yt_slug"].' </td>	
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