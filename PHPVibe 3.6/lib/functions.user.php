<?php
function is_user( ) {
return isset($_SESSION['user_id']);
}
function user_id( ) {
return intval($_SESSION['user_id']);
}
function user_name( ) {
return $_SESSION['name'];
}
function my_profile() {
return profile_url(user_id( ), user_name( ));
}
function user_un( ) {
return $_SESSION['username'];
}
function user_avatar( ) {
return thumb_fix($_SESSION['avatar']);
}
function user_group() {
if (is_user( )) {
$gr = isset($_SESSION['group']) ? intval($_SESSION['group']) : 1 ;
return $gr;
} else {
return false;
}
}
function is_admin() {
global $db;
if (!is_user() || user_group() <> 1) {
return false;
} else {
$check = $db->get_row("SELECT group_id from ".DB_PREFIX."users WHERE id='".user_id()."'");
if($check && ($check->group_id == 1)) {
return true;
} else {
return false;
}
}
}
function is_moderator(){
global $db;
if (!is_user() || user_group() > 2 ) {
return false;
} else {
$check = $db->get_row("SELECT group_id from ".DB_PREFIX."users WHERE id='".user_id()."'");
if($check && ($check->group_id < 3)) {
return true;
} else {
return false;
}
}
}

function validate_session() {
if (isset($_SESSION['HTTP_USER_AGENT'])) {
            if ($_SESSION['HTTP_USER_AGENT'] != md5($_SERVER['HTTP_USER_AGENT'])) {
               user::clearSessionData();
                exit;
            }
        }
}
function authByCookie() {
if (!is_user() && isset($_COOKIE[COOKIEKEY]))
{
user::LoginbyPass($_COOKIE[COOKIEKEY]);
}

}

class user{
public static function encrypt($text, $salt) 
{ 
if ( function_exists('mcrypt_encrypt') ) { 
 $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CFB), MCRYPT_RAND);
    return strrev($iv) . '@@' .
        mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $salt, $text, MCRYPT_MODE_CFB, $iv);
  
} else {
return $text;
} 
}

public static function decrypt($text, $salt) 
{ 
if ( function_exists('mcrypt_encrypt') ) { 
list($iv, $data) = explode('@@', $text);
    return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $salt, $data, MCRYPT_MODE_CFB, strrev($iv))); 
} else {
return $text;
}
}
public static function checkUser($userData) {
global $db;
//var_dump($userData);
switch ($userData['type']) {
	case "twitter":
	if(!empty($userData['oauth_token'])) {	
	$result = $db->get_var("SELECT id FROM ".DB_PREFIX."users WHERE oauth_token ='" . $userData['oauth_token'] . "'");
	return 	$result;	
} else {
die(_lang('Error. Please go back'));
}		
		
		break;
		case "google":
	if(!empty($userData['gid'])) {		
	 $result = $db->get_var("SELECT id FROM ".DB_PREFIX."users WHERE gid ='" . $userData['gid'] . "'");
	return 	$result;
	} else {
die(_lang('Error. Please go back'));
}
		
		break;
	case "facebook":
	if(!empty($userData['fid'])) {	
	$result = $db->get_var("SELECT id FROM ".DB_PREFIX."users WHERE fid ='" . $userData['fid'] . "'");
	return 	$result;	
	} else {
die(_lang('Error. Please go back'));
}	
		break;	
case "core":
if(!empty($userData['email'])) {	
	$result = $db->get_var("SELECT id FROM ".DB_PREFIX."users WHERE email ='" . toDb($userData['email']) . "'");
	return 	$result;	
	} else {
die(_lang('Error. Please go back'));
}	
break;	
}
}
public static function CheckMail($mail) {
global $db;
$result = $db->get_row("SELECT count(*) as dup FROM ".DB_PREFIX."users WHERE email ='" . toDb($mail) . "'");
if($result) {
return $result->dup;
}
return 0;
}
public static function checkUnique($field, $value) {
global $db;
$result = $db->get_var("SELECT count(*) FROM ".DB_PREFIX."users WHERE ".$field." ='" . $value . "'");
if($result && ($result > 0 )) {
return false;
} else {return true;}
}
public static function generateRandomNumber($length = 9) {
        $random= "";

        srand((double)microtime()*1000000);

        $data = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $data .= "abcdefghijklmnopqrstuvwxyz";
        $data .= "0123456789";

        for($i = 0; $i < $length; $i++) {
            $random .= substr($data, (rand()%(strlen($data))), 1);
        }

        $tk = md5($random);
		if (user::checkUnique('pass', $tk)) {
		return $tk;
		} else {
		$tk= user::generateRandomNumber();
		}
}

public static function AddUser($userData) {
global $db;
$pass = user::generateRandomNumber();
//avoid not set issues
if(!isset($userData['username']) || nullval($userData['username'])) { $userData['username'] = nice_url($userData['name']); }
if (!user::checkUnique('username', $userData['username'])) { $userData['username'] = ''; }
if(!isset($userData['avatar']) || empty($userData['avatar'])) {$userData['avatar'] = 'uploads/noimage.png';}
if(!isset($userData['email']) || empty($userData['email'])) {$userData['email'] = '';}
if(!isset($userData['gid']) || empty($userData['gid'])) {$userData['gid'] = '';}
if(!isset($userData['fid']) || empty($userData['fid'])) {$userData['fid'] = '';}
if(!isset($userData['oauth_token']) || empty($userData['oauth_token'])) {$userData['oauth_token'] = '';}
if(!isset($userData['password']) || empty($userData['password'])) {$userData['password'] = '';}
if(!isset($userData['local']) || empty($userData['local'])) {$userData['local'] = '';}
if(!isset($userData['country']) || empty($userData['country'])) {$userData['country'] = '';}
if(!isset($userData['bio']) || empty($userData['bio'])) {$userData['bio'] = '';}
//insert to db
$sql = "INSERT INTO ".DB_PREFIX."users (name,username,email,type,lastlogin,date_registered,gid,fid,oauth_token,avatar,local,country,group_id,pass,password,bio)"
 . " VALUES ('" . toDb($userData['name']) . "','" . toDb($userData['username']) . "','" . esc_attr($userData['email']) . "','" . $userData['type'] . "', now(), now(), '".$userData['gid']."', '".$userData['fid']."', '".$userData['oauth_token']."', '".$userData['avatar']."', '".toDb($userData['local'])."', '".toDb($userData['country'])."', '4', '".$pass."','".toDb($userData['password'])."', '".toDb($userData['bio'])."')";
     
$db->query($sql);
$tid = user::checkUser($userData);
return $tid;
}
public static function loginbymail($mail, $pass) {
global $db;
$result = $db->get_row("SELECT id FROM ".DB_PREFIX."users WHERE email ='" . toDb($mail) . "' and password = '".sha1($pass)."'");
if ($result && $result->id) {
user::LoginUser($result->id);
return true;
}
return false;
}
public static function LoginUser($id) {
global $db;
if($id && ($id > 0)) {
user::LastLogin($id);
$result = $db->get_row ("SELECT * FROM ".DB_PREFIX."users WHERE id ='" . sanitize_int($id) . "'");
$new_pass = user::generateRandomNumber();
user::ChangePass($id, $new_pass);
user::setSessionData('vibe_user',$result,$new_pass);
}
}
public static function ChangePass($id, $pass) {
global $db;
$db->query ("UPDATE  ".DB_PREFIX."users SET pass='".$pass."' WHERE id ='" . sanitize_int($id) . "'");
}
public static function LastLogin($id) {
global $db;
$db->query ("UPDATE  ".DB_PREFIX."users SET lastlogin=now() WHERE id ='" . sanitize_int($id) . "'");
}
public static function LoginbyPass($full) {
global $db;
if($full && !empty($full)){
list($id, $pass) = explode(COOKIESPLIT, user::decrypt($full, SECRETSALT));
if(isset($id) && isset($pass) && $id && $pass) {
$id = intval($id);
$result = $db->get_var("SELECT id FROM ".DB_PREFIX."users WHERE id ='" . sanitize_int($id). "' and pass ='" .toDb($pass) . "'");
if($result && !empty($result)) {
user::LoginUser($result);
}
}
}
}
public static function RefreshUser($id) {
user::clearSessionData();
user::LoginUser($id);
}
public static function Update($field, $value,$id = null) {
global $db;
if(!is_moderator() || is_null($id)) { $id = user_id();}
if ($field && $value) {
$db->query ("UPDATE  ".DB_PREFIX."users SET ".$field."='".toDb($value)."' WHERE id ='" . sanitize_int($id) . "'");
}
}
 public static function setSessionData($key, $val, $np =null) {
        global $db;
        if (!is_array($val)) {
		$val = user::obj_to_array($val);		
		}
if (function_exists('session_regenerate_id')) {		
session_regenerate_id();  
}
	//foreach($val as $key=>$value){  
	// if(!empty($value))  {	 
	// $_SESSION['user_'.$key] = $value;
	// }
	                $_SESSION['logintype']      = toDb($val["type"]);
					$_SESSION['name']       = toDb($val["name"]);
					$_SESSION['group']       = intval($val["group_id"]);
                    $_SESSION['username']       = toDb($val["username"]);
                    $_SESSION['user_id']         = intval($val["id"]);
					$_SESSION['avatar']         = toDb($val["avatar"]);
					if(!is_null($np)) {
					$_SESSION['pass']         = $np;
					} else {
					$_SESSION['pass']         = toDb($val["pass"]);
					}
                    $_SESSION['usergroup']      = intval($val["group_id"]);
                    $_SESSION['token']          = md5(uniqid(rand(), TRUE));
                    $_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);



setcookie(COOKIEKEY, user::encrypt($_SESSION['user_id'].COOKIESPLIT.$_SESSION['pass'], SECRETSALT), time() + 60 * 60 * 24 * 5,'/', cookiedomain());
           
        

    }

public static function obj_to_array($data)
{
    if (is_array($data) || is_object($data))
    {
        $result = array();
        foreach ($data as $key => $value)
        {
            $result[$key] = user::obj_to_array($value);
        }
        return $result;
    }
    return $data;
}	
 public static function clearSessionData() {
    $_SESSION = array();
	session_destroy();
	setcookie(COOKIEKEY, '', -3600,'/', cookiedomain());
	if (empty($_SESSION)) {
    session_start();
}
    }
	
public static function getDataFromUrl($url) {
		$ch = curl_init();
		$timeout = 15;
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}


}
?>