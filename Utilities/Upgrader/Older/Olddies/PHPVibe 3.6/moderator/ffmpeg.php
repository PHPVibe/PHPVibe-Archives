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
<h3>Bin path</h3>
<p>Needed for both crons and ffmpeg. </p>

<form id="validate" class="form-horizontal styled" action="<?php echo admin_url('ffmpeg');?>" enctype="multipart/form-data" method="post">
<fieldset>
<input type="hidden" name="update_options_now" class="hide" value="1" /> 
<div class="control-group">
	<label class="control-label"><i class="icon-wrench"></i>Server bin path</label>
	<div class="controls">
	<input type="text" name="binpath" class=" span12" value="<?php echo get_option('binpath'); ?>" /> 
	<span class="help-block" id="limit-text">PHP Bin path for crons &ffmpeg (conversion/scheduled tasks). Note: Also make sure videocron.php and cron.php have execute permissions (chmod : 0555)</span>
	</div>
	</div>
	
	<?php
if(function_exists('exec')) {
echo "<div class=\"control-group\"><p>Attempting a 'whereis php' command:</p><pre>";
echo exec('whereis php');
echo "</pre></div>";  
}
?>

<div class="control-group">
<button class="btn btn-large btn-primary pull-right" type="submit"><?php echo _lang("Update settings"); ?></button>	
</div>	
</fieldset>						
</form>
</div>
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
<label class="control-label"><i class="icon-folder-open"></i>Raw media folder</label>
<div class="controls">
<input type="text" name="tmp-folder" class="span12" value="<?php echo get_option('tmp-folder','rawmedia'); ?>" /> 
<span class="help-block" id="limit-text">Folder to store unconverted files..</span>						
</div>	
</div>	
<div class="control-group">
<button class="btn btn-large btn-primary pull-right" type="submit"><?php echo _lang("Update settings"); ?></button>	
</div>	
</fieldset>						
</form>
</div>