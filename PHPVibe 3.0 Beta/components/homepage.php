<?php

$seo_title = $config->site->htitle;
$seo_description = $config->site->hdesc;

include_once("tpl/header.php");
$Cache->SetTtl(3600);
$cacheid = seo_clean_url($lang['home']). "-home";
 //if(!$Cache->Start("$cacheid")){ 

include_once("tpl/homepage.tpl.php");
//} 
//echo $Cache->Stop();
include_once("tpl/footer.php");

?>