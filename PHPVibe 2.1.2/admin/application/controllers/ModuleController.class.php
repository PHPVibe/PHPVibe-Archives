<?php

class MK_ModuleController extends MK_DefaultController
{

	protected $options_list = array();
	protected $options_list_global = array('delete', 'add');
	protected $export_methods = array('csv');

	public function _init()
	{
		parent::_init();
		$this->getView()->setDisplayPath('modules/index');
	}

	public function __construct($module)
	{
		
		parent::__construct();
		
		$this->getView()->module = $module;

		$this->getView()->getHead()->prependTitle( $this->getView()->module->getName() );
		
		$this->loadSection();

	}
	
	protected function loadSection()
	{
		
		if( ( $export = MK_Request::getParam('export') ) && in_array( $export, $this->export_methods ) )
		{
			$this->sectionIndex($export);
		}
		elseif( $record_delete = MK_Request::getParam('module-select') )
		{
			$this->sectionDeleteMultiple($record_delete);
		}
		elseif( MK_Request::getParam('method') === 'edit' && ( $record_id = MK_Request::getParam('id') ) )
		{
			$this->sectionForm( $record_id );
		}
		elseif( MK_Request::getParam('method') === 'clear-field' && ( $record_id = MK_Request::getParam('id') ) && ( $field_id = MK_Request::getParam('field-id') ) )
		{
			$this->sectionClearField( $record_id, $field_id );
		}
		elseif( MK_Request::getParam('method') === 'delete' && ( $record_id = MK_Request::getParam('id') ) )
		{
			$this->sectionDelete( $record_id );
		}
		elseif( MK_Request::getParam('method') === 'add' )
		{
			$this->sectionForm();
		}
		else
		{
			$this->sectionIndex();
		}
	}

	public function sectionDeleteMultiple( $record_delete )
	{
		$config = MK_Config::getInstance();

		$this->getView()->title = 'Delete Record(s)';
		$this->getView()->setDisplayPath('modules/message');

		if( ( $config->core->mode != MK_Core::MODE_DEMO ) )
		{
			foreach($record_delete as $record)
			{
				$record = MK_RecordManager::getFromId($this->getView()->module->getId(), $record);
				$record->delete();
			}
			
			$this->getView()->messages = array(
				new MK_Message('success', 'This record(s) has been deleted. <a href="'.$this->getView()->uri().'">Return to the record list</a>.')
			);
		}
		else
		{
			$this->getView()->messages = array(
				new MK_Message('warning', 'This record(s) was not deleted as <strong>'.$config->instance->name.'</strong> is running in demonstration mode. <a href="'.$this->getView()->uri().'">Return to the record list</a>.')
			);
		}
	}

	public function sectionDelete( $record_id )
	{
		$config = MK_Config::getInstance();

		$this->getView()->title = 'Delete Record';
		$this->getView()->setDisplayPath('modules/message');

		if( $config->core->mode != MK_Core::MODE_DEMO )
		{
			$record = MK_RecordManager::getFromId( $this->getView()->module->getId(), $record_id );
			$record->delete();
			
			$this->getView()->messages = array(
				new MK_Message('success', 'This record has been deleted. <a href="'.$this->getView()->uri().'">Return to the record list</a>.')
			);
		}
		else
		{
			$this->getView()->messages = array(
				new MK_Message('warning', 'This record was not deleted as <strong>'.$config->instance->name.'</strong> is running in demonstration mode. <a href="'.$this->getView()->uri().'">Return to the record list</a>.')
			);
		}

	}

	public function sectionClearField( $record_id, $field_id )
	{
		$config = MK_Config::getInstance();
		
		if( $config->core->mode != MK_Core::MODE_DEMO )
		{
			$field_type = MK_RecordModuleManager::getFromType('module_field');
			
			$field = MK_RecordManager::getFromId( $field_type->getId(), $field_id );
			$module = MK_RecordModuleManager::getFromId( $field->getModuleId());
	
			$record = MK_RecordManager::getFromId( $module->getId(), $record_id );
	
			$method = MK_Utility::stringToReference($field->getName());
			$get_method = 'get'.$method;
			$set_method = 'set'.$method;
			
			if( substr($field->getType(), 0, 4) === 'file' )
			{
				try{
					$file = new MK_File('../'.$record->$get_method());
					$file->delete();
				}catch(Exception $e){}
			}
	
			$record->$set_method('');
			$record->save(false);
			
		}

		$this->getView()->back();
	}

	public function getFormFields( MK_Record $record )
	{
		$record_fields = $this->getView()->module->getFields();
		$structure = array();

		foreach($record_fields as $field)
		{
			if( !$field->isEditable() )
			{
				continue;
			}
			$get_method = 'get'.MK_Utility::stringToReference($field->getName());
			$structure[$field->getName()] = MK_FieldHandler::get($record, $field, $record->$get_method());
			if( substr($field->getType(), 0, 4) === 'file' )
			{
				$structure[$field->getName()]['file_remove_link'] = $this->getView()->uri( array('method' => 'clear-field', 'field-id' => $field->getId(), 'id' => $record->getId() ) );
			}
		}
		return $structure;
	}

	public function sectionForm( $record_id = null )
	{
		$config = MK_Config::getInstance();
		
		$this->getView()->setDisplayPath('modules/form');
		
		$settings = array(
			'attributes' => array(
				'class' => 'standard large'
			)
		);

		if( !empty($record_id) )
		{
			// Get record
			$this->getView()->title = 'Edit Record';
			$this->getView()->getHead()->prependTitle( 'Edit Record' );
			$record = MK_RecordManager::getFromId( $this->getView()->module->getId(), $record_id );
	
			// Get related records
			$linked_module_data = array();
			$module_field_type = MK_RecordModuleManager::getFromType( 'module_field' );
			$module_type = MK_RecordModuleManager::getFromType( 'module' );
	
			$search_fields = array(
				array( 'literal' => " `type` = '".$this->getView()->module->getType()."' GROUP BY `module_id`" )
			);
	
			$linked_fields = $module_field_type->searchRecords($search_fields);
			$paginator = new MK_Paginator();
			$paginator->setPerPage(10);
			foreach($linked_fields as $field)
			{
				$module = MK_RecordManager::getFromId($module_type->getId(), $field->getModuleId());
				$record_search = array( array( 'field' => $field->getName(), 'value' => $record_id) );
				$related_records = $module->searchRecords( $record_search, $paginator );
				if( count($related_records) > 0 )
				{
					$linked_module_data[] = array(
						'link_field' => $field->getName(),
						'module' => $module,
						'records' => $related_records
					);
				}
				$field_module = MK_RecordModuleManager::getFromType( 'module_field' );
			}

			if( count($linked_module_data) > 0 )
			{
				$this->getView()->linked_module_data = $linked_module_data;
				$this->getView()->setDisplayPath('modules/form-extra');
			}

		}
		else
		{
			$this->getView()->title = 'Create Record';
			$this->getView()->getHead()->prependTitle( 'Create Record' );
			$record = MK_RecordManager::getNewRecord( $this->getView()->module->getId() );
		}
		
		$structure = $this->getFormFields($record);

		$structure['module_submit'] = array(
			'attributes' => array(
				'value' => ( empty($record_id) ? 'Add record' : 'Save changes' ),
			),
			'type' => 'submit'
		);

		$form = new MK_Form($structure, $settings);

		$this->getView()->form = $form->render();
		
		if($form->isSuccessful())
		{
			
			$fields = $form->getFields();

			foreach($fields as $field)
			{
				$set_method = 'set'.MK_Utility::stringToReference($field->getName());
				$record->$set_method( $field->getValue() );
			}

			if($record_id)
			{
				if($config->core->mode != MK_Core::MODE_DEMO)
				{
					$record->save(false);
					$this->getView()->messages = array(
						new MK_Message('success', 'This record has been updated. <a href="'.$this->getView()->uri(array('method' => 'edit', 'id' => $record_id)).'">Make more changes</a>, <a href="'.$this->getView()->uri(array('method' => 'add')).'">create a new record</a> or <a href="'.$this->getView()->uri().'">return to the list view</a>.')
					);
				}
				else
				{
					$this->getView()->messages = array(
						new MK_Message('warning', 'This record was not updated as <strong>'.$config->instance->name.'</strong> is running in demonstration mode. <a href="'.$this->getView()->uri(array('method' => 'add')).'">create a new record</a> or <a href="'.$this->getView()->uri().'">return to the list view</a>.')
					);
				}
			}
			else
			{
				$record->save(false);
				$this->getView()->messages = array(
					new MK_Message('success', 'This record has been added. <a href="'.$this->getView()->uri(array('method' => 'edit', 'id' => $record->getId())).'">Make changes</a>, <a href="'.$this->getView()->uri(array('method' => 'add')).'">add another</a>,  or <a href="'.$this->getView()->uri().'">return to the list view</a>.')
				);
			}

			$this->getView()->setDisplayPath('modules/message');
		}
			
		$this->getView()->record = $record;

	}

	public function sectionIndex( $export = null )
	{

		// Define display options
		$this->options_list['Edit'] = array(
			'href' => $this->getView()->uri( array('method' => 'edit', 'id' => '{record_id}') ),
			'title' => 'Make changes to this record'
		);

		$this->options_list['Delete'] = array(
			'href' => $this->getView()->uri( array('method' => 'delete', 'id' => '{record_id}') ),
			'title' => 'Are you sure you want to delete this record and all related records?',
			'rel' => 'record delete'
		);
		
		$this->getView()->options_list = $this->options_list;
		$this->getView()->options_list_global = $this->options_list_global;

		// Paginator
		$paginator = new MK_Paginator();
		$paginator->setPage( MK_Request::getParam('page', 1) );
		$paginator->setPerPage( MK_Request::getParam('per_page', 20) );

		// Module field names
		$module_fields = $this->getView()->module->getFieldList();

		// Search Form
		$form_settings = array(
			'attributes' => array(
				'id' => 'module-search',
				'class' => 'clear-fix standard '.( MK_Request::getParam('method') === 'search' ? 'search-full' : 'search-mini' ),
				'action' => $this->getView()->uri( array('method' => 'search') )
			)
		);

		$form_structure = array(
			'search_keywords' => array(
				'type' => 'text',
				'label' => 'Keywords',
				'fieldset' => 'Search',
				'value' => MK_Request::getParam('search_keywords')
			),
			'per_page' => array(
				'type' => 'select',
				'options' => array(
					'20' => '20',
					'30' => '30',
					'40' => '40',
					'50' => '50'
				),
				'label' => 'Per page',
				'fieldset' => 'Search',
				'value' => $paginator->getPerPage()
			)
		);

		foreach($this->getView()->module->getFields() as $search_field)
		{
			if($search_field->getSpecificSearch() == '1')
			{
				$search_field->setFieldset('Search');
				$form_structure[$search_field->getName()] = MK_fieldHandler::get( null, $search_field, MK_Request::getParam($search_field->getName()) );
			}
		}

		$form_structure['search_submit'] = array(
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Search'
			)
		);

		$form_structure['search_clear'] = array(
			'type' => 'link',
			'text' => 'Clear Search',
			'attributes' => array(
				'href' => $this->getView()->uri()
			)
		);

		$module_search = new MK_Form($form_structure, $form_settings);
		
		$this->getView()->search_form = $module_search->render();

		// Data all fields
		if( !empty($export) )
		{
			$this->getView()->fields = $this->getView()->module->getFields();
		}
		// Data grid fields
		else
		{
			$this->getView()->fields = $this->getView()->module->getDataGridFields();
		}

		// Record display options & page params
		$options = array();
		$page_params = array();
		$page_params['page'] = $paginator->getPage();
		
		// Ordering
		if( !(MK_Request::getParam('orderby') && MK_Request::getParam('orderby_direction')) && ($this->getView()->module->getFieldOrderby() && $this->getView()->module->getOrderbyDirection()) )
		{
			MK_Request::setParam('orderby', $this->getView()->module->getFieldOrderby());
			MK_Request::setParam('orderby_direction', $this->getView()->module->getOrderbyDirection());
		}

		if( MK_Request::getParam('orderby') && MK_Request::getParam('orderby_direction') )
		{
			$options['orderby'] = array(
				'direction' => MK_Request::getParam('orderby_direction'),
				'field' => MK_Request::getParam('orderby')
			);
			$page_params['orderby'] = MK_Request::getParam('orderby');
			$page_params['orderby_direction'] = MK_Request::getParam('orderby_direction');
		}

		// Search submission
		$search_fields = array();
		foreach( $module_search->getFields() as $search_field )
		{
			$search_field_value = MK_Request::getParam($search_field->getName());
			if( ( $search_field->getName() === 'search_keywords' || array_key_exists($search_field->getName(), $module_fields) ) && $search_field_value )
			{
				$search_fields[$search_field->getName()] = $search_field_value;
				$page_params[$search_field->getName()] = $search_field_value;
			}
			elseif( $search_field->getName() === 'per_page' && $search_field_value )
			{
				$page_params[$search_field->getName()] = $search_field_value;
			}
		}

		if( count($search_fields) > 0 )
		{
			$page_params['method'] = 'search';
			$search_criteria = array();
			$search_criteria_list = array();

			$config = MK_Config::getInstance();
			foreach($search_fields as $search_field_name => $search_field_value)
			{
				if($search_field_name == 'search_keywords')
				{
					$search_keywords = array_filter(explode(' ', $search_field_value));
					foreach($this->getView()->module->getFields() as $search_field)
					{
						foreach($search_keywords as $keyword)
						{
							$search_criteria_list[] = "`".$search_field->getName()."` LIKE '%".mysql_real_escape_string($keyword, $config->db->con)."%'";
						}
					}
					$search_criteria[] = array( 'literal' => '('.implode(' OR ', $search_criteria_list).')' );
				}
				else
				{
					$search_criteria[] = array( 'field' => $search_field_name, 'value' => $search_field_value );
				}

			}
			
			// Get all records for export
			if( !empty($export) )
			{
				$this->getView()->records = $this->getView()->module->searchRecords($search_criteria);
			}
			// Get the paginated records
			else
			{
				$this->getView()->records = $this->getView()->module->searchRecords($search_criteria, $paginator, $options);
			}
		}
		else
		{
			// Get all records for export
			if( !empty($export) )
			{
				$this->getView()->records = $this->getView()->module->getRecords();
			}
			// Get the paginated records
			else
			{
				$this->getView()->records = $this->getView()->module->getRecords($paginator, $options);
			}
		}

		$this->getView()->page_params = $page_params;

		// Export records
		if( !empty($export) )
		{
			$this->getView()->setDisplayPath('modules/export');
			$this->getView()->setTemplatePath('export');
			$this->getView()->export = $export;
		}
		// Otherwise render the content normally for browser display
		else
		{
			$paging_url = $this->getView()->uri( array_merge_replace($page_params, array('page' => '{page}')) , false );
			$this->getView()->paginator = $paginator->render( $paging_url );
	
			if($this->getView()->module->getFieldUid() == 0 || $this->getView()->module->getFieldSlug() == 0)
			{
				$this->getView()->setDisplayPath('modules/message');
				$this->getView()->messages = array(
					new MK_Message('information', 'This module is not configured correctly, please ensure a \'UID Field\' and \'Slug Field\' have been specified')
				);
			}
			elseif(count($this->getView()->records) === 0)
			{
				if( MK_Request::getParam('method') === 'search' )
				{
					$this->getView()->messages = array(
						new MK_Message('information', 'Your search returned no results. Try again or return to the <a href="'.$this->getView()->uri().'">list view</a>.')
					);
				}
				else
				{
					$this->getView()->setDisplayPath('modules/message');
					$this->getView()->messages = array(
						new MK_Message('information', 'There are no records to display. Why not <a href="'.$this->getView()->uri( array('method' => 'add') ).'">create a new one</a>?')
					);
				}
			}
		}

	}

}

?>