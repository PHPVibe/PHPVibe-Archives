<div id="usidebar" class="span2 top10">
<div class="module">
<h2 class="module-title">
<?php echo stripslashes(user_name());?>
</h2>
<div class="avatar">
<span class="clip">
<img src="<?php echo thumb_fix( user_avatar( ));?>" alt="<?php echo user_name();?>" />
</span>		
</div>
<form class="styled top20 bottom20" action="<?php echo canonical();?>/" enctype="multipart/form-data" method="post">
<input type="hidden" id="changeavatar" name="changeavatar" value="yes" />
<input type="file" id="avatar" name="avatar" class="styled" />
<button class="btn btn-large btn-primary" type="submit"><?php echo _lang("Upload avatar"); ?></button>
</form>

</div>
</div>
<div id="my-content" class="main-holder pad-holder span8 nomargin top20">
<div class="row-fluid clearfix">
<form class="form-horizontal styled" action="<?php echo canonical();?>/" enctype="multipart/form-data" method="post">
<input type="hidden" name="changeuser" class="hide" value="1" /> 
<fieldset>
<div class="control-group">
<label class="control-label"><i class="icon-user"></i><?php echo _lang("Name"); ?></label>
<div class="controls">
<input type="text" name="name" class="span12" value="<?php echo user_name();?>" /> 						
</div>	
</div>	
<div class="control-group">
<label class="control-label"><?php echo _lang("City"); ?></label>
<div class="controls">
<input type="text" name="city" class="span12" value="<?php echo stripslashes($profile->local); ?>" /> 						
</div>	
</div>	
<div class="control-group">
<label class="control-label"><?php echo _lang("Country"); ?></label>
<div class="controls">
<input type="text" name="country" class="span12" value="<?php echo stripslashes($profile->country); ?>" /> 						
</div>	
</div>	
<div class="control-group">
<label class="control-label"><?php echo _lang("About you"); ?></label>
<div class="controls">
<textarea rows="5" cols="5" name="bio" class="auto span12" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 88px;"><?php echo stripslashes($profile->bio); ?></textarea>					
</div>	
</div>
<div class="control-group">
<label class="control-label"><?php echo _lang("Gender"); ?></label>
<div class="controls">
<label class="radio">
<input type="radio" name="gender" id="gender2" class="styled" value="1" <?php if($profile->gender < 2) { ?>checked="checked"<?php } ?>><?php echo _lang("Male"); ?>
</label>
<label class="radio">
<input type="radio" name="gender" id="gender2"  class="styled" value="2" <?php if($profile->gender > 1) { ?>checked="checked"<?php } ?>>
<?php echo _lang("Female"); ?>
</label>
</div>	
</div>
					
<div class="control-group">
<div class="msg-info"><?php echo _lang("Social profiles can be left blank, if added they become public."); ?></div>	
<label class="control-label"><i class="icon-facebook-sign"></i><?php echo _lang("Facebook page"); ?> </label>
<div class="controls">
<input type="text" name="f-link" class="span12" placeholder="<?php echo _lang("my.fan.url"); ?>" value="<?php echo stripslashes($profile->fblink); ?>" /> 
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
<input type="text" name="tw-link" class="span12" placeholder="<?php echo _lang("my.twitter.id"); ?>" value="<?php echo stripslashes($profile->twlink); ?>" /> 
<span class="help-block" id="limit-text"><?php echo _lang("Without"); ?> https://twitter.com/</span>						
</div>	
</div>	
<div class="control-group">
<button class="btn btn-large btn-primary pull-right" type="submit"><?php echo _lang("Save changes"); ?></button>	
</div>	
</fieldset>					
</form>
</div>
</div>
<div class="span2 nomargin top20" style="padding:5px;">
<div class="module">
<h2 class="module-title">
<?php echo _lang("Control panel");?>
</h2>
<ul>
<li> <i class="icon-plus"></i><a href="<?php echo canonical();?>&sk=new-playlist"><?php echo _lang('Create playlist');?></a> </li>
<li> <i class="icon-edit"></i><a href="<?php echo canonical();?>&sk=playlists"><?php echo _lang('Manage playlists');?></a> </li>
<li> <i class="icon-remove-circle"></i><a href="<?php echo canonical();?>&sk=likes"><?php echo _lang('Manage likes');?></a> </li>
<li> <i class="icon-check"></i><a href="<?php echo canonical();?>&sk=videos"><?php echo _lang('Manage videos');?></a> </li>
</ul>
</div>
</div>