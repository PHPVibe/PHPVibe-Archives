<?php if(_post('type') && _post('file') && ($_FILES['play-img'] || _post('remote-img'))) {
$sec = intval(_post('duration'));
//if is image upload
if(isset($_FILES['play-img']) && !empty($_FILES['play-img']['name'])){
$formInputName   = 'play-img';							
	$savePath	     = ABSPATH.'/'.get_option('mediafolder').'/thumbs';	
	$saveName        = md5(time()).'-'.user_id();									
	$allowedExtArray = array('.jpg', '.png', '.gif');	
	$imageQuality    = 100;
$uploader = new FileUploader($formInputName, $savePath, $saveName , $allowedExtArray);
if ($uploader->getIsSuccessful()) {
//$uploader -> resizeImage(200, 200, 'crop');
$uploader -> saveImage($uploader->getTargetPath(), $imageQuality);
$thumb  = $uploader->getTargetPath();
$thumbz  = str_replace(ABSPATH.'/' ,'',$thumb);
}
} else {
$thumbz = toDb($_POST['remote-img']);
}
$thumb = empty($thumbz)? 'uploads/noimage.png' : $thumbz ;

//Insert video
if(_post('type') < 2) {
//if it's web link
$db->query("INSERT INTO ".DB_PREFIX."videos (`pub`,`source`, `user_id`, `date`, `thumb`, `title`, `duration`, `tags` ,  `liked` , `category`, `description`, `nsfw`, `views`, `featured`) VALUES 
('".intval(_post('pub'))."','"._post('file')."', '".user_id()."', now() , '".$thumb."', '".toDb(_post('title')) ."', '".$sec."', '".toDb(_post('tags'))."', '0','".toDb(_post('categ'))."','".toDb(_post('description'))."','".toDb(_post('nsfw'))."','".intval(_post('views'))."','".intval(_post('featured'))."')");	
} else {
//if it's remote file
$db->query("INSERT INTO ".DB_PREFIX."videos (`pub`,`remote`, `user_id`, `date`, `thumb`, `title`, `duration`, `tags`, `liked` , `category`, `description`, `nsfw`, `views`, `featured`) VALUES 
('".intval(_post('pub'))."','"._post('file')."', '".user_id()."', now() , '".$thumb."', '".toDb(_post('title')) ."', '".$sec."', '".toDb(_post('tags'))."', '0','".toDb(_post('categ'))."','".toDb(_post('description'))."','".toDb(_post('nsfw'))."','".intval(_post('views'))."','".intval(_post('featured'))."')");	
}
$doit = $db->get_row("SELECT id from ".DB_PREFIX."videos where user_id = '".user_id()."' order by id DESC limit 0,1");
add_activity('4', $doit->id);
echo '<div class="msg-info">'._post('title').' '._lang("created successfully.").' <a href="'.admin_url("videos").'">'._lang("Manage videos.").'</a></div>';
}elseif(_post('vfile') || _post('vremote')) { 
if(_post('vfile')){
$vid = new Vibe_Providers();
if(!$vid->isValid(_post('vfile'))){
echo '<div class="msg-warning">'._lang("We don't support yet embeds from that website").'</div>';
die();
}
$details = $vid->get_data();	
$file = _post('vfile');
$type = 1;
}
if(_post('vremote')){
if(!validateRemote(_post('vremote'))){ 
echo '<div class="msg-warning">'._lang("Seems that link it's not valid or link is wrong").'</div>';
die();
}
$file = _post('vremote');
$details = array("title" => "","thumbnail" => "","duration" => "","description" => "");
$type = 2;
}
$span = 12;
$data = '<div class="clearfix">			
	<div class="row-fluid clearfix ">
		<h3 class="loop-heading"><span>'._lang("Share video by link").'</span></h3>	
    <div id="formVid" class="span12 pull-left well">
	<h3 style="display:block; margin:10px 20px">'._lang("New video details").'</h3>
	<div class="ajax-form-result clearfix "></div>
	<form id="validate" class="form-horizontal styled" action="'.admin_url('add-video').'" enctype="multipart/form-data" method="post">
	<input type="hidden" name="file" id="file" value="'.$file.'" readonly/>
	<input type="hidden" name="type" id="type" value="'.$type.'" readonly/>
	<div class="control-group">
	<label class="control-label">'._lang("Title:").'</label>
	<div class="controls">
	<input type="text" id="title" name="title" class="validate[required] span12" value="'.$details['title'].'">
	</div>
	</div>
	<div class="control-group">
	<label class="control-label">'._lang("Thumbnail:").'</label>
	<div class="controls"> <input type="file" name="play-img" id="play-img" class="styled">
	<h3>'._lang("OR").'</h3>
	<div class="row-fluid">';
	if($details['thumbnail'] && !empty($details['thumbnail'])) {
$data .=' <div class="span4 pull-left">
	<img src="'.$details['thumbnail'].'"/>
	</div>
<div class="span8 pull-right">
	<input type="text" id="remote-img" name="remote-img" class=" span12" value="'.$details['thumbnail'].'" placeholder="'._lang("http://www.dailymotion.com/img/x116zuj_imbroglio_shortfilms.jpg").'">
	<span class="help-block" id="limit-text">'._lang("Link to original video image file. Don't change this to use video default (if any in left)").'</span>
	</div>';
} else {
$data .='
	<input type="text" id="remote-img" name="remote-img" class=" span12" value="" placeholder="'._lang("http://www.dailymotion.com/img/x116zuj_imbroglio_shortfilms.jpg").'">
	<span class="help-block" id="limit-text">'._lang("Link to web image file.").'</span>
	
 ';
}	
$data .=' 	</div>
	</div>
	</div>
	<div class="control-group">
	<label class="control-label">'._lang("Duration:").'</label>
	<div class="controls">
	<input type="text" id="duration" name="duration" class="validate[required] span12" value="'.$details['duration'].'" placeholder="'._lang("In seconds").'">
	</div>
	</div>
	<div class="control-group">
	<label class="control-label">Initial views</label>
	<div class="controls">
	<input type="text" id="duration" name="views" class="span12" value="1">
	</div>
	</div>
	<div class="control-group">
	<label class="control-label">'._lang("Category:").'</label>
	<div class="controls">
	<select data-placeholder="'._lang("Choose a category:").'" name="categ" id="clear-results" class="select validate[required]" tabindex="2">
	';
$categories = $db->get_results("SELECT cat_id as id, cat_name as name FROM  ".DB_PREFIX."channels order by cat_name asc limit 0,10000");
if($categories) {
foreach ($categories as $cat) {	
$data .='	
	
	 <option value="'.intval($cat->id).'">'.stripslashes($cat->name).'</option> 

	';
	}
}	else {
$data .='<option value="">'._lang("No categories").'</option>';
}
$data .='	  
	  </select>
	  </div>             
	  </div>
	<div class="control-group">
	<label class="control-label">'._lang("Description:").'</label>
	<div class="controls">
	<textarea id="description" name="description" class="validate[required] span12 auto">'.$details['description'].'</textarea>
	</div>
	</div>
	<div class="control-group">
	<label class="control-label">'._lang("Tags:").'</label>
	<div class="controls">
	<input type="text" id="tags" name="tags" class="tags span12" value="">
	</div>
	</div>
	<div class="control-group">
	<label class="control-label">'._lang("NSFW:").'</label>
	<div class="controls">
	<label class="radio inline"><input type="radio" name="nsfw" class="styled" value="1"> '._lang("Not safe").' </label>
	<label class="radio inline"><input type="radio" name="nsfw" class="styled" value="0" checked>'._lang("Safe").'</label>
	</div>
	</div>
	<div class="control-group">
	<label class="control-label">Featured?</label>
	<div class="controls">
	<label class="radio inline"><input type="radio" name="featured" class="styled" value="1"> YES </label>
	<label class="radio inline"><input type="radio" name="featured" class="styled" value="0" checked>NO</label>
	</div>
	</div>
	<div class="control-group">
	<label class="control-label">Published?</label>
	<div class="controls">
	<label class="radio inline"><input type="radio" name="pub" class="styled" value="1" checked> YES </label>
	<label class="radio inline"><input type="radio" name="pub" class="styled" value="0">NO</label>
	</div>
	</div>
	<div class="control-group">
	<button id="Subtn" class="btn btn-success btn-large pull-right" type="submit">'._lang("Add video").'</button>
	</div>
	</form>
	</div>
	
	</div>
	</div>
	</div>
';
echo $data;
 } else { ?>

<div class="row-fluid clearfix ">
    <div id="formVid" class="span12 pull-left well">
	<h3 style="display:block; margin:10px 20px"><?php echo _lang("New video"); ?></h3>
	<form id="validate" class="form-horizontal styled" action="<?php echo admin_url('add-video'); ?>" enctype="multipart/form-data" method="post">
	<input type="hidden" name="vembed" id="vembed" readonly/>
	<div class="control-group">
	<label class="control-label"><?php echo _lang("Social video link:"); ?></label>
	<div class="controls">
	<input type="text" id="vfile" name="vfile" class=" span12" value="" placeholder="<?php echo _lang("http://www.dailymotion.com/video/x116zuj_imbroglio_shortfilms"); ?>">
	<span class="help-block" id="limit-text"><?php echo _lang("Link to video (Youtube, Metacafe, etc)"); ?></span>
	<h3><?php echo _lang("OR"); ?></h3>
	<input type="text" id="vremote" name="vremote" class=" span12" value="" placeholder="<?php echo _lang("http://www.mycustomhost.com/video/rihanna-file.mp4"); ?>">
	<span class="help-block" id="limit-text"><?php echo _lang("Remote file (direct link to .mp4,.flv file)"); ?></span>
	</div>
	</div>
	<div class="control-group">
	<button id="Subtn" class="btn btn-success btn-large pull-right" type="submit"><?php echo _lang("Continue"); ?></button>
	</div>
	</form>
</div>
</div>	
<?php } ?>
	