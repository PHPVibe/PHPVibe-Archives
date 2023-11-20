<?php if(!is_user()) { redirect(site_url().'login/'); }
$error='';
// SEO Filters
function modify_title( $text ) {
 return strip_tags(stripslashes($text.' '._lang('share')));
}
$token = md5(user_name().user_id().time());
function file_up_support($text) {
global $token;
$text .= '
<!-- The basic File Upload plugin -->
<script src="'.site_url().'lib/maxupload.js"></script>
 <script type="text/javascript" >
$(document).ready(function(){
	$(\'#dumpvideo\').MaxUpload({
		maxFileSize:3145728000,
		maxFileCount: 1,
		allowedExtensions:[\'.flv\',\'.mp4\',\'.mp3\',\'.jpg\',\'.jpeg\',\'.gif\',\'.png\'],
		data: {"token": "'.$token.'"},
        onComplete: function (data) { processVid(data);  },
		onError: function () { findVideo("'.$token.'"); }		
	});
	 });

  </script>

';
return $text;
}
add_filter( 'filter_extrajs', 'file_up_support');
if(isset($_POST['vtoken'])) {
$source = get_file(_post('vfile'),_post('vtoken'));
$sec = intval(_post('duration'));
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
$thumb = str_replace(ABSPATH.'/' ,'',$thumb);
} else { $thumb  = 'uploads/noimage.png'; 	}
//Do the sql insert
$db->query("INSERT INTO ".DB_PREFIX."videos (`pub`,`source`, `user_id`, `date`, `thumb`, `title`, `duration`, `tags` , `views` , `liked` , `category`, `description`, `nsfw`) VALUES 
('".intval(get_option('videos-initial'))."','".$source."', '".user_id()."', now() , '".$thumb."', '".toDb(_post('title')) ."', '".$sec."', '".toDb(_post('tags'))."', '0', '0','".toDb(_post('categ'))."','".toDb(_post('description'))."','".toDb(_post('nsfw'))."')");	
$error .= '<div class="msg-info">'._post('title').' '._lang("created successfully.").' <a href="'.site_url().me.'&sk=videos">'._lang("Manage videos.").'</a></div>';
$doit = $db->get_row("SELECT id from ".DB_PREFIX."videos where user_id = '".user_id()."' order by id DESC limit 0,1");
add_activity('4', $doit->id);
}

function modify_content( $text ) {
global $error, $token, $db;
$data =  $error.'
<h3 class="loop-heading"><span>'._lang("Share a video").'</span></h3>	
   <div class="clearfix vibe-upload">			
	<div class="row-fluid clearfix ">
	<div id="AddVid" class="span5 pull-left">
	<div id="dumpvideo"></div>
	</div>
    <div id="formVid" class="span7 pull-right nomargin well">
	<h3 style="display:block; margin:10px 20px">'._lang("Video details").'</h3>
	<form id="validate" class="form-horizontal styled" action="'.canonical().'" enctype="multipart/form-data" method="post">
	<input type="hidden" name="vfile" id="vfile"/>	
	<input type="hidden" name="vup" id="vup" value="1"/>	
	<input type="hidden" name="vtoken" id="vtoken" value="'.$token.'"/>
	<div class="control-group">
	<label class="control-label">'._lang("Title:").'</label>
	<div class="controls">
	<input type="text" id="title" name="title" class="validate[required] span12" value="">
	</div>
	</div>
	<div class="control-group">
	<label class="control-label">'._lang("Thumbnail:").'</label>
	<div class="controls"> <input type="file" name="play-img" id="play-img" class="validate[required] styled"></div>
	</div>
	<div class="control-group">
	<label class="control-label">'._lang("Duration:").'</label>
	<div class="controls">
	<input type="text" id="duration" name="duration" class="validate[required] span12" value="" placeholder="'._lang("In seconds").'">
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
	<textarea id="description" name="description" class="validate[required] span12 auto"></textarea>
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
	<button id="Subtn" class="btn btn-large pull-right" type="submit" disabled>'._lang("Waiting for upload").'</button>
	</div>
	</form>
	</div>
	
	</div>
	</div>
	</div>
';
return $data;
}
function modify_content_embed( $text ) {
global $error, $token, $db;
if(!_get('step') || _get('step') < 1) {
$data =  $error.'
<h3 class="loop-heading"><span>'._lang("Share video by link").'</span></h3>	
   <div class="clearfix" style="margin:10px;">			
	<div class="row-fluid clearfix ">
    <div id="formVid" class="span12 pull-left well">
	<h3 style="display:block; margin:10px 20px">'._lang("New video").'</h3>
	<form id="validate" class="form-horizontal styled" action="'.canonical().'&step=2" enctype="multipart/form-data" method="post">
	<input type="hidden" name="vembed" id="vembed" readonly/>
	<div class="control-group">
	<label class="control-label">'._lang("Social video link:").'</label>
	<div class="controls">
	<input type="text" id="vfile" name="vfile" class=" span12" value="" placeholder="'._lang("http://www.dailymotion.com/video/x116zuj_imbroglio_shortfilms").'">
	<span class="help-block" id="limit-text">'._lang("Link to video (Youtube, Metacafe, etc)").'</span>
	<h3>'._lang("OR").'</h3>
	<input type="text" id="vremote" name="vremote" class=" span12" value="" placeholder="'._lang("http://www.mycustomhost.com/video/rihanna-file.mp4").'">
	<span class="help-block" id="limit-text">'._lang("Remote file (direct link to .mp4,.flv file)").'</span>
	</div>
	</div>
	<div class="control-group">
	<button id="Subtn" class="btn btn-success btn-large pull-right" type="submit">'._lang("Continue").'</button>
	</div>
	</form>
	
	';
} elseif(_post('vfile') || _post('vremote')) {
if(_post('vfile')){
$vid = new Vibe_Providers();
if(!$vid->isValid(_post('vfile'))){
return '<div class="msg-warning">'._lang("We don't support yet embeds from that website").'</div>';
}
$details = $vid->get_data();	
$file = _post('vfile');
$type = 1;
}
if(_post('vremote')){
if(!validateRemote(_post('vremote'))){ 
return '<div class="msg-warning">'._lang("Seems that link it's not valid or link is wrong").'</div>';
}
$file = _post('vremote');
$details = array("title" => "","thumbnail" => "","duration" => "","description" => "");
$type = 2;
}
$span = 12;
	$data =  $error.'
	<h3 class="loop-heading"><span>'._lang("Share video by link").'</span></h3>	
   <div class="clearfix" style="margin:10px;">			
	<div class="row-fluid clearfix ">
    <div id="formVid" class="span12 pull-left well">
	<h3 style="display:block; margin:10px 20px">'._lang("New video details").'</h3>
	<div class="ajax-form-result clearfix "></div>
	<form id="validate" class="form-horizontal ajax-form-video styled" action="'.site_url().'lib/ajax/addVideo.php" enctype="multipart/form-data" method="post">
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
	<button id="Subtn" class="btn btn-success btn-large pull-right" type="submit">'._lang("Add video").'</button>
	</div>
	</form>
	</div>
	
	</div>
	</div>
	</div>
';
} else {
$data ='<div class="msg-warning">'._lang("Something went wrong, please try again.").'</div>';
}
return $data;
}
add_filter( 'phpvibe_title', 'modify_title' );
if(_get('type') && _get('type') > 1) {
add_filter( 'the_defaults', 'modify_content_embed' );
} else {
if((get_option('uploadrule') == 1) ||  is_moderator()) {	
add_filter( 'the_defaults', 'modify_content' );
}
}
//Time for design
 the_header();
include_once(TPL.'/default.php');
the_footer();
?>