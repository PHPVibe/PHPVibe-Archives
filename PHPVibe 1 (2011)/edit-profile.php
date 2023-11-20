<?php
require_once("_inc.php");

$head_title = array();
$head_desc = array();
$head_title[] = 'Edit profile'; 
$head_desc[] = 'Editing my profile'; 
include_once("tpl/php/global_header.php");
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
			'class' => 'clear-fix titled standard'
		)
	);

	$structure = array(
		'name' => array(
			'label' => __("Real Name"),
			'value' => $user->getName()
		),
		'display_name' => array(
			'label' => __("Display Name"),
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
			'validation' => array(
				'url' => array()
			),
			'value' => $user->getWebsite()
		),
		'gender' => array(
			'label' => __("Gender"),
			'type' => 'select',
			'options' => array(
				'' => 'Prefer not to disclose',
				'Male' => 'Male',
				'Female' => 'Female'
			),
			'value' => $user->getGender()
		),
		'date_of_birth' => array(
			'label' => __("Date of Birth"),
			'type' => 'date',
			'value' => $user->getDateOfBirth()
		),
		'avatar' => array(
			'label' => __("Profile picture"),
			'type' => 'file_image',
			'upload_path' => $config->site->upload_path,
			'value' => $user->getAvatar()
		),		
		'fromcity' => array(
			'label' => __("From (City)"),
			'validation' => array(
				'instance' => array()
			),
			'value' => $user->getFromCity()
		),
	    'nowcity' => array(
			'label' => __("City you live in"),
			'validation' => array(
				'instance' => array()
			),
			'value' => $user->getNowCity()
		),
		'about' => array(
			'label' => __("Describe yourself"),
			'type' => 'textarea',
			'validation' => array(
				'instance' => array()
			),
			'value' => $user->getAbout()
		),
		'quote' => array(
			'label' => __("Favorite Quote"),
			'validation' => array(
				'instance' => array()
			),
			'value' => $user->getQuote()
		),
		'music' => array(
			'label' => __("Music or Artists that you like (comma separated)"),
			'validation' => array(
				'instance' => array()
			),
			'value' => $user->getMusic()
		),
		'movies' => array(
			'label' => __("Favorite Movies (comma separated)"),
			'validation' => array(
				'instance' => array()
			),
			'value' => $user->getMovies()
		),
		'tv' => array(
			'label' => __("Tv Show (comma separated)"),
			'validation' => array(
				'instance' => array()
			),
			'value' => $user->getTv()
		),
		'relation' => array(
			'label' => __("Status"),
			'type' => 'select',
			'options' => array(
				'' => 'Prefer not to disclose',
				'Single' => 'Single',
				'In a relationship' => 'In a relationship',
				'Engaged' => 'Engaged',
				'Married' => 'Married',
				'It\'s complicated' => 'It\'s complicated',
				'Open for fun' => 'Open for fun'
			),
			'value' => $user->getRelation()
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
			->setDateOfBirth( $form->getField('date_of_birth')->getValue() )
			->setGender( $form->getField('gender')->getValue() )
			->setDisplayName( $form->getField('display_name')->getValue() )
			->setFromCity( $form->getField('fromcity')->getValue() )
		    ->setNowCity( $form->getField('nowcity')->getValue() )
		    ->setAbout( $form->getField('about')->getValue() )
			->setQuote( $form->getField('quote')->getValue() )
			->setMusic( $form->getField('music')->getValue() )
			->setMovies( $form->getField('movies')->getValue() )			
			->setTv( $form->getField('tv')->getValue() )			
			->setRelation( $form->getField('relation')->getValue() )
			->save();
	}
		
	$output .= $form->render();

}else{
	$output .= '<p class="alert warning">Please <a href="login.php">log in</a> or <a href="register.php">register</a> to view this page!</p>';
}
?>
<div class="clearfix" id="main-content">
<div class="col col12">
  <div class="col-bkg clearfix">
    <h1><?php echo __("Edit your profile");?></h1>

	<?php print $output; ?>

			
  </div>

</div>
</div>
</div>
<?php      

include_once("tpl/php/footer.php");
?>