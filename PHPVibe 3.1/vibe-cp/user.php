<?php include_once("header.php");
	// Default language 
	$DEFAULT_LANGUAGE = 'en';	
	// This is the directory to the available languages folder
	$LANGUAGE_DIR = '../langs';	
	
	// Makes the language class ready to be used
	$language = new Language();
	$lang = $language->getLanguage('en');
 if(isset($_GET['delete'])){ 
	 $del = dbquery("DELETE from users WHERE id = '".$_GET['delete']."'");
	  $del2 = dbquery("DELETE from users_meta WHERE user = '".$_GET['delete']."'");
	$message= 'Deleted user # '.$_GET['delete'];
	 }
if($user_id = $_GET["id"]){
    $user_module = MK_RecordModuleManager::getFromType('user');
    $user_profile = MK_RecordManager::getFromId($user_module->getId(), $user_id);
	$field_module = MK_RecordModuleManager::getFromType('module_field');
	$criteria = array(
		array('field' => 'module_id', 'value' => $user_module->getId()),
		array('field' => 'name', 'value' => 'email')
	);
	
	$user_email_field = array_pop( $field_module->searchRecords($criteria) );

	$settings = array(
		'attributes' => array(
			'class' => 'form 800px'
		)
	);

	$structure = array(
		'name' => array(
			'label' => "Real Name",
			'value' => $user_profile->getName()
		),
		'groupid' => array(
			'label' => "Autority group",
			'type' => 'select',
			'options' => array(
				'2' => 'Regular member',
				'3' => 'Author',
				'1' => 'Admin (Caution!)'
			),
			'value' => $user_profile->getGroupId()
		),
		'display_name' => array(
			'label' => "Display Name",
			'validation' => array(
				'instance' => array()
			),
			'value' => $user_profile->getDisplayName()
		),
		'email' => array(
			'label' => 'Email',
			'validation' => array(
				'email' => array(),
				'instance' => array(),
				'unique' => array($user, $user_email_field, $user_module)
			),
			'value' => $user_profile->getEmail()
		),
		'website' => array(
			'label' => 'Website',
			'value' => $user_profile->getWebsite()
		),
		'gender' => array(
			'label' => "Gender",
			'type' => 'select',
			'options' => array(
				'' => 'Prefer not to disclose',
				'Male' => 'Male',
				'Female' => 'Female'
			),
			'value' => $user_profile->getGender()
		),
			
		
	    'nowcity' => array(
			'label' => "City you live in",			
			'value' => $user_profile->getNowCity()
		),
		'avatar' => array(
			'label' => "Profile picture",
			'type' => 'file_image',
			'upload_path' => $config->site->upload_path,
			'value' => $user_profile->getAvatar()
		),		
		'about' => array(
			'label' => "Describe yourself",
			'type' => 'textarea',
			'value' => $user_profile->getAbout()
		),
		
		'music' => array(
			'label' => "Music you like",
			'value' => $user_profile->getMusic()
		),
		'movies' => array(
			'label' => "Favorite Movies",
			'value' => $user_profile->getMovies()
		),
		
			'submit' => array(
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Save changes'
			)
		)
	);

	$form = new MK_Form($structure, $settings);
	
	if($form->isSubmitted()){
		$content.= '<p>Your changes have been saved.</p>';
		$user_profile
			->setAvatar( $form->getField('avatar')->getValue() )
			->setEmail( $form->getField('email')->getValue() )
			->setGroupId( $form->getField('groupid')->getValue() )
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
	?>
		<div id="content">
<div class="box">
<div class="box-header"><h1>Members area </h1></div>
<div class="box-content">
	<?php echo $content;

}
else
{
	echo "That profile doesn't exist! ";
}
?>



</div>
</div>


<br style="clear:both;">
	
</div>	

	</div>
	
<?php include_once("footer.php");?>