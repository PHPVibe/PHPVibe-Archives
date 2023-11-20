<?php //Vital file include
include("phpvibe.php");
$reqform = true;
include_once("tpl/header.php");
?>


<?php
if($user->isAuthorized())
{
	// We get an instance of the users module and the email field to make sure the given email is unique
	$user_module = MK_RecordModuleManager::getFromType('user');
	$field_module = MK_RecordModuleManager::getFromType('module_field');
	$criteria = array(
		array('field' => 'module_id', 'value' => $user_module->getId()),
		array('field' => 'name', 'value' => 'email')
	);
	
	$user_email_field = array_pop( $field_module->searchRecords($criteria) );

	$settings = array(
		'attributes' => array(
			'class' => 'form'
		)
	);

	$structure = array(
		'name' => array(
			'label' => "Real Name",
			'value' => $user->getName()
		),
		'display_name' => array(
			'label' => "Display Name",
			'validation' => array(
				'instance' => array()
			),
			'value' => $user->getDisplayName()
		),
		'email' => array(
			'label' => 'Email',
			'validation' => array(
				'email' => array(),
				'instance' => array(),
				'unique' => array($user, $user_email_field, $user_module)
			),
			'value' => $user->getEmail()
		),
		'website' => array(
			'label' => 'Website',
			'value' => $user->getWebsite()
		),
		'gender' => array(
			'label' => "Gender",
			'type' => 'select',
			'options' => array(
				'' => 'Prefer not to disclose',
				'Male' => 'Male',
				'Female' => 'Female'
			),
			'value' => $user->getGender()
		),
			
		
	    'nowcity' => array(
			'label' => "City you live in",			
			'value' => $user->getNowCity()
		),
		'avatar' => array(
			'label' => "Profile picture",
			'type' => 'file_image',
			'upload_path' => $config->site->upload_path,
			'value' => $user->getAvatar()
		),		
		'about' => array(
			'label' => "Describe yourself",
			'type' => 'textarea',
			'value' => $user->getAbout()
		),
		
		'music' => array(
			'label' => "Music you like",
			'value' => $user->getMusic()
		),
		'movies' => array(
			'label' => "Favorite Movies",
			'value' => $user->getMovies()
		),
		
			'submit' => array(
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Save changes'
			)
		)
	);

	$form = new MK_Form($structure, $settings);
	
	if($form->isSuccessful()){
		$output .= '<p class="alert success">Your changes have been saved.</p>';
		$user
			->setAvatar( $form->getField('avatar')->getValue() )
			->setEmail( $form->getField('email')->getValue() )
			->setName( $form->getField('name')->getValue() )
			->setWebsite( $form->getField('website')->getValue() )			
			->setGender( $form->getField('gender')->getValue() )
			->setDisplayName( $form->getField('display_name')->getValue() )
		    ->setNowCity( $form->getField('nowcity')->getValue() )
		    ->setAbout( $form->getField('about')->getValue() )
			->setMusic( $form->getField('music')->getValue() )
			->setMovies( $form->getField('movies')->getValue() )			
			
			->save();
	}
		
	$content .= $form->render();

}else{
	$content .= '<p class="alert warning">Please <a href="login.php">log in</a> or <a href="register.php">register</a> to view this page!</p>';
}

$content_title = "Edit your profile info";
include_once("tpl/header.php");     
include_once("tpl/content.tpl.php");
include_once("tpl/footer.php");
?>