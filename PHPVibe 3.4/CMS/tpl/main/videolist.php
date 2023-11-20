<?php echo '<div class="searchWidget visible-phone hidden-tablet hidden-desktop" style="margin:10px 6%;">
            <form action="" method="get" id="searchform" onsubmit="location.href=\''.site_url().show.'/\' + encodeURIComponent(this.tag.value).replace(/%20/g, \'+\'); return false;">
                <input type="text" name="tag" id="suggest-videos" value="'._lang("Search videos").'" onfocus="if (this.value == \''._lang("Search videos").'\') {this.value = \'\';}" onblur="if (this.value == \'\') {this.value = \''._lang("Search videos").'\';}" />
             </form>       
		</div>'
?>
<div id="videolist-content" class="main-holder pad-holder span10 top10 nomargin">
<?php echo _ad('0','video-list-top');
include_once(TPL.'/video-loop.php');
 echo _ad('0','video-list-bottom');
?>
</div>