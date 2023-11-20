<?php include_once("sidebar.tpl.php"); ?> 
  <div class="main">

<?php
$boxes_sql = dbquery("SELECT * FROM `homepage` order by id asc LIMIT 0, 10");
while($row = mysql_fetch_array($boxes_sql)){
$iden = $row["querystring"];
$limit =  $row["total"];
if($iden == "most_viewed"):
$vbox_result = dbquery("select * from videos WHERE views > 0 ORDER BY views DESC limit 0,$limit");

elseif($iden == "top_rated"):
$vbox_result = dbquery("select * from videos WHERE liked > 0 ORDER BY liked DESC limit 0, $limit");

elseif($iden == "featured"):
$vbox_result = dbquery("select * from videos WHERE featured = '1' ORDER BY id DESC limit 0, $limit");

else:
$vbox_result = dbquery("select * from videos WHERE views > 0 ORDER BY id DESC limit 0, $limit");

endif;
$box_title = $row["title"];
include("video_box.tpl.php");

}

?>

<br /> 

</div>
