<?php require_once("../phpvibe.php");
$width = "748";
$height = "366";
$vid_source = base64_decode($_GET["vid"]);
$vid = new phpVibe($width, $height);
echo $vid->getEmbedCode($vid_source);

if($user->isAuthorized()) {
 $submit_it = $site_url."submit/&vid=".$_GET["vid"];
echo '
<center>
<p><br />
<a href="'. $submit_it.'" class="buttonS bBlue">'.$lang['addthisto'].'</a>
</p></center>
';
}else {
echo '<center>
<p><br /><a href="'.$config->site->url.'login.php" class="btn btn_link"><span>'.$lang['login'].'</span></a></p>
  <div class="alert-box">'.$lang['notpermited'].'</div>
   
   </center>';
}

?>