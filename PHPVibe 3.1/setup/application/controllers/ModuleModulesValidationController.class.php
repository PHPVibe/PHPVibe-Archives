<?php

require_once 'ModuleController.class.php';

class MK_ModuleModulesValidationController extends MK_ModuleController
{
	
	public function getFormFields( MK_Record $record )
	{
		$structure = parent::getFormFields( $record );
		$values = array_pop($record->getRule());
		$structure['validation_arguments'] = array(
			'label' => 'Arguments',
			'type' => 'text_multiple',
			'value' => $values
		);
		return $structure;
	}

}

?>