<?php 
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

$all_options = get_all_options();
?>

<div class="row-fluid">
<h3>Uploads configuration</h3>
<form id="validate" class="form-horizontal styled" action="<?php echo admin_url('upsetts');?>" enctype="multipart/form-data" method="post">
<fieldset>
<input type="hidden" name="update_options_now" class="hide" value="1" /> 
	<div class="control-group">
<label class="control-label"><i class="icon-user"></i>Allowed files for upload</label>
<div class="controls">
<input type="text" name="alext" class="span12" value="<?php echo get_option('alext','flv,mp4,mp3,avi,mpeg'); ?>" /> 
<span class="help-block" id="limit-text">Comma separated file extensions for upload. Ex: flv,mp4,mp3,avi </span>						
</div>	
</div>	
	<div class="control-group">
<label class="control-label"><i class="icon-user"></i>Thumbnail extraction time</label>
<div class="controls">
<input type="text" name="ffmpeg-thumb-time" class="span12" value="<?php echo get_option('ffmpeg-thumb-time','00:00:03'); ?>" /> 
<span class="help-block" id="limit-text">Time at which to extract the thumbnail. Ex: 00:00:03 - at second 3 </span>						
</div>	
</div>	
	<div class="control-group">
<label class="control-label"><i class="icon-user"></i>Max upload size</label>
<div class="controls">
<input type="text" name="maxup" class="span12" value="<?php echo get_option('maxup','3145728000'); ?>" /> 
<span class="help-block" id="limit-text">Limit for files. Note: This sometimes <strong>fails due to server/hosting limitations</strong>.<br /> Value is in bytes! 1 Mb = 131072 B. Ex coversion: 3145728000 Bytes
= 24000 Megabits = 23.4375 Gigabits</span>						
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
<input type="text" name="importuser" class=" span1" value="<?php echo get_option('importuser','1'); ?>" /> 
<span class="help-block" id="limit-text">ID of the user the cron should use for imported videos.</span>						
</div>	
</div>
	<div class="control-group">
<label class="control-label"><i class="icon-user"></i>Category for wall images</label>
<div class="controls">
<?php
echo '<select data-placeholder="'._lang("Image category:").'" name="def-img-cat" id="clear-results" class="select validate[required]" tabindex="2">	';
$categories = $db->get_results("SELECT cat_id as id, cat_name as name FROM  ".DB_PREFIX."channels order by cat_name asc limit 0,10000");
if($categories) {
foreach ($categories as $cat) {	
echo (get_option('def-img-cat') == $cat->id)? '<option value="'.intval($cat->id).'" selected>'.stripslashes($cat->name).'</option> ' : '<option value="'.intval($cat->id).'">'.stripslashes($cat->name).'</option> ';

	}
}	else {
echo'<option value="">'._lang("No categories").'</option>';
}
echo'	  
	  </select>

';

?>
<span class="help-block" id="limit-text">To which category should images go?</span>						
</div>	
</div>
	
<div class="control-group">
<button class="btn btn-large btn-primary pull-right" type="submit"><?php echo _lang("Update settings"); ?></button>	
</div>	
</fieldset>						
</form>
</div>