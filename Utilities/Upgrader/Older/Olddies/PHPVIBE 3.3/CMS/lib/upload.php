<?php require_once("../load.php");
if(is_user()) {
$target_path = ABSPATH.'/'.get_option('mediafolder')."/";
$allowedExts = array();
$maxFileSize = 0;
$new_name = strtolower(date("M-j-")).rand(15, 4567850).'-'.user_id();

function ByteSize($bytes) { 
    $size = $bytes / 1024; 
    if($size < 1024) 
        { 
        $size = number_format($size, 2); 
        $size .= ' KB'; 
        }  
    else  
        { 
        if($size / 1024 < 1024)  
            { 
            $size = number_format($size / 1024, 2); 
            $size .= ' MB'; 
            }  
        else if ($size / 1024 / 1024 < 1024)   
            { 
            $size = number_format($size / 1024 / 1024, 2); 
            $size .= ' GB'; 
            }  
        } 
    return $size; 
    } 

function getHeaders() {
    $headers = array();
    foreach ($_SERVER as $k => $v)
	{
        if (substr($k, 0, 5) == "HTTP_")
		{
            $k = str_replace('_', ' ', substr($k, 5));
            $k = str_replace(' ', '-', ucwords(strtolower($k)));
            $headers[$k] = $v;
		}
	}
    return $headers;
}  
$token = $_GET['token'];
function vinsert($file) {
global $db, $token;
$ext = substr($file, strrpos($file, '.') + 1);
$inserttmp = $db->query("INSERT INTO ".DB_PREFIX."videos_tmp (`uid`, `name`, `path`, `ext`) VALUES ('".user_id()."', '".$token."', '".$file."', '".$ext."')");
}

$headers = getHeaders();

if ($headers['X-Requested-With']=='XMLHttpRequest') { 
   $fileName = $headers['X-File-Name'];
   $fnc = explode(".",$fileName);
   if(in_array("php", $fnc)){
   echo '{"success":false, "details": "Insecure file detected."}';
   die();
   }
   if(in_array("Php", $fnc)){
   echo '{"success":false, "details": "Insecure file detected."}';
   die();
   }
   if(in_array("PHP", $fnc)){
   echo '{"success":false, "details": "Insecure file detected."}';
   die();
   }
   $fileSize = $headers['X-File-Size'];
	$ext = substr($fileName, strrpos($fileName, '.') + 1);
	if (in_array($ext,$allowedExts) or empty($allowedExts)) {
		if ($fileSize<$maxFileSize or empty($maxFileSize)) {
		$input = fopen("php://input",'r');
		$output = fopen($target_path.$new_name.'.'.$ext,'a');
		if ($output!=false) {
			while (!feof($input)) {
				$buffer=fread($input, 4096);
				fwrite($output, $buffer);
			}
			fclose($output);
			$truefile = $target_path.$new_name.'.'.$ext;
			$insertit = $new_name.'.'.$ext;

			vinsert($insertit);
			echo '{"success":true, "file": "'.$insertit.'"}';
			
		} else echo('{"success":false, "details": "Can\'t create a file handler."}');
		fclose($input);
	} else { echo('{"success":false, "details": "Maximum file size: '.ByteSize($maxFileSize).'."}'); };
	} else {
		echo('{"success":false, "details": "File type '.$ext.' not allowed."}');
		}
} else {
	if ($_FILES['file']['name']!='') {
	$fileName= $_FILES['file']['name'];
	  $fnc = explode(".",$fileName);
	if(in_array("php", $fnc)){
   echo '{"success":false, "details": "Insecure file detected."}';
   die();
   }
   if(in_array("Php", $fnc)){
   echo '{"success":false, "details": "Insecure file detected."}';
   die();
   }
   if(in_array("PHP", $fnc)){
   echo '{"success":false, "details": "Insecure file detected."}';
   die();
   }
	$fileSize = $_FILES['file']['size'];
	$ext = substr($fileName, strrpos($fileName, '.') + 1);
	if (in_array($ext,$allowedExts) or empty($allowedExts)) {
		if ($fileSize<$maxFileSize or empty($maxFileSize)) {
	$target_path = $target_path . $new_name.'.'.$ext;
	if(move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
		echo '{"success":true, "file": "OK"}';
			vinsert($new_name.'.'.$ext);
	} else{
		echo '{"success":false, "details": "move_uploaded_file failed"}';
	}
} else { echo('{"success":false, "details": "Maximum file size: '.ByteSize($maxFileSize).'."}'); };
} else echo('{"success":false, "details": "File type '.$ext.' not allowed."}');
} else echo '{"success":false, "details": "No file received."}';

	
	}
}
?>
