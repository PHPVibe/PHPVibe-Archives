<div id="footer" class="clearfix">
	<div class="wrapper">
		<div class="col col4">
			<div id="footer-logo-wrap">
				<a href="" id="footer-logo" class="clearlink">phpVibe</a>
				<div class="font10">Copyright &copy; 2011 phpVibe.com<br />All Rights Reserved.</div>
			</div>
		</div>
		<div class="col col7">
			<div id="search">
<div id="search_right">
    <div id="search_bg">
        <form class="searchform" method="get" action="video_tags.php" onsubmit="location.href='<?php print $config->site->url; ?>show/' + encodeURIComponent(this.tag.value).replace(/%20/g, '+'); return false;">
            
                <div class="input-holder">
                    <input class="search" name="tag" type="text" value="<?php echo __("Type a keyword to list your favorite videos");?>" ONFOCUS="clearDefault(this)"/>
                </div>              
          
        </form>
    </div>
</div>
</div>  
		</div>
	</div>	
</div>

</body>
<?php
MK_MySQL::disconnect();
?>
</html>