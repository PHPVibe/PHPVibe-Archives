<?php include_once("security.php");
include_once("head.php");
 if(isset($_GET['delete'])){ 
	 $del = dbquery("DELETE from slider WHERE id = '".$_GET['delete']."'");
	 echo 'You deleted the slide with id : '.$_GET['delete'];
	 }
if(isset($_POST['youtube_id'])){ 
if ($_POST['youtube_id'] != "Youtube video id") {
$slider = str_replace("http://www.youtube.com/watch?v=","",$_POST['youtube_id']);
$slider = str_replace("www.youtube.com/watch?v=","",$slider);
$slider = str_replace("youtube.com/watch?v=","",$slider);
$slider = str_replace("Youtube.com/watch?v=","",$slider);
$insertvideo = dbquery("INSERT INTO slider(`yt_id`) VALUES ('".addslashes($slider)."')"); 
echo "Video slide inserted successfull";
} else {
echo "Video slide not inserted. Check your submision form and add an valid youtube id.";
}
}
?>
 <div id="content" class="clear-fix">	 


 <div class="block">

 <h2>Choose the videos used in the slider</h2> 
 <div class="form">
   <form action="slider.php" method="post" class="standard clear-fix large">
   <fieldset>
  <div class="clear-fix form-field"></div>         
                    <div class="input-left"><div class="input-right">
					   <dt><label for="youtube_id">
					  <i>Youtube.com/watch?v=<span style="color:red">TxvpctgU_s8</span></i>
					   </label></dt>
					<dl>
<input type="text" name="youtube_id" id="" size="4" value="Youtube video id" class="data input-text"/>
</dl>
</div></div><div class="clear-fix form-field"></div>  
<div class="clear-fix form-field field-searchsubmit form-field-submit">
<div class="input-left"><div class="input-right">
 <dl class="submit">
<input type="submit" name="submit" id="submit" value="Add slide" />
 </dl>	
</div></div></div><div class="clear-fix form-field"></div>
  </fieldset>
</form>
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
<object width="225" height="155">
  <param name="movie"
         value="http://www.youtube.com/v/'.$row["yt_id"].'?version=3&autohide=1&showinfo=0"></param>
  <param name="allowScriptAccess" value="always"></param>
  <embed src="http://www.youtube.com/v/'.$row["yt_id"].'?version=3&autohide=1&showinfo=0"
         type="application/x-shockwave-flash"
         allowscriptaccess="always"
         width="225" height="155"></embed>
</object>
</td>

';
echo '
<td class="last options">
<a href="slider.php?delete='.$row["id"].'" title="Are you sure you want to delete this video?" rel="record delete" class="mini-button mini-button-delete">Delete</a> </td>		

</tr>
';	
}			
?>	



	</tbody>

</table>
<br/> <br/>

		</div>
</div>


     </div><!-- end of right content-->

 <?php 
  include_once("foot.php");
 ?>