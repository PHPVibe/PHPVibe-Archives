<?php
require_once '_inc.php';
$head_title = array();
$head_title[] = 'Change Password';

if($user->isAuthorized())
{
	$settings = array(
		'attributes' => array(
			'class' => 'narrow clear-fix standard'
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
	
	$output = '<h2 class="narrow">Change Password</h2>';

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

include_once("tpl/php/global_header.php");
?>
<div id="content-bkg">   
<div class="wrapper">
<div class="clearfix" id="main-content">
<?php
print $output;
?>
</div>
</div>
</div>
</div>
<?php
include_once("tpl/php/footer.php");

?>