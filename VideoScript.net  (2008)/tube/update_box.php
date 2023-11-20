<?php require_once("mainfile.php");

/* if(( empty ( $theval ) ) && (!empty($val))){

$theval = $val;

}*/

$theval  = $_REQUEST['val']; 


$result=dbquery("select * from zu_ratings where vid = '".$theval."'");



$row=dbarray($result);

//$gettotal = mysql_num_rows($result);



//$gettotal = $row['dislike'] + $row['liked'];


			


$dislike=$row['dislike'];



$like=$row['liked'];

$gettotal = $like + $dislike;



$likes=($like*20)/$gettotal;

$dislikes=($dislike*20)/$gettotal;?>



<button type="button" class="totalstatsbutton" onclick=";return false;" >

<img src="pixel-vfl73.gif" alt=""> 

<div class="greenBar" style="width:<?php echo $likes?>px">&nbsp;</div>

<div class="redbar" style="width:<?php echo $dislikes?>px">&nbsp;</div>

</button>