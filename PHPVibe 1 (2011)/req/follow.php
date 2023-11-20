<?php

	include("../_inc.php");
$joe = $_REQUEST['id'];		
$doe =  $user->getId() ;	
$res =  mysql_query("SELECT * FROM `follow` WHERE `uid` = ".$joe." AND `fid` = ".$doe." LIMIT 0, 30 ");
$check_result =  mysql_num_rows($res);
	if($check_result > 0)
	{
		mysql_query("delete from follow where uid = '$joe' AND fid = ".$doe);
		echo '<a class="btn-follow" href="#"></a>';
	}	
	else
	{
		mysql_query("INSERT INTO follow (uid,fid) VALUES('".$joe."','".$doe."')");
		echo '<a class="btn-following" href="#"></a>';
	}		
					

?>