<?php
require_once '../admin/library/com/frame/File/File.class.php';
require_once '../admin/library/com/frame/File/Image.class.php';
require_once '../admin/library/com/frame/File/ImageThumb.class.php';
//require_once '../phpvibe.php';

if(empty($_GET)){
	$params = str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['REQUEST_URI']);
	$params = array_filter(explode('/', $params));

	$method = array_pop($params);	
	$h = array_pop($params);
	$w = array_pop($params);
	$file = '../'.implode('/', $params);

}else{
	$method = $_GET['m'];
	$h = $_GET['h'];
	$w = $_GET['w'];
	if(!empty($_GET['f'])) {
	$file = '../'.$_GET['f'];
	} else {
	$file = "../tpl/images/noavatar.png";
	}
}

$image = new MK_Image_Thumb($file, $w, $h, $method, '../tpl/img/thumbs/');

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