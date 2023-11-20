 <section id="wrapper">		
<div class="column-full"> 
<!--Vedio slider -->
<div class="vedio_banner">
<div id="slider2" style="height:324px; overflow:hidden ">
<?php 
$videos_array = explode(', ', $youtube_link);

	if (count($videos_array) > 0):

		foreach ($videos_array as $video):

			if ($video != ""):
  echo "<div class=\"contentdiv\">";          
$AE->parseUrl($video);
$AE->setWidth(930);
$AE->setHeight(324); 
echo $AE->getEmbedCode();
echo "</div>";
			endif;

		endforeach;
     	endif;

 ?>
  </div>  

                    <div id="paginate-slider2" class="pagination">
<?php 
$thumbs_array = explode(', ', $youtube_image);

	if (count($thumbs_array) > 0):
$i=1;
		foreach ($thumbs_array as $image_thumb):

			if ($image_thumb != ""):
			if ($i == 6) { $class="toc nomar";} else {$class="toc";};
  echo '
<a class="'.$class.'" href="#">
<img class="imge" src="'.$image_thumb .'"  width="141px" height="76px" alt="" /> 
<img class="addtoplaylist1" src="'.$site_url.'tpl/images/screen16.png" alt="" />

                            </a>  '; 
$i++;
endif;

		endforeach;
     	endif;

 ?>

 </div> 

<script type='text/javascript' src='<?php print $config->site->url; ?>tpl/js/slider.js'></script>
 </div> 
<div class="page_wrap">
<div class="page_container box_alignleft sidebox">
<div class="viboxes">
<ul>

<?php

$type = "3";
$display_type = "1";
$pageNumber = "1";
$nb_display = "6";
$q = "";
$username = "";
$feed = "top_rated";
$time = "today";
$category = "";
include("./components/core/youtube/display.php");
?>

</ul>
</div>

<br /> <div class="viboxes">
<ul>

<?php

$type = "5";
$display_type = "1";
$pageNumber = "1";
$nb_display = "6";
$q = "";
$username = "";
$feed = "";
$time = "today";
$category = "Music";
include("./components/core/youtube/display.php");
?>

</ul>
</div>
<br /> 

</div>
<?php
include("sidebar.tpl.php");
?>
</div>
</div>
