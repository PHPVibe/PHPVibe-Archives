<?php
if( $this->export === 'csv' )
{
	flush();
	header("Content-type: application/csv");
	header("Content-Disposition: attachment; filename=export-".date('Y-m-d').".csv");
	header("Pragma: no-cache");
	header("Expires: 0");
	$data_array = array();
	$data_output = array();
	$counter = 0;
	foreach($this->records as $record)
	{
		$counter++;
		$data_array[$counter] = array();
		foreach($this->fields as $field)
		{
			if( in_array($field->getType(), array('password', 'file', 'file_image')) )
			{
				continue;
			}
			$data_array[$counter][$field->getName()] = addslashes( $record->renderMetaValue($field->getName()) );
		}
		$data_output[] = '"'.implode('","',$data_array[$counter]).'"';
	}
	print implode("\n", $data_output);
	exit;
}
?>