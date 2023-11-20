<?php include("../phpvibe.php");
$width = "340";
$height = "160";
$vid = new phpVibe($width, $height);


if(isSet($_POST['content']) && $user->isAuthorized())
// de repus POST
{
$msg = mysql_real_escape_string(cleanInput($_POST['content']));
$c_user = $user->getId();
$t=time();
$c_time = date("F j, Y, g:i a",$t);
$cuvinte=explode(' ',$msg);
$atach = "";
foreach ($cuvinte as $item){
		$item=trim($item);
		$http = stristr($item, 'http://');
		$www = stristr($item, 'www.');
		if (($http==true) or ($www==true)){
		if ($vid->getEmbedCode($item) != "This URL is invalid or the video is removed by the provider.")  {
			$atach = $item;
			break;
			}			
			
		}		
	}

if(!empty($atach)) { 
$sql=mysql_query("insert into user_wall(message,u_id,att,time)values('$msg','$c_user ','$atach','$c_time')");
}
else {
$sql=mysql_query("insert into user_wall(message,u_id,time)values('$msg','$c_user ','$c_time')");
} 
}
?>