<?php require_once("phpvibe.php");
if($user->isAuthorized()) {
$target_path = $config->site->mediafolder."/".$config->site->picsfolder.'/';
$allowedExts = array();
$maxFileSize = 0;
$extrastamp = strtolower(date("F-j-y-g-i-a-"));
$usr = $user->getId();

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

function vinsert($file,$name) {
global $user;
$c_user = $user->getId();
$t=time();
$c_time = date("F j, Y, g:i a",$t);
$ext = substr($file, strrpos($file, '.') + 1);
$name = str_replace($ext,'',$name);
$inserttmp = dbquery("insert into user_wall(message,u_id,picture,time)values('".$name."','".$c_user."','".$file."','".$c_time."')");
}

$headers = getHeaders();

if ($headers['X-Requested-With']=='XMLHttpRequest') { 
	$fileName = $headers['X-File-Name'];
	$fileSize = $headers['X-File-Size'];
	$ext = substr($fileName, strrpos($fileName, '.') + 1);
	if (in_array($ext,$allowedExts) or empty($allowedExts)) {
		if ($fileSize<$maxFileSize or empty($maxFileSize)) {
		$input = fopen("php://input",'r');
		$output = fopen($target_path.$extrastamp.str_replace(" ","-",$fileName),'a');
		if ($output!=false) {
			while (!feof($input)) {
				$buffer=fread($input, 4096);
				fwrite($output, $buffer);
			}
			fclose($output);
			$truefile = $target_path.$extrastamp.str_replace(" ","-",$fileName);
			$fakefile = $fileName;
			vinsert($truefile,$fakefile);
			echo '{"success":true, "file": "'.$fakefile.'"}';
			
		} else echo('{"success":false, "details": "Can\'t create a file handler."}');
		fclose($input);
	} else { echo('{"success":false, "details": "Maximum file size: '.ByteSize($maxFileSize).'."}'); };
	} else {
		echo('{"success":false, "details": "File type '.$ext.' not allowed."}');
		}
} else {
	if ($_FILES['file']['name']!='') {
	$fileName= $_FILES['file']['name'];
	$fileSize = $_FILES['file']['size'];
	$ext = substr($fileName, strrpos($fileName, '.') + 1);
	if (in_array($ext,$allowedExts) or empty($allowedExts)) {
		if ($fileSize<$maxFileSize or empty($maxFileSize)) {
	$target_path = $target_path . basename( $_FILES['file']['name']);
	if(move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
		echo '{"success":true, "file": "'.$target_path.'"}';
		vinsert(basename( $_FILES['file']['name']),basename( $_FILES['file']['name']));
	} else{
		echo '{"success":false, "details": "move_uploaded_file failed"}';
	}
} else { echo('{"success":false, "details": "Maximum file size: '.ByteSize($maxFileSize).'."}'); };
} else echo('{"success":false, "details": "File type '.$ext.' not allowed."}');
} else echo '{"success":false, "details": "No file received."}';

	
	}
}
?>
