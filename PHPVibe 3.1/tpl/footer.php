<div class="clear"></div>
</section>
<br style="clear:both;"/>
<!-- Footer -->
    	<footer id="footer">			
		<div class="footer_wrapper">
		<div class="bottom-gradient"> </div>	
    		<span class="left-footer">
    			<a href="<?php echo $config->site->url; ?>"><img src="<?php echo $config->site->url; ?>tpl/images/logo.png" title="<?php echo $config->site->name; ?>" alt="<?php echo $config->site->name; ?>" /></a>     	
			<br />
			
			<?php 
			$langs = explode(',',  $config->site->langs);
			foreach ($langs as $ln) {
echo '<a class="flags" href="'.$site_url.'?lang='.$ln.'"><img src="'.$site_url.'/langs/flags/'.$ln.'.png" /></a>';
}
?>
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
<script type="text/javascript" src="<?php echo $config->site->url; ?>tpl/js/vibe_init.js"></script>
</body>  
</html>