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
  echo '<div class="msg-info">SEF configuration updated.</div>';

  $db->clean_cache();
}
$all_options = get_all_options();
?>

<div class="row">
<h3>Permalinks</h3>
<form id="validate" class="form-horizontal styled" action="<?php echo admin_url('sef');?>" enctype="multipart/form-data" method="post">
<fieldset>
<input type="hidden" name="update_options_now" class="hide" value="1" /> 
<div class="form-group form-material">
<label class="control-label"><i class="icon-link"></i>Base path</label>
<div class="controls">
<input type="text" name="SiteBasePath" class="col-md-12" value="<?php echo get_option('SiteBasePath',''); ?>" /> 
<span class="help-block" id="limit-text"><code>Default: empty</code>! Set this <code>only if PHPVibe is installed in a folder</code>! Basepath is the folder name in clear, no lead/end-slashes! </span>						
</div>	
</div>		
<div class="form-group form-material">
<label class="control-label"><i class="icon-link"></i>Video & Song permalink</label>
<div class="controls">
<input type="text" name="video-seo-url" class="col-md-12" value="<?php echo get_option('video-seo-url','/video/:id/:name'); ?>" /> 
<span class="help-block" id="limit-text">Default: /video/:id/:name </span>						
</div>	
</div>
<div class="form-group form-material">
<label class="control-label"><i class="icon-link"></i>Image permalink</label>
<div class="controls">
<input type="text" name="image-seo-url" class="col-md-12" value="<?php echo get_option('image-seo-url','/image/:id/:name'); ?>" /> 
<span class="help-block" id="limit-text">Default: /image/:id/:name </span>						
</div>	
</div>	
<div class="form-group form-material">
<label class="control-label"><i class="icon-link"></i>Profile permalink</label>
<div class="controls">
<input type="text" name="profile-seo-url" class="col-md-12" value="<?php echo get_option('profile-seo-url','/profile/:name/:id/:section'); ?>" /> 
<span class="help-block" id="limit-text">Default: /profile/:name/:id/:section </span>						
</div>	
</div>	
<div class="form-group form-material">
<label class="control-label"><i class="icon-link"></i>Article permalink</label>
<div class="controls">
<input type="text" name="article-seo-url" class="col-md-12" value="<?php echo get_option('article-seo-url','/article/:name/:id'); ?>" /> 
<span class="help-block" id="limit-text">Default: /article/:name/:id </span>						
</div>	
</div>	
<div class="form-group form-material">
<label class="control-label"><i class="icon-link"></i>Page permalink</label>
<div class="controls">
<input type="text" name="page-seo-url" class="col-md-12" value="<?php echo get_option('page-seo-url','/read/:name/:id'); ?>" /> 
<span class="help-block" id="limit-text">Default: /read/:name/:id </span>						
</div>	
</div>	
<div class="form-group form-material">
<label class="control-label"><i class="icon-link"></i>Channel permalink</label>
<div class="controls">
<input type="text" name="channel-seo-url" class="col-md-12" value="<?php echo get_option('channel-seo-url','/channel/:name/:id/:section'); ?>" /> 
<span class="help-block" id="limit-text">Default: /channel/:name/:id/:section</span>						
</div>	
</div>	

<div class="form-group form-material">
<button class="btn btn-large btn-primary pull-right" type="submit"><?php echo _lang("Update settings"); ?></button>	
</div>	
</fieldset>						
</form>
</div>
