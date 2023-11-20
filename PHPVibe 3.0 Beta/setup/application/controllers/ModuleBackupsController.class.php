<?php

require_once 'ModuleController.class.php';

class MK_ModuleBackupsController extends MK_ModuleController
{
	
	protected $options_list_global = array('delete');

	protected function loadSection()
	{
		if( MK_Request::getParam('method') === 'restore' && ( $record_id = MK_Request::getParam('id') ) )
		{
			$this->sectionRestore( $record_id );
		}
		elseif( MK_Request::getParam('method') === 'add' )
		{
			$this->getView()->redirect( array('controller' => 'dashboard', 'section' => 'backup') );
		}
		else
		{
			parent::loadSection();
		}
	}

	public function sectionRestore( $record_id )
	{
		$this->getView()->setDisplayPath('modules/backups/restore');

		$config = MK_Config::getInstance();
		
		try
		{
			$backup = MK_RecordManager::getFromId( $this->getView()->module->getId(), $record_id );
			$this->getView()->title = 'Restore backup from '.$backup->renderDateTime();
			$this->getView()->backup = $backup;
		}catch(Exception $e){};
		
		$form_settings = array(
			'attributes' => array(
				'class' => 'large clear-fix standard'
			)
		);

		$form_structure = array(
			'backup_confirm' => array(
				'type' => 'select',
				'options' => array(
					0 => 'No',
					1 => 'Yes'
				),
				'label' => 'Start recovery?',
				'validation' => array(
					'boolean_true' => array()
				)
			),
			'backup_submit' => array(
				'type' => 'submit',
				'attributes' => array(
					'value' => 'Confirm'
				)
			)
		);

		$form = new MK_Form($form_structure, $form_settings);
		
		$this->getView()->form = $form->render();

		if($form->isSuccessful())
		{
			$this->getView()->setDisplayPath('modules/message');
			if( $config->core->mode === MK_Core::MODE_DEMO )
			{
				$this->getView()->messages = array(
					new MK_Message('warning', 'This backup could not be loaded as <strong>'.$config->instance->name.'</strong> is running in demonstration mode.')
				);
			}
			elseif(!class_exists('ZipArchive'))
			{
				$this->getView()->messages = array(
					new MK_Message('error', "Cannot find the 'ZipArchive' library - This is used for performing a backup.")
				);
			}
			else
			{
				try
				{
					MK_Backup::load('../'.$backup->getFile());
					$this->getView()->messages = array(
						new MK_Message('success', 'This backup was loaded successfully.')
					);
				}
				catch(Exception $e)
				{
					$this->getView()->messages = array(
						new MK_Message('error', $e->getMessage())
					);
				}
			}
		}
	}

	public function sectionIndex( $export = null )
	{
		// Define display options
		$this->options_list['Restore'] = array(
			'href' => $this->getView()->uri( array('method' => 'restore', 'id' => '{record_id}') ),
			'title' => 'Restore previous backup'
		);

		parent::sectionIndex( $export );
	}

}

?>