<?php
require_once 'phpvibe.php';
if($user->isAuthorized())
{
	$settings = array(
		'attributes' => array(
			'class' => 'form'
		)
	);

	$structure = array(
		'new_password' => array(
			'label' => 'New password',
			'type' => 'password',
			'validation' => array(
				'instance' => array()
			)
		),
		'submit' => array(
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Save changes'
			)
		)
	);

	$form = new MK_Form($structure, $settings);
	
	//$output = '<h2 class="narrow">Change Password</h2>';

	if($form->isSuccessful())
	{
		$output .= '<p class="alert success">Your changes have been saved.</p>';
		$user
			->setPassword( $form->getField('new_password')->getValue() )
			->save();
	}
	$output .= $form->render();
		
}
else
{
	$output = '<p class="alert success">Please <a href="login.php">log in</a> or <a href="register.php">register</a> to view this page!</p>';
}
$content.=$output;
$content_title = "Change password";
include_once("tpl/header.php");
include_once("tpl/content.tpl.php");
include_once("tpl/footer.php");

?>