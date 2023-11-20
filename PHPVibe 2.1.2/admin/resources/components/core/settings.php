<?php
if(empty($config->extensions->core->logout_url)): $logout_redirect = "/"; 
else:
$logout_redirect = $config->extensions->core->logout_url;
endif;

if(empty($config->extensions->core->login_url)): $login_redirect = "/"; 
else:
$login_redirect = $config->extensions->core->login_url;
endif;

if(empty($config->extensions->core->register_url)): $reg_redirect = "/"; 
else:
$reg_redirect = $config->extensions->core->register_url;
endif;


$form_structure['extensions-core-logout_url'] = array(
	'label' => 'Post-logout URL',
	'tooltip' => 'This is the URL that users will be redirected to after they have logged out.',
	'fieldset' => 'User Settings',
	'value' => $logout_redirect
);

$form_structure['extensions-core-login_url'] = array(
	'label' => 'Post-login URL',
	'tooltip' => 'This is the URL that users will be redirected to after they have logged in. ',
	'fieldset' => 'User Settings',
	'value' => $login_redirect
);

$form_structure['extensions-core-register_url'] = array(
	'label' => 'Post-registration URL',
	'tooltip' => 'This is the URL that users will be redirected to after they have registered.<br /><strong>All URLs are relative to the site\'s URL</strong>',
	'fieldset' => 'User Settings',
	'value' => $reg_redirect
);
?>