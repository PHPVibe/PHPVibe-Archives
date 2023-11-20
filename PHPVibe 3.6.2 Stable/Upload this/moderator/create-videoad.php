<?php
if(isset($_POST['name'])) {
$spot = (isset($_POST['spot']) && !nullval($_POST['spot'])) ? $_POST['spot'] : $_POST['ad_spot'];
$content = array();
$content['body'] = addslashes($_POST['content']);
$content['box'] = $_POST['box'];
$content['sec'] = $_POST['sec'];
$content['end'] = $_POST['end'];
$db->query("INSERT INTO ".DB_PREFIX."jads (`jad_start`,`jad_end`,`jad_type`, `jad_box`, `jad_body`, `jad_title`, `jad_pos`) VALUES
('".$content['sec']."','".$content['end']."','".$spot."', '".intval($content['box'])."', '".$content['body']."', '".$db->escape($_POST['name'])."', '".$db->escape($_POST['pos'])."')
");
echo '<div class="msg-info">Ad '.$_POST['name'].' created</div>';
}
?>
<div class="row-fluid">
<h3>Create video ads for JPlayer</h3>
<form id="validate" class="form-horizontal styled" action="<?php echo admin_url('create-videoad');?>" enctype="multipart/form-data" method="post">
<fieldset>
<input type="hidden" name="type" value="1">
<div class="control-group">
<label class="control-label"><i class="icon-copy"></i>Title</label>
<div class="controls">
<input type="text" name="name" class="validate[required] span12"/> 	
<span class="help-block" id="limit-text">Only visible in administration.</span>						
					
</div>	
</div>	
<div class="control-group">
<label class="control-label"><i class="icon-th"></i>Video Ad Type</label>
<div class="controls">
<label class="radio inline"><input type="radio" name="spot" class="styled" value="5" checked>Video Overlay</label>
<label class="radio inline"><input type="radio" name="spot" class="styled" value="2">Video Annotation</label>
<label class="radio inline"><input type="radio" name="spot" class="styled" value="3">Pre-roll</label>
<label class="radio inline"><input type="radio" name="spot" class="styled" value="4">Post-Roll</label>
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
	<label class="control-label"><i class="icon-fullscreen"></i>Video Annotation position: </label>
	<div class="controls">
	<label class="radio inline"><input type="radio" name="pos" class="styled" value="plTopleft" checked>Top Left</label>
	<label class="radio inline"><input type="radio" name="pos" class="styled" value="plTopRight">Top Right</label>
	<label class="radio inline"><input type="radio" name="pos" class="styled" value="plBotleft">Bottom Left</label>
	<label class="radio inline"><input type="radio" name="pos" class="styled" value="plBotRight">Bottom Right</label>
	<span class="help-block" id="limit-text">For type "Video Annotation" only.</span>
	</div>
	</div>
<div class="control-group">
	<label class="control-label"><i class="icon-fullscreen"></i>Ad start: </label>
	<div class="controls">
<input type="text" name="sec" class="validate[required] span4" value="10"/> 	
<span class="help-block" id="limit-text">When will the ad appear on the player?</span>	
	</div>
	</div>	
<div class="control-group">
	<label class="control-label"><i class="icon-fullscreen"></i>Ad duration: </label>
	<div class="controls">
<input type="text" name="end" class="validate[required] span4" value="25"/> 	
<span class="help-block" id="limit-text">How many seconds will it be keept? If 0 is set, it will remain until user closes it.</span>	
	</div>
	</div>	
	
<div class="control-group">
	<label class="control-label"><i class="icon-fullscreen"></i>Video ad design: </label>
	<div class="controls">
	<label class="radio inline"><input type="radio" name="box" class="styled" value="0" checked>Transparent</label>
	<label class="radio inline"><input type="radio" name="box" class="styled" value="1">Black & Boxed </label>
	<span class="help-block" id="limit-text">For type "Video Overlay" only.</span>
	</div>
	</div>	

<div class="control-group">
<button class="btn btn-large btn-primary pull-right" type="submit">Create Ad</button>	
</div>	
</fieldset>						
</form>
</div>