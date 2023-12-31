<?php require_once("../load.php");
if(is_user()) {
$target_path = ABSPATH.'/'.get_option('tmp-folder','rawmedia')."/";
$final_path = ABSPATH.'/'.get_option('mediafolder')."/";
$ip = ABSPATH.'/'.get_option('mediafolder').'/thumbs/';	;

$allowedExts = array();
$maxFileSize = 0;
$token = toDb($_GET['token']);
$new_name = $token;


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

function vinsert($file) {
global $db, $token;
$ext = substr($file, strrpos($file, '.') + 1);
$db->query("INSERT INTO ".DB_PREFIX."videos_tmp (`uid`, `name`, `path`, `ext`) VALUES ('".user_id()."', '".$token."', '".$file."', '".$ext."')");
if($ext !== "mp4") {
//Needs converting
$db->query("INSERT INTO ".DB_PREFIX."videos (`date`,`pub`,`token`, `user_id`, `tmp_source`, `thumb`) VALUES (now(), '0','".$token."', '".user_id()."', '".$file."','uploads/processing.png')");
$binpath = get_option('binpath','/usr/bin/php5');
$command = $binpath." -f ".ABSPATH."/videocron.php";
exec( "$command > /dev/null &", $arrOutput );
} else {
//It's  mp4
global $target_path,  $final_path, $ip;
rename($target_path.$file, $final_path.$file);
$source = get_file($file,$token);
$db->query("INSERT INTO ".DB_PREFIX."videos (`pub`,`token`, `user_id`, `source`, `thumb`,`date`) VALUES ('0','".$token."', '".user_id()."', '".$source."','".get_option('mediafolder')."/thumbs/xmp3.jpg', now())");

//Extract thumbnail
$imgout = "{ffmpeg-cmd} -i {input} -y -f image2  -ss ".get_option('ffmpeg-thumb-time','00:00:03')." -vframes 1 -s 500x300 {output}";
$imgfinal = $ip.$token.'.jpg';
$thumb = str_replace(ABSPATH.'/' ,'',$imgfinal);
$imgout = str_replace(array('{ffmpeg-cmd}','{input}','{output}'),array(get_option('ffmpeg-cmd','ffmpeg'), $final_path.$file,$imgfinal), $imgout);
shell_exec ( $imgout);
$db->query("UPDATE  ".DB_PREFIX."videos SET thumb='".$thumb."' WHERE token = '".$token."'");


//Extract Duration

$cmd = get_option('ffmpeg-cmd','ffmpeg')." -i ".$final_path.$file;
exec ( "$cmd 2>&1", $output );
$text = implode ( "\r", $output );
if (preg_match ( '!Duration: ([0-9:.]*)[, ]!', $text, $matches )) {
			list ( $v_hours, $v_minutes, $v_seconds ) = explode ( ":", $matches [1] );
			// duration in time format
			$d = $v_hours * 3600 + $v_minutes * 60 + $v_seconds;			
		}
if(isset($d)) {		
list ( $duration, $trash ) = explode ( ".", $d );
}		
if(isset($duration)) {
$db->query("UPDATE  ".DB_PREFIX."videos SET duration='".$duration."' WHERE token = '".$token."'");
}


}
$doit = $db->get_row("SELECT id from ".DB_PREFIX."videos where token = '".$token."' order by id DESC limit 0,1");
if($doit) { add_activity('4', $doit->id); }
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
