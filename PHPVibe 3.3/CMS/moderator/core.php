<?php
echo ' <div id="phpvibe-content">
<div class="container-fluid">';
if(_get('sk')) {
//security
$file = ADM.'/'.str_replace(array("/",":","http","www"),array("","","",""),_get("sk")).'.php';
if(is_readable( $file )) {
require_once($file); 
} else {
echo $file.'<br />';
die("Wrong page included...");
}
} else {
require_once( ADM.'/dashboard.php' );
}
echo '</div></div>';
echo '</div></div>';
?>