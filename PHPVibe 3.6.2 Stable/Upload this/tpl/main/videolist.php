
<div id="videolist-content" class="main-holder pad-holder span8 top10 nomargin">
<?php echo _ad('0','video-list-top');
include_once(TPL.'/video-loop.php');
 echo _ad('0','video-list-bottom');
?>
</div>
<?php if (!is_ajax_call()) { right_sidebar();  } ?>