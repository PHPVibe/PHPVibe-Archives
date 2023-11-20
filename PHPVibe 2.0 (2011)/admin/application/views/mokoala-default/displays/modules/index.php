<?php
	$user = MK_Authorizer::authorize();
?>
<div class="block">
    <h2>Managing <?php print $this->module->getName(); ?></h2>
    <div class="inner-block">
<?php
print $this->search_form;
if(  MK_Request::getParam('method') === 'search' )
{
	print '<p class="module-search-expand module-search-contract"><span>&ndash;</span><a href="'.$this->uri().'">Fewer options</a></p>';
}
else
{
	print '<p class="module-search-expand"><span>+</span><a href="'.$this->uri( array('method' => 'search') ).'">More options</a></p>';
}
?>
	</div>
<p class="module-export"><span>&#9660;</span><a href="<?php print $this->uri( array_merge_replace($this->page_params, array('export' => 'csv')) , false ); ?>">Export as CSV</a></p>
<h3>Records</h3>
<?php
if( !empty($this->message) )
{
	foreach( $this->messages as $message )
	{
		print '<p class="simple-message simple-message-'.$message->getType().'">'.$message->getMessage().'</p>';
	}
}
else
{
?>
<form id="module-browse" class="clear-fix" action="<?php print $this->uri(); ?>" enctype="multipart/form-data" method="post">
<table class="table-data" cellspacing="0" cellpadding="0" border="0">
    <thead>
        <tr>
            <th class="first center" style="width:5%;"><input type="checkbox" value="0" /></th>
<?php
	$field_count = 0;
	$total_fields = count($this->fields) + 1;
	if($this->module->getManagementWidth())
	{
		$total_fields++;
	}

	foreach($this->fields as $field){
		$field_count++;
		$class = array();
		if($field_count === 1) $class[] = 'first';
		if($field_count === $total_fields) $class[] = 'last';
		if($field->getId() == MK_Request::getParam('orderby'))
		{
			if(MK_Request::getParam('orderby_direction') === 'DESC') $class[] = 'desc';
			else $class[] = 'asc';
		}
    	print '<th class="'.implode(' ', $class).'" style="width:'.$field->getDisplayWidth().'"><a href="'.$this->uri( array('orderby' => $field->getId(), 'orderby_direction' => MK_Request::getParam('orderby_direction') == 'DESC' ? 'ASC' : 'DESC' ) ).'">'.$field->getLabel().'</a></th>';
	}
	
	if($this->module->getManagementWidth()){
		print '<th class="last" style="width:'.$this->module->getManagementWidth().'">Options</th>';
	}
?>
		</tr>
	</thead>
    <tbody>
<?php
	$counter = 0;
	foreach($this->records as $record){
		$counter++;
		$text_indent = '';

		for($i = 0; $i < $record->getNestedLevel(); $i++){
			$text_indent.='&nbsp;&nbsp;&nbsp;';
		}
?>
		<tr class="<?php print is_int($counter / 2) ? 'odd' : 'even'; ?>">
            <td class="first center" style="width:5%;"><input name="module-select[]" type="checkbox" value="<?php print $record->getId(); ?>" /></td>
<?php
		foreach($this->fields as $field){
			$get_method = 'get'.MK_Utility::stringToReference($field->getName());
			if($field->getId() === $this->module->getFieldSlug()){
?>
			<td><?php print $text_indent.$record->$get_method($field); ?></td>
<?php
			}else{
?>
			<td><?php print $record->$get_method($field); ?></td>
<?php
			}
		}
		
		if($this->module->getManagementWidth()){
			print '<td class="last options">';
			foreach( $this->options_list as $title => $attributes )
			{
				$attributes['class'] = 'mini-button mini-button-'.MK_Utility::getSlug($title);
				if(!$record->canEdit( $user )){
					$attributes['href'] = str_replace('{record_id}', $record->getId(), $attributes['href']);
					print '<a'.MK_Utility::getAttributes($attributes).'>'.$title.'</a> ';
				}
				else
				{
					print '<span title="This record cannot be edited" class="'.$attributes['class'].'">'.$title.'</span> ';
				}
			}
			print '</td>';
		}
?>
		</tr>
<?php
	}
	
	if(count($this->records) === 0)
	{
?>
		<tr class="no-records">
        	<td colspan="<?php print $total_fields; ?>">Sorry, your search returned no results!</td>
        </tr>
<?php
	}

?>
	</tbody>
</table>

<?php
	if(count($this->records) > 0)
	{
		print '<div class="paginator clear-fix">'.$this->paginator.'</div>';
	}

	if( in_array('delete', $this->options_list_global) )
	{
?>

<div class="clear-fix form-buttons form-field-submit field-delete">

    <div class="input-left">
        <div class="input-right">
            <input rel="record delete" title="Are you sure you want to delete the selected record(s) and all related records?" value="Delete Selected" type="submit" class="input-submit">
        </div>
    </div>
    
</div>

<?php
	}

	if( in_array('add', $this->options_list_global) )
	{
?>

<div class="clear-fix form-buttons form-field-link field-new">
    <div class="input-left">
        <div class="input-right">
            <a href="<?php print $this->uri( array('method' => 'add')); ?>" class="input-submit">Create New Record</a>
        </div>
    </div>

</div>

<?php
	}
?>

</form>
<?php
}
?>
</div>