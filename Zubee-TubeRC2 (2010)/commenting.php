<?php
require_once "mainfile.php";
require_once('recaptchalib.php');
$privatekey = "your private key";
$resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

if (!$resp->is_valid) {
  die ("The reCAPTCHA wasn't entered correctly. Go back and try it again." .
       "(reCAPTCHA said: " . $resp->error . ")");
}
if (isset($_POST['redirect'])) {

    $variables = explode('-X-', $_POST['redirect']);
    $video_id  = $variables[0];
    $title     = $variables[1];

    $username    = $_POST['uname'];
    $website     = $_POST['uwebsite'];
    $comment     = $_POST['comment'];

  if ($username != "" || $comment != ""):

    $username  = Security($username);
    $website   = Security($website);
    $comment   = Security($comment);
    
    $date = date("d/m/y - G:i A");

    dbquery("INSERT INTO `comments` VALUES (null, '".$video_id."', '".$username."', '".$website."', '".$comment."', '".$date."');");
    dbquery("UPDATE `videos` SET comments = comments+1 WHERE video_id = '".$video_id."'");
    
    redirect($site_url.$video_id.'/'.Friendly_URL($title).'.html#sh_commenting');

  endif;
  
} else { redirect($site_url); }

?>