<?php
require_once 'phpvibe.php';

$session = MK_Session::getInstance();
$cookie = MK_Cookie::getInstance();
unset($session->login, $cookie->login);

if( !$redirect = $config->extensions->core->register_url )
{
	$redirect = $logical_redirect;
}

header('Location: '.$redirect, true, 302);
exit;
?>