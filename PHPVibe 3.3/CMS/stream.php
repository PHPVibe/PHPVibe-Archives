<?php // physical path of your root
if( !defined( 'ABSPATH' ) )
	define( 'ABSPATH', str_replace( '\\', '/',  dirname( __FILE__ ) )  );
//full path to dir with video.
$token = htmlspecialchars(base64_decode(base64_decode($_GET["file"])));
list($filename,$path) = explode('@@', $token);
$path = ABSPATH.'/'.$path.'/';
$ext=strrchr($filename, ".");
$file = $path . $filename;
$content_len=@filesize($file);  
header("Content-Description: File Transfer"); 
if(isset($_GET["type"])) {
$size = getimagesize($file); 
header('Content-Type:'.$size['mime']);
} else {
header("Content-type: video/".str_replace(array(".","ogv"),array("","ogg"),$ext)."");  
header("Accept-Ranges: bytes"); 
header("Content-Disposition: attachment; filename=\"$filename\"");  
header("Content-Transfer-Encoding: binary"); 
header("Content-Length: " . filesize($file)); 
}
if($content_len!=FALSE)  
{  
Header("Content-length: $content_len");  
} 
readfile($file);