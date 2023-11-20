<?php if(isset($_GET['ac']) && $_GET['ac'] ="remove-logo"){
update_option('site-logo', '');
 $db->clean_cache();
}
if(isset($_POST['update_options_now'])){
foreach($_POST as $key=>$value)
{
if($key !== "site-logo") {
  update_option($key, $value);
}
}
  echo '<div class="msg-info">Configuration options have been updated.</div>';
  $db->clean_cache();
}
//Set logo
if(isset($_FILES['site-logo']) && !empty($_FILES['site-logo']['name'])){
$thumb = ABSPATH.'/uploads/'.nice_url($_FILES['site-logo']['name']);
if (move_uploaded_file($_FILES['site-logo']['tmp_name'], $thumb)) {
     $sthumb = str_replace(ABSPATH.'/' ,'',$thumb);
    update_option('site-logo', $sthumb);
	  $db->clean_cache();
	} else {
	echo '<div class="msg-warning">Logo upload failed.</div>';
	}
	
}
$all_options = get_all_options();
?>

<div class="row-fluid">
<h3>Configuration</h3>
<form id="validate" class="form-horizontal styled" action="<?php echo admin_url('setts');?>" enctype="multipart/form-data" method="post">
<fieldset>
<input type="hidden" name="update_options_now" class="hide" value="1" /> 	
<div class="control-group">
<label class="control-label"><i class="icon-pencil"></i>Site name</label>
<div class="controls">
<input type="text" name="site-logo-text" class="span12" value="<?php echo get_option('site-logo-text'); ?>" /> 						
<span class="help-block" id="limit-text">Also shown on top of site, in header as text logo.</span>
</div>	
</div>
<div class="control-group">
<label class="control-label"><i class="icon-pencil"></i>Mobile logo</label>
<div class="controls">
<input type="text" name="site-logo-mobi" class="span12" value="<?php echo get_option('site-logo-mobi'); ?>" /> 						
<span class="help-block" id="limit-text">Text logo for mobile browsers.</span>
</div>	
</div>		
<div class="control-group">
<label class="control-label"><i class="icon-picture"></i>Image logo</label>
<div class="controls">
<input type="file" id="site-logo" name="site-logo" class="styled" />
<span class="help-block" id="limit-text">If used, replaces the default text logo with this image.</span>
<?php if(get_option('site-logo')) { ?><p><img src="<?php echo thumb_fix(get_option('site-logo')); ?>"/> <br /> <a href="<?php echo admin_url('setts');?>&ac=remove-logo">Remove</a></p><?php } ?>
</div>	
</div>
<div class="control-group">
<label class="control-label"><i class="icon-search"></i>Meta title</label>
<div class="controls">
<input type="text" name="seo_title" class="span12" value="<?php echo get_option('seo_title'); ?>" /> 
<span class="help-block" id="limit-text">Title in browser's bar and Google's index.</span>						
</div>	
</div>	
<div class="control-group">
	<label class="control-label"><i class="icon-search"></i>Meta description</label>
	<div class="controls">
	<textarea id="embed" name="seo_desc" class="auto span12" placeholder="Default: blank"><?php echo get_option('seo_desc'); ?></textarea>
	<span class="help-block" id="limit-text">The site's default meta description,it appears in search engines.</span>
	</div>
	</div>
<div class="control-group">
<label class="control-label"><i class="icon-globe"></i>Default language</label>
<div class="controls">
<input type="text" name="def_lang" class=" span1" value="<?php echo get_option('def_lang'); ?>" /> 
<span class="help-block" id="limit-text">Short 2 letters name of an existing language. Default: en</span>						
</div>	
</div>	
<div class="control-group">
<label class="control-label"><i class="icon-facebook-sign"></i>Facebook page</label>
<div class="controls">
<input type="text" name="fb-fanpage" class=" span12" value="<?php echo get_option('fb-fanpage'); ?>" /> 
<span class="help-block" id="limit-text">Facebook page slug, ex: <strong>/MediaVibe.ro</strong></span>						
</div>	
</div>
<div class="control-group">
<label class="control-label"><i class="icon-fast-forward"></i>Video page settings</label>
 <div class="controls">
<div class="row-fluid">
<div class="span3">
<input type="text" name="video-width" class="span12" value="<?php echo get_option('video-width'); ?>"><span class="help-block">Default video <strong>width</strong> </span>
</div>
<div class="span3">
<input type="text" name="video-height" class="span12" value="<?php echo get_option('video-height'); ?>"><span class="help-block align-center">Default video <strong>height</strong></span>
</div>
<div class="span3">
<input type="text" name="related-nr" class="span12" value="<?php echo get_option('related-nr'); ?>"><span class="help-block align-center">Number of <strong> related videos</strong></span>
</div>
<div class="span3">
<input type="text" name="jwkey" class="span12" value="<?php echo get_option('jwkey'); ?>"><span class="help-block align-right">Optional <strong>JwPlayer key</strong> (mostly if PRO)</span>
</div>
</div>
</div>
</div>
<div class="control-group">
<label class="control-label"><i class="icon-resize-horizontal"></i>Video thumbs (list images)</label>
 <div class="controls">
<div class="row-fluid">
<div class="span6">
<input type="text" name="thumb-width" class="span12" value="<?php echo get_option('thumb-width'); ?>"><span class="help-block">Default thumb <strong>width</strong> </span>
</div>
<div class="span6">
<input type="text" name="thumb-height" class="span12" value="<?php echo get_option('thumb-height'); ?>"><span class="help-block align-center">Default thumb <strong>height</strong></span>
</div>
</div>
</div>
</div>
<div class="control-group">
	<label class="control-label"><i class="icon-wrench"></i>Upload Rule</label>
	<div class="controls">
	<label class="radio inline"><input type="radio" name="uploadrule" class="styled" value="1" <?php if(get_option('uploadrule') == 1 ) { echo "checked"; } ?>>All registred users</label>
	<label class="radio inline"><input type="radio" name="uploadrule" class="styled" value="0" <?php if(get_option('uploadrule') <> 1 ) { echo "checked"; } ?>>Only moderators & administrators</label>
	</div>
	</div>
	<div class="control-group">
<label class="control-label"><i class="icon-folder-open"></i>Upload folder</label>
<div class="controls">
<input type="text" name="mediafolder" class=" span4" value="<?php echo get_option('mediafolder'); ?>" /> 
<span class="help-block" id="limit-text">Ex: <strong>media</strong>! <strong><i>Warning</i></strong>: This folders needs to exist and have write permissions for upload to work.</span>						
</div>	
</div>
		<div class="control-group">
	<label class="control-label"><i class="icon-legal"></i>Uploaded video state </label>
	<div class="controls">
	<label class="radio inline"><input type="radio" name="videos-initial" class="styled" value="1" <?php if(get_option('videos-initial') == 1 ) { echo "checked"; } ?>>Published</label>
	<label class="radio inline"><input type="radio" name="videos-initial" class="styled" value="0" <?php if(get_option('videos-initial') == 0 ) { echo "checked"; } ?>>Unpublished</label>
	<span class="help-block" id="limit-text">Do you wish user submitted videos to show on site immediately (Published) or hold them to user only until approval(Unpublished).</span>
	</div>
	</div>
	<div class="control-group">
	<label class="control-label"><i class="icon-edit"></i>Own videos editing rule</label>
	<div class="controls">
	<label class="radio inline"><input type="radio" name="editrule" class="styled" value="1" <?php if(get_option('editrule') == 1 ) { echo "checked"; } ?>>Owner can edit</label>
	<label class="radio inline"><input type="radio" name="editrule" class="styled" value="0" <?php if(get_option('editrule') <> 1 ) { echo "checked"; } ?>>Only moderators and up</label>
	</div>
	</div>
	<div class="control-group">
<label class="control-label"><i class="icon-user"></i>Owner of cron imports</label>
<div class="controls">
<input type="text" name="importuser" class=" span1" value="<?php echo get_option('importuser'); ?>" /> 
<span class="help-block" id="limit-text">ID of the user the cron should use for imported videos.</span>						
</div>	
</div>	
<div class="control-group">
<label class="control-label"><i class="icon-play-circle"></i>Browse per page</label>
<div class="controls">
<input type="text" name="bpp" class=" span4" value="<?php echo get_option('bpp'); ?>" /> 
<span class="help-block" id="limit-text">Number of videos per page</span>						
</div>	
</div>
	<div class="control-group">
	<label class="control-label"><i class="icon-film"></i>Youtube player</label>
	<div class="controls">
	<label class="radio inline"><input type="radio" name="youtube-player" class="styled" value="2" <?php if(get_option('youtube-player') == 2 ) { echo "checked"; } ?>>Use JwPlayer</label>
	<label class="radio inline"><input type="radio" name="youtube-player" class="styled" value="0" <?php if(get_option('youtube-player') == 0 ) { echo "checked"; } ?>>Use Youtube's</label>
	<span class="help-block" id="limit-text">Which player do you wish to handle Youtube?</span>
	</div>
	</div>
	<div class="control-group">
	<label class="control-label"><i class="icon-film"></i>JwPlayer version</label>
	<div class="controls">
	<label class="radio inline"><input type="radio" name="jwp_version" class="styled" value="5" <?php if(get_option('jwp_version') == 5 ) { echo "checked"; } ?>>Old 5</label>
	<label class="radio inline"><input type="radio" name="jwp_version" class="styled" value="6" <?php if(get_option('jwp_version') == 6 ) { echo "checked"; } ?>>New 6</label>
	<span class="help-block" id="limit-text">Which version of JwPlayer do you wish to use? Note: Only 6 has mobile/pad support</span>
	</div>
	</div>
	<div class="control-group">
	<label class="control-label"><i class="icon-facetime-video"></i>Mp4/mobi player</label>
	<div class="controls">
	<label class="radio inline"><input type="radio" name="choosen-player" class="styled" value="1" <?php if(get_option('choosen-player') == 1 ) { echo "checked"; } ?>>Use JwPlayer <i>(only if using Jwplayer 6)</i></label>
	<label class="radio inline"><input type="radio" name="choosen-player" class="styled" value="2" <?php if(get_option('choosen-player') == 2 ) { echo "checked"; } ?>>Use FlowPlayer HTML5</label>
		<label class="radio inline"><input type="radio" name="choosen-player" class="styled" value="3" <?php if(get_option('choosen-player') == 3 ) { echo "checked"; } ?>>Use MediaElement</label>
	<span class="help-block" id="limit-text">Which player should be loaded for mobile supported files (.mp4, etc)? JwPlayer is loaded for the rest.</span>
	</div>
	</div>
	
	<div class="control-group">
	<label class="control-label"><i class="icon-comments"></i>Comments system</label>
	<div class="controls">
	<label class="radio inline"><input type="radio" name="video-coms" class="styled" value="1" <?php if(get_option('video-coms') == 1 ) { echo "checked"; } ?>>Facebook</label>
	<label class="radio inline"><input type="radio" name="video-coms" class="styled" value="0" <?php if(get_option('video-coms') <> 1 ) { echo "checked"; } ?>>phpVibe</label>
	</div>
	</div>
	<div class="control-group">
	<label class="control-label"><i class="icon-share"></i>AddThis</label>
	<div class="controls">
	<label class="radio inline"><input type="radio" name="addthis" class="styled" value="1" <?php if(get_option('addthis') == 1 ) { echo "checked"; } ?>>Enable</label>
	<label class="radio inline"><input type="radio" name="addthis" class="styled" value="0" <?php if(get_option('addthis') <> 1 ) { echo "checked"; } ?>>Disable</label>
	</div>
	</div>
	<div class="control-group">
	<label class="control-label"><i class="icon-bar-chart"></i>Tracking code</label>
	<div class="controls">
	<textarea id="googleanalitycs" name="googleanalitycs" class="auto span12"><?php echo get_option('googleanalitycs'); ?></textarea>
	<span class="help-block" id="limit-text">Paste your full tracking code. For example Google Analytics</span>
	</div>
	</div>
	<div class="control-group">
<label class="control-label"><i class="icon-font"></i>Copyright</label>
<div class="controls">
<input type="text" name="site-copyright" class=" span12" value="<?php echo get_option('site-copyright'); ?>" /> 
<span class="help-block" id="limit-text">Ex: &copy; 2013 <?php echo ucfirst(ltrim(cookiedomain(),".")); ?></span>						
</div>	
</div>	
	<div class="control-group">
<label class="control-label"><i class="icon-hand-down"></i>Custom licensing</label>
<div class="controls">
<input type="text" name="licto" class=" span12" value="<?php echo get_option('licto'); ?>" /> 
<span class="help-block" id="limit-text">Ex: Licensed to <?php echo ucfirst(ltrim(cookiedomain(),".")); ?></span>						
</div>	
</div>
<div class="control-group">
<button class="btn btn-large btn-primary pull-right" type="submit"><?php echo _lang("Update settings"); ?></button>	
</div>	
</fieldset>						
</form>
</div>