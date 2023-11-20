<?php
if(isset($_POST['update_options_now'])){
foreach($_POST as $key=>$value)
{
update_option($key, $value);
}
  echo '<div class="msg-info">FFMPEG options have been updated.</div>';
  $db->clean_cache();
}
$all_options = get_all_options();
?>

<div class="row-fluid">
<h3>FFMPEG Settings</h3>
<form id="validate" class="form-horizontal styled" action="<?php echo admin_url('ffmpeg');?>" enctype="multipart/form-data" method="post">
<fieldset>
<input type="hidden" name="update_options_now" class="hide" value="1" /> 

	<div class="control-group">
	<label class="control-label"><i class="icon-check"></i>Enable ffmpeg conversion</label>
	<div class="controls">
	<label class="radio inline"><input type="radio" name="ffa" class="styled" value="1" <?php if(get_option('ffa') == 1 ) { echo "checked"; } ?>>Yes</label>
	<label class="radio inline"><input type="radio" name="ffa" class="styled" value="0" <?php if(get_option('ffa') == 0 ) { echo "checked"; } ?>>No</label>
	<span class="help-block" id="limit-text">Please make sure you have FFMPEG installed on server before enabling this</span>
	</div>
	</div>
	
	<div class="control-group">
<label class="control-label"><i class="icon-key"></i>FFmpeg comand</label>
 <div class="controls">
<div class="row-fluid">
<div class="span6">
<input type="text" name="ffmpeg-cmd" class="span12" value="<?php echo get_option('ffmpeg-cmd','ffmpeg'); ?>"><span class="help-block">FFMPEG comand to run, ex: ffmpeg, usr/bin/ffmpeg. Make sure it works. </span>
</div>
<div class="span6">
<input type="text" name="ffmpeg-vsize" class="span12" value="<?php echo get_option('ffmpeg-vsize','640x360'); ?>"><span class="help-block align-center"> Size for converted videos: <strong>width and height, ex: 630x320</strong></span>
</div>

</div>
</div>
</div>
<div class="control-group">
<label class="control-label"><i class="icon-folder-open"></i>Temporary folder</label>
<div class="controls">
<input type="text" name="tmp-folder" class="span12" value="<?php echo get_option('tmp-folder','rawmedia'); ?>" /> 
<span class="help-block" id="limit-text">Temporary folder to store unconverted files..</span>						
</div>	
</div>	
<div class="control-group">
	<label class="control-label"><i class="icon-trash"></i>Delete raw videos after conversion</label>
	<div class="controls">
	<label class="radio inline"><input type="radio" name="raw-remove" class="styled" value="1" <?php if(get_option('raw-remove') == 1 ) { echo "checked"; } ?>>Yes, delete!</label>
	<label class="radio inline"><input type="radio" name="raw-remove" class="styled" value="0" <?php if(get_option('raw-remove') <> 1 ) { echo "checked"; } ?>>No, keep!</label>
	</div>
	</div>
<div class="control-group">
<button class="btn btn-large btn-primary pull-right" type="submit"><?php echo _lang("Update settings"); ?></button>	
</div>	
</fieldset>						
</form>
</div>