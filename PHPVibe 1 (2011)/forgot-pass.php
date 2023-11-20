<?php
	require_once '_inc.php';
	$head_title = array();
	$head_title[] = 'Forgotten Password';

	if($user->isAuthorized()){
		header('Location: '.($config->site->referer === $config->site->page ? $config->site->base : $config->site->referer), true, 302);
		exit;
	}
	
	$output = '<h2 class="narrow">Forgotten Password</h2>';
	$output .= '<p class="narrow">Ener your email below, to reset your password.</p>';

	$settings = array(
		'attributes' => array(
			'class' => 'narrow clear-fix standard'
		)
	);

	$structure = array(
		'email' => array(
			'label' => 'Your Email',
			'validation' => array(
				'email' => array(),
				'instance' => array()
			)
		),
		'submit' => array(
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Recover password'
			)
		)
	);

	$form = new MK_Form($structure, $settings);

	if($form->isSuccessful())
	{
		$user_type = MK_RecordModuleManager::getFromType('user');
		$user_search = array(
			array('field' => 'email', 'value' => $form->getField('email')->getValue()),
			array('field' => 'type', 'value' => MK_RecordUser::TYPE_CORE)
		);

		if( $reset_user = array_pop($user_type->searchRecords($user_search)) ){
			$new_password = MK_Utility::getRandomPassword(8);
			$reset_user
				->setTemporaryPassword($new_password)
				->save();

			$output = '<p class="alert success">We have sent you an email containing your new password.</p>';

			$message = '<p>Dear '.$reset_user->getDisplayName().',<br /><br />Your new password is: <strong>'.$new_password.'</strong>.</p>';
			$mailer = new MK_BrandedEmail();
			$mailer
				->setSubject('Password Recovery')
				->setMessage($message)
				->send($reset_user->getEmail(), $reset_user->getDisplayName());
		}else{
			$form->getField('email')->getValidator()->addError('This email does not match our records. Please try again.');
			$output .= $form->render();
		}
	}
	else
	{
		$output .= $form->render();
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