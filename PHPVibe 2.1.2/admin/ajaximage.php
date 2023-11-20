<?php
include('security.php');
session_start();
$session_id='1'; //$session id
$path = "../uploads/";

	$valid_formats = array("jpg", "png", "gif", "bmp");
	if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
		{
			$name = $_FILES['photoimg']['name'];
			$size = $_FILES['photoimg']['size'];
			
			if(strlen($name))
				{
					list($txt, $ext) = explode(".", $name);
					if(in_array($ext,$valid_formats))
					{
					if($size<(2024*2024))
						{
							$actual_image_name = time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
							$tmp = $_FILES['photoimg']['tmp_name'];
							if(move_uploaded_file($tmp, $path.$actual_image_name))
								{
								//mysql_query("UPDATE users SET profile_image='$actual_image_name' WHERE uid='$session_id'");
									
									echo '
									
									 <div class="form">
   <form action="slider.php" method="post" class="standard clear-fix large">
   <fieldset>
  <div class="clear-fix form-field"></div>         
                    <div class="input-left"><div class="input-right">
					   <dt><label for="h2">
					 Title
					   </label></dt>
					   </div></div>
					    <div class="input-left"><div class="input-right">
					<dl>
<input type="text" name="h2" id="" size="4" value="" class="data input-text"/>
</dl>
</div></div>
  <div class="clear-fix form-field"></div>         
                    <div class="input-left"><div class="input-right">
					   <dt><label for="h3">
					 Subtitle
					   </label></dt>
					   </div></div>
					    <div class="input-left"><div class="input-right">
					<dl>
<input type="text" name="h3" id="" size="4" value="" class="data input-text"/>
</dl>
</div></div>
  <div class="clear-fix form-field"></div>         
                    <div class="input-left"><div class="input-right">
					   <dt><label for="link">
					 Link
					   </label></dt>
					   </div></div>
					    <div class="input-left"><div class="input-right">
					<dl>
<input type="text" name="link" id="" size="4" value="" class="data input-text"/>
</dl>
</div></div>
 <div class="clear-fix form-field"></div>         
                    <div class="input-left"><div class="input-right">
<img src=\''.$path.$actual_image_name.'\'  width="200" heaight="200" class=\'preview\'>


<input type="hidden" name="image" id="" size="4" value="'.$path.$actual_image_name.'"/>
					
		</div></div>		

<div class="clear-fix form-field"></div>  
<div class="clear-fix form-field field-searchsubmit form-field-submit">
<div class="input-left"><div class="input-right">
 <dl class="submit">
<input type="submit" name="submit" id="submit" value="Add slide" />
 </dl>	
</div></div></div><div class="clear-fix form-field"></div>
  </fieldset>
</form>
</div>
									
									
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