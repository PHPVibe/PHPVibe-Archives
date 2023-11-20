<script type="text/javascript">
$(document).ready(function()   {
  <?php if (isset($message)) { ?>
   $.sticky(' <?php echo $message; ?>!', {autoclose : 25000, position: "bottom-right" });
  <?php } else { ?>
    $.sticky('Page loaded!', {autoclose : 4000, position: "bottom-right" });	
	<?php } ?>
  });
  $('#large_grid ul').masonry( 'reloadItems' );
</script>


</body>
</html>