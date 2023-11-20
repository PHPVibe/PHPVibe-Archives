<?php

/* if(( empty ( $theval ) ) && (!empty($val))){

$theval = $val;

}*/


$result=dbquery("select * from zu_ratings where vid = '".$video_id."'");



$row=dbarray($result);

//$gettotal = mysql_num_rows($result);



//$gettotal = $row['dislike'] + $row['liked'];


			


$dislike=$row['dislike'];



$like=$row['liked'];

$gettotal = $like + $dislike;



$likes=($like*20)/$gettotal;

$dislikes=($dislike*20)/$gettotal;?>



<button type="button" class="totalstatsbutton" onclick=";return false;" >
<div class="greenBar" style="width:<?php echo $likes?>px">&nbsp;</div>
<div class="redbar" style="width:<?php echo $dislikes?>px">&nbsp;</div>
</button>