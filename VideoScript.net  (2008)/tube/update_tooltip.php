<?php
require_once("mainfile.php");
$theval  = $_REQUEST['val']; 
$result=dbquery("select * from zu_ratings where vid = '".$theval."'");

$row=dbarray($result);

$dislike=$row['dislike'];

$like=$row['liked'];
?>
<span class="totalstats">
<?php echo $like?>  likes, <?php echo $dislike?>  dislikes
</span>