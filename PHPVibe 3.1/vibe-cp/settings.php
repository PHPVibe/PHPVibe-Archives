<?php include_once("header.php");
?>
	<div id="content">
<div class="box">

	<div class="box-header"><h1>Settings area</h1></div>

<?php
		$form_settings = array(
			'attributes' => array(
				'class' => 'form'
			)
		);

			$form_structure = array();
	
		$form_structure['site_name'] = array(
			'type' => 'text',
			'label' => 'Site name',
			'fieldset' => 'Main Setup',
			'validation' => array(
				'instance' => array()
			),
			'value' => $config->site->name
		);

		
	     $form_structure['site_url'] = array(
			'type' => 'text',
			'label' => 'Site link',
			'fieldset' => 'Main Setup',
			'validation' => array(
				'url' => array(),
				'instance' => array()
			),
			'value' => $config->site->url
		);
		
	$form_structure['dlang'] = array(
			'type' => 'text',
			'label' => 'Default language',
			'fieldset' => 'Main Setup',
			'validation' => array(
				'instance' => array()
			),
			'value' => $config->site->dlang
		);
		$form_structure['langs'] = array(
			'type' => 'text',
			'label' => 'Languages, comma separated',
			'fieldset' => 'Main Setup',
			'value' => implode(',', (array) $config->site->langs)
		);
		$form_structure['storethumbs'] = array(
			'type' => 'select',
			'options' => array(
				0 => 'No',
				1 => 'Yes'
			),
			'label' => 'Download thumbnails',
			'tooltip' => 'Download and store thumbnails on server?',
			'fieldset' => 'Main Setup',
			'value' => $config->site->storethumbs
		);
		$form_structure['wpics'] = array(
			'type' => 'text',
			'label' => 'Pictures width',
			'tooltip' => 'Downloaded pictures resize to this choosen width',
			'fieldset' => 'Main Setup',
			'value' => $config->site->wpics
		);
$form_structure['hpics'] = array(
			'type' => 'text',
			'label' => 'Pictures height',
			'tooltip' => 'Downloaded pictures resize to this choosen height',
			'fieldset' => 'Main Setup',
			'value' => $config->site->hpics
		);	
			$form_structure['video_player'] = array(
			'type' => 'select',
			'options' => array(
				1 => 'Use Youtube player',
				2 => 'Use JwPlayer'
				
			),
				'label' => 'Video Player',
				'tooltip' => 'Select what video player your prefer for Youtube videos.',
				'fieldset' => 'Videos',
				'value' =>  $config->video->player
			);	
			
			$form_structure['video_submit'] = array(
			'type' => 'select',
			'options' => array(
				2 => 'Authors only',
				1 => 'All members'
				
			),
				'label' => 'Who can submit videos',
				'tooltip' => 'Select which group can submit videos.',
				'fieldset' => 'Videos',
				'value' =>  $config->video->submit
			);	
			
			$form_structure['video_bpp'] = array(
			'type' => 'text',
			'validation' => array(
				'instance' => array()
			),			
			'label' => 'Browse per page',
			'tooltip' => 'Number of videos per page. Multiple of 4',
			'fieldset' => 'Videos',
			'value' => $config->video->bpp
		);
			$form_structure['mediafolder'] = array(
			'type' => 'text',
			'label' => 'Media folder ',
			'tooltip' => 'Main media folder. Contains all media folder.',
			'fieldset' => 'Videos',
			'value' => $config->site->mediafolder
		);
$form_structure['videofolder'] = array(
			'type' => 'text',
			'label' => 'Video folder',
			'tooltip' => 'Holds uploaded videos.',
			'fieldset' => 'Videos',
			'value' => $config->site->videofolder
		);
$form_structure['thumbsfolder'] = array(
			'type' => 'text',
			'label' => 'Thumbs folder',
			'tooltip' => 'Holds uploaded videos.',
			'fieldset' => 'Videos',
			'value' => $config->site->thumbsfolder
		);
$form_structure['picsfolder'] = array(
			'type' => 'text',
			'label' => 'Pictures folder',
			'tooltip' => 'Folder for wall pictures',
			'fieldset' => 'Videos',
			'value' => $config->site->picsfolder
		);	
         $form_structure['video_api'] = array(
			'type' => 'select',
			'options' => array(
				1 => 'Use combined',
				2 => 'Don\'t use it '
				
			),
				'label' => 'Use Youtube in front-end search?',
				'tooltip' => 'Select if your prefer Youtube videos via API in search results.',
				'fieldset' => 'Videos',
				'value' =>  $config->video->api
			);			
	    $form_structure['video_devkey'] = array(
			'type' => 'text',			
			'label' => 'Youtube dev key',
			'tooltip' => 'This is optional, but removes some limitations of requests',
			'fieldset' => 'Videos',
			'value' => $config->video->devkey
		);	
	
				
		$form_structure['site_facebook_app_id'] = array(
			'type' => 'text',
			'label' => 'Facebook App ID',
			'fieldset' => 'Connect',
			'value' => $config->site->facebook->app_id
		);

		$form_structure['site_facebook_app_secret'] = array(
			'type' => 'text',
			'label' => 'Facebook App Secret',
			'fieldset' => 'Connect',
			'value' => $config->site->facebook->app_secret
		);
		
		$form_structure['site_facebook_login'] = array(
			'type' => 'select',
			'options' => array(
				0 => 'No',
				1 => 'Yes'
			),
			'label' => 'Facebook Login',
			'tooltip' => 'Can users login to the site using their Facebook account?',
			'fieldset' => 'Connect',
			'value' => $config->site->facebook->login
		);

		$form_structure['site_twitter_app_key'] = array(
			'type' => 'text',
			'label' => 'Twitter App Key',
			'fieldset' => 'Connect',
			'value' => $config->site->twitter->app_key
		);

		$form_structure['site_twitter_app_secret'] = array(
			'type' => 'text',
			'label' => 'Twitter App Secret',
			'fieldset' => 'Connect',
			'value' => $config->site->twitter->app_secret
		);
		
		$form_structure['site_twitter_login'] = array(
			'type' => 'select',
			'options' => array(
				0 => 'No',
				1 => 'Yes'
			),
			'label' => 'Twitter Login',
			'tooltip' => 'Can users login to the site using their Twitter account?',
			'fieldset' => 'Connect',
			'value' => $config->site->twitter->login
		);
         	$form_structure['allow_upload'] = array(
			'type' => 'select',
			'options' => array(
				0 => 'No',
				1 => 'Yes'
			),
			'label' => 'Allow upload',
			'tooltip' => 'Can users upload videos?',
			'fieldset' => 'Video Upload',
			'value' => $config->video->allowupload
		);
  $form_structure['max_filesize'] = array(
			'type' => 'text',			
			'label' => 'Max filesize in bytes',
			'tooltip' => 'Allows you to set the maximum file size in bytes. Set to -1 for unlimited. 100 megabytes = 104 857 600 bytes',
			'fieldset' => 'Video Upload',
			'value' => $config->video->size
		);	
 $form_structure['max_uploads'] = array(
			'type' => 'text',			
			'label' => 'Max simultaneous uploads',
			'tooltip' => 'You can restrict de number of videos simultaneously uploaded',
			'fieldset' => 'Video Upload',
			'value' => $config->video->maxuploads
		);	
		
 $form_structure['max_library'] = array(
			'type' => 'text',			
			'label' => 'Max unpublished videos',
			'tooltip' => 'When number is reached, user cannot upload videos before publishing the uploaded ones',
			'fieldset' => 'Video Upload',
			'value' => $config->video->maxlibrary
		);	
		$form_structure['cache_video'] = array(
			'type' => 'select',
			'options' => array(
				0 => 'No',
				1 => 'Yes'
			),
			'label' => 'Cache video page',
			'tooltip' => 'Cache mysql queries in video page.',
			'fieldset' => 'Cache',
			'value' => $config->cache->video
		);
		
$form_structure['cache_time'] = array(
			'type' => 'text',
			'label' => 'Cache refresh time',
			'tooltip' => 'How much should cache last in seconds? Bigger than 600, 3600 + recomended',
			'fieldset' => 'Cache',
			'value' => $config->cache->time
		);		
		

		$form_structure['site_email'] = array(
			'type' => 'text',
			'label' => 'Email address',
			'fieldset' => 'Custom',
			'value' => $config->site->email
		);
	
		$form_structure['email_signature'] = array(
			'type' => 'textarea',
			'attributes' => array(
				'class' => 'input-textarea-small'
			),
			'label' => 'Email signature',
			'tooltip' => 'This will be appended to the bottom of any emails sent to users. This field is HTML.',
			'fieldset' => 'Custom',
			'value' => $config->site->email_signature
		);
		
		
				
	$form_structure['site_timezone'] = array(
			'type' => 'select',
			'options' => MK_Utility::getTimezoneList(),
			'label' => 'Timezone',
			'fieldset' => 'Custom',
			'validation' => array(
				'instance' => array()
			),
			'value' => $config->site->timezone
		);
		$form_structure['site_date_format'] = array(
			'type' => 'text',
			'label' => 'Date format',
			'validation' => array(
				'instance' => array()
			),
			'fieldset' => 'Custom',
			'value' => $config->site->date_format
		);
		$form_structure['site_time_format'] = array(
			'type' => 'text',
			'label' => 'Date format',
			'validation' => array(
				'instance' => array()
			),
			'fieldset' => 'Custom',
			'value' => $config->site->time_format
		);
		$form_structure['site_valid_file_extensions'] = array(
			'type' => 'textarea',
			'label' => 'File extensions',
			'tooltip' => 'The following file types can be uploaded to the site. Separate with a comma \',\'.',
			'fieldset' => 'Custom',
			'validation' => array(
				'instance' => array()
			),
			'value' => implode(', ', (array) $config->site->valid_file_extensions)
		);
	
		$form_structure['user_timeout'] = array(
			'type' => 'text',
			'label' => 'User login time',
			'validation' => array(
				'instance' => array(),
				'integer' => array()
			),
			'tooltip' => 'This field defines how long users will be signed in for (in seconds). After this period users will need to login again.',
			'fieldset' => 'Custom',
			'value' => $config->site->user_timeout
		);

		$form_structure['search_submit'] = array(
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Save Changes'
			)
		);
	$form = new MK_Form($form_structure, $form_settings);
	
	if( $form->isSuccessful() )
		{
			$message = array();
			$config_data = array();
			
			$fields = $form->getFields();
			
			$config_data['dlang'] = $form->getField('dlang')->getValue();
			$langs = explode(',', $form->getField('langs')->getValue());
$langs = array_map('trim', $langs);
$langs = array_filter($langs);
$langs = array_unique($langs);
$config_data['site.langs'] = implode(',', $langs);
			$config_data['video.player'] = $form->getField('video_player')->getValue();
			$config_data['video.submit'] = $form->getField('video_submit')->getValue();	
            $config_data['video.bpp'] = $form->getField('video_bpp')->getValue();	
            $config_data['video.devkey'] = $form->getField('video_devkey')->getValue();	
            $config_data['video.api'] = $form->getField('video_api')->getValue();	
            $config_data['video.allowupload'] = $form->getField('allow_upload')->getValue();
		    $config_data['video.size'] = $form->getField('max_filesize')->getValue();
		    $config_data['video.maxuploads'] = $form->getField('max_uploads')->getValue();
		    $config_data['video.maxlibrary'] = $form->getField('max_library')->getValue();		   
		
			$config_data['licence.checked'] = time();
			$config_data['site.facebook.app_id'] = $form->getField('site_facebook_app_id')->getValue();
			$config_data['site.facebook.app_secret'] = $form->getField('site_facebook_app_secret')->getValue();
			$config_data['site.facebook.login'] = $form->getField('site_facebook_login')->getValue();

			$config_data['site.twitter.app_key'] = $form->getField('site_twitter_app_key')->getValue();
			$config_data['site.twitter.app_secret'] = $form->getField('site_twitter_app_secret')->getValue();
			$config_data['site.twitter.login'] = $form->getField('site_twitter_login')->getValue();

			$valid_file_extensions = explode(',', $form->getField('site_valid_file_extensions')->getValue());
			$valid_file_extensions = array_map('trim', $valid_file_extensions);
			$valid_file_extensions = array_filter($valid_file_extensions);
			$valid_file_extensions = array_unique($valid_file_extensions);
			$config_data['site.valid_file_extensions'] = implode(',', $valid_file_extensions);
            $config_data['site.mediafolder'] = $form->getField('mediafolder')->getValue();
			$config_data['site.videofolder'] = $form->getField('videofolder')->getValue();
			$config_data['site.thumbsfolder'] = $form->getField('thumbsfolder')->getValue();
			$config_data['site.picsfolder'] = $form->getField('picsfolder')->getValue();
	        $config_data['site.storethumbs'] = $form->getField('storethumbs')->getValue();
	        $config_data['site.wpics'] = $form->getField('wpics')->getValue();
	        $config_data['site.hpics'] = $form->getField('hpics')->getValue();	
			$config_data['site.name'] = $form->getField('site_name')->getValue();
			$config_data['site.timezone'] = $form->getField('site_timezone')->getValue();
			$config_data['site.email'] = $form->getField('site_email')->getValue();
			$config_data['site.email_signature'] = $form->getField('email_signature')->getValue();
			$config_data['site.url'] = $form->getField('site_url')->getValue();
			$config_data['site.date_format'] = $form->getField('site_date_format')->getValue();
			$config_data['site.time_format'] = $form->getField('site_time_format')->getValue();
			$config_data['user.timeout'] = $form->getField('user_timeout')->getValue();
			$config_data['cache.video'] = $form->getField('cache_video')->getValue();
			$config_data['cache.time'] = $form->getField('cache_time')->getValue();
			
			MK_Utility::writeConfig($config_data,$target_ini);
		  echo "All done! Settings saved";
		} else {

	print $form->render();
	
	}

?>

	</div>
</div>	
<?php include_once("footer.php");?>