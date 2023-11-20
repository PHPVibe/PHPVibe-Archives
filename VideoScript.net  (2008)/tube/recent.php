<?php
require('config.php');
require('mainfile.php');

 echo '
  <?xml version="1.0" encoding="UTF-8"?>
<ut_response status="ok">
    <video_list> ';


$result = dbquery("SELECT * FROM recent LIMIT 30");  
$check = dbrows($result);
      
while($row = dbarray($result)){
echo '
		<video> 
<title>'.$row['title'].'</title> 
<url>'.Friendly_URL($row['video_id']).'</url> 
<thumbnail_url>'.Get_Thumb($row['video_id']).'</thumbnail_url> 
<run_time>'.$row['duration'].'</run_time> 
</video> 
';
	
}

  echo '  </video_list>

</ut_response>';

?>