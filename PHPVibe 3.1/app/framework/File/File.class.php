<?php

class MK_File
{
	protected $file;

	public function __construct($file)
	{
		$this->file = $file;
		if(!$this->fileExists())
		{
			throw new MK_Exception("File, $file, does not exist");
		}
	}

	public function fileExists()
	{
		return is_file( $this->file );
	}
	
	public function delete()
	{
		return unlink( $this->file );
	}
	
	public function fileReadable()
	{
		return is_readable( $this->file );
	}

	public function getFile()
	{
		return $this->file;
	}

	public function getFilename()
	{
		$file_parts = explode('/', $this->file);
		return array_pop($file_parts);
	}

	public function getSize()
	{
		return filesize($this->file);
	}
}

?>