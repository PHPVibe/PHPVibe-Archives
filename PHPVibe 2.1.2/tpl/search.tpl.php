    <!-- Main Content -->
    <section id="wrapper">		
    	<!-- Featured -->

<div class="column-full">
<br />
 <!--BEGIN .pager description -->
                <div class="pager-description">

                    <p class="title"><?php echo ucfirst($Info->Get("term")); ?></p>
                    <span class="accent-line goright"></span>
                
               
                </div>
				 <!--END .pager-description -->

<center><?php echo $search_ads; ?></center>
<div class="page_wrap">
<div class="page_container box_alignleft sidebox">

<div class="viboxes">

<ul>

<?php
//echo $q;
include("youtube_show.php");
?>

</ul>
<div class="clear"></div>

<?php
$a->show_pages($pagi_url);
?>
<br />
<br />
<br />
</div>

</div>
<?php
include("sidebar.tpl.php");
?>

</div>
</div>
</div>
