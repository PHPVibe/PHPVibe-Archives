<?php
require_once 'phpvibe.php';
$reqform = true;
if($user->isAuthorized()){
		header('Location: '.($config->site->referer === $config->site->page ? $config->site->base : $config->site->referer), true, 302);
		exit;
	}
if(!$user->isAuthorized())
{
	$settings = array(
		'attributes' => array(
			'class' => 'form'
		)
	);

	$structure = array(
		'email' => array(
			'label' => 'Email used on register',
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
				->setPassword($new_password)
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
	
		
}
else
{
	$output = '<p class="alert success">Please <a href="login.php">log in</a> or <a href="register.php">register</a> to view this page!</p>';
}
$content.=$output;
$content_title = "Forgot Password";
include_once("tpl/header.php");
include_once("tpl/content.tpl.php");
include_once("tpl/footer.php");

?>