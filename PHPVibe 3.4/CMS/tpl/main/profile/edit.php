<div class="row-fluid clearfix">
<?php if(isset($msg)) { echo $msg; } ?>
<form class="styled top20 bottom20 span6 profile-up" action="<?php echo canonical();?>/" enctype="multipart/form-data" method="post">
<div class="box">
<div class="box-head">
<h4 class="box-heading"><?php echo _lang("Change picture");?></h4>
</div>
<div class="box-body">
<input type="hidden" id="changeavatar" name="changeavatar" value="yes" />
<input type="file" id="avatar" name="avatar" class="styled" />
<button class="btn btn-small" type="submit"><?php echo _lang("Upload avatar"); ?></button>
</div>
</div>
</form>
<form class="styled top20 bottom20 span6 profile-up"action="<?php echo canonical();?>/" enctype="multipart/form-data" method="post">
<div class="box">
<div class="box-head">
<h4 class="box-heading"><?php echo _lang("Change cover (1170px/315px)");?></h4>
</div>
<div class="box-body">
<input type="hidden" id="changecover" name="changecover" value="yes" />
<input type="file" id="cover" name="cover" class="styled" />
<button class="btn btn-small" type="submit"><?php echo _lang("Upload cover"); ?></button>
</div>
</div>
</form>
</div>
<div class="row-fluid clearfix">
<h3 style="padding-left: 15px;"><?php echo _lang("Change profile data");?><h3>
<form class="form-horizontal styled" action="<?php echo canonical();?>/" enctype="multipart/form-data" method="post">
<input type="hidden" name="changeuser" class="hide" value="1" /> 
<fieldset>
<div class="control-group">
<label class="control-label"><i class="icon-user"></i><?php echo _lang("Name"); ?></label>
<div class="controls">
<input type="text" name="name" class="span8" value="<?php echo user_name();?>" /> 						
</div>	
</div>	
<div class="control-group">
<label class="control-label"><?php echo _lang("City"); ?></label>
<div class="controls">
<input type="text" name="city" class="span4" value="<?php echo stripslashes($profile->local); ?>" /> 						
</div>	
</div>	
<div class="control-group">
<label class="control-label"><?php echo _lang("Country"); ?></label>
<div class="controls">
<input type="text" name="country" class="typeahead tt-query span12" autocomplete="off" spellcheck="false" value="<?php echo stripslashes($profile->country); ?>" /> 						
</div>	
</div>	
<div class="control-group">
<label class="control-label"><?php echo _lang("About you"); ?></label>
<div class="controls">
<textarea rows="5" cols="5" name="bio" class="auto span8" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 88px;"><?php echo stripslashes($profile->bio); ?></textarea>					
</div>	
</div>
<div class="control-group">
<label class="control-label"><?php echo _lang("Gender"); ?></label>
<div class="controls">
<label class="radio inline">
<input type="radio" name="gender" id="gender2" class="styled" value="1" <?php if($profile->gender < 2) { ?>checked="checked"<?php } ?>><?php echo _lang("Male"); ?>
</label>
<label class="radio inline">
<input type="radio" name="gender" id="gender2"  class="styled" value="2" <?php if($profile->gender > 1) { ?>checked="checked"<?php } ?>>
<?php echo _lang("Female"); ?>
</label>
</div>	
</div>
					
<div class="control-group">
<label class="control-label"><i class="icon-facebook-sign"></i><?php echo _lang("Facebook"); ?> </label>
<div class="controls">
<input type="text" name="f-link" class="span12" placeholder="<?php echo _lang("my.profile.username"); ?>" value="<?php echo stripslashes($profile->fblink); ?>" /> 
<span class="help-block" id="limit-text"><?php echo _lang("Without"); ?> https://facebook.com/</span>							
</div>	
</div>	
<div class="control-group">
<label class="control-label"><i class="icon-google-plus"></i><?php echo _lang("Google Plus"); ?></label>
<div class="controls">
<input type="text" name="g-link" class="span12" placeholder="<?php echo _lang("my.google.id"); ?>" value="<?php echo stripslashes($profile->glink); ?>"/> 
<span class="help-block" id="limit-text"><?php echo _lang("Without"); ?> https://plus.google.com/</span>						
</div>	
</div>	
<div class="control-group">
<label class="control-label"><i class="icon-twitter"></i><?php echo _lang("Twitter"); ?> </label>
<div class="controls">
<input type="text" name="tw-link" class="span12" placeholder="<?php echo _lang("my.twitter.username"); ?>" value="<?php echo stripslashes($profile->twlink); ?>" /> 
<span class="help-block" id="limit-text"><?php echo _lang("Without"); ?> https://twitter.com/</span>						
</div>	
</div>	
<div class="control-group">
<button class="btn btn-large btn-primary pull-right" type="submit"><?php echo _lang("Save changes"); ?></button>	
</div>	
</fieldset>					
</form>
</div>
