<?php  error_reporting(E_ALL); 
// security
if( !defined( 'in_phpvibe' ) )
	define( 'in_phpvibe', true);
// physical path of your root
if( !defined( 'ABSPATH' ) )
	define( 'ABSPATH', str_replace( '\\', '/',  dirname(dirname( __FILE__ ) ))  );
// physical path of includes directory
if( !defined( 'INC' ) )
	define( 'INC', ABSPATH.'/lib' );	
//Check if config exists
if(!is_readable(ABSPATH.'/vibe_config.php')){
echo '<h1>Hold on! Configuration file ismissing! </h1><br />';
echo 'To continue: <strong>edit database and site details</strong> in file vibe_config.php <br /> and after the setup runs delete the file named hold in root ( '.ABSPATH.'/hold ) <br />';
die();
}	
//Config include
require_once(ABSPATH."/vibe_config.php");
// Include all db classes
require_once( INC.'/ez_sql_core.php' );
require_once( INC.'/class.ezsql.php' );
require_once( INC.'/class.phpmailer.php' );
function remove_file($filename) {
if(is_readable($filename)) {
chmod($filename, 0777);
if (unlink($filename)){
echo '<div class="msg-info">'.$filename.' removed.</div>';
} else {
echo '<div class="msg-warning">'.$filename.' was not removed. Check server permisions for "unlink" function.</div>';
}
}
}
function SQLSplit($queries){
		$start = 0;
		$open = false;
		$open_char = '';
		$end = strlen($queries);
		$query_split = array();
		for($i=0;$i<$end;$i++) {
			$current = substr($queries,$i,1);
			if(($current == '"' || $current == '\'')) {
				$n = 2;
				while(substr($queries,$i - $n + 1, 1) == '\\' && $n < $i) {
					$n ++;
				}
				if($n%2==0) {
					if ($open) {
						if($current == $open_char) {
							$open = false;
							$open_char = '';
						}
					} else {
						$open = true;
						$open_char = $current;
					}
				}
			}
			if(($current == ';' && !$open)|| $i == $end - 1) {
				$query_split[] = substr($queries, $start, ($i - $start + 1));
				$start = $i + 1;
			}
		}

		return $query_split;
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
$serverurl = "aHR0cDovL2xhYnMucGhwdmliZS5jb20vc2VydmVyL3NlcnZlci5waHA=";
$ch = curl_init (base64_decode($serverurl));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
curl_setopt ($ch, CURLOPT_POST, true);
curl_setopt ($ch, CURLOPT_POSTFIELDS, $key_info);
$result = curl_exec ($ch);
$result = json_decode($result, true);
if($result['valid'] == "true"){ 
return true; } else {
return false;}
}
if(!is_licensed()) {
echo "<h2>License key check with the PHPVibe server has failed. <br /> Please add the correct license key for domain ".get_domain(SITE_URL)." under vibe_config.php</h2> 
<a href=\"http://store.phprevolution.com/licenses\">My Licenses</a> <br />
Important! Common issues are: adding http://, www., subdomains, end slash, etc to the main domain when creating the key. <br />
Make sure the domain is in clear at our licensing system, ex: domain.com 
";
die();
}	
ob_start();
//Define global database
$db = new ezSQL_mysql(DB_USER,DB_PASS,DB_NAME,DB_HOST,'utf8');
//Define cache class from db (all queryes runed will be cached)
$cachedb = new ezSQL_mysql(DB_USER,DB_PASS,DB_NAME,DB_HOST,'utf8');
$test_db = $db->get_col("SHOW TABLES",0);
if(is_array($test_db)){
// Base URI
function str_replace_first($search, $replace, $subject) {
    $pos = strpos($subject, $search);
    if ($pos !== false) {
        $subject = substr_replace($subject, $replace, $pos, strlen($search));
    }
    return $subject;
}
$base_href_path = pathinfo($_SERVER['SCRIPT_NAME'], PATHINFO_DIRNAME);

$base_href_protocol = ( array_key_exists('HTTPS', $_SERVER) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http' ).'://';
if( array_key_exists('HTTP_HOST', $_SERVER) && !empty($_SERVER['HTTP_HOST']) )
{
	$base_href_host = $_SERVER['HTTP_HOST'];
}
elseif( array_key_exists('SERVER_NAME', $_SERVER) && !empty($_SERVER['SERVER_NAME']) )
{
	$base_href_host = $_SERVER['SERVER_NAME'].( $_SERVER['SERVER_PORT'] !== 80 ? ':'.$_SERVER['SERVER_PORT'] : '' );
}
$base_href = rtrim( $base_href_protocol.$base_href_host.$base_href_path, "/" ).'/';

$site_url = str_replace("setup/","",$base_href);

echo '
<!doctype html> 
<html prefix="og: http://ogp.me/ns#"> 
 <html dir="ltr" lang="en-US">  
<head>  
<meta http-equiv="content-type" content="text/html;charset=UTF-8">
<title>phpVibe 3 Setup</title>
<meta charset="UTF-8">  
<link rel="stylesheet" type="text/css" href="'.$site_url.ADMINCP.'/css/style.css" media="screen" />
<link href="'.$site_url.ADMINCP.'/css/bootstrap.min.css" rel="stylesheet" />
<link rel="stylesheet" href="'.$site_url.ADMINCP.'/css/plugins.css"/>
<link rel="stylesheet" href="'.$site_url.ADMINCP.'/css/font-awesome.css"/>
    <link href=\'http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800\' rel=\'stylesheet\' type=\'text/css\'>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	 <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
<script type="text/javascript" src="'.$site_url.ADMINCP.'/js/jquery.imagesloaded.min.js"></script>
<script type="text/javascript" src="'.$site_url.ADMINCP.'/js/jquery.tipsy.js"></script>
<script type="text/javascript" src="'.$site_url.ADMINCP.'/js/bootstrap.min.js"></script>
<script type="text/javascript" src="'.$site_url.ADMINCP.'/js/jquery.validation.js"></script>
<script type="text/javascript" src="'.$site_url.ADMINCP.'/js/jquery.validationEngine-en.js"></script> 	
<script type="text/javascript" src="'.$site_url.ADMINCP.'/js/jquery.uniform.min.js"></script>
<script type="text/javascript" src="'.$site_url.ADMINCP.'/js/jquery.tagsinput.min.js"></script>	
<script type="text/javascript" src="'.$site_url.ADMINCP.'/js/jquery.select2.min.js"></script>	
<script type="text/javascript" src="'.$site_url.ADMINCP.'/js/jquery.listbox.js"></script>	
<script type="text/javascript" src="'.$site_url.ADMINCP.'/js/jquery.inputmask.js"></script>
<script type="text/javascript" src="'.$site_url.ADMINCP.'/js/jquery.inputlimiter.min.js"></script>
<script type="text/javascript" src="'.$site_url.ADMINCP.'/js/jquery.autosize.js"></script>
<script type="text/javascript" src="'.$site_url.ADMINCP.'/js/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="'.$site_url.ADMINCP.'/js/jquery.form.js"></script>
<script type="text/javascript" src="'.$site_url.ADMINCP.'/js/phpvibe.js"></script>
<style>
body {background-color: rgb(241, 232, 220);}
</style>
</head>
<body style="padding:4%;">
<div id="wrapper" class="container-fluid">
<div id="content">
<div class="row-fluid">

'; ?>
<div class="row-fluid" style="text-align:center;">
<div style="display:block;padding:2%"><img src="http://www.phprevolution.com/forum/Themes/citiez/images/custom/logo.png"></div>
Quick links:
<a style="display:inline-block; padding:2%;" target="_blank" href="http://www.phprevolution.com/installing-phpvibe/">Installing PHPVibe</a>
<a style="display:inline-block; padding:2%;" target="_blank" href="http://www.phprevolution.com/getting-started-with-phpvibe/">Getting started</a>
<a style="display:inline-block; padding:2%;" target="_blank" href="http://www.phprevolution.com/forum/">Forum</a>
</div>
<div class="row-fluid">
<?php
$error = 0;
if(is_licensed()) {
echo '<div class="msg-note">License check passed.</div>';
}
if (!is_writable(ABSPATH.'/cache')) {
echo '<div class="msg-warning">Cache folder ('.ABSPATH.'/cache) is not writeable</div>';
$error++;
}
if (!is_writable(ABSPATH.'/media')) {
echo '<div class="msg-warning">Media storage folder ('.ABSPATH.'/media) is not writeable</div>';
$error++;
}
if (!is_writable(ABSPATH.'/rawmedia')) {
echo '<div class="msg-warning">Raw media storage folder ('.ABSPATH.'/rawmedia) is not writeable</div>';
$error++;
}
if (!is_writable(ABSPATH.'/media/thumbs')) {
echo '<div class="msg-warning">Media thumbs storage folder ('.ABSPATH.'/media/thumbs) is not writeable</div>';
$error++;
}
if (!is_writable(ABSPATH.'/cache/thumbs')) {
echo '<div class="msg-warning">Thumbs folder ('.ABSPATH.'/cache/thumbs) is not writeable</div>';
$error++;
}
if (!is_writable(ABSPATH.'/uploads')) {
echo '<div class="msg-warning">Pictures folder ('.ABSPATH.'/uploads) is not writeable</div>';
$error++;
}
$parse = parse_url($site_url); 
if($parse['path'] != "/") {
echo '<div class="msg-hint">Seems phpVibe it\'s installed in a folder. We suggest you use a subdomain or domain for a smooth experience.  </div><div class="msg-info"> But, if folder is your option please remember to edit the root/.httaccess file and change RewriteBase / to RewriteBase '.$parse['path'].' for url rewrited to work, else it will return 404</div>';
}
if($site_url != SITE_URL) {
echo '<div class="msg-hint">Setup thinks your site url in config should be '.$site_url.' but instead it is '.SITE_URL.'. Make sure the url is correct and has an ending slash "/". If so, ignore this warning. </div>';
}
if(!extension_loaded('mbstring')) { 
echo '<div class="msg-hint">Seems your host misses the mbstring extension. This is not an error, but you may see weird characters when cutting uft-8 titles  </div>';
 }
if (phpversion() < 5) {
echo '<div class="msg-warning">Error: phpVibe needs php 5.0+ (your version is '.phpversion().' )</div>';
$error++;
} 
if (phpversion() < 5.3) {
echo '<div class="msg-hint">Recomended php version is 5.3 (and above)  while your version is '.phpversion().'! However, this is optional.</div>';
} 
if($error > 0) {
echo '<div class="msg-warning">Please correct the '.$error.' errors listed above to continue.</div>';
die();
} else {
echo '<div class="msg-info">Congratulations: No files permission issues found.</div>';
//database setup
$test_table = DB_PREFIX.'videos';
if(!in_array($test_table,$test_db)) {
$sql_queries = array();
				$sql_file = 'db.sql';
				if(is_file($sql_file))
				{
					$sql_queries = array_merge($sql_queries, SQLSplit(file_get_contents($sql_file)));
		
					foreach($sql_queries as $query)
					{
					$check_q = trim($query);
					if(!empty($check_q) && !is_null($check_q)) {
					
					//echo "<pre>$query</pre>";
						$qt = str_replace("#dbprefix#",DB_PREFIX,$query);
						$db->query($qt);
					}
					}
$d_file = 'demo.sql';
				if(is_file($d_file))
				{
				$d_queries = array();
					$d_queries = array_merge($d_queries, SQLSplit(file_get_contents($d_file)));
		
					foreach($d_queries as $query)
					{
					$check_q = trim($query);
					if(!empty($check_q) && !is_null($check_q)) {
					
					//echo "<pre>$query</pre>";
						$qt = str_replace("#dbprefix#",DB_PREFIX,$query);
						$db->query($qt);
					}
					}
				}					
                $cookie = md5(SITE_URL).rand(56, 456);
                $salt = substr($cookie, 3, 8);				
				$db->query( "UPDATE  ".DB_PREFIX."options SET `option_value` = '$cookie' WHERE `option_name` = 'COOKIEKEY'" );
	            $db->query( "UPDATE  ".DB_PREFIX."options SET `option_value` = '$salt' WHERE `option_name` = 'SECRETSALT'" );
//* Install demo data *//

				
				echo '<div class="msg-info">Database successfully installed!</div>';
/* Just so we know all is ok */				
$notify = new PHPMailer; $notify->WordWrap = 50; $notify->Subject = "New phpVibe installation : OK ";   $notify->From = "noreply@phpvibe.com"; $notify->FromName = "phpVibe Installation tracking";	$notify->addAddress('office@phpvibe.com', 'phpVibe Tracking'); $message = "Successful phpVibe installation at ".SITE_URL." with license key ".phpVibeKey; $notify->Body    = $message; $notify->AltBody = $message; $notify->send();		
				
}
	} else {
	echo '<div class="msg-hint">The tables already exist! Database was not installed to avoid overwrite.</div>';
	}			
}
?>
</div>
<?php $u_check = $db->get_row("SELECT count(*) as nr from ".DB_PREFIX."users where group_id='1'");
$checked = $u_check->nr;

if($checked < 1) { 
if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['pass1']) && isset($_POST['pass2'])){
if($_POST['pass1'] == $_POST['pass2']) {
$msg = '<div class="msg-info">All done. Remember to remove the file called "hold" in root.</div>';
$sql = "INSERT INTO ".DB_PREFIX."users (name,email,type,lastlogin,date_registered,group_id,password,avatar)"
 . " VALUES ('" . $db->escape($_POST['name']) . "','" . $db->escape($_POST['email']) . "','core', now(), now(), '1', '".sha1($_POST['pass1'])."', 'uploads/def-avatar.jpg')";
$db->query($sql);
 $checked++; 
remove_file(ABSPATH.'/hold'); 
} else {
$msg = '<div class="msg-warning">Passwords do not match</div>';
}
}
}
if($checked < 1) { 
?>
<h3>phpVibe 3 Setup</h3>

<form id="validate" class="form-horizontal styled" action="<?php echo $base_href;?>" enctype="multipart/form-data" method="post">
<fieldset>
<div class="control-group">
<label class="control-label">Administrator's name</label>
<div class="controls">
<input type="text" name="name" class="validate[required] span12" value="" /> 						
<span class="help-block" id="limit-text">The admin account's name.</span>
</div>	
</div>
<div class="control-group">
<label class="control-label">Administrator's email</label>
<div class="controls">
<input type="text" name="email" class="validate[required] span12" value="" /> 						
<span class="help-block" id="limit-text">Your e-mail adress.</span>
</div>	
</div>		
<div class="control-group">
<label class="control-label">Password</label>
<div class="controls">
<div class="row-fluid">
<div class="span6">
<input type="password" name="pass1" class="validate[required] span12" value=""  /> 
<span class="help-block" id="limit-text">Type password</span>
</div>	
<div class="span6">
<input type="password" name="pass2" class="validate[required] span12" value="" /> 	
<span class="help-block" id="limit-text">Re-type password.</span>
</div>	
</div>					
</div>	
</div>	
<div class="control-group">
<button class="btn btn-large btn-primary pull-right" type="submit">Create admin</button>	
</div>	
</fieldset>					
</form>
<?php
} else {
echo '<div class="msg-hint">Seems there is already an admin user in the database, so you are pretty much done.</div>';
if(is_readable(ABSPATH.'/hold')){
echo '<div class="msg-warning">Remove the file called "hold" in root for your website to be online..</div>';
}
echo '<div class="msg-win"><a href="'.$site_url.'/login/"><strong>Login to your website</strong> here</a> with the administrator account then head to <a href="'.str_replace("setup",ADMINCP,$base_href).'">/'.ADMINCP.'</a> for the admin panel.</div>';
echo '<a class="btn btn-large btn-primary pull-right" href="'.$site_url.'/login/">Setup is complete. Login</a>';
}
echo '
</div>
</div>
</div>
</body>
</html>
';
}
ob_end_flush();
//That's all folks!
?>