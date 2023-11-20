<?php 
require_once("../phpvibe.php");

//$userip = $_SERVER['REMOTE_ADDR'];
if(isset($_REQUEST['val'])) {
$val = mysql_escape_string($_REQUEST['val']);
} else {
$val = mysql_escape_string($_GET['val']);
}
$usr = $user->getId();


if($val)
{
$value = "like";
if(($value) && ($usr))	{

$check = dbrows(dbquery("SELECT * FROM likes WHERE vid = '".$val."' AND uid ='".$usr."' "));	
	 if($check == 0) :
	    $query = "update videos set liked = liked+1 where id = '".$val."'";
		dbquery($query);
        $like_sql = "INSERT INTO likes (`uid`, `vid`, `type`) VALUES ('".$usr."', '".$val."', '".$value."');";
        dbquery($like_sql);
		
endif;
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

}?>



