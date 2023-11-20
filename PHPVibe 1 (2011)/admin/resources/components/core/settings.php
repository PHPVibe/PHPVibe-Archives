<?php
$form_structure['extensions-core-logout_url'] = array(
	'label' => 'Post-logout URL',
	'tooltip' => 'This is the URL that users will be redirected to after they have logged out. If you leave it blank they will return to the previous page.',
	'fieldset' => 'User Settings',
	'value' => $config->extensions->core->logout_url
);

$form_structure['extensions-core-login_url'] = array(
	'label' => 'Post-login URL',
	'tooltip' => 'This is the URL that users will be redirected to after they have logged in. If you leave it blank they will return to the previous page.',
	'fieldset' => 'User Settings',
	'value' => $config->extensions->core->login_url
);

$form_structure['extensions-core-register_url'] = array(
	'label' => 'Post-registration URL',
	'tooltip' => 'This is the URL that users will be redirected to after they have registered. If you leave it blank they will be a shown a registration confirmation message.<br /><br /><strong>All URLs are relative to the site\'s URL</strong>',
	'fieldset' => 'User Settings',
	'value' => $config->extensions->core->register_url
);
?>