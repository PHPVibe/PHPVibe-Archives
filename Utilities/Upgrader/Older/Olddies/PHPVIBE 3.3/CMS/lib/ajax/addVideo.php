<?php  require_once('../../load.php');
function checkRemoteFileImage($url)
{
$pieces_array = explode('.', $url);
		$ext = end($pieces_array);
$file_supported = array("jpg", "jpeg", "png", "gif");
if(in_array($ext, $file_supported)) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    // don't download content
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    if(curl_exec($ch)!==FALSE)
    {
        return true;
    }
    else
    {
        return false;
    }
	} else {
	 return false;
	}
}
if (is_user( )) {
if(_post('type') && _post('file') && ($_FILES['play-img'] || _post('remote-img'))) {
$sec = intval(_post('duration'));
//if is image upload
if(isset($_FILES['play-img']) && !empty($_FILES['play-img']['name'])){
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
} else {
if(checkRemoteFileImage(_post('remote-img'))){
$thumb = _post('remote-img');
} else {
$thumb = 'uploads/noimage.png';
}
}
//Insert video
if(_post('type') < 2) {
//if it's web link
$db->query("INSERT INTO ".DB_PREFIX."videos (`pub`,`source`, `user_id`, `date`, `thumb`, `title`, `duration`, `tags` , `views` , `liked` , `category`, `description`, `nsfw`) VALUES 
('".intval(get_option('videos-initial'))."','"._post('file')."', '".user_id()."', now() , '".$thumb."', '".toDb(_post('title')) ."', '".$sec."', '".toDb(_post('tags'))."', '0', '0','".toDb(_post('categ'))."','".toDb(_post('description'))."','".toDb(_post('nsfw'))."')");	
} else {
//if it's remote file
$db->query("INSERT INTO ".DB_PREFIX."videos (`pub`,`remote`, `user_id`, `date`, `thumb`, `title`, `duration`, `tags` , `views` , `liked` , `category`, `description`, `nsfw`) VALUES 
('".intval(get_option('videos-initial'))."','"._post('file')."', '".user_id()."', now() , '".$thumb."', '".toDb(_post('title')) ."', '".$sec."', '".toDb(_post('tags'))."', '0', '0','".toDb(_post('categ'))."','".toDb(_post('description'))."','".toDb(_post('nsfw'))."')");	
}
$doit = $db->get_row("SELECT id from ".DB_PREFIX."videos where user_id = '".user_id()."' order by id DESC limit 0,1");
add_activity('4', $doit->id);
echo '<div class="msg-info">'._post('title').' '._lang("created successfully.").' <a href="'.site_url().me.'&sk=videos">'._lang("Manage videos.").'</a></div>';
//remove form
echo'
 <script type="text/javascript" >
$(document).ready(function(){
 $(\'.ajax-form-video\').hide();
	 });

  </script>

';
} else {
echo '<div class="msg-warning">'._lang('Something went wrong: Missing file or thumbnail').'</div>';
}
    
} else {
echo '<div class="msg-warning">'._lang('Login first').'</div>';
}
	?>