<section id="wrapper">
<div class="one" style="padding-top: 10px; padding-left:5px;">
<div class="one_fourth">
	<div class="leftNav">
	
	<?php 			echo '<a class="lightbox" href="'.$site_url.$user_profile->getAvatar().'"><img src="'.$site_url.'com/timthumb.php?src='.$user_profile->getAvatar().'&w=212&crop&q=100" /></a>'; ?>
	
	<ul id="menu">
<li class="pin"><a href="<?php echo $u_canonical; ?>" title="<?php echo $user_profile->getDisplayName(); ?>" class="active"><span>
 <?php
if( $name = $user_profile->getName() ) 	{ echo $name; 		} else { echo $user_profile->getDisplayName(); 		} ?>

</span></a></li>

<?php 		
           if(!$is_friend && ($user->getId() != $user_profile->getId() )){
			echo'<li class="addhim"> <a id="reqfriend" href="#friendshipreq"><span>'.$lang['addf'].'</span></a></li> ';
			} else {
			echo"<li class=\"walled\"><a href=\"".$site_url."messages.php?method=compose&member=".$user_profile->getId()."\"><span>".$lang['send-msg']."</span></a></li>";
			echo "<li class=\"check\"><a href=\"\"><span>".$lang['addf0']."</span></a></li>";
			
			}
			
	$uvideopath = $u_canonical.'&sk=video&page=1';;
		$ufriendspath = $u_canonical.'&sk=friends&page=1';
		$uwallpath = $u_canonical.'&sk=wall&page=1';
		$ulikepath = $u_canonical.'&sk=likes&page=1';

	?>

 <?php
 echo'
<li class="walled"><a href="'.$uwallpath.'"><span>'.$lang['wall'].'</span></a> </li>
<li class="friends"><a href="'.$ufriendspath.'"><span>'.$lang['friends'].'</span></a> </li>
<li class="videos"><a href="'.$uvideopath.'"><span>'.$lang['videos'].'</span></a> </li>
<li class="likes"><a href="'.$ulikepath.'"><span>'.$lang['likes'].'</span></a> </li>
';
if( $website = $user_profile->getWebsite() )
{ echo '<li class="web"><a href='.$website.' target="_blank"><span>'.$lang['website'].'</span></a></li>';}
?>
</ul>
</div>
</div>
<div class="three_fourth last">
<?php if( $user->isAuthorized() && $user->getId() == $user_profile->getId() ) { ?>
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
		
<?php } ?>

<?php 
	
	switch($_GET['sk']){
	case "video":
	include_once("usr/uvideos.tpl.php");
	break;
	case "friends":
	include_once("usr/ufriends.tpl.php");
	break;
	case "likes":
	include_once("usr/ulikes.tpl.php");
	break;
	case "wall":
	include_once("usr/uwall.tpl.php");
	break;	
	
	default:
	
	include_once("usr/uinfo.tpl.php");
	
	
	break;	
}
	
	?>



</div>
</div>

	<div id="friendshipreq" style="display:none; width:290px;">
	You are about to request <? print $user_profile->getDisplayName();?> to be your friend.
	<form action="<?php echo $u_canonical; ?>" method="post" class="standard clear-fix large">
	<input type="hidden" name="friendship" id="" size="54" value="<? print $user_profile->getId();?>"/>
	 <center><input type="submit" class="button red icon connections" name="submit" id="submit" value="Send request" /></center>
	</form>
	</div>