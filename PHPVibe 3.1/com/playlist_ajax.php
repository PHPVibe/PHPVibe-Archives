<?php
include('../phpvibe.php');
if( !$user->isAuthorized() ) { die("You have no business here untill you login!");}

$path = "../uploads/playlists";

	$valid_formats = array("bmp","jpg", "png", "gif");
	if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
		{
			$name = $_FILES['photoimg']['name'];
			$size = $_FILES['photoimg']['size'];
			
			if(strlen($name))
				{
					list($txt, $ext) = explode(".", $name);
					if(in_array($ext,$valid_formats))
					{
					if($size<(1024*1024))
						{
							$actual_image_name = time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
							$tmp = $_FILES['photoimg']['tmp_name'];
							if(move_uploaded_file($tmp, $path.$actual_image_name))
								{
								//mysql_query("UPDATE users SET profile_image='$actual_image_name' WHERE uid='$session_id'");
									
									echo '
									
									
                   
<img src=\''.$path.$actual_image_name.'\'  width="200" heaight="200" class=\'preview\'>


<input type="hidden" name="ch" id="ch" size="4" value="'.$path.$actual_image_name.'"/>
					
										
									';
								}
							else
								echo "failed";
						}
						else
						echo "Image file size max 1 MB";					
						}
						else
						echo "Invalid file format..";	
				}
				
			else
				echo "Please select image..!";
				
			exit;
		}
?>