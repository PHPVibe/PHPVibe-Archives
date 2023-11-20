<?php
$result=dbquery("select * from zu_ratings where vid = '".$video_id."'");

$row=dbarray($result);

$dislike=$row['dislike'];

$like=$row['liked'];
?>
<span class="totalstats">
<?php echo $like?> likes,  <?php echo $dislike?> dislikes
</span>