<?php require_once("../phpvibe.php");

$val =  mysql_real_escape_string(cleanInput($_REQUEST['val']));
$value =  mysql_real_escape_string(cleanInput($_REQUEST['type']));
$usr = $user->getId();
if(empty($value)) {$value = "like";}

if($val)
{

if(($value) && ($usr))	{

if ($value == "like") {

$check = dbrows(dbquery("SELECT * FROM likes WHERE vid = '".$val."' AND uid ='".$usr."' "));	
	 if($check == 0) :
	    $query = "update videos set liked = liked+1 where id = '".$val."'";
		dbquery($query);
        $like_sql = "INSERT INTO likes (`uid`, `vid`, `type`) VALUES ('".$usr."', '".$val."', '".$value."');";
        dbquery($like_sql);
		
endif;


    } else {
	
$check = dbrows(dbquery("SELECT * FROM likes WHERE vid = '".$val."' AND uid ='".$usr."' "));	
	 if($check == 0) :
	    $query = "update videos set disliked = disliked+1 where id = '".$val."'";
		dbquery($query);
        $like_sql = "INSERT INTO likes (`uid`, `vid`, `type`) VALUES ('".$usr."', '".$val."', 'dislike');";
        dbquery($like_sql);
		
endif;


	
	
	}
	}

	
?>
<?php  if(!$usr) {
echo '<div class="alert-box">You need to login to like this video! </div>';
}
elseif($check == 0) {
	echo '<div class="success-box">You '.$value.' this video </div>';
} else {
echo '<div class="info-box">You have already voted on this video before!</div>';
}
?>
	<?php

}
MK_MySQL::disconnect();
?>
