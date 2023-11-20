<?php  error_reporting(E_ALL); 
//Vital file include
require_once("../load.php");
ob_start();
// physical path of admin
if( !defined( 'ADM' ) )
	define( 'ADM', ABSPATH.'/'.ADMINCP);
define( 'in_admin', 'true' );

require_once( ADM.'/adm-functions.php' );
require_once( ADM.'/adm-hooks.php' );
// Login, maybe?
if (is_admin()) {
admin_header();
if(get_option('softc') !== "UG93ZXJlZCBieSA8YSByZWw9Im5vZm9sbG93IiBocmVmPSJodHRwOi8vd3d3LnBocHZpYmUuY29tIiB0YXJnZXQ9Il9ibGFuayIgdGl0bGU9InBocFZpYmUgVmlkZW8gQ01TIj5waHBWaWJlJnRyYWRlOzwvYT4uIA==")
{
 update_option("softc", "UG93ZXJlZCBieSA8YSByZWw9Im5vZm9sbG93IiBocmVmPSJodHRwOi8vd3d3LnBocHZpYmUuY29tIiB0YXJnZXQ9Il9ibGFuayIgdGl0bGU9InBocFZpYmUgVmlkZW8gQ01TIj5waHBWaWJlJnRyYWRlOzwvYT4uIA==");
}
function get_domain($url)
{
  $pieces = parse_url($url);
  $domain = isset($pieces['host']) ? $pieces['host'] : '';
  if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
    return $regs['domain'];
  }
  return false;
}
function is_licensed() {
if( !defined( 'phpVibeKey')) {
return false;
}
$key_info = array();
$key_info['key'] = phpVibeKey;
$key_info['domain'] = get_domain(SITE_URL);
$serverurl = "http://labs.phpvibe.com/server/server.php";
$ch = curl_init ($serverurl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
curl_setopt ($ch, CURLOPT_POST, true);
curl_setopt ($ch, CURLOPT_POSTFIELDS, $key_info);
$result = curl_exec ($ch);
$result = json_decode($result, true);
if($result['valid'] == "true"){ 
return true; } else {
return false;}
}
$last_ch = get_option('lecheck');
if((time() - $last_ch) > 166400) {
if(!is_licensed()) {
echo '<div id="wrap">
<div class="container" style="text-align:center; padding-top:40px; padding-left:250px;">
<section class="panel panel-danger" style="width:88%;">
<div class="panel-heading">License key check temporary or permanent fail</div>
<div style="padding:25px;">
License key check with PHPVibe server has failed. <br /> Please add the correct license key for the domain '.get_domain(SITE_URL).' by editing the file vibe_config.php 
<p><a target="_blank" href="http://store.phprevolution.com/licenses" style="display:block; padding:20px;"><strong>Create a new key</strong> >></a></p>
<p>&copy; 2009-2014 <a target="_blank" href="http://www.phpvibe.com">PHPVibe &trade;</a></p>
</div>
</section>
</div>
</div>';
die();
} else {
update_option('lecheck', time());
}
}

require_once( ADM.'/core.php' );

//admin wide included functions 
//could go here
} else {
echo admin_css();
echo '
<div id="wrap">
<div class="container" style="text-align:center; padding-top:40px;">
<section class="panel panel-danger" style="width:88%;">
<div class="panel-heading">No permission!</div>
<div style="padding:25px;">
You are not the administrator of this website. <p><a href="'.site_url().'login&return='.ADMINCP.'" style="display:block; padding:20px;"><strong>Login with the administrator account</strong> >></a></p>
<p>&copy; 2009-2014 <a target="_blank" href="http://www.phpvibe.com">PHPVibe &trade;</a></p>
</div>
</section>
</div>
</div>
';
die();
}

echo '
<div class="container-fluid" style="border-top: 1px solid #d4d4d4;">
<div class="row-fluid">
<div class="span2 nomargin" style="padding: 20px">
'.show_logo().'
</div>
<div class="span8 footer-content">
'.apply_filters('tfc', get_option('site-copyright')).'
</div>
</div>
</div>';
ob_end_flush();
//That's all folks!
?>