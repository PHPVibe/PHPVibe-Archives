<?php $start = microtime(true);
require_once '../app/framework/loader.php';
require_once 'application/controllers/ErrorController.class.php';
$iterator = new DirectoryIterator(dirname(__FILE__));
$root = str_replace("setup","",$iterator->getPath());
$ini = $root."app/config.ini.php";
$session = MK_Session::getInstance();
$cookie = MK_Cookie::getInstance();
$config = MK_Config::getInstance();

if( $cookie->login && empty($session->login) )
{
	$session->login = $cookie->login;
}

$controller = MK_Core::init($path);

//header('Content-Type: text/html; charset=utf-8');
print $controller->getView()->getTemplateOutput();
?>