<?php $error='';
require_once(INC.'/recaptchalib.php');
$publickey = "6Lc-A84SAAAAAD3btrvWyQUi7MI6EX1fH_RE6p0U"; 
$privatekey = "6Lc-A84SAAAAAONAhS-azqRi9Dyqkkzz5XZ4FvMb";
function add_rec($text) {
$text = $text.'<script type="text/javascript">
 var RecaptchaOptions = {     theme : \'clean\'  };
 </script>';
return $text;
}
add_filter( 'filter_extracss', 'add_rec' );

						 
//If submited
if(get_option('allowlocalreg') == 1 ) {
if(_post('name') && _post('password') && _post('email')){
$resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

  if (!$resp->is_valid) {
    // What happens when the CAPTCHA was entered incorrectly
   $error = '<div class="msg-warning">The reCAPTCHA wasn\'t entered correctly. Go back and try it again
         reCAPTCHA error: ' . $resp->error.'</div>';
  } else {
  if(_post('password') == _post('password2')) {
    $avatar = 'uploads/def-avatar.jpg';
	if($_FILES['avatar']){
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
} 
	}
		if(user::CheckMail(_post('email')) < 1) {
		$keys_values = array(
                                "avatar"=> $avatar,
								"local"=> _post('city'),
								"country"=> _post('country'),
                                "name"=> _post('name'),								
								"email"=> _post('email'),
                                "password"	 => sha1(_post('password')),							
                                "type"=> "core"  );
		$id = user::AddUser($keys_values);
        user::LoginUser($id);
	
		} else {
		$error = '<div class="msg-warning">' . _lang('Email already in use').'</div>';
		}						
	
	} else {
	$error = '<div class="msg-warning">' . _lang('Passwords are not the same').'</div>';
  }
}
}
}
if (is_user()) { redirect(site_url().me);}
if(get_option('allowlocalreg') == 0 ) { redirect(site_url()); }
$captcha =  recaptcha_get_html($publickey);

// SEO Filters
function modify_title( $text ) {
 return strip_tags(stripslashes($text.' '._lang('registration')));
}
function modify_content( $text ) {
global $error , $captcha;
return $error.'
<div id="validate" class="form-signin">
		<h3>'._lang("Create a new Account").'</h3>
	<!-- Row -->
		<div class="row-fluid row-merge clearfix">
		
				<div class="inner">
				<!-- Form -->
					<form class="styled" action="'.canonical().'" enctype="multipart/form-data" method="post">
					    <label class="strong">'._lang("Name").'<span class="text-error">*</span></label>
						<input type="text" name="name" class="validate[required] span12" placeholder="'._lang("Your stage name").' "> 						
						<label class="strong">'._lang("Email").'<span class="text-error">*</span></label>
						<input type="text" name="email" class="validate[required] span12" placeholder="'._lang("Email address").' "> 
						<label class="strong">'._lang("Choose Password").' <span class="text-error">*</span></label>
						<input type="password" name="password" class="validate[required] span12" placeholder="'._lang("Choose Password").'"> 
						<label class="strong">'._lang("Repeat Password").'<span class="text-error">*</span></label>
						<input type="password" name="password2" class="validate[required] span12" placeholder="'._lang("Repeat Password").'"> 
						<label class="strong">'._lang("City").'<span class="text-error">*</span></label>
						<input type="text" name="city" class="validate[required] span12" placeholder="'._lang("City").'"> 
						<label class="strong">'._lang("Country").'<span class="text-error">*</span></label>
						<input type="text" name="country" class="validate[required] span12" placeholder="'._lang("Country").'"> 
						 <label class="strong">'._lang("Avatar").'<span class="text-error">*</span></label>
	                       <input type="file" name="avatar" class="validate[required] styled">
	                           <div class="row-fluid top10 bottom10">      '.$captcha.'</div>
						<div class="row-fluid">
							<div class="span5 center">
								<button class="btn btn-large btn-primary" type="submit">'._lang("Register").'</button>
							</div>
						</div>
					</form>
				</div>
			
			
			</div>
			<!-- // Column END -->
		</div>
		<!-- // Row END -->
      </div>
	</div>
';
}
add_filter( 'phpvibe_title', 'modify_title' );
add_filter( 'the_defaults', 'modify_content' );

//Time for design
 the_header();
include_once(TPL.'/default.php');
the_footer();
?>