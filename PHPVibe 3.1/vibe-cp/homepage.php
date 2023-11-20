<?php include_once("header.php"); 
 if(isset($_GET['delete'])){ 
	 $del = dbquery("DELETE from ".DB_PREFIX."homepage WHERE id = '".intval($_GET['delete'])."'");
	 echo '<div class="msg-info">You deleted the home box with id : '.$_GET['delete'].'</div>';
	 }
if(isset($_POST['queries'])){ 
$insertvideo = dbquery("INSERT INTO homepage (`title`, `type`, `ident`, `querystring`, `total`, `order` ) VALUES ('".addslashes($_POST['title'])."', '2', '".addslashes($_POST['ident'])."', '".addslashes($_POST['queries'])."', '".addslashes($_POST['number'])."', '1')");		
}


?>
<div id="content">
<div class="box">
<div class="box-header"><h1>Homepage builder</h1></div>
<div class="box-content">


 <div id="easyhome">
                    <ul>

                <?php
$boxes_sql = dbquery("SELECT * FROM `homepage` order by `order` ASC");
while($row = mysql_fetch_array($boxes_sql)){ 
?>
<li id="recordsArray_<?php echo $row['id'];?>" class="sortable">
<div class="ns-row"><div class="ns-title"><?php echo $row['title'];?></div><div class="ns-actions"><a href="homepage.php?delete=<?php echo $row['id'];?>" class="delete-menu" title="Delete"><img src="img/cross.png" alt="Delete"></a></div></div>
 </li>
  <?php }  ?>
 </ul>
</div>	

	<div id="respo" style="display:none;"></div>		

			

 <div class="widget" style="width:100%;">
   <div class="title"><img src="img/icons/users.png" alt="" class="titleIcon" /><h6>New block</h6></div>
<form action="homepage.php" method="post" class="form">
<div class="column-left">
<div class="formRow"> 
<label for="title">Title:</label>
 <div class="formRight">
<input type="text" id="title" name="title">
 <p class="tooltip"> The title of the box container</p>
 </div>
<div class="clear"></div>
</div>	

<div class="formRow"> 
<label for="queries">Number of videos:</label>
 <div class="formRight">
 <input type="text" id="number" name="number">

<p class="tooltip"> Multiple of 4 is recomended</p>
 </div>
<div class="clear"></div>
</div>	
</div>
<div class="column-right">
<div class="formRow"> 
<label for="queries">Type:</label>
 <div class="formRight">
<select id="queries" name="queries">
<option value="most_viewed" selected>Most viewed videos</option>
<option value="top_rated">Most liked videos</option>
<option value="viral">New videos </option>
<option value="featured">Featured videos</option>
<option value="random">Random videos</option>
</select>
 <p class="tooltip"> Type of query the module does</p>
 </div>
<div class="clear"></div>
</div>	
<div class="formRow"> 
 <label for="channel">Channel</label>
 <div class="formRight">
<select name="ident">
<option value="" />ALL</option>
<?php				
 $chsql = dbquery("SELECT * FROM `channels` order by cat_name ASC");
 while($row = mysql_fetch_array($chsql)){
echo '			
<option value="'.$row["cat_id"].'" />'.$row["cat_name"].' </option>';		
}	?></select>
 <p class="tooltip"> Optional</p>
</div>
<div class="clear"></div>
</div>
	</div>
<div class="formRow"> 
<input type="submit" name="submit" id="submit" class="button blueB" value="Add video block" />
</div>
</form>

</div>	
</div>	

<br style="clear:both;">
	</div>
	
	</div>
<?php include_once("footer.php");?>