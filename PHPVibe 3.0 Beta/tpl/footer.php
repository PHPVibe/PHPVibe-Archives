<div class="clear"></div>
<center><?php print $ad_footer; ?></center>
</section>
<br style="clear:both;"/>
<!-- Footer -->
    	<footer id="footer">			
		<div class="footer_wrapper">
		<div class="bottom-gradient"> </div>	
    		<span class="left-footer">
    			<a href="<?php echo $config->site->url; ?>"><img src="<?php echo $config->site->url; ?>tpl/images/logo.png" title="<?php echo $config->site->name; ?>" alt="<?php echo $config->site->name; ?>" /></a>     	
			</span>
    		<span class="right-footer">
&copy; <?php echo date("Y");?>	<a href="<?php print $config->site->url; ?>"><?php print $config->site->name; ?></a>
<?php if($page == "home") { ?>
<br />Powered by <a class="signature" href="<?php print $config->core->url; ?>">  <?php print $config->core->name; ?> v<?php print $config->core->version; ?></a>
<?php } ?>
</span>
<br style="clear:both;"/>
        </div>
    	</footer>

<?php 
//print custom styles or codes added from admin (if any)
if(!empty($config->site->footerc)) {print html_back($config->site->footerc); } ?>	  	
<?php if(($page == "user" ) && ($user_profile->getId() == $user->getId())) { ?>
<script>
$(function(){				
$("#update_button").live('click',function() {
var x=$("#update").val();
var dataString = 'content='+ x;
$(".firstdiv").prepend(' <article><footer class="entry-footer"> <div class="excerpt"> <p>'+x+'</p></div> </footer></article>');
$.ajax({
type: "POST",
  url: "components/update_status.php",
   data: dataString,
  cache: false,
  success: function(html){
   }
 });
 $("#update").val('');
return false;
});
 
$(".deletebox").live('click',function() {
var ID = $(this).attr("id");
var dataString = 'msg_id='+ ID;
if(confirm("Sure you want to delete this update? There is NO undo!")) {
$(this).closest('article').fadeOut('slow');  
$.ajax({
  type: "POST",
  url: "components/delete_update.php",
  data: dataString,
  cache: false,
  success: function(html){
  }
 });
}
return false;
});
});
</script>
<?php } ?>
<script type="text/javascript" src="<?php echo $config->site->url; ?>tpl/js/vibe_init.js"></script>
</body>  
</html>