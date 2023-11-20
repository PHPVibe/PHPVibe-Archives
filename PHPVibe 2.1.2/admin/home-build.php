<?php include_once("security.php");
include_once("head.php");
require_once("../com/youtube_api.php");

 if(isset($_GET['delete'])){ 
	 $del = dbquery("DELETE from homepage WHERE id = '".$_GET['delete']."'");
	 echo 'You deleted the home box with id : '.$_GET['delete'];
	 }
if(isset($_POST['q'])){ 
$insertvideo = dbquery("INSERT INTO homepage (`title`,`type`, `ident`, `querystring`, `total` ) VALUES ('".addslashes($_POST['title'])."', '1', '', '".addslashes($_POST['q'])."', '".addslashes($_POST['number'])."')");		

}

if(isset($_POST['feed'])){ 
$insertvideo = dbquery("INSERT INTO homepage (`title`,`type`, `ident`, `querystring`, `total` ) VALUES ('".addslashes($_POST['title'])."', '3', '".addslashes($_POST['feed'])."', '".addslashes($_POST['time'])."', '".addslashes($_POST['number'])."')");		

}

if(isset($_POST['queries'])){ 
$insertvideo = dbquery("INSERT INTO homepage (`title`, `type`, `ident`, `querystring`, `total` ) VALUES ('".addslashes($_POST['title'])."', '2', '', '".addslashes($_POST['queries'])."', '".addslashes($_POST['number'])."')");		

}
?>
 <div id="content" class="clear-fix">	 
<div id="left">

 <div class="block">




 <h2>Insert a new video block</h2> 
 <div class="form">
   <form action="home-build.php" method="post" class="standard clear-fix large">
   <fieldset>
   <div class="input-left"><div class="input-right">
					   <dt><label for="title">Title:
					     </label></dt>
						  </div>
						 </div>
<div class="input-left"><div class="input-right">
<dl>
<input type="text" id="title" name="title" class="data input-text">
</dl>
 </div></div>		
  <div class="clear-fix form-field"></div> 
<div class="input-left"><div class="input-right">
					   <dt><label for="q">For Keyword:
					     </label></dt>
						  </div>
						 </div>
						 
<div class="input-left"><div class="input-right">
<dl>
<input type="text" id="q" name="q" class="data input-text">
</dl>
 </div></div>
  <div class="clear-fix form-field"></div> 
  <div class="input-left"><div class="input-right">
					   <dt><label for="number">Number of videos:
					     </label></dt>
						  </div>
						 </div>
<div class="input-left"><div class="input-right">  
 <select id="number" name="number"  style="width:140px">
<option value="3" selected>3 videos</option>
<option value="6">6 videos</option>
<option value="9">9 videos</option>
<option value="12">12 videos</option>
<option value="15">15 videos</option>
<option value="18">18 videos</option>
<option value="21">21 videos</option>
<option value="24">24 videos</option>
</select>
 </div></div>
 <div class="clear-fix form-field"></div>  
<div class="clear-fix form-field field-searchsubmit form-field-submit">
<div class="input-left"><div class="input-right">
 <dl class="submit">
<input type="submit" name="submit" id="submit" value="Add video block" />
 </dl>	
 </div></div></div>
 <div class="clear-fix form-field"></div>
  </fieldset>
</form>
</div>
<br />



 <h2>Insert from Youtube standard feeds</h2> 
  <div class="form">
<form action="home-build.php" method="post" class="standard clear-fix large">
  <fieldset>
     <div class="input-left"><div class="input-right">
					   <dt><label for="title">Title:
					     </label></dt>
						
<dl>
<input type="text" id="title" name="title" class="data input-text">
</dl>
 </div></div>		
  <div class="clear-fix form-field"></div> 
<table>
<tr><td>Feeds: &nbsp;&nbsp;&nbsp;</td><td>
<select id="feed" name="feed"  style="width:140px">
<option value="most_viewed" selected>Most viewed</option>
<option value="top_rated">Top rated</option>
<option value="top_favorites">Top favorites</option>
<option value="most_popular">Most popular</option>
<option value="most_discussed">Most discussed</option>
<option value="most_linked">Most linked</option>
</select></td></tr><tr><td>Time: &nbsp;&nbsp;&nbsp;</td><td>
<select id="time" name="time" style="width:140px">
<option value="today" selected>Today</option>
<option value="this_week">This week</option>
<option value="this_month">This month videos</option>
<option value="all_time">All time</option></select></td></tr>
<tr><td>Number of results: &nbsp;&nbsp;&nbsp;</td><td>
<select id="number" name="number"  style="width:140px">
<option value="3" selected>3 videos</option>
<option value="6">6 videos</option>
<option value="9">9 videos</option>
<option value="12">12 videos</option>
<option value="15">15 videos</option>
<option value="18">18 videos</option>
<option value="21">21 videos</option>
<option value="24">24 videos</option>
</select></td></tr>
</table>

<div class="clear-fix form-field field-searchsubmit form-field-submit">
<div class="input-left"><div class="input-right">
 <dl class="submit">
<input type="submit" name="submit" id="submit" value="Add video block" />
 </dl>	
 </div></div></div>
 <div class="clear-fix form-field"></div>
  </fieldset>
</form>				
</div>
<br/> <br/>
 <h2>Insert from local queries</h2> 
  <div class="form">
<form action="home-build.php" method="post" class="standard clear-fix large">
  <fieldset>
     <div class="input-left"><div class="input-right">
					   <dt><label for="title">Title:
					     </label></dt>
						
<dl>
<input type="text" id="title" name="title" class="data input-text">
</dl>
 </div></div>		
  <div class="clear-fix form-field"></div> 
<table>
<tr><td>Queries: &nbsp;&nbsp;&nbsp;</td><td>
<select id="queries" name="queries"  style="width:140px">
<option value="most_viewed" selected>Most viewed</option>
<option value="top_rated">Most liked</option>
<option value="viral">New videos </option>
<option value="featured">Featured videos</option>
</select></td></tr>
<tr><td>Number of results: &nbsp;&nbsp;&nbsp;</td><td>
<select id="number" name="number"  style="width:140px">
<option value="3" selected>3 videos</option>
<option value="6">6 videos</option>
<option value="9">9 videos</option>
<option value="12">12 videos</option>
<option value="15">15 videos</option>
<option value="18">18 videos</option>
<option value="21">21 videos</option>
<option value="24">24 videos</option>
</select></td></tr>
</table>

<div class="clear-fix form-field field-searchsubmit form-field-submit">
<div class="input-left"><div class="input-right">
 <dl class="submit">
<input type="submit" name="submit" id="submit" value="Add video block" />
 </dl>	
 </div></div></div>
 <div class="clear-fix form-field"></div>
  </fieldset>
</form>				
</div>

		</div>
		
			</div>	


   <div id="right">
<div class="block block-flushbottom">

    <div class="inner-block">
<h3>Home blocks </h3>
<table class="table-data table-supplement">
<thead>
<tr>
<th style="width:85%;">List of blocks</th>
<th style="width:15%;">&nbsp;</th>
</tr>
</thead>
<tbody>
<?php 
$boxes_sql = dbquery("SELECT * FROM `homepage` order by id asc LIMIT 0, 10");
while($row = mysql_fetch_array($boxes_sql)){ 

if($row["type"] == "1") :
$type .= "<strong> ".$row["title"]."</strong>: <br />Youtube keyword ".$row["querystring"]." ".$row["total"]." results";
elseif($row["type"] == "3"):
$type .= "<strong>".$row["title"]."</strong> <br /> Youtube feed: ".$row["ident"]." <br />Time: ".$row["querystring"]." <br />".$row["total"]." results";
else:
$type .= "<strong>".$row["title"]."</strong><br />Sql select : ". $row["querystring"] ."<br /> ".$row["total"]." results";
endif;

echo'<tr class="first">
<td>';
echo $type;
echo '</td>	
<td class="options"><a class="mini-button" href="home-build.php?delete='.$row["id"].'">Delete</a></td>
</tr>

';
unset($type);		
}
?>
</tbody>
</table>
</div>
</div>
</div>

     </div><!-- end of right content-->

 <?php 
  include_once("foot.php");
 ?>