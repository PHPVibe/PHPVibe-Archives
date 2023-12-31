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

//Set logo
if(isset($_FILES['site-logo']) && !empty($_FILES['site-logo']['name'])){
$extension = end(explode('.', $_FILES['image']['name']));
$thumb = ABSPATH.'/uploads/'.nice_url($_FILES['site-logo']['name']).uniqid().'.'.$extension;
if (move_uploaded_file($_FILES['site-logo']['tmp_name'], $thumb)) {
     $sthumb = str_replace(ABSPATH.'/' ,'',$thumb);
    update_option('site-logo', $sthumb);
	  //$db->clean_cache();
	} else {
	echo '<div class="msg-warning">Logo upload failed.</div>';
	}
	
}
  $db->clean_cache();
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
<label class="control-label"><i class="icon-play-circle"></i>Browse per page</label>
<div class="controls">
<input type="text" name="bpp" class=" span4" value="<?php echo get_option('bpp'); ?>" /> 
<span class="help-block" id="limit-text">Number of videos per page</span>						
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