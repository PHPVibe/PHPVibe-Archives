<?php include_once("sidebar.tpl.php"); ?> 
  <div class="main">
<?php
$options = "id,title,thumb,views,liked,duration,nsfw";
$boxes_sql = "SELECT * FROM `homepage` ORDER BY `order` ASC";
if ($boxes = $dbi->query($boxes_sql, 0)) {
foreach ($boxes as $row) {
$query = $row["querystring"];
$iden =  $row["ident"];
$c_add="";
if(!empty($iden)){ $c_add ="AND category = '".$iden."'"; }
$limit =  $row["total"];
if($query == "most_viewed"):
$vbox_result = "select ".$options." from videos WHERE views > 0 $c_add ORDER BY views DESC limit 0,$limit";

elseif($query == "top_rated"):
$vbox_result = "select ".$options." from videos WHERE liked > 0 $c_add ORDER BY liked DESC limit 0, $limit";

elseif($query == "random"):
$vbox_result = "select ".$options." from videos WHERE views > 0 $c_add ORDER BY rand() limit 0, $limit";

elseif($query == "featured"):
$vbox_result = "select ".$options." from videos WHERE featured = '1' $c_add ORDER BY id DESC limit 0, $limit";


else:
$vbox_result = "select ".$options." from videos WHERE views > 0 $c_add ORDER BY id DESC limit 0, $limit";

endif;
$box_title = $row["title"];
include("video_box.tpl.php");

}
} else {
echo 'No homeblocks defined by administrator.';
}
$dbi->disconnect();
?>
</div>