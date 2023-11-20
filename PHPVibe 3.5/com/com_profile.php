<?php $user = token_id();
//Query this user
if($user > 0) { $profile = $db->get_row("SELECT * FROM ".DB_PREFIX."users where id = '".$user ."' limit  0,1");}
if ($profile) {
// Canonical url
$canonical = profile_url($profile->id , $profile->name);   
// SEO Filters
function modify_title( $text ) {
global $profile;
    return strip_tags(stripslashes($profile->name));
}
function modify_desc( $text ) {
global $profile;
    return _cut(strip_tags(stripslashes($profile->bio)), 160);
}
if(is_powner()) {
if(isset($_POST['changeavatar'])) {
$formInputName   = 'avatar';							
	$savePath	     = ABSPATH.'/uploads';								
	$saveName        = md5(time()).'-'.user_id();									
	$allowedExtArray = array('.jpg', '.png', '.gif');	
	$imageQuality    = 100;
$uploader = new FileUploader($formInputName, $savePath, $saveName , $allowedExtArray);
if ($uploader->getIsSuccessful()) {
//$uploader -> resizeImage(200, 200, 'crop');
$uploader -> saveImage($uploader->getTargetPath(), $imageQuality);
$thumb  = $uploader->getTargetPath();
$avatar = str_replace(ABSPATH.'/' ,'',$thumb);
	
	user::Update('avatar',$avatar);
	user::RefreshUser(user_id());
	redirect(profile_url(user_id(), user_name()).'&sk=edit');
} else { 
$msg = '<div class=".msg-warning">'._lang("Avatar upload failed.").'</div>';

	}

}
if(isset($_POST['changecover'])) {
$formInputName   = 'cover';							
	$savePath	     = ABSPATH.'/uploads';								
	$saveName        = md5(time()).'-'.user_id();									
	$allowedExtArray = array('.jpg', '.png', '.gif');	
	$imageQuality    = 100;
$uploader = new FileUploader($formInputName, $savePath, $saveName , $allowedExtArray);
if ($uploader->getIsSuccessful()) {
$uploader -> resizeImage(1170, 315, 'crop');
$uploader -> saveImage($uploader->getTargetPath(), $imageQuality);
$thumb  = $uploader->getTargetPath();
$cover = str_replace(ABSPATH.'/' ,'',$thumb);
	user::Update('cover',$cover);
	user::RefreshUser(user_id());
	redirect(profile_url(user_id(), user_name()).'&sk=edit');
} else {
$msg = '<div class="msg-warning">'._lang("Cover upload failed.").'</div>';

} 

}
//Details change
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
redirect(profile_url(user_id(), user_name()).'&sk=edit');
}
}
//Filters

add_filter( 'phpvibe_title', 'modify_title' );
add_filter( 'phpvibe_desc', 'modify_desc' );
//Time for design
 the_header();
include_once(TPL.'/profile.php');
 the_footer(); 
 //Track this view
	
$db->query("UPDATE ".DB_PREFIX."users SET views = views+1 WHERE id = '".$profile->id."'");
} else {
//Oups, not found
layout('404');
}
?>