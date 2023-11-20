<?php
if(isset($_POST['name'])) {
$spot = (isset($_POST['spot']) && !nullval($_POST['spot'])) ? $_POST['spot'] : $_POST['ad_spot'];
$db->query("INSERT INTO ".DB_PREFIX."ads (`ad_spot`, `ad_type`, `ad_content`, `ad_title`, `ad_pos`) VALUES
('".$spot."', '".intval($_POST['type'])."', '".$db->escape($_POST['content'])."', '".$db->escape($_POST['name'])."', '".$db->escape($_POST['pos'])."')
");
echo '<div class="msg-info">Ad '.$_POST['name'].' created</div>';
}
?>
<div class="row-fluid">
<form id="validate" class="form-horizontal styled" action="<?php echo admin_url('create-ad');?>" enctype="multipart/form-data" method="post">
<fieldset>
<div class="control-group">
<label class="control-label"><i class="icon-copy"></i>Ad title</label>
<div class="controls">
<input type="text" name="name" class="validate[required] span12"/> 	
<span class="help-block" id="limit-text">Only visible in administration.</span>						
					
</div>	
</div>	
<div class="control-group">
<label class="control-label"><i class="icon-th"></i>Ad spot</label>
<div class="controls">
<input type="text" name="spot" class="span12"/> 
<br /> - OR SELECT EXISTING - <br />
<?php
$predef = "top-of-comments,related-videos-top,video-list-bottom,video-list-top,video-loop-top,profile-right";
$categories = $db->get_results("SELECT distinct ad_spot FROM  ".DB_PREFIX."ads order by ad_spot asc limit 0,10000");
echo ' 
	<select data-placeholder="'._lang("Choose a spot:").'" name="ad_spot" id="clear-results" class="select" tabindex="2">
	<option value="" selected>-- None --</option>';
	foreach (explode(',',$predef) as $pf) {
	if(!nullval($pf)) {
echo'<option value="'.$pf.'">'.stripslashes($pf).'</option>';
}
	
	}
	if($categories) {
foreach ($categories as $cat) {	
if(!nullval($cat->ad_spot) && !in_array($cat->ad_spot,explode(',',$predef))) {
echo'<option value="'.$cat->ad_spot.'">'.stripslashes($cat->ad_spot).'</option>';
}
	}
}


echo '</select>
	 ';
?>
<span class="help-block" id="limit-text">Important! You can position several ads in same spot, they will show up randomly</span>						
</div>	
</div>	

<div class="control-group">
	<label class="control-label"><i class="icon-check"></i>Ad type</label>
	<div class="controls">
	<label class="radio inline"><input type="radio" name="type" class="styled" value="1">Video Overlay</label>
	<label class="radio inline"><input type="radio" name="type" class="styled" value="0" checked>Normal</label>
	<span class="help-block" id="limit-text">Does it appear over the video or on site?</span>
	</div>
	</div>	
<div class="control-group">
<label class="control-label">Ad content</label>
<div class="controls">
<textarea rows="5" cols="5" name="content" class="span12" style="word-wrap: break-word; resize: horizontal; height: 88px;"></textarea>					
<span class="help-block" id="limit-text">The actual html or js ad.</span>
</div>	
</div>
<div class="control-group">
	<label class="control-label"><i class="icon-fullscreen"></i>Video Overlay positioning: </label>
	<div class="controls">
	<label class="radio inline"><input type="radio" name="pos" class="styled" value="adtop" checked>Top</label>
	<label class="radio inline"><input type="radio" name="pos" class="styled" value="adbottom">Bottom</label>
	<span class="help-block" id="limit-text">Only affects Ad type: Video Overlay.</span>
	</div>
	</div>

<div class="control-group">
<button class="btn btn-large btn-primary pull-right" type="submit">Create Ad</button>	
</div>	
</fieldset>						
</form>
</div>