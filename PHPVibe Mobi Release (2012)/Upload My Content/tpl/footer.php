<div class="clear"></div>
</div>
    <!-- end page -->	
  <!-- start footer -->
      <div class="footer">
        <div class="footer_unit">	<a href="<?php echo $fb; ?>"><img src="<?php echo $site_url;?>img/icons/facebook.png"  alt="<?php echo $fb_txt; ?>"/>	<span><?php echo $fb_txt; ?></span></a>	</div>
        <div class="footer_unit">	<a href="<?php echo $tw; ?>"><img src="<?php echo $site_url;?>img/icons/twitter.png"  alt="<?php echo $tw_txt; ?>"/>	<span><?php echo $tw_txt; ?></span></a>	</div>
        <div class="footer_unit">	<a href="<?php echo $rss; ?>"><img src="<?php echo $site_url;?>img/icons/rss.png" alt="<?php echo $rss_txt; ?>"/>	<span><?php echo $rss_txt; ?></span></a>	</div>
        <div class="footer_unit last_unit">	<a href="#header"><img src="<?php echo $site_url;?>img/icons/back-to-top.png"  alt="<?php echo $up_txt; ?>"/>	<span><?php echo $up_txt; ?></span></a>	</div>
      </div>
 <!-- end footer -->   

<!--DO NOT REMOVE BELOW SCRIPT. IT SHOULD ALWAYS APPEAR AT THE VERY END OF YOUR mobile CONTENT-->
<script language="JavaScript1.2">
//Scrollable content III- By http://www.dynamicdrive.com
var speed, currentpos=curpos1=0,alt=1,curpos2=-1
function initialize(){
if (window.parent.scrollspeed!=0){
speed=window.parent.scrollspeed
scrollwindow()
}
}
function scrollwindow(){
temp=(document.all)? document.body.scrollTop : window.pageYOffset
alt=(alt==0)? 1 : 0
if (alt==0)
curpos1=temp
else
curpos2=temp
window.scrollBy(0,speed)
}
setInterval("initialize()",10)
</script>
    
    
</body>
</html>