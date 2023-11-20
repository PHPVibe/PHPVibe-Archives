<?php

require_once 'FormFieldFile.class.php';

class MK_Form_Field_File_Image extends MK_Form_Field_File
{

	protected $valid_extensions = array(
		'jpg', 'jpeg', 'jpe', 'jif', 'jfif', 'jfi', // JPEG
		'gif', // GIF
		'png' // PNG
	);

	protected $valid_mime_types = array(
		'image/jpeg', 'image/pjpeg', // JPEG
		'image/gif', // GIF
		'image/png' // PNG
	);

	protected function renderField()
	{

		$html = '<label class="input-text" for="'.$this->getName().'">'.$this->getLabel().'</label>';
		$html .= '<div class="file-details">';
		$html .= '<input type="hidden" name="'.$this->getName().'[existing]" value="'.form_data($this->getValue()).'" />';
		if($this->getValue() && is_string($this->getValue()))
		{
			$html.='<img src="../com/timthumb.php?src='.$this->getValue().'&h=240&w=250&crop&q=100" />';
			if($this->getFileRemoveLink())
			{
				$html.='<p class="file-remove"><a href="'.$this->getFileRemoveLink().'">Remove file</a></p>';
			}
		}
		
		$html .= '<div class="input-left"><div class="input-right"><input'.($this->getAttributes()).' type="file" name="'.$this->getName().'" id="'.$this->getName().'" /></div></div>';
		$html .= '</div>';

		return $html;

	}

}

?>