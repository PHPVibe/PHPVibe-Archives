<?php
$start = microtime(true);

require_once 'library/com/mokoala/Mokoala.php';
require_once 'application/controllers/ErrorController.class.php';

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