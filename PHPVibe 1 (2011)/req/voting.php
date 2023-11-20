<?php 
require_once("../_inc.php");

//$userip = $_SERVER['REMOTE_ADDR'];

$val = mysql_escape_string($_REQUEST['val']);
$usr = $user->getId();



if($_REQUEST['value'])

{

	$value = mysql_escape_string($_REQUEST['value']);

	//if($value)

	//{

		//$result = dbquery("select userip from youtube_ip where userip='$userip'");

		//$num = mysql_num_rows($result);
		
	//}


	//if($num==0)
	if(($value) && ($usr))

	{

		if($value == 'like')

		{

			$query = "update videos set liked = liked+1 where id = '".$val."'";

		}

		else

		{

			$query = "update videos set disliked = disliked+1 where id = '".$val."'";

		}

		
$check = dbrows(dbquery("SELECT * FROM likes WHERE vid = '".$val."' AND uid ='".$usr."' "));	
	 if($check == 0) :
		dbquery($query);
    $like_sql = "INSERT INTO likes (`uid`, `vid`, `type`) VALUES ('".$usr."', '".$val."', '".$value."');";
dbquery($like_sql);
		
endif;
		//$que = "insert into youtube_ip (userip) values ('$userip')";

		//dbquery( $que);

	}

	
?>
<script type="text/javascript">

$(document).ready(function(){	

$('.close').click(function(){

		$('#voting_result').fadeOut();

	});	



});	

</script>
<?php  if($check == 0) {
	echo '<div class="mesgbox">You '.$value.' this video </div>';
} else {
echo '<div class="mesgbox">You have already voted on this video before!</div>';
}
?>
<div style="display:block;">
	<div class="close">X</div>
	
	<br clear="all" />
</div>
	<?php

}?>



