<?php include_once("header.php"); 
 if(isset($_GET['delete'])){ 
	 $del = dbquery("DELETE from homepage WHERE id = '".$_GET['delete']."'");
	 $message= 'You deleted the home box with id : '.$_GET['delete'];
	 }
if(isset($_POST['queries'])){ 
$insertvideo = dbquery("INSERT INTO homepage (`title`, `type`, `ident`, `querystring`, `total` ) VALUES ('".addslashes($_POST['title'])."', '2', '', '".addslashes($_POST['queries'])."', '".addslashes($_POST['number'])."')");		
}
?>
<div id="content">
<div class="box">
<div class="box-header"><h1>Homepage builder</h1></div>
<div class="box-content">
<div class="widget" >
<ul class="tabs">
<li><a href="#tab1">Add new</a></li>
<li><a href="#tab2">Existing Blocks</a></li>
</ul>
<div class="tab_container">

 <div id="tab1" class="tab_content">
<form action="homepage.php" method="post" class="form">
<div class="formRow"> 
<label for="title">Title:</label>
 <div class="formRight">
<input type="text" id="title" name="title">
 <p class="tooltip"> The title of the box container</p>
 </div>
<div class="clear"></div>
</div>	
<div class="formRow"> 
<label for="queries">Type:</label>
 <div class="formRight">
<select id="queries" name="queries" style="width:350px;">
<option value="most_viewed" selected>Most viewed videos</option>
<option value="top_rated">Most liked videos</option>
<option value="viral">New videos </option>
<option value="featured">Featured videos</option>
</select>
 <p class="tooltip"> Type of query the module does</p>
 </div>
<div class="clear"></div>
</div>	
<div class="formRow"> 
<label for="queries">Number of videos:</label>
 <div class="formRight">
 <input type="text" id="number" name="number">

<p class="tooltip"> The number of videos in this module. Multiple of 4 is recomended</p>
 </div>
<div class="clear"></div>
</div>	
<div class="formRow"> 
<input type="submit" name="submit" id="submit" class="button blueB" value="Add video block" />
</div>
</form>

</div>	
 <div id="tab2" class="tab_content">
<?php 
$boxes_sql = dbquery("SELECT * FROM `homepage` order by id asc LIMIT 0, 10");
while($row = mysql_fetch_array($boxes_sql)){ 
echo "<div style=\"width:100%; min-width:600px; height:50px; clear:both;\"><strong>".$row["title"]."</strong> <p style=\"float:right;margin-right:3px;\"><a href=\"homepage.php?delete=".$row["id"]."\" class=\"button redB\"><span>Delete</span></a></p> </div>";
}
?>
</div>
	</div>

<br style="clear:both;">

		
</div>	
	</div>	
	
</div>	
	</div>
	
<?php include_once("footer.php");?>