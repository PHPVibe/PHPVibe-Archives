<?php 
if(isset($_POST['update_options_now'])){
foreach($_POST as $key=>$value)
{

  update_option($key, $value);

}
  echo '<div class="msg-info">Configuration options have been updated.</div>';
  $db->clean_cache();
}

$all_options = get_all_options();
?>

<div class="row-fluid">
<h3>Configuration</h3>
<form id="validate" class="form-horizontal styled" action="<?php echo admin_url('players');?>" enctype="multipart/form-data" method="post">
<fieldset>
<input type="hidden" name="update_options_now" class="hide" value="1" /> 	

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
<button class="btn btn-large btn-primary pull-right" type="submit"><?php echo _lang("Update settings"); ?></button>	
</div>	
</fieldset>						
</form>
</div>