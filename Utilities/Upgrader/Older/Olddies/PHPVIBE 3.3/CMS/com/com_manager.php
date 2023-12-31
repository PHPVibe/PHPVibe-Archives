<?php if (is_user()) {
$profile = $db->get_row("SELECT * FROM ".DB_PREFIX."users where id = '".user_id()."' limit  0,1");
// Canonical url
$canonical = site_url().me;
if(_get('sk')) { $canonical = site_url().me.'&sk='._get('sk'); }
if(isset($_POST['changeavatar'])) {
$formInputName   = 'avatar';							# This is the name given to the form's file input
	$savePath	     = ABSPATH.'/uploads';								# The folder to save the image
	$saveName        = md5(time()).'-'.user_id();									# Without ext
	$allowedExtArray = array('.jpg', '.png', '.gif');	# Set allowed file types
	$imageQuality    = 100;
$uploader = new FileUploader($formInputName, $savePath, $saveName , $allowedExtArray);
if ($uploader->getIsSuccessful()) {
//$uploader -> resizeImage(200, 200, 'crop');
$uploader -> saveImage($uploader->getTargetPath(), $imageQuality);
$thumb  = $uploader->getTargetPath();
$avatar = str_replace(ABSPATH.'/' ,'',$thumb);
} else { $avatar  = 'uploads/def-avatar.jpg'; 	}
	//$db->query("UPDATE ".DB_PREFIX."users set avatar = '".$avatar."' where id='".user_id()."'");
	user::Update('avatar',$avatar);
	user::RefreshUser(user_id());
	$msg = '<div class="msg-info">'._lang("Avatar changed.").'</div>';
} 

if(isset($_POST['edited-video']) && !is_null(intval($_POST['edited-video']))) {
if($_FILES['play-img']){
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
$thumb  = str_replace(ABSPATH.'/' ,'',$thumb);
} else { $thumb  = 'uploads/noimage.png'; 	}
	$db->query("UPDATE  ".DB_PREFIX."videos SET thumb='".toDb($thumb )."' WHERE user_id= '".user_id()."' and id = '".intval($_POST['edited-video'])."'");

}
$db->query("UPDATE  ".DB_PREFIX."videos SET title='".toDb(_post('title'))."', description='".toDb(_post('description') )."', duration='".intval(_post('duration') )."', category='".toDb(intval(_post('categ')))."', tags='".toDb(_post('tags') )."', nsfw='".intval(_post('nsfw') )."'  WHERE user_id= '".user_id()."' and id = '".intval($_POST['edited-video'])."'");
$msg = '<div class="msg-info">'._lang("Video edited.").'</div>';
} 
if(isset($_POST['change-password'])) {
if($_POST['pass1'] == $_POST['pass2']) {
$msg = '<div class="msg-info">'._lang("Password changed.").'</div>';
user::Update('password',sha1($_POST['pass1']));
} else {
$msg = '<div class="msg-warning">'._lang("Passwords do not match.").'</div>';
}
}
if(isset($_POST['changeuser'])) {
if(isset($_POST['name'])) { user::Update('name',$_POST['name']); }
if(isset($_POST['city'])) { user::Update('local',$_POST['city']); }
if(isset($_POST['country'])) { user::Update('country',$_POST['country']); }
if(isset($_POST['bio'])) { user::Update('bio',$_POST['bio']); }
if(isset($_POST['gender'])) { user::Update('gender',$_POST['gender']); }
if(isset($_POST['f-link'])) { user::Update('fblink',$_POST['f-link']); }
if(isset($_POST['g-link'])) { user::Update('glink',$_POST['g-link']); }
if(isset($_POST['tw-link'])) { user::Update('twlink',$_POST['tw-link']); }
user::RefreshUser(user_id());
redirect(site_url().me);
}
if(isset($_POST['likesRow'])) {
foreach ($_POST['likesRow'] as $del) {
unlike_video($del);
}
$msg = '<div class="msg-info">'._lang("Videos unliked.").'</div>';
}
if(isset($_GET['delete-like'])) {
unlike_video($_GET['delete-like']);
}
if(isset($_GET['delete-video'])) {
unpublish_video(intval($_GET['delete-video']));
$msg = '<div class="msg-info">'._lang("Video unpublished.").'</div>';
} 
if(isset($_POST['playlistsRow'])) {
foreach ($_POST['playlistsRow'] as $del) {
delete_playlist($del);
}
$msg = '<div class="msg-info">'._lang("Playlists deleted.").'</div>';
}
if(isset($_POST['checkRow'])) {
foreach ($_POST['checkRow'] as $del) {
unpublish_video(intval($del));
}
$msg = '<div class="msg-info">'._lang("Videos unpublished.").'</div>';
}
if(isset($_GET['delete-playlist'])) {
delete_playlist($_GET['delete-playlist']);
$msg = '<div class="msg-info">'._lang("Playlist deleted.").'</div>';
}
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
} else { $picture  = 'uploads/noimage.png'; 	}

$db->query("INSERT INTO ".DB_PREFIX."playlists (`owner`, `title`, `picture`, `description`) VALUES ('".user_id()."','".toDb($_POST['play-name'])."', '".toDb($picture)."' , '".toDb($_POST['play-desc'])."')");
$msg = '<div class="msg-info">'._lang("Playlist created.").'</div>';
}
if(isset($msg)) {
// Info filter
function modify_info( $text ) {
global $msg;
    return $text.$msg;
}
add_filter( 'the_defaults' , 'modify_info' );
}
// SEO Filters
function modify_title( $text ) {
    return strip_tags(stripslashes(user_name( )));
}
add_filter( 'phpvibe_title', 'modify_title' );
//Time for design
 the_header();
 if(!_get('sk')) {
include_once(TPL.'/me.php');
} else {
include_once(TPL.'/manager.php');
}
 the_footer(); 
} else {
redirect(site_url().'login');
}
?>