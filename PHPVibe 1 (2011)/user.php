<?php require_once '_inc.php';
include("req/tolink.php");
include_once("library/AutoEmbed.class.php");
$AE = new AutoEmbed();

// We get an instance of the users module
$user_module = MK_RecordModuleManager::getFromType('user');

if($user_id = MK_Request::getQuery('id'))
{
	try
	{
		$user_profile = MK_RecordManager::getFromId($user_module->getId(), $user_id);
		$output = '';
		
		
		$output.= '<div class="user-details">';
		if( $name = $user_profile->getName() )
		{
			$output.= '<p><strong>'.__("Real Name").':</strong> ';
			$output.=$name.'</p>';
		}
		$output.= '<p><strong>'.__("Display Name").' :</strong> ';
		$output.=$user_profile->getDisplayName().'</p>';
		$output.= '<p><strong>'.__("Member Since").' :</strong> ';
		$output.=$user_profile->renderDateRegistered().'</p>';
		$output.= '<p><strong>'.__("Last Online").' :</strong> ';
		$output.=$user_profile->renderLastlogin().'</p>';
		if( $location = $user_profile->getNowCity() )
		{
			$output.= '<p><strong>'.__("Current city").' :</strong> ';
			$output.=$location.'</p>';
		}
		if( $from_location = $user_profile->getFromCity() )
		{
			$output.= '<p><strong>'.__("From").' :</strong> ';
			$output.=$from_location.'</p>';
		}
		if( $gender = $user_profile->getGender() )
		{
			$output.= '<p><strong>'.__("Gender").' :</strong> ';
			$output.=$gender.'</p>';
		}
		if( $website = $user_profile->getWebsite() )
		{
			$output.= '<p><strong>'.__("Website").' :</strong> ';
			$output.= '<a href="'.$website.'">'.$website.'</a></p>';
		}
		if( $date_of_birth = $user_profile->getDateOfBirth() )
		{
			$date_of_birth = date($config->site->date_format, strtotime($date_of_birth));
			$output.= '<p><strong>'.__("Date of Birth").' :</strong> ';
			$output.=$date_of_birth.'</p>';
		}		
		if( $about = $user_profile->getAbout() )
		{
			$output.= '<p><strong>'.__("About Me").' :</strong> ';
			$output.=$about.'</p>';
		}
		if( $rel = $user_profile->getRelation() )
		{
			$output.= '<p><strong>'.__("Relationship status").' :</strong> ';
			$output.=$rel.'</p>';
		}
		if( $quote = $user_profile->getQuote() )
		{
			$output.= '<p><strong>'.__("Favourite quote").' :</strong> ';
			$output.=$quote.'</p>';
		}
		if( $music = $user_profile->getMusic() )
		{
			$output.= '<p><strong>'.__("Favourite Music").' :</strong> ';
			$output.=$music.'</p>';
		}
		if( $movies = $user_profile->getMovies() )
		{
			$output.= '<p><strong>'.__("Movies").' :</strong> ';
			$output.=$movies.'</p>';
		}
		if( $tv = $user_profile->getTv() )
		{
			$output.= '<p><strong>'.__("TV Shows").' :</strong> ';
			$output.=$tv.'</p>';
		}
		$output.= '</div>';
	}
	catch(Exception $e)
	{
		header('Location: index.php', true, 302);
	}
}
else
{
	echo "That profile doesn't exist! ";
}
$cu_id = $user_profile->getId();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
 <title>
 <?php
if( $name = $user_profile->getName() )
		{
echo $name;
		} else {

		echo $user_profile->getDisplayName();
		}

?>
 
 </title>
<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge" /><![endif]-->
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="application-name"	content="phpVibe Videos" />
<meta name="description" content="
<?php
if( $about = $user_profile->getAbout() )
		{
			echo $about;
		} ?>
"/>
<link rel="shortcut icon" href="favicon.ico" />
<link href="tpl/css/default.css" media="screen" rel="stylesheet" type="text/css" />
<link href="tpl/css/comments.css" media="screen" rel="stylesheet" type="text/css" />
<link href="tpl/css/buttons.css" media="screen" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/comment.js"></script>
<script type="text/javascript" src="tpl/js/jquery.livequery.js"></script>

<SCRIPT>
function clearDefault(el) {
if (el.defaultValue==el.value) el.value = ""
}
</SCRIPT>
<script type="text/javascript">
$(function() {
$(".wall_update").click(function() {
var element = $(this);
var boxval = $("#content").val();
var dataString = 'content='+ boxval;
if(boxval=='')
{
alert("Please Enter Some Text");
}
else

	{

	$("#flash").show();

	$("#flash").fadeIn(400).html('<img src="ajax.gif" align="absmiddle">&nbsp;<span class="loading">Loading Update...</span>');

$.ajax({

		type: "POST",

  url: "req/update_ajax.php",

   data: dataString,

  cache: false,

  success: function(html){
  $("ul#update").prepend(html);

  $("ul#update li:first").slideDown("slow");

   document.getElementById('content').value='';

   $('#content').value='';

   $('#content').focus();

  $("#flash").hide();

  }

 });

}

return false;

	});

// Delete Wall Update

$('.delete_update').live("click",function() 

{

var ID = $(this).attr("id");

var dataString = 'msg_id='+ ID;

if(confirm("Sure you want to delete this update? There is NO undo!"))
{
$.ajax({

		type: "POST",

  url: "req/delete_update.php",

   data: dataString,

  cache: false,

  success: function(html){
 $(".bar"+ID).slideUp();
  }
 });
}
});
});
</script>
 <script type="text/javascript"> 
$(document).ready(function() { 
$('.follow_but> a').livequery("click",function(e){
var parent  = $(this).parent();
var getID   =  parent.attr('id').replace('button_','');
$.post("req/follow.php?id="+getID, {
}, function(response){
$('#button_'+getID).html($(response).fadeIn('slow'));
});
});	

});
 </script>
  </head>
<body>
<div id="top_er" class="clearfix">
<div id="top_left" class="clearfix">
<a href="<?php print $config->site->url; ?>" rel="nofollow"><img src="tpl/images/logo.png" alt="<?php print $config->site->name; ?>"/></a>
 </div>
 
 <div id="top_center" class="clearfix">
 <div id="searchwrap">
<form action="/video_tags.php" method="get" name="thisform-search" id="thisform-search" onsubmit="location.href='<?php print $config->site->url; ?>show/' + encodeURIComponent(this.tag.value).replace(/%20/g, '+'); return false;">
<input type="text" name="search" id="s" value="Search.." onfocus="if(this.value == 'Search..') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Search..';}"/>
<input type="submit" value="" class="go" />
</form>
</div>
 </div>
 <div id="top_right" class="clearfix">


<?php
if($user->isAuthorized())
	{
	$user_message_module = MK_RecordModuleManager::getFromType('user_message');

		$user_messages_inbox = $user_message_module->searchRecords(
			array(
				array('field' => 'recipient', 'value' => $user->getId()),
				array('field' => 'type', 'value' => 'inbox_unread')
			)
		);
		$user_messages_inbox_total = count($user_messages_inbox);

		$user_messages_drafts = $user_message_module->searchRecords(
			array(
				array('field' => 'sender', 'value' => $user->getId()),
				array('field' => 'type', 'value' => 'draft')
			)
		);
		$user_messages_drafts_total = count($user_messages_drafts);
echo'
<div class="button-group">
<a href="user.php?id='.$user->getId().'" class="button blue icon man rounded">'.$user->getName().'</a> 
<a href="edit-profile.php" class="button blue icon preferences rounded">'.__("Edit Profile").'</a>
<a href="messages.php?folder=inbox" class="button blue icon mailclosed rounded">Inbox ('.$user_messages_drafts_total.')</a>
';
?>
<?php print $user->getType() === MK_RecordUser::TYPE_CORE ? '<a href="change-password.php" class="button blue icon padlock rounded">'.__("Password").'</a>' : '' ?>
<a href="logout.php" class="button blue icon eject rounded">Logout</a>
</div>
<?php
} else {
echo'
<div class="button-group">
<a href="'.$config->site->url.'login/" class="button blue icon man rounded">'.__("Guest").'</a> 
<a href="'.$config->site->url.'login/" class="button blue icon connections rounded">'.__("Login").'</a>
<a href="'.$config->site->url.'register/" class="button blue icon connections rounded">'.__("Register").'</a>
<a href="'.$config->site->url.'login/" class="button blue rounded on">Facebook</a>
<a href="'.$config->site->url.'login/" class="button green rounded on">Twitter</a>

</div>';
}
?>

</div>
</div>
<div id="content-bkg"> 
<div class="wrapper"> 
 <div class="centerblock clearfix">

                            <div class="button-group">                             
                                <a href="<?php print $config->site->url; ?>" class="button blue icon house rounded"><?php echo __("Home");?></a>
								<a href="<?php print $config->site->url; ?>browse/" class="button blue icon clapboard rounded"><?php echo __("Recent videos");?></a>
								<a href="<?php print $config->site->url; ?>viewed/" class="button blue icon star rounded"><?php echo __("Most Viewed");?></a>
                                <a href="<?php print $config->site->url; ?>liked/" class="button blue icon heart rounded"><?php echo __("Most liked videos");?></a>
                                <a href="<?php print $config->site->url; ?>members.php" class="button blue icon man rounded"><?php echo __("Our Community");?></a>
								 <a href="<?php print $config->site->url; ?>bigwall.php" class="button blue icon speechmedia rounded"><?php echo __("Recent Buzz");?></a>
                            </div>

</div> 
<div class="clearfix" id="main-content">
<div class="col col12 clearfix">

<div class="col col3 border-right">	
  <div class="col-bkg clearfix">
      <h1>
	<?php if( $name = $user_profile->getName() ) 		{ echo $name;		} else {		echo $user_profile->getDisplayName(); 		} ?>
	</h1>
<?php
		if($avatar = $user_profile->getAvatar())
		{
			echo '<img class="user-image" src="library/thumb.php?f='.$avatar.'&h=128&w=208&m=crop" /> ';
		}
?>
<br /><br />
<?php
if( $user->isAuthorized() && $user->getId() != $user_profile->getId() )
{
			echo '<a href="messages.php?method=compose&member='.$user_profile->getId().'" class="button black icon mailclosed rounded">Send Msg</a>';
$joe = $user_profile->getId();					
$doe =  $user->getId() ;
$res =  mysql_query("SELECT * FROM `follow` WHERE `uid` = ".$joe." AND `fid` = ".$doe." LIMIT 0, 30 ");
$check_result =  mysql_num_rows($res);
					if($check_result > 0)
					{
						echo '<span class="follow_but" id="button_'.$joe.'"><a class="button black icon minus rounded" href="javascript: void(0)">Unfollow</a></span>';
						
					}
					else
					{
						echo '<span class="follow_but" id="button_'.$joe.'"><a class="button black icon plus rounded" href="javascript:void(0)">Follow</a></span>';
						
					}	
} ?>
<br /><br />
<?php
echo $output; ?>
</div>
</div>
<div class="col col6">	
  <div class="col-bkg clearfix">
<div id="FBpage">
<?php
if( $user->isAuthorized() && $user->getId() == $user_profile->getId() )
{
?>

<h4><?php echo __("What are you doing");?> <?php echo $user->getDisplayName();?>?</h4>
<div class="emAddComment">
<form  method="post" name="form" action="">
<textarea cols="20" rows="2" style="width:400px;font-size:14px;" name="content" id="content" maxlength="245" ></textarea><br />
<span class="emButton"> <input type="submit"  value="Update status"  id="v" name="submit" class="wall_update"/></span>
</form>

</div>
<br />
<?php } ?>

<div id="flash" align="left"></div>
<ul id="update" class="facebookWall">
</ul>
<ul id="oldupdate" class="facebookWall">
</ul>
<div class="clear-fix"></div>
<div id="wall" class="facebookWall">

<?php

$result=mysql_query("select * from user_wall where u_id = '".$cu_id."' order by msg_id desc limit 0,20");
 while($row = mysql_fetch_array($result)){
$id=$row['msg_id'];
$msg=$row['message'];
$user_id=$row['u_id'];
$user_time=$row['time'];
$user_video=$row['att'];
$msg=toLink($msg);
$user_module = MK_RecordModuleManager::getFromType('user');
$user_wall = MK_RecordManager::getFromId($user_module->getId(), $user_id);
$u_avatar = $user_wall->getAvatar();
$u_name = $user_wall->getDisplayName();

echo '
<li>
<img class="avatar" src="../../library/thumb.php?f='.$u_avatar.'&h=62&w=62&m=crop" />
<div class="status">
<h2><a href="user.php?id='.$user_id.'">'.$u_name.'</a></h2>
<p class="message">'.$msg.'</p>
';
if ($AE->parseUrl($user_video)) {
$AE->setWidth(240);
$AE->setHeight(160); 
echo '<div class="attachment">'.$AE->getEmbedCode().'</div>';  
}
echo '</div>
<p class="meta">'.$user_time.'</p>
<div class="comment-data">
';  

$object_id = 'status_'.$id; //identify the object which is being commented
include('loadComments.php'); //load the comments and display    
echo '</div></li>';

}
?>
</div>

<a class="button blue icon speechbubble rounded" href="<?php print $config->site->url; ?>statuses.php?id=<?php echo $cu_id; ?>">All statuses</a>


</div>
    </div>	
  </div>
  </div>

<div class="col col4 col-last">

  <div class="sidecol-bkg">
     

    
      <div class="sidebare">
         <div class="header">
           <h5 class="button black icon man rounded">Followed by</h5>
         </div>     
		 
<div class="av_content">
<?php
$fresult=mysql_query("SELECT fid FROM follow where uid = '".$cu_id."' order by id desc");
while($row = mysql_fetch_array($fresult)){	
$fid = $row['fid'];
$user_fmodule = MK_RecordModuleManager::getFromType('user');
$user_f = MK_RecordManager::getFromId($user_fmodule->getId(), $fid);
$f_avatar = $user_f->getAvatar();
$f_name = $user_f->getDisplayName();
echo '<a href="user.php?id='.$fid.'" title="'.$f_name.'"><img src="library/thumb.php?f='.$f_avatar.'&h=48&w=48&m=crop" / alt="'.$f_name.'"></a>';
}	
?>			

<div class="clear"></div>
 </div>

       <div class="sidebare">
         <div class="header">
           <h5 class="button black icon man rounded">Following</h5>
         </div>     
		 
<div class="av_content">
<?php
$fresult=mysql_query("SELECT uid FROM follow where fid = '".$cu_id."' order by id desc");
while($row = mysql_fetch_array($fresult)){	
$uid = $row['uid'];
$user_umodule = MK_RecordModuleManager::getFromType('user');
$user_u = MK_RecordManager::getFromId($user_umodule->getId(), $uid);
$u_avatar = $user_u->getAvatar();
$u_name = $user_u->getDisplayName();
echo '<a href="user.php?id='.$uid.'"  title="'.$u_name.'"><img src="library/thumb.php?f='.$u_avatar.'&h=48&w=48&m=crop" alt="'.$u_name.'"/></a>';

}	
?>			

<div class="clear"></div>
 </div>
 
  </div>
         <div class="sidebare">
         <div class="header">
           <h5 class="button black icon clapboard rounded">Likes</h5>
         </div>     
		 
<div class="sidekeep clearfix">

<ul class="clearfix">
<?php
$l_result=dbquery("SELECT vid FROM likes where uid = '".$cu_id."' and type='like' order by id desc");
$vid="";
while ($info = dbarray($l_result)):
$vid .= $info['vid'].", ";
endwhile;
$vid_array = explode(', ', $vid);
foreach($vid_array as $liked):	
//echo $liked;
$v_result=dbquery("SELECT id,youtube_id,title,views,duration,liked FROM videos WHERE id = '".$liked."' limit 0,1");
while($row = mysql_fetch_array($v_result)){
	$new_id = $row["id"];	
	$new_yt = $row["youtube_id"];
	$new_title = $row["title"];
	$small_title = substr($new_title, 0, 50);  
	$new_seo_url = $site_url.'video/'.$new_id.'/'.seo_clean_url($new_title) .'/';	
	$new_views = $row["views"];
	$new_duration = $row["duration"];
	$new_liked = $row["liked"];
	
	
  echo '
<li class="clearfix">
<div class="thumb clearfix">
<a href="'.$new_seo_url.'"><img src="'.Get_Thumb($new_yt).'"  width="122" height="84" alt="'.$new_title.'" />
<span class="time">'.sec2hms($new_duration).'</span>
</a>
</div>
<div class="description clearfix">
<p><a href="'.$new_seo_url.'"> '.$small_title.'...</a></p>
<p class="viewcounts">'.$new_views.' '.__("views").'</p>
<p class="stat">Liked by '.$new_liked.' '.__("persons").'</p> 
</div>
</li>';

}
endforeach;
?>			
</ul>
<div class="clear"></div>
 </div>
 
  </div>
 </div>
        </div>
            <div class="sidebare">
         <div class="header">
           <h5 class="button black icon delete rounded">Doesn't like</h5>
         </div>     
		 
<div class="sidekeep clearfix">

<ul class="clearfix">
<?php
$dl_result=dbquery("SELECT vid FROM likes where uid = '".$cu_id."' and type='dislike' order by id desc");
$vid="";
while ($info = dbarray($dl_result)):
$vid .= $info['vid'].", ";
endwhile;
$vid_array = explode(', ', $vid);
foreach($vid_array as $liked):	
//echo $liked;
$dv_result=dbquery("SELECT id,youtube_id,title,views,duration,liked FROM videos WHERE id = '".$liked."' limit 0,1");
while($row = mysql_fetch_array($dv_result)){
	$new_id = $row["id"];	
	$new_yt = $row["youtube_id"];
	$new_title = $row["title"];
	$small_title = substr($new_title, 0, 50);  
	$new_seo_url = $site_url.'video/'.$new_id.'/'.seo_clean_url($new_title) .'/';	
	$new_views = $row["views"];
	$new_duration = $row["duration"];
	$new_liked = $row["liked"];
	
	
  echo '
<li class="clearfix">
<div class="thumb clearfix">
<a href="'.$new_seo_url.'"><img src="'.Get_Thumb($new_yt).'"  width="122" height="84" alt="'.$new_title.'" />
<span class="time">'.sec2hms($new_duration).'</span>
</a>
</div>
<div class="description clearfix">
<p><a href="'.$new_seo_url.'"> '.$small_title.'...</a></p>
<p class="viewcounts">'.$new_views.' views</p>
<p class="stat">'.__("Liked by").' '.$new_liked.' persons</p> 
</div>
</li>';

}
endforeach;
?>			
</ul>
<div class="clear"></div>
 </div>
 
  </div>
 </div>
        </div>   
    </div>
    
    </div>
	</div>
	</div>
<?php      
include_once("tpl/php/footer.php");
?>
 </body>
</html>
