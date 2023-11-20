<?php require_once("../mainfile.php");

$userip = $_SERVER['REMOTE_ADDR'];

$val = $_REQUEST['val'];




if($_REQUEST['value'])

{

	$value = mysql_escape_string($_REQUEST['value']);

	//if($value)

	//{

		//$result = dbquery("select userip from youtube_ip where userip='$userip'");

		//$num = mysql_num_rows($result);
		
	//}


	//if($num==0)
	if($value)

	{

		if($value == 'like')

		{

			$query = "update zu_ratings set liked = liked+1 where id = '".$val."'";

		}

		else

		{

			$query = "update zu_ratings set dislike = dislike+1 where id = '".$val."'";

		}

		

		dbquery($query);

		

		$que = "insert into youtube_ip (userip) values ('$userip')";

		dbquery( $que);

	}

	if($value == 'like')

	{

		$what = 'like';

	}

	else

	{

		$what = 'dislike';

	}

	$result=dbquery("select * from zu_ratings where id = '".$val."' ");

	

	$row=mysql_fetch_array($result);

	//$gettotal = mysql_num_rows($result);

	

	//$gettotal = $row['dislike'] + $row['liked'];

	$dislike=$row['dislike'];

	

	$like=$row['liked'];

	$gettotal = $like + $dislike;

	$likes=($like*100)/$gettotal;
	$dislikes=($dislike*100)/$gettotal;?>

<script type="text/javascript">

$(document).ready(function(){	

$('.close').click(function(){

		$('#voting_result').fadeOut();

	});	



});	

</script>

	<div class="mesgbox">You <?php echo $value?> this Article </div>

	<div class="close">X</div>
	
	<br clear="all" />

	<div style="margin-left:30px; color:#000000; font-size:12px;">Ratings for this Article 

	<span style="color:#999999">(<?php echo $gettotal?> total)</span>

	</div>

	

	<div class="thumbUp">

		<div style="margin-top:5px;"><?php echo $like?> </div><div class="bigGreenBar" style="width:<?php echo $likes?>px">&nbsp;</div>

	</div>

	<div class="thumbDown">

		<div style="margin-top:5px;"><?php echo $dislike?> </div><div class="bigRedBar" style="width:<?php echo $dislikes?>px">&nbsp;</div>

	</div>

	<?php

}?>



