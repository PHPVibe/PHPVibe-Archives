<?php
require_once('image_lib_class.php');

class imageUpload extends imageLib {
	
	// *** Parameters passed in by the user
	private $fileInputName;
	private $saveFilePath;
	private $newFileName;
	private $allowedFileTypesArray = array();
	private $maxSize;
	
	// *** Parameters set by class
	private $targetPath;
	
	// *** Uploaded file information
   	private $fileTempName;
   	private $fileName;
   	private $fileSize; 
   	private $fileType;
	private $fileError;
   	private $fileExtension; 
	
	// *** This array holds errors to display to the users only.
	private $errorsArray = array();
	
	// *** This array holds errors you can use for debuggin' lovin'.
	private $debugArray = array();
	
	// *** The Holy Grail.
	private $isSuccessful;

## ------------------------------------------

	function __construct($fileInputName, $saveFilePath, $newFileName, $allowedFileTypesArray = array('.jpg', '.png', '.gif', '.bmp'), $maxSize = '2097152')
	
	{
		
		// *** Call me a pessimist, but I'm setting this sucker to false.
		$this->isSuccessful = false;
		
		$this->fileInputName = $fileInputName;
		$this->saveFilePath = $saveFilePath;
		$this->newFileName = $this->remove_ext($newFileName);
		$this->allowedFileTypesArray = $allowedFileTypesArray;
		$this->maxSize = $maxSize;
		
			
		$this->getUploadedFileInfo();
		$this->checkUploadedFile();	
		$this->processUploadedFile();
		
	}
	
## ------------------------------------------

	private function getUploadedFileInfo()
	#
	
	#	Purpose:	Get the uploaded file info provided in the PHP $_FILES array
	#
	{
       	$this->fileTempName	= $_FILES[$this->fileInputName]["tmp_name"];
       	$this->fileName		= $_FILES[$this->fileInputName]["name"];
       	$this->fileSize		= $_FILES[$this->fileInputName]["size"];
       	$this->fileType	    = $_FILES[$this->fileInputName]["type"];
       	$this->fileError    = $_FILES[$this->fileInputName]["error"];

		$this->retrieveExtension($this->fileName);
		
	}
	
## ------------------------------------------

	private function retrieveExtension($fileName) 
	#
	
	#	Purpose:	
	#
	{
		// *** Gets the last portion of the string starting at (and including) '.'
       	$this->fileExtension 	= strtolower(strrchr($fileName, '.'));
	}

## ------------------------------------------

	private function checkUploadedFile()
	#
		
	#	Purpose:	Performs tests on the file to make sure it is valid and uploaded.
	#
	{
   		// *** Test a file has been entered for upload
       	if (!$this->fileName) {
	
			$this->errorsArray[] = 'No file selected. Please select a file to upload';         
		}      


		switch ($this->fileError) {
		   case 0:
			   break;
		   case 1:
			   $this->errorsArray[] = "The uploaded file exceeds the upload_max_filesize directive (".ini_get("upload_max_filesize").") in php.ini.";
			   break;
		   case 2:
			   $this->errorsArray[] = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.";
			   break;
		   case 3:
			   $this->errorsArray[] = "The uploaded file was only partially uploaded.";
			   break;
		   case 4:
			   $this->errorsArray[] = "No file was uploaded.";
			   break;
		   case 5:
			   $this->errorsArray[] = "Missing a temporary folder.";
			   break;
		   case 6:
			   $this->errorsArray[] = "Failed to write file to disk.";
			   break;
		   default:
			   $this->errorsArray[] = "Unknown File Error.";
		}


		// *** Check for a valid file type
		if (!in_array($this->fileExtension,$this->allowedFileTypesArray) && empty($this->errorsArray)) {
			
			// *** Get extensions from array -> string
			$extensions = ''; 
			foreach ($this->allowedFileTypesArray as $value) {
				
				// *** Remove the '.' eg '.jpg' = 'jpg'
				$extensions .= ltrim($value, '.') . ', ';
			}
			
			// *** Remove the last comma
			$extensions = rtrim($extensions, ', ');
			
           	$this->errorsArray[] = 'The type of file you are trying to upload is invalid. Please make sure it is one of the following file types: ' . $extensions . '.';								    			
		}

       	// *** Check the size
       	if (($this->fileSize >= $this->maxSize) && empty($this->errorsArray)) {
           	$this->errorsArray[] = 'The file you are trying to uploaded is too big. Try again with a file smaller than ' . $this->maxSize .'.';
       	}

       	// *** Make sure the file was uploaded to the server
       	if (!is_uploaded_file($this->fileTempName) &&  empty($this->errorsArray)) {
           	$this->errorsArray[] = 'There was an error uploading your file. Please try again.';        
       	}		

		if (count($this->errorsArray) == 0) {
			$this->debugArray[] = 'Just checked the uploded file, all is good.';
		} else {		
			$this->debugArray[] = 'Just checked the uplaoded file. User file had some issues... check errorsArray';		
		}
		
	}

## ------------------------------------------

	private function processUploadedFile()
	#
		
	#	Purpose:	This is where we, ...wait for it, move the file from our hidden, underground,
	# 				temporary location, - known to only a few, to the public eye. ...The new Paris Hilton?	
	#
	# 						...POSSIBLY.
	#
	{
		// *** If no errors
		if (count($this->errorsArray) == 0) {

			// *** Check the upload directory exists, if not, desperatly try and create it.
			$result = $this->setupFolder();
			if (!$result) { return; }			
			
			// *** Set the target path. (path + filename + extension)
			$this->targetPath = $this->saveFilePath . '/' . $this->newFileName . $this->fileExtension; 

	        // *** Move file to our specified location
	        if (move_uploaded_file($this->fileTempName, $this->targetPath)) {
				$this->debugArray[] = '"move_upload_file" command successful.';

				// *** This IS the magic. Don't even think about saying its' name.	
				$this->isSuccessful = true;
				
				parent::__construct($this->targetPath);
	
			} else {
				$this->errorsArray[] = 'There was an error uploading your file. Please try again.';  
				$this->debugArray[] = 'There was an error with "move_upload_file". :('; 
			}	
		}		
	}

## ------------------------------------------

	private function setupFolder($permissions = 0777)
	#
	
	#	Purpose:	Creates the upload folder, with 777 permissions, if it doesn't exist already.
	# 				This is kinda a desperate attempt. Most uploading issues will stem from permissions.
	# 				
	# 				NOTE: You need permissions to for the folder you are wanting to create a new folder in.
	# 				This is unlikly to happen.
	#
	{
		$result = true;
		if (!is_dir($this->saveFilePath)) {
			if (mkdir($this->saveFilePath, $permissions)) {
								
				$this->debugArray[] = 'Folder does not exist but has been created.';

				
			} else {
				$this->debugArray[] = 'Folder does not exist and could NOT be created.';
				$result = false;
			}		
		} else {			
			$this->debugArray[] = 'Folder NOT created, it already exists!';
		}
		
		// *** Check if the path is writable
		if (!is_writable($this->saveFilePath)) {
			$this->errorsArray[] = 'The path is not writable';
			$result = false;
		}		
		
		return $result;
	}

## --------------------------------------------------------

	function remove_ext($name)
 	 {
 	     $ext = strrchr($name, '.');
 	     if($ext !== false)
 	     {
 	         $name = substr($name, 0, -strlen($ext));
 	     }
 	     return $name;
  	 }

## ------------------------------------------

	public function getTargetPath() 
	{
		return $this->targetPath;
	}
	 
	public function getErrorsArray()
	{
		return $this->errorsArray;
	}
	
	public function getError()
	{
		return array_pop($this->errorsArray);
	}
	
	public function getDebugArray()
	{
		return $this->debugArray;
	}
	
	public function getIsSuccessful()
	{
		return $this->isSuccessful;
	}	
	
	public function getExtension()
	{
		return $this->fileExtension;
	}
	
## ------------------------------------------


}

?>