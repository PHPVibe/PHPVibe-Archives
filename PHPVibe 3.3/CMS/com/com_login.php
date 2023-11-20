<?php $error='';
/** Login via mail request **/

if(_get('do') && (_get('do') == "autologin") && _get('m') && _get('k')) {
$mail = base64_decode(_get('m'));
$key = base64_decode(_get('k'));
$check = user::CheckMail($mail);
if($check > 0 ) {
$result = $db->get_row("SELECT id FROM ".DB_PREFIX."users WHERE email ='" . toDb($mail) . "' and pass = '" . toDb($key) . "'");
if($result && $result->id) {
user::LoginUser($result->id);
if (is_user()) { redirect(site_url().me.'&sk=password');} else {
$error = '<div class="msg-warning">'._lang('Something went wrong. Try refreshing this page').'</div>';
}
} else {
$error = '<div class="msg-warning">'._lang('Something went wrong. Wrong credentials').'</div>';
}
} else {
$error = '<div class="msg-warning">'._lang('Something went wrong. That email is wrong').'</div>';
}
}
/** Actual login **/
if(_post('password') && _post('email')){
if(user::loginbymail(_post('email'),_post('password') )) {
redirect(site_url().me.'/');
} else {
$error = '<div class="msg-warning">'._lang('Wrong username or password.').'</div>';
}
}
/** New password request **/
if(_post('forgot-pass') && _post('remail')){
$check = user::CheckMail(_post('remail'));
if($check > 0 ) {
$omail = toDb(_post('remail'));
$result = $db->get_row("SELECT pass, name FROM ".DB_PREFIX."users WHERE email ='" . toDb($omail) . "'");
if($result) {
$key = base64_encode($result->pass);
$link = site_url().'login&do=autologin&m='.base64_encode($omail).'&k='.$key;
$message = _lang('In order to change your password please follow this link:');
$message .= '<br /> <a href="##link##">##link##</a> <br />';
$message .= 'Regards '.site_url();
$message = str_replace("##link##",$link,$message);	
//echo $link;
$mail = new PHPMailer;
$mail->From = "noreply@".ltrim(cookiedomain(),".");
$mail->FromName = get_option('site_logo-text');	
$mail->addAddress($omail, toDb($result->name));
$mail->WordWrap = 50;  
$mail->Subject = _lang('Password change for'). ' '.$result->name;
$mail->Body    = $message;
$mail->AltBody = $message;
if(!$mail->send()) {
$error = '<div class="msg-warning">'.toDb(_post('remail')).' '._lang('Message could not be sent.').$mail->ErrorInfo.'</div>';
} else {
$error = '<div class="msg-note">'._lang('An e-mail has been sent to your account. Please also check the "spam" folder.').'</div>';					
}
}
} else {
$error = '<div class="msg-warning">'.toDb(_post('remail')).' '._lang('is not registered to any account.').'</div>';
}
}

// SEO Filters
function modify_title( $text ) {
 return strip_tags(stripslashes($text.' '._lang('login')));
}
function modify_content( $text ) {
global $error;
return $error.'
<div id="validate" class="form-signin">
		<h3>'._lang("Sign in to Your Account").'</h3>
	<!-- Row -->
		<div class="row-fluid row-merge clearfix">
		<!-- Column -->
			<div class="span7">
				<div class="inner">
				<!-- Form -->
					<form class="styled" action="'.canonical().'" enctype="multipart/form-data" method="post">
						<label class="strong">'._lang("Email").'</label>
						<input type="text" name="email" class="validate[required] span12" placeholder="'._lang("Email address").' "> 
						<label class="strong">'._lang("Password").' <a class="password" href="'.canonical().'&do=forgot">'._lang("forgot your password?").'</a></label>
						<input type="password" name="password" class="validate[required] span12" placeholder="'._lang("Your Password").'"> 
						<div class="row-fluid">
							<div class="span5 center">
								<button class="btn btn-large btn-primary" type="submit">'._lang("Sign in").'</button>
							</div>
						</div>
					</form>
				</div>
			</div>
			<!-- // Column END -->
			<!-- Column -->
			<div class="span5" style="border-left:1px solid #e5e5e5; ">
				<div class="inner center">
					<p>Alternatively</p>
					<a href="'.site_url().'index.php?action=login&type=facebook" class="button"><i class="icon-facebook-sign"></i><span>'._lang("Join with ").'</span> <span class="strong">'._lang("Facebook ").'</span></a>
					<p>or</p>
					<a href="'.site_url().'index.php?action=login&type=twitter" class="button"><i class="icon-twitter"></i><span>'._lang("Join with ").'</span> <span class="strong">'._lang("Twitter ").'</span></a>
					<p>or</p>
					<a href="'.site_url().'index.php?action=login&type=google" class="button"><i class="icon-google-plus"></i><span>'._lang("Join with ").'</span> <span class="strong">'._lang("Google ").'</span></a>
				</div>
			</div>
			<!-- // Column END -->
		</div>
		<!-- // Row END -->
      </div>
	</div>
';
}
function forgot_content() {
global $error;
return $error.'
<div id="validate" class="form-signin">
		<h3>'._lang("Recover password").'</h3>
	<!-- Row -->
		<div class="row-fluid row-merge clearfix">
		<!-- Column -->
			<div class="span12">
				<div class="inner">
				<!-- Form -->
					<form class="styled" action="'.canonical().'" enctype="multipart/form-data" method="post">
					<input type="hidden" name="forgot-pass" value="1"/>
						<label class="strong">'._lang("Email").'</label>
						<input type="text" name="remail" class="validate[required] span12" placeholder="'._lang("Email address").' "> 
						<div class="row-fluid">
							<div class="span5 center">
								<button class="btn btn-large btn-primary" type="submit">'._lang("Recover").'</button>
							</div>
						</div>
					</form>
				</div>
			</div>
			
		<!-- // Row END -->
      </div>
	</div>';
}
add_filter( 'phpvibe_title', 'modify_title' );
if(_get('do') && (_get('do') == "forgot")) {
add_filter( 'the_defaults', 'forgot_content' );
} else {
add_filter( 'the_defaults', 'modify_content' );
}
//Time for design
 the_header();
include_once(TPL.'/default.php');
the_footer();
?>