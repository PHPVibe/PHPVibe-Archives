<?php
if(isset($_POST['play-name'])) {
$picture ='uploads/noimage.png';
$formInputName   = 'play-img';							# This is the name given to the form's file input
	$savePath	     = ABSPATH.'/uploads';								# The folder to save the image
	$saveName        = md5(time()).'-'.user_id();									# Without ext
	$allowedExtArray = array('.jpg', '.png', '.gif');	# Set allowed file types
	$imageQuality    = 100;
$uploader = new FileUploader($formInputName, $savePath, $saveName , $allowedExtArray);
if ($uploader->getIsSuccessful()) {
//$uploader -> resizeImage(200, 200, 'crop');
$uploader -> saveImage($uploader->getTargetPath(), $imageQuality);
$thumb  = $uploader->getTargetPath();
$picture  = str_replace(ABSPATH.'/' ,'',$thumb);
} else { $picture = 'uploads/noimage.png';}
$db->query("INSERT INTO ".DB_PREFIX."channels (`child_of`, `cat_name`, `picture`, `cat_desc`) VALUES ('".intval($_POST['categ'])."','".toDb($_POST['play-name'])."', '".toDb($picture)."' , '".toDb($_POST['play-desc'])."')");
echo '<div class="msg-info">Channel '.$_POST['play-name'].' created</div>';
}

?>
<div class="row-fluid">
<form id="validate" class="form-horizontal styled" action="<?php echo admin_url('create-channel');?>" enctype="multipart/form-data" method="post">
<fieldset>
<div class="control-group">
<label class="control-label"><i class="icon-bookmark"></i><?php echo _lang("Title"); ?></label>
<div class="controls">
<input type="text" name="play-name" class="validate[required] span12" placeholder="<?php echo _lang("Your channel's title"); ?>" /> 						
</div>	
</div>	
<?php
echo '<div class="control-group">
	<label class="control-label">'._lang("Child of:").'</label>
	<div class="controls">
	<select data-placeholder="'._lang("Choose a parentcategory:").'" name="categ" id="clear-results" class="select" tabindex="2">
	';
echo'<option value="" selected>-- None --</option>';	
$categories = $db->get_results("SELECT cat_id as id, cat_name as name FROM  ".DB_PREFIX."channels order by cat_name asc limit 0,10000");
if($categories) {
foreach ($categories as $cat) {	
echo'<option value="'.intval($cat->id).'">'.stripslashes($cat->name).'</option>';
	}
}


echo '</select>
	  </div>             
	  </div>';
?>		
<div class="control-group">
<label class="control-label"><?php echo _lang("Description"); ?></label>
<div class="controls">
<textarea rows="5" cols="5" name="play-desc" class="auto span12" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 88px;"></textarea>					
</div>	
</div>
<div class="control-group">
<label class="control-label"><?php echo _lang("Channel image"); ?></label>
<div class="controls">
<input type="file" id="play-img" name="play-img" class="styled" />
</div>	
</div>
<div class="control-group">
<button class="btn btn-large btn-primary pull-right" type="submit"><?php echo _lang("Create channel"); ?></button>	
</div>	
</fieldset>						
</form>
</div>