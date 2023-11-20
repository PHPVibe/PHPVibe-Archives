<?php if(!is_user()) { redirect(site_url().'login/'); }
$error='';
// SEO Filters
function modify_title( $text ) {
 return strip_tags(stripslashes($text.' '._lang('share')));
}
$token = md5(user_name().user_id().time());
function modify_content_embed( $text ) {
global $error, $token, $db;
if(!_post('vfile')) {
$data =  $error.'
<h3 class="loop-heading"><span>'._lang("Share video by link").'</span></h3>	
   <div class="clearfix" style="margin:10px;">			
	<div class="row-fluid clearfix ">
    <div id="formVid" class="span12 pull-left well">
	<h3 style="display:block; margin:10px 20px">'._lang("New video").'</h3>
	<form id="validate" class="form-horizontal styled" action="'.canonical().'" enctype="multipart/form-data" method="post">
	<input type="hidden" name="vembed" id="vembed" readonly/>
	<div class="control-group">
	<label class="control-label">'._lang("Social video link:").'</label>
	<div class="controls">
	<input type="text" id="vfile" name="vfile" class=" span12" value="" placeholder="'._lang("www.dailymotion.com/video/x116zuj_imbroglio_shortfilms").'">
	<span class="help-block" id="limit-text">'._lang("Link to video (Youtube, Metacafe, etc)").'</span>
	</div>
	</div>
	<div class="control-group">
	<button id="Subtn" class="btn btn-success btn-large pull-right" type="submit">'._lang("Continue").'</button>
	</div>
	</form>
	
	';
} elseif(_post('vfile')) {
$vid = new Vibe_Providers();
if(!$vid->isValid(_post('vfile'))){
return '<div class="msg-warning">'._lang("We don't support yet embeds from that website").'</div>';
}
$details = $vid->get_data();	
$file = _post('vfile');
$type = 1;


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
	<div class="row-fluid">
	<div class="control-group span6">
	<label class="control-label">'._lang("Channel:").'</label>
	<div class="controls">
	'.cats_select('categ').'
	  </div>             
	  </div>
	<div class="control-group span6" style="border-top:none;">
	<label class="control-label">'._lang("Duration:").'</label>
	<div class="controls">
	<input type="text" id="duration" name="duration" class="validate[required] span12" value="'.$details['duration'].'" placeholder="'._lang("In seconds").'">
	</div>
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
	<label class="control-label">'._lang("Visibility").' </label>
	<div class="controls">
	<label class="radio inline"><input type="radio" name="priv" class="styled" value="1"> '._lang("Users only").' </label>
	<label class="radio inline"><input type="radio" name="priv" class="styled" value="0" checked>'._lang("Everybody").' </label>
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

if((get_option('sharingrule','0') == 1) ||  is_moderator()) {	
add_filter( 'the_defaults', 'modify_content_embed' );
} else {
add_filter( 'the_defaults', _lang("Sharing is disabled") );
}

//Time for design
 the_header();
include_once(TPL.'/default-full.php');
the_footer();
?>