<?php if(isset($_POST['edited-video']) && !is_null(intval($_POST['edited-video']))) {
if(isset($_FILES['play-img']) && !empty($_FILES['play-img']['name'])){
$formInputName   = 'play-img';							# This is the name given to the form's file input
	$savePath	     = ABSPATH.'/'.get_option('mediafolder').'/thumbs';								# The folder to save the image
	$saveName        = md5(time()).'-'.user_id();									# Without ext
	$allowedExtArray = array('.jpg', '.png', '.gif');	# Set allowed file types
	$imageQuality    = 100;
$uploader = new FileUploader($formInputName, $savePath, $saveName , $allowedExtArray);
if ($uploader->getIsSuccessful()) {
//$uploader -> resizeImage(200, 200, 'crop');
$uploader -> saveImage($uploader->getTargetPath(), $imageQuality);
$thumb  = $uploader->getTargetPath();
$thumb  = str_replace(ABSPATH.'/' ,'',$thumb);
	$db->query("UPDATE  ".DB_PREFIX."videos SET thumb='".toDb($thumb )."' WHERE id = '".intval($_POST['edited-video'])."'");
}

} else {
$db->query("UPDATE ".DB_PREFIX."videos SET thumb='".toDb($_POST['remote-img'])."' WHERE id = '".intval($_POST['edited-video'])."'");
}
$db->query("UPDATE  ".DB_PREFIX."videos SET title='".toDb(_post('title'))."', description='".toDb(_post('description') )."', duration='".intval(_post('duration') )."', category='".toDb(intval(_post('categ')))."', tags='".toDb(_post('tags') )."', nsfw='".intval(_post('nsfw') )."', source='".toDb(_post('source'))."',remote='".toDb(_post('remote'))."',embed='".esc_textarea(_post('embed'))."' WHERE id = '".intval($_POST['edited-video'])."'");
echo '<div class="msg-info">Video: '._post('title').' updated.</div>';
} 
$video = $db->get_row("SELECT * from ".DB_PREFIX."videos where id = '".intval(_get("vid"))."' ");
if($video) {
?>
<div class="row-fluid">

<h3>Video preview</h3>
<iframe width="100%" height="<?php echo get_option('video-height'); ?>" src="<?php echo site_url();?>embed/<?php echo intval(_get("vid")); ?>/" frameborder="0" allowfullscreen></iframe>
</div>
<div class="row-fluid">
<h3>Update video</h3>
<form id="validate" class="form-horizontal styled" action="<?php echo admin_url('edit-video');?>&vid=<?php echo $video->id; ?>" enctype="multipart/form-data" method="post">
<fieldset>
<input type="hidden" name="edited-video" id="edited-video" value = "<?php echo $video->id; ?>"/>
<div class="control-group">
<label class="control-label"><i class="icon-bookmark"></i><?php echo _lang("Title"); ?></label>
<div class="controls">
<input type="text" name="title" class="validate[required] span12" value="<?php echo $video->title; ?>" /> 						
</div>	
</div>	
	
<div class="control-group">
<label class="control-label"><?php echo _lang("Description"); ?></label>
<div class="controls">
<textarea rows="5" cols="5" name="description" class="auto validate[required] span12" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 88px;"><?php echo $video->description; ?></textarea>					
</div>	
</div>
<div class="control-group">
<label class="control-label"><?php echo _lang("Image"); ?></label>
<div class="controls">
<div class="row-fluid">
<img src="<?php echo thumb_fix($video->thumb); ?>" style="max-width:100%; max-height:168px; margin-bottom:5px;"/>
</div>
<div class="row-fluid">
<div class="span6">
<input type="file" id="play-img" name="play-img" class="styled" />
<span class="help-block" id="limit-text"><?php echo _lang("Select only if you wish to change the image");?></span>
</div>
<div class="span6">
<input type="text" name="remote-img" class="span12" value="<?php echo thumb_fix($video->thumb); ?>" /> 	
<span class="help-block" id="limit-text"><strong>Remote image. </strong> Leave unchanged for default.</span>
</div>
</div>
</div>
	
</div>
<div class="control-group">
	<label class="control-label"><?php echo _lang("Duration (in seconds):") ?></label>
	<div class="controls">
	<input type="text" id="duration" name="duration" class="validate[required] span12" value="<?php echo $video->duration; ?>">
	</div>
	</div>
	<div class="control-group">
	<label class="control-label"><?php echo _lang("Category:"); ?></label>
	<div class="controls">
	<select data-placeholder="<?php echo _lang("Choose a category:"); ?>" name="categ" id="clear-results" class="select validate[required]" tabindex="2">
	<?php 
	echo '	
	 <option value="'.intval($video->category).'">'._lang("No change").'</option> 
	';
$categories = $db->get_results("SELECT cat_id as id, cat_name as name FROM  ".DB_PREFIX."channels where type='".$video->media."' order by cat_name asc limit 0,10000");
if($categories) {
foreach ($categories as $cat) {	
    if($video->category <> $cat->id) {
    echo '<option value="'.intval($cat->id).'">'.stripslashes($cat->name).'</option> ';
	} else {
	echo '<option value="'.intval($cat->id).'" selected>'.stripslashes($cat->name).'</option> ';
	$hint = _lang("Initial category is").' <strong>'.stripslashes($cat->name).'</strong>';
	}
	
}
}	else {
echo '<option value="">'._lang("No categories").'</option>';
}
?> 
	  </select>
	<?php  if(isset($hint)) { ?>
	  <span class="help-block"> <?php echo $hint; ?></span>
	<?php } ?>  
	  </div>             
	  </div>
	  <div class="control-group">
	<label class="control-label"><?php echo _lang("Tags:"); ?></label>
	<div class="controls">
	<input type="text" id="tags" name="tags" class="tags span12" value="<?php echo $video->tags; ?>">
	</div>
	</div>
	<div class="control-group">
	<label class="control-label"><?php echo _lang("NSFW:"); ?></label>
	<div class="controls">
	<label class="radio inline"><input type="radio" name="nsfw" class="styled" value="1" <?php if($video->nsfw > 0 ) { echo "checked"; } ?>> <?php echo _lang("Not safe"); ?> </label>
	<label class="radio inline"><input type="radio" name="nsfw" class="styled" value="0" <?php if($video->nsfw < 1 ) { echo "checked"; } ?>><?php echo _lang("Safe"); ?></label>
	</div>
	</div>
	<div class="control-group">
	<label class="control-label">Source (link)</label>
	<div class="controls">
	<input type="text" id="source" name="source" class=" span12" value="<?php echo $video->source; ?>">
	</div>
	</div>
	<div class="control-group">
	<label class="control-label">Remote link</label>
	<div class="controls">
	<input type="text" id="remote" name="remote" class=" span12" value="<?php echo $video->remote; ?>" placeholder="Default: blank">
	</div>
	</div>
	<div class="control-group">
	<label class="control-label">Embed/Iframe</label>
	<div class="controls">
	<textarea id="embed" name="embed" class="auto span12" placeholder="Default: blank"><?php echo render_video(stripslashes($video->embed)); ?></textarea>
	</div>
	</div>
<div class="control-group">
<button class="btn btn-large btn-primary pull-right" type="submit"><?php echo _lang("Update video"); ?></button>	
</div>	
</fieldset>						
</form>
<?php
} else {
echo '<div class="msg-warning">Missing video</div>';
} ?>
</div>