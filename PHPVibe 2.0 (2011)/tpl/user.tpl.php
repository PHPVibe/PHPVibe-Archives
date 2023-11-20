<section id="wrapper">
<div class="one" style="padding-top: 10px;">
<div class="box one" style="width:98%; margin-left:9px; margin-bottom:9px;">

 		<div class="header">

 			<h2>
			 <?php
if( $name = $user_profile->getName() ) 	{ echo $name; 		} else { echo $user_profile->getDisplayName(); 		} ?>
			</h2>

    <!--Toggle-->

    <span class="toggle"></span>

 		</div>

 		<div class="content padding">
		<div class="one_fifth">
		<?php 			echo '<a class="lightbox" href="'.$site_url.$user_profile->getAvatar().'"><img src="'.$site_url.'components/thumb.php?f='.$user_profile->getAvatar().'&h=80&w=160&m=crop" /></a>';
           if(!$is_friend && ($user->getId() != $user_profile->getId() )){
			echo'<center><a id="reqfriend" href="#friendshipreq" class="button red icon connections">Add as friend</a> </center>';
			} else {
			echo 'Already friends';
			}
		?>

		</div>
		<div class="four_fifth last">
		<?php if( $about = $user_profile->getAbout() )
		{
			echo '<p><strong>About Me :</strong> ';
			echo $about.'</p>';
		} 
			
		
		$uvideopath = $u_canonical.'&sk=video&page=1';;
		$ufriendspath = $u_canonical.'&sk=friends&page=1';
		$uwallpath = $u_canonical.'&sk=wall&page=1';
		$ulikepath = $u_canonical.'&sk=likes&page=1';
		echo' <br /> <p>
<a href="'.$uwallpath.'" class="button red icon speechmedia">Wall</a> 
<a href="'.$ufriendspath.'" class="button red icon man">Friends</a> 
<a href="'.$uvideopath.'" class="button red icon play">Videos</a> 
<a href="'.$ulikepath.'" class="button red icon fire">Likes</a> 
';
if( $website = $user_profile->getWebsite() )
{ echo '<a href='.$website.' class="button red icon rss" target="_blank">Website</a>';}
?>
</p>		
		</div>
	<div class="clear"></div>		
</div>	
</div>	
<?php if(($pageNumber == "1") && ( $user->isAuthorized() && $user->getId() == $user_profile->getId() )) { ?>
<div class="one"  style="width:98%; margin-left:9px; margin-bottom:9px;">
<div class="box one_half">

 		<div class="header">

 			<h2>Friend requests</h2>

    <!--Toggle-->

    <span class="toggle"></span>

 		</div>

 		<div class="content padding">

<?php
$fresult = dbquery("SELECT id,fid FROM users_friends WHERE uid = '".$user_profile->getId()."' and status ='0'  ");
$fnr = mysql_num_rows($fresult); 
if ($fnr == "0") {echo "No friend requests for now. Maybe you should be more active ;)";}
 while($row = mysql_fetch_array($fresult)){

//echo $bff;
$user_fmodule = MK_RecordModuleManager::getFromType('user');
$user_f = MK_RecordManager::getFromId($user_fmodule->getId(), $row["fid"]);

$f_avatar = $user_f->getAvatar();
$f_name = $user_f->getDisplayName();
$f_canonical = $site_url.'user/'.$row["fid"].'/'.seo_clean_url($f_name) .'/';
$action_url =  $site_url.'components/friend_req.php?id='.$row["id"].'&action=';
echo '
<div style="width:162px; margin: 2px 5px; float:left; border: 1px dashed #000">
<a href="'.$f_canonical.'" title="'.$f_name.'"><img src="'.$site_url.'components/thumb.php?f='.$f_avatar.'&h=88&w=162&m=crop" / alt="'.$f_name.'"></a>
<p><center><strong>'.$f_name.'</strong></center></p>
<div class="button-group" style="margin: 1px 3px;">
<a href="'.$action_url.'aprove&lightbox[width]=396&lightbox[height]=120&lightbox[modal]=true" class="lightbox button red icon star">Accept</a> 
<a href="'.$action_url.'deny&lightbox[width]=396&lightbox[height]=120&lightbox[modal]=true" class="lightbox button red icon delete">Reject</a>
</div></div>';
}

?>

    </div>	
	</div>
<div class="box one_half last">

 		<div class="header">

 			<h2>Messages</h2>

    <!--Toggle-->

    <span class="toggle"></span>

 		</div>

 		<div class="content padding">	
	
		
	
	</div>
	</div>
	</div>
	<div class="clear"></div>	
	<?php } ?>
<div class="box one_fifth">

 		<div class="header">

 			<h2>Info</h2>

    <!--Toggle-->

    <span class="toggle"></span>

 		</div>

 		<div class="content padding">
	
		<?php
	if( $name = $user_profile->getName() )
		{
			echo '<p><strong>Real Name:</strong> ';
			echo $name.'</p>';
		}
		echo '<p><strong>Display Name :</strong> ';
		echo $user_profile->getDisplayName().'</p>';
		echo '<p><strong>Member Since :</strong> ';
		echo $user_profile->renderDateRegistered().'</p>';
		
		if( $location = $user_profile->getNowCity() )
		{
			echo '<p><strong>Current city :</strong> ';
			echo $location.'</p>';
		}
		if( $from_location = $user_profile->getFromCity() )
		{
			echo '<p><strong>From :</strong> ';
			echo $from_location.'</p>';
		}
		if( $gender = $user_profile->getGender() )
		{
			echo '<p><strong>Gender :</strong> ';
			echo $gender.'</p>';
		}
		if( $date_of_birth = $user_profile->getDateOfBirth() )
		{
			$date_of_birth = date($config->site->date_format, strtotime($date_of_birth));
			echo '<p><strong>Date of Birth :</strong> ';
			echo $date_of_birth.'</p>';
		}		
		echo '<p><strong>Last seen :</strong>
		'.$user_profile->renderLastlogin().'</p>';
		if( $rel = $user_profile->getRelation() )
		{
			echo '<p><strong>Relationship status :</strong> ';
			echo $rel.'</p>';
		}
		if( $quote = $user_profile->getQuote() )
		{
			echo '<p><strong>Favourite quote :</strong> ';
			echo $quote.'</p>';
		}
		if( $music = $user_profile->getMusic() )
		{
			echo '<p><strong>Favourite Music :</strong> ';
			echo $music.'</p>';
		}
		if( $movies = $user_profile->getMovies() )
		{
			echo '<p><strong>Movies :</strong> ';
			echo $movies.'</p>';
		}
		if( $tv = $user_profile->getTv() )
		{
			echo '<p><strong>TV Shows :</strong> ';
			echo $tv.'</p>';
		}
	
		
	
?>
		
		</div>

 	</div>
<div class="three_fifth">
<?php if(($pageNumber == "1") && ( $user->isAuthorized() && $user->getId() == $user_profile->getId() )) { ?>
<div class="box one">

 		<div class="header">

 			<h2>Share stuff</h2>

    <!--Toggle-->

    <span class="toggle"></span>

 		</div>

 		<div class="content padding">
		
		<div class="emAddComment">
<form  method="post" name="form" action="">
<textarea cols="20" rows="2" style="width:540px;font-size:14px;" name="content" id="content" maxlength="245" ></textarea><br />
<span class="emButton"> <input type="submit"  value="Update status"  id="v" name="submit" class="wall_update emButton"/></span>
</form>

</div>
<div id="flash" align="left"></div>
<ul id="update" class="facebookWall">
</ul>
<ul id="oldupdate" class="facebookWall">
</ul>
<div class="clear-fix"></div>
		</div>
</div>

	
 <?} ?>
	<?php 
	
	switch($_GET['sk']){
	case "video":
	include_once("uvideos.tpl.php");
	break;
	case "friends":
	include_once("ufriends.tpl.php");
	break;
	case "likes":
	include_once("ulikes.tpl.php");
	break;
	default:
	include_once("uwall.tpl.php");
	break;	
}
	
	?>
	</div>	
 </div>		
		</div>

 	</div>

 	<div class="box one_fifth last">
		<div class="header">

 			<h2>Advertisment</h2>

    <!--Toggle-->

    <span class="toggle"></span>

 		</div>

 		<div class="content padding">
		<center><img src="http://video.phpvibe.com/AD-120X600.jpg"/></center>
		</div>
		</div>
 	</div>
	<div id="friendshipreq" style="display:none; width:290px;">
	You are about to request <? print $user_profile->getDisplayName();?> to be your friend.
	<form action="<?php echo $u_canonical; ?>" method="post" class="standard clear-fix large">
	<input type="hidden" name="friendship" id="" size="54" value="<? print $user_profile->getId();?>"/>
	 <center><input type="submit" class="button red icon connections" name="submit" id="submit" value="Send request" /></center>
	</form>
	</div>