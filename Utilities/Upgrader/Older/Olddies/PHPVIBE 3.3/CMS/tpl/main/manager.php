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
<form class="styled top20 bottom20" action="<?php echo site_url().me;?>/" enctype="multipart/form-data" method="post">
<input type="hidden" id="changeavatar" name="changeavatar" value="yes" />
<input type="file" id="avatar" name="avatar" class="styled" />
<button class="btn btn-large btn-primary" type="submit"><?php echo _lang("Upload avatar"); ?></button>
</form>
<ul>
<li> <i class="icon-plus"></i><a href="<?php echo site_url().me;?>&sk=new-playlist"><?php echo _lang('Create playlist');?></a> </li>
<li> <i class="icon-edit"></i><a href="<?php echo site_url().me;?>&sk=playlists"><?php echo _lang('Manage playlists');?></a> </li>
<li> <i class="icon-remove-circle"></i><a href="<?php echo site_url().me;?>&sk=likes"><?php echo _lang('Manage likes');?></a> </li>
<li> <i class="icon-check"></i><a href="<?php echo site_url().me;?>&sk=videos"><?php echo _lang('Manage videos');?></a> </li>
</ul>
</div>
</div>
<div id="my-content" class="main-holder pad-holder span10 nomargin top20" style="padding-right:12px;">
<div class="row-fluid clearfix">
<?php 
echo default_content();
$module = $_GET['sk'];
switch($module) { 
case "videos":
$count = $db->get_row("Select count(*) as nr from ".DB_PREFIX."videos where user_id ='".user_id()."'");
$videos = $db->get_results("select id,title,thumb, views, liked, duration from ".DB_PREFIX."videos where user_id ='".user_id()."' and pub > 0 ORDER BY ".DB_PREFIX."videos.id DESC ".this_limit()."");
if($videos) {
$ps = site_url().me.'&sk=videos&p=';
$a = new pagination;	
$a->set_current(this_page());
$a->set_first_page(true);
$a->set_pages_items(7);
$a->set_per_page(bpp());
$a->set_values($count->nr);
$a->show_pages($ps);
?>

<form class="form-horizontal styled" action="<?php echo site_url().me;?>&sk=videos&p=<?php echo this_page();?>" enctype="multipart/form-data" method="post">

<div class="cleafix full"></div>
<fieldset>
<div class="table-overflow top10">
                        <table class="table table-bordered table-checks">
                          <thead>
                              <tr>
                                  <th><input type="checkbox" name="checkRows" class="styled check-all" /></th>
                                  <th width="130px"><?php echo _lang("Thumb"); ?></th>
                                  <th width="35%"><?php echo _lang("Video"); ?></th>
                                  <th><?php echo _lang("Duration"); ?></th>
                                  <th><?php echo _lang("Likes"); ?></th>
                                  <th><?php echo _lang("Views"); ?></th>
								  <th><button class="btn btn-large btn-danger" type="submit"><?php echo _lang("Unpublish selected"); ?></button></th>
                              </tr>
                          </thead>
                          <tbody>
						  <?php foreach ($videos as $video) { ?>
                              <tr>
                                  <td><input type="checkbox" name="checkRow[]" value="<?php echo $video->id; ?>" class="styled" /></td>
                                  <td><img src="<?php echo thumb_fix($video->thumb); ?>" style="width:130px; height:90px;"></td>
                                  <td><?php echo stripslashes($video->title); ?></td>
                                  <td><?php echo video_time($video->duration); ?></td>
                                  <td><?php echo stripslashes($video->liked); ?></td>
                                  <td><?php echo stripslashes($video->views); ?></td>
								  <td>
								  <p><a href="<?php echo site_url().me;?>&sk=videos&p=<?php echo this_page();?>&delete-video=<?php echo $video->id;?>"><i class="icon-trash" style="margin-right:5px;"></i><?php echo _lang("Unpublish"); ?></a></p>
								  <?php if((get_option('uploadrule') == 1) ||  is_moderator()) { ?>
								  <p><a href="<?php echo site_url().me;?>&sk=edit-video&vid=<?php echo $video->id;?>"><i class="icon-edit" style="margin-right:5px;"></i><?php echo _lang("Edit"); ?></a></p>
								 <?php } ?>
								 <p> <a target="_blank" href="<?php echo video_url($video->id, $video->title);?>"><i class="icon-check" style="margin-right:5px;"></i><?php echo _lang("View"); ?></a></p>
								  </td>
                              </tr>
							  <?php } ?>
						</tbody>  
</table>
</div>						
</fieldset>					
</form>
<?php  $a->show_pages($ps); }
 break; 
  
case "likes":
$count = $db->get_row("Select count(*) as nr from ".DB_PREFIX."videos where ".DB_PREFIX."videos.id in ( select vid from ".DB_PREFIX."likes where uid ='".user_id()."' and type='like')");
$videos = $db->get_results("select id,title,thumb, views, liked, duration from ".DB_PREFIX."videos where ".DB_PREFIX."videos.id in ( select vid from ".DB_PREFIX."likes where uid ='".user_id()."' and type='like') ORDER BY ".DB_PREFIX."videos.id DESC ".this_limit()."");
if($videos) {
$ps = site_url().me.'&sk=likes&p=';
$a = new pagination;	
$a->set_current(this_page());
$a->set_first_page(true);
$a->set_pages_items(7);
$a->set_per_page(bpp());
$a->set_values($count->nr);
$a->show_pages($ps);
?>

<form class="form-horizontal styled" action="<?php echo site_url().me;?>&sk=likes&p=<?php echo this_page();?>" enctype="multipart/form-data" method="post">
<div class="cleafix full"></div>
<fieldset>
<div class="table-overflow top10">
                        <table class="table table-bordered table-checks">
                          <thead>
                              <tr>
                                  <th><input type="checkbox" name="likesRows" class="styled check-all" /></th>
                                  <th width="130px"><?php echo _lang("Thumb"); ?></th>
                                  <th width="35%"><?php echo _lang("Video"); ?></th>
                                  <th><?php echo _lang("Duration"); ?></th>
                                  <th><?php echo _lang("Likes"); ?></th>
                                  <th><?php echo _lang("Views"); ?></th>
								  <th><button class="btn btn-large btn-danger" type="submit"><?php echo _lang("Remove selected"); ?></button></th>
                              </tr>
                          </thead>
                          <tbody>
						  <?php foreach ($videos as $video) { ?>
                              <tr>
                                  <td><input type="checkbox" name="likesRow[]" value="<?php echo $video->id; ?>" class="styled" /></td>
                                  <td><img src="<?php echo thumb_fix($video->thumb); ?>" style="width:130px; height:90px;"></td>
                                  <td><?php echo stripslashes($video->title); ?></td>
                                  <td><?php echo video_time($video->duration); ?></td>
                                  <td><?php echo stripslashes($video->liked); ?></td>
                                  <td><?php echo stripslashes($video->views); ?></td>
								  <td>
								  <p><a href="<?php echo site_url().me;?>&sk=likes&p=<?php echo this_page();?>&delete-like=<?php echo $video->id;?>"><i class="icon-trash" style="margin-right:5px;"></i><?php echo _lang("Remove rating"); ?></a></p>
								 <p> <a target="_blank" href="<?php echo video_url($video->id, $video->title);?>"><i class="icon-check" style="margin-right:5px;"></i><?php echo _lang("View"); ?></a></p>
								  </td>
                              </tr>
							  <?php } ?>
						</tbody>  
</table>
</div>						
</fieldset>					
</form>
<?php  $a->show_pages($ps); }
 break; 
  
case "playlists":
$count = $db->get_row("SELECT count(*) as nr FROM ".DB_PREFIX."playlists where owner= '".user_id()."'");
$videos = $db->get_results("SELECT * FROM ".DB_PREFIX."playlists where owner= '".user_id()."' order by views desc ".this_limit()."");
if($videos) {
$ps = site_url().me.'&sk=playlists&p=';
$a = new pagination;	
$a->set_current(this_page());
$a->set_first_page(true);
$a->set_pages_items(7);
$a->set_per_page(bpp());
$a->set_values($count->nr);
$a->show_pages($ps);
?>

<form class="form-horizontal styled" action="<?php echo site_url().me;?>&sk=playlists&p=<?php echo this_page();?>" enctype="multipart/form-data" method="post">
<div class="cleafix full"></div>
<fieldset>
<div class="table-overflow top10">
                        <table class="table table-bordered table-checks">
                          <thead>
                              <tr>
                                  <th><input type="checkbox" name="likesRows" class="styled check-all" /></th>
                                  <th width="130px"><?php echo _lang("Thumb"); ?></th>
                                  <th width="35%"><?php echo _lang("Title"); ?></th>
                                  <th><?php echo _lang("Description"); ?></th>                                  
								  <th><button class="btn btn-large btn-danger" type="submit"><?php echo _lang("Remove selected"); ?></button></th>
                              </tr>
                          </thead>
                          <tbody>
						  <?php foreach ($videos as $video) { ?>
                              <tr>
                                  <td><input type="checkbox" name="playlistsRow[]" value="<?php echo $video->id; ?>" class="styled" /></td>
                                  <td><img src="<?php echo thumb_fix($video->picture); ?>" style="width:130px; height:90px;"></td>
                                  <td><?php echo stripslashes($video->title); ?></td>
                                  <td><?php echo stripslashes($video->description); ?></td>                                 
								  <td>
								  
								  <p><a target="_blank" href="<?php echo playlist_url($video->id, $video->title);?>"><i class="icon-eye-open" style="margin-right:5px;"></i><?php echo _lang("View"); ?></a></p>
								  <p><a href="<?php echo site_url().me;?>&sk=manage-playlists&playlist=<?php echo $video->id;?>"><i class="icon-check" style="margin-right:5px;"></i><?php echo _lang("Manage Videos"); ?></a></p>
								  <p><a href="<?php echo site_url().me;?>&sk=playlists&p=<?php echo this_page();?>&delete-playlist=<?php echo $video->id;?>"><i class="icon-trash" style="margin-right:5px;"></i><?php echo _lang("Delete playlist"); ?></a></p>
								  </td>
                              </tr>
							  <?php } ?>
						</tbody>  
</table>
</div>						
</fieldset>					
</form>
<?php  $a->show_pages($ps); }
break; 
  
case "manage-playlists":
if(!_get("playlist")) {
die(_lang("Something went wrong"));
}
$play_check = $db->get_row("SELECT * FROM ".DB_PREFIX."playlists where owner= '".user_id()."' and  id= '".toDb(_get("playlist"))."' order by views desc limit 0,1");
if(!$play_check) {
die(_lang("Something went wrong"));
}
if(_get("playlist") && _get("remove") && $play_check) {
playlist_remove(_get("playlist"), _get("remove"));
}
if(_get("playlist") && isset($_POST['playlistsRemoval']) && $play_check) {
playlist_remove(_get("playlist"), $_POST['playlistsRemoval']);
}
$count = $db->get_row("SELECT count(*) as nr FROM ".DB_PREFIX."playlist_data where playlist= '".toDb($play_check->id)."'");

$options = DB_PREFIX."videos.id,".DB_PREFIX."videos.title,".DB_PREFIX."videos.user_id,".DB_PREFIX."videos.thumb,".DB_PREFIX."videos.views,".DB_PREFIX."videos.liked,".DB_PREFIX."videos.duration,".DB_PREFIX."videos.nsfw";
$vq = "select ".$options.", ".DB_PREFIX."users.name as owner FROM ".DB_PREFIX."videos LEFT JOIN ".DB_PREFIX."users ON ".DB_PREFIX."videos.user_id = ".DB_PREFIX."users.id WHERE ".DB_PREFIX."videos.id in (SELECT ".DB_PREFIX."playlist_data.video_id from ".DB_PREFIX."playlist_data where playlist='".$play_check->id."') ORDER BY ".DB_PREFIX."videos.id DESC ".this_offset(bpp());
$videos = $db->get_results($vq);
if($videos) {
$ps = site_url().me.'&sk=manage-playlists&p=';
$a = new pagination;	
$a->set_current(this_page());
$a->set_first_page(true);
$a->set_pages_items(7);
$a->set_per_page(bpp());
$a->set_values($count->nr);
$a->show_pages($ps);
?>

<form class="form-horizontal styled" action="<?php echo site_url().me;?>&sk=manage-playlists&playlist=<?php echo _get("playlist");?>" enctype="multipart/form-data" method="post">
<div class="cleafix full"></div>
<fieldset>
<div class="table-overflow top10">
                        <table class="table table-bordered table-checks">
                          <thead>
                              <tr>
                                  <th><input type="checkbox" name="likesRows" class="styled check-all" /></th>
                                  <th width="130px"><?php echo _lang("Thumb"); ?></th>
                                  <th width="35%"><?php echo _lang("Title"); ?></th>
                                                             
								  <th><button class="btn btn-large btn-danger" type="submit"><?php echo _lang("Remove selected"); ?></button></th>
                              </tr>
                          </thead>
                          <tbody>
						  <?php foreach ($videos as $video) { ?>
                              <tr>
                                  <td><input type="checkbox" name="playlistsRemoval[]" value="<?php echo $video->id; ?>" class="styled" /></td>
                                  <td><img src="<?php echo thumb_fix($video->thumb); ?>" style="width:130px; height:90px;"></td>
                                  <td><?php echo stripslashes($video->title); ?></td>                                                               
								  <td>
								  <p><a href="<?php echo site_url().me;?>&sk=manage-playlists&playlist=<?php echo _get("playlist");?>&remove=<?php echo $video->id;?>"><i class="icon-trash" style="margin-right:5px;"></i><?php echo _lang("Remove from playlist"); ?></a></p>
								  </td>
                              </tr>
							  <?php } ?>
						</tbody>  
</table>
</div>						
</fieldset>					
</form>
<?php  $a->show_pages($ps); }
 break; 
case "edit-video":
if(isset($_POST['edited-video'])) {
echo '<div class="msg-hint top10 bottom10">'.$_POST['title']._lang(" updated.").'</div>';
}
if(!_get("vid")){
die(_lang("Missing video id"));
}
if((get_option('uploadrule') <> 1) ||  !is_moderator()) {
die(_lang("Video editing has been disabled by the administrator"));
}
$video = $db->get_row("SELECT * from ".DB_PREFIX."videos where user_id= '".user_id()."' and id = '".intval(_get("vid"))."' ");
if($video) {
?>
<form id="validate" class="form-horizontal styled" action="<?php echo site_url().me;?>&sk=edit-video&vid=<?php echo $video->id; ?>" enctype="multipart/form-data" method="post">
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
<input type="file" id="play-img" name="play-img" class="styled" />
<span class="help-block" id="limit-text"><?php echo _lang("Select only if you wish to change the image");?></span>
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
$categories = $db->get_results("SELECT cat_id as id, cat_name as name FROM  ".DB_PREFIX."channels order by cat_name asc limit 0,10000");
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
<button class="btn btn-large btn-primary pull-right" type="submit"><?php echo _lang("Update video"); ?></button>	
</div>	
</fieldset>						
</form>
<?php
} else {
echo '<div class="msg-warning">'._lang("This video does not belong to you").'</div>';
}
 break; 
case "password":
?>
<h3><?php echo _lang("Change password"); ?></h3>
<form id="validate" class="form-horizontal styled" action="<?php echo site_url().me;?>&sk=password" enctype="multipart/form-data" method="post">
<fieldset>
<input type="hidden" name="change-password" id="change-password" value = "1"/>
<div class="control-group">
<label class="control-label"><i class="icon-unlock"></i>New password</label>
<div class="controls">
<input type="password" name="pass1" class="validate[required] span12" value="" /> 						
</div>	
</div>	
<div class="control-group">
<label class="control-label"><i class="icon-unlock"></i>Repeat password</label>
<div class="controls">
<input type="password" name="pass2" class="validate[required] span12" value="" /> 						
</div>	
</div>	
<div class="control-group">
<button class="btn btn-large btn-primary pull-right" type="submit"><?php echo _lang("Change password"); ?></button>	
</div>	
</fieldset>
</form>
<?php	
 break; 
case "new-playlist":
if(isset($_POST['play-name'])) {
echo '<div class="msg-hint top10 bottom10">'.$_POST['play-name']._lang(" created.").'</div>';
}
?>
<form id="validate" class="form-horizontal styled" action="<?php echo site_url().me;?>&sk=new-playlist" enctype="multipart/form-data" method="post">
<fieldset>
<div class="control-group">
<label class="control-label"><i class="icon-bookmark"></i><?php echo _lang("Title"); ?></label>
<div class="controls">
<input type="text" name="play-name" class="validate[required] span12" placeholder="<?php echo _lang("Your playlist's title"); ?>" /> 						
</div>	
</div>	
	
<div class="control-group">
<label class="control-label"><?php echo _lang("Description"); ?></label>
<div class="controls">
<textarea rows="5" cols="5" name="play-desc" class="auto validate[required] span12" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 88px;"></textarea>					
</div>	
</div>
<div class="control-group">
<label class="control-label"><?php echo _lang("Playlist image"); ?></label>
<div class="controls">
<input type="file" id="play-img" name="play-img" class="styled validate[required]" />
</div>	
</div>
<div class="control-group">
<button class="btn btn-large btn-primary pull-right" type="submit"><?php echo _lang("Create playlist"); ?></button>	
</div>	
</fieldset>						
</form>
<?php

 break; 
} ?>
</div>
</div>