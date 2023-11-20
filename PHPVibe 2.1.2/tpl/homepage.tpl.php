 <section id="wrapper">		
 <div class="page_wrap">
<div class="page_container box_alignleft sidebox">
<?php		while($row = mysql_fetch_array($slideql)){
	$slides .= '
		<li>
         <a href="'.$row["link"].'"> <img src="'.$row["image"].'" alt="'.stripslashes($row["h2"]).'"/></a>
          <div class="ei-title">
          <h2>'.stripslashes($row["h2"]).'</h2>
           <h3>'.stripslashes($row["h3"]).'</h3>
            </div>
            </li>
	
	
	';
	$slide_thumbs .= '
	
	<li><a href="#">'.stripslashes($row["h2"]).'</a><img src="'.$config->site->url.'com/timthumb.php?src='.$row["image"].'&h=150&w=150&crop&q=100" alt="'.stripslashes($row["h3"]).'" /></li>
	'; 
}
?>
  <div class="ei-wrapper">
  <div id="ei-slider" class="ei-slider">
                    <ul class="ei-slider-large">
			
					<?php echo $slides; ?>
					
                    </ul><!-- ei-slider-large -->
                    <ul class="ei-slider-thumbs">
                        <li class="ei-slider-element">Current</li>
						<?php echo $slide_thumbs; ?>
                       
                    </ul><!-- ei-slider-thumbs -->
                </div><!-- ei-slider -->
    </div>
  <div class="clear" style="height:30px;"></div>

<?php
$boxes_sql = dbquery("SELECT * FROM `homepage` order by id desc LIMIT 0, 10");
while($row = mysql_fetch_array($boxes_sql)){


if ($row["type"] == "1") :
echo '<h2 class="title-line alignright">'.stripslashes($row["title"]).'</h2>';
echo '<div class="viboxes">
<ul>';
$type = $row["type"];
$display_type = "1";
$pageNumber = "1";
$nb_display = $row["total"];
$q = $row["querystring"];
$username = "";
$feed = "";
$time = "";
$category = "";
include("youtube_show.php");

elseif($row["type"] == "3"):
$h1 = str_replace("_", "-", $row["ident"]);
echo '<h2 class="title-line alignright">'.stripslashes($row["title"]).'</h2>';
echo '<div class="viboxes">
<ul>';

$type = $row["type"];
$display_type = "1";
$pageNumber = "1";
$nb_display = $row["total"];
$q = "";
$username = "";
$feed = $row["ident"];
$time = $row["querystring"];
$category = "";
include("youtube_show.php");

else:
$iden = $row["querystring"];
include("video_box.tpl.php");

endif;




echo '</ul>
</div>';
}

?>

<br /> 

</div>
<?php
include("sidebar.tpl.php");
?>
</div>
</div>
