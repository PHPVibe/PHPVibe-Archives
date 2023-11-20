<?php include_once("header.php"); ?>
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

		$form_structure['seo_htitle'] = array(
			'type' => 'text',
			'label' => 'Homepage title',
			'fieldset' => 'Homepage SEO',
			
			'value' => $config->seo->htitle
		);
		$form_structure['seo_hdesc'] = array(
			'type' => 'textarea',
			'label' => 'Homepage description',
			'fieldset' => 'Homepage SEO',
			'attributes' => array(
				'class' => 'input-textarea-small'
			),
			'value' => $config->seo->hdesc
		);
		$form_structure['seo_prevideo'] = array(
			'type' => 'text',
			'label' => 'Pre video title',
			'tooltip' => 'This will be added before the title of the video',
			'fieldset' => 'Video SEO',			
			'value' => $config->seo->prevideo
		);		
		
		$form_structure['seo_postvideo'] = array(
			'type' => 'text',
			'label' => 'Post video title',
			'tooltip' => 'Keyword added in title AFTER video title. You can use ##user## for username of sharer and ##site_name## for site name',
			'fieldset' => 'Video SEO',			
			'value' => $config->seo->postvideo
		);		
		$form_structure['extra_header'] = array(
			'type' => 'textarea',
			'attributes' => array(
				'class' => 'input-textarea-small'
			),
			'label' => 'Extra header content',
			'tooltip' => 'This will be appended to the header of every page. This field is HTML.',
			'fieldset' => 'Custom Code',
			'value' => $config->site->headerc
		);
		
			$form_structure['extra_footer'] = array(
			'type' => 'textarea',
			'attributes' => array(
				'class' => 'input-textarea-small'
			),
			'label' => 'Extra footer content',
			'tooltip' => 'This will be appended to the footer of every page. This field is HTML.',
			'fieldset' => 'Custom Code',
			'value' => $config->site->footerc
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
			$config_data = array();			
			$fields = $form->getFields();
		    $config_data['seo.htitle'] = $form->getField('seo_htitle')->getValue();
		    $config_data['seo.hdesc'] = $form->getField('seo_hdesc')->getValue();
			$config_data['seo.prevideo'] = $form->getField('seo_prevideo')->getValue();
			$config_data['seo.postvideo'] = $form->getField('seo_postvideo')->getValue();			
			$config_data['site.headerc'] = $form->getField('extra_header')->getValue();
			$config_data['site.footerc'] = $form->getField('extra_footer')->getValue();		
			
			MK_Utility::writeConfig($config_data,$target_ini);
		  echo "All done! Settings saved";
		} else {

	print $form->render();
	
	}

?>

	</div>
</div>	
<?php include_once("footer.php");?>