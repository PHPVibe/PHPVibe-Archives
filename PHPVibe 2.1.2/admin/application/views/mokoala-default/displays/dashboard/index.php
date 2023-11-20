<div class="block">

	
<?php 
$sql = dbquery("SELECT COUNT(*) FROM videos"); 
$nrvideos = mysql_result($sql , 0);
function percent($num_amount, $num_total=NULL) {
if(is_null($num_total)): $num_total= "1000000"; endif;
$count1 = $num_amount / $num_total;
$count2 = $count1 * 100;
$count = number_format($count2, 0);
if($count > 100):
$count = 100;
elseif ($count < 5):
$count = $count + 3;
endif;
return $count;
}
$comsql = dbquery("SELECT COUNT(*) FROM em_comments"); 
$nrcoms = mysql_result($comsql , 0);
$tagsql = dbquery("SELECT COUNT(*) FROM tags"); 
$nrtags = mysql_result($tagsql , 0);
$likesql = dbquery("SELECT COUNT(*) FROM likes"); 
$nrlikes = mysql_result($likesql , 0);
$usersql = dbquery("SELECT COUNT(*) FROM users"); 
$nrusers = mysql_result($usersql , 0);
$wallsql = dbquery("SELECT COUNT(*) FROM user_wall"); 
$nrstatuses = mysql_result($wallsql , 0);
?>

	

<!-- Information data -->

        <div class="information-data">

        	<div class="date">

                <span class="date-figures"><?php echo $nrvideos; ?></span>
				
				<div class="headway-2"><div class="advance-2" style="width:<?php echo percent($nrvideos)?>%;"></div></div>

                <span class="date-title">Videos</span>

            </div>

            <div class="date">

                <span class="date-figures"><?php echo $nrlikes; ?></span>

                <div class="headway-2"><div class="advance-2" style="width:<?php echo percent($nrlikes,$nrvideos)?>%;"></div></div>

                <span class="date-title">Likes</span>

            </div>
			
			<div class="date">

                <span class="date-figures"><?php echo $nrusers; ?></span>

                <div class="headway-2"><div class="advance-2" style="width:<?php echo percent($nrusers,"5000")?>%;"></div></div>

                <span class="date-title">Users</span>

            </div>
			
			<div class="date">

                <span class="date-figures"><?php echo $nrstatuses; ?></span>

                <div class="headway-2"><div class="advance-2" style="width:<?php echo percent($nrststuses,$nrusers)?>%;"></div></div>

                <span class="date-title">Statuses</span>

            </div>

            <div class="date">

                <span class="date-figures"><?php echo $nrcoms; ?></span>

                <div class="headway-2"><div class="advance-2" style="width:<?php echo percent($nrcoms, "100")?>%;"></div></div>

                <span class="date-title">Comments</span>

            </div>

            <div class="date date-last">

                <span class="date-figures"><?php echo $nrtags; ?></span>

                <div class="headway-2"><div class="advance-2" style="width:<?php echo percent($nrtags, "4000")?>%;"></div></div>

                <span class="date-title">Tags</span>

            </div>

        </div>

        <!-- Information data end -->
	
	
<?php
if( count($this->message_list) > 0 )
{
	foreach( $this->message_list as $message )
	{
		print '<p class="simple-message simple-message-'.$message['type'].'">'.$message['message'].'</p>';
	}
}
?>
</div>
