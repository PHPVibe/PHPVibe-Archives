    <!-- Main Content -->
    <section id="wrapper">		
    	<!-- Featured -->

<div class="column-full">
<br />
<h1><?php echo ucfirst($Info->Get("term")); ?></h1>
<br />
<?php
$a->show_pages($pagi_url);
?> 
<div class="page_wrap">
<div class="page_container box_alignleft sidebox">

<br /> 
<div class="viboxes">

<ul>

<?php
//echo $q;
include("./components/core/youtube/display.php");
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
