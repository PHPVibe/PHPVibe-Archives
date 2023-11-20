<?php

require_once 'com/mokoala/File/File.class.php';
require_once 'com/mokoala/File/Image.class.php';
require_once 'com/mokoala/File/ImageThumb.class.php';


if(empty($_GET)){
	$params = str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['REQUEST_URI']);
	$params = array_filter(explode('/', $params));

	$method = array_pop($params);	
	$h = array_pop($params);
	$w = array_pop($params);
	$file = '../../'.implode('/', $params);

}else{
	$method = $_GET['m'];
	$h = $_GET['h'];
	$w = $_GET['w'];
	$file = '../../'.$_GET['f'];
}

$image = new MK_Image_Thumb($file, $w, $h, $method, '../../tpl/img/thumbs/');

if(!$image->fileExists()){
	
	print 'Source file does not exist';

}elseif(!$image->fileReadable()){
	
	print 'Source file not readable';

}elseif(!$image->thumbDestinationWritable()){

	print 'Thumbnail directory not writable';

}else{
	
	$image->create();
	header('Content-Type: '.$image->getMime());
	header('Content-Disposition: inline; filename="'.$image->getThumbDestinationFilename().'"');
	print $image->getThumbData();

}

?>