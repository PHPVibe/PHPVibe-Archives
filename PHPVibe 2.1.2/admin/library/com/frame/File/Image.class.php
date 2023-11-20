<?php

class MK_Image extends MK_File
{

	protected $image = array();

	public function __construct($image_file){

		parent::__construct( $image_file );

		if( $this->fileReadable() ){

			$details = getimagesize($image_file);

			$this->image['height'] = $details[1];
			$this->image['width'] = $details[0];
			$this->image['mime'] = $details['mime'];

		}

	}
	
	public function getMime(){

		return $this->image['mime'];

	}
	
	public function getType(){
		switch( $this->getMime() ){
			
			case 'image/jpeg':
			case 'image/pjpeg':
				return 'jpeg';
				break;
			case 'image/png':
				return 'png';
				break;
			case 'image/gif':
				return 'gif';
				break;
			default:
				break;
			
		}
	}

	public function getWidth(){

		return $this->image['width'];

	}

	public function getHeight(){

		return $this->image['height'];

	}

}

?>