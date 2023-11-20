<?php

class MK_Directory
{
	
	protected $path;

	protected $files = array();
	protected $directories = array();

	public function __construct( $directory, $auto_create = true )
	{
		$directory = trim($directory, '/');
		if( !is_dir($directory) )
		{
			if($auto_create === true)
			{
				mkdir($directory, 0777);
			}
			if( !is_dir($directory) )
			{
				throw new MK_Exception("The directory '$directory' does not exist");
			}
		}
		else
		{
			$this->path = $directory;
		}
	}
	
	public function getDirectories( $force_refresh = false )
	{
		if( $force_refresh === true || empty($this->files) )
		{
			$folder_contents = scandir($this->path);
			foreach($folder_contents as $folder_item)
			{
				if( $folder_item != '.' && $folder_item != '..' && is_dir($this->path.'/'.$folder_item) )
				{
					$this->directories[$folder_item] = $folder_item;
				}
			}
		}

		return $this->directories;
	}
	
	public function getFiles( $force_refresh = false )
	{
		if( $force_refresh === true || empty($this->files) )
		{
			$folder_contents = scandir($this->path);
			foreach($folder_contents as $folder_item)
			{
				if( is_file($this->path.'/'.$folder_item) )
				{
					$this->files[$folder_item] = $folder_item;
				}
			}
		}

		return $this->files;
	}

	public function move( $destination )
	{
		rename( $this->path, $destination );
	}

	public function copy( $target )
	{
		$source = $this->path;

		if( is_dir( $source ) )
		{
			if( !is_dir( $target ) )
			{
				mkdir( $target, 0777, true );
			}
			$extension_contents = scandir( $source );

			foreach( $extension_contents as $file_folder )
			{
				if( $file_folder == '.' || $file_folder == '..' )
				{
					continue;
				}

				$entry = $source . '/' . $file_folder; 

				try
				{
					$copy_dir = new MK_Directory($entry, false);
					$copy_dir->copy( $target . '/' . $file_folder );
				}
				catch(Exception $e)
				{
					copy( $entry, $target . '/' . $file_folder );
				}
			}
	 
		}
		else
		{
			copy( $source, $target );
		}
		
		return $this;
		
	}
	
	public function deleteContents()
	{
		$this->delete(true, false);
	}
	
	public function delete( $delete_contents = false, $delete_self = true )
	{
		if( $delete_contents === true )
		{
			$directories = $this->getDirectories();
			$files = $this->getFiles();

			foreach($directories as $directory)
			{
				$directory = new MK_Directory($this->path.'/'.$folder_item);
				$directory->delete(true);
				unset($directory);
			}

			foreach($files as $file)
			{
				unlink($this->path.'/'.$file);
			}
		}

		if( !rmdir($this->path) )
		{
			throw new MK_Exception("The directory '".$this->path."' could not be deleted. Either you do not have permission or the directory is not empty.");
		}
	}
	
}

?>