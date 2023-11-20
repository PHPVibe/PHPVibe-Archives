<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="Description" content="<?php echo $bio_body; ?> | <?php echo $username; ?>" />
<meta name="Keywords" content="<?php echo "$username, $city, $state, $country"; ?>" />
<meta name="rating" content="General" />
<meta name="ROBOTS" content="All" />
<title><?php echo $username; ?>'s profile</title>
<link rel="icon" href="<?=$site_url?>templates/<?=$template?>favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="<?=$site_url?>templates/<?=$template?>favicon.ico" type="image/x-icon" />
<script src="<?=$site_url?>js/jquery-1.4.2.js" type="text/javascript"></script>
<base href="<?=$site_url?>" />
		
<!-- Zubee's STYLESHEET --> 
<link href="<?=$site_url?>templates/<?=$template?>/style.css" rel="stylesheet" type="text/css" />
<!--[if IE 7]>	
	<link rel="stylesheet" href="http://misterdevil.com/templates/default/css/ie7.css" type="text/css" media="screen" title="ie8" charset="utf-8" />
	<![endif]--> 
<!--[if IE 6]>
<script src="http://misterdevil.com/templates/default/js/DD_belatedPNG_0.0.8a-min.js"></script>
<link rel="stylesheet" href="css/ie6.css" type="text/css" media="screen," />
<script>
  
  DD_belatedPNG.fix('#header'); 
  DD_belatedPNG.fix('.pngfix'); 
 
</script>
<![endif]--> 
<script type="text/javascript" src="<?=$site_url?>templates/<?=$template?>/js/iepngfix_tilebg.js"></script>
<script type="text/javascript" src="<?=$site_url?>templates/<?=$template?>/js/cufon/cufon-yui.js"></script>
<script type="text/javascript" src="<?=$site_url?>templates/<?=$template?>/js/cufon/TitilliumText22L_300.font.js"></script>	
		<script type="text/javascript" src="<?=$site_url?>templates/<?=$template?>/js/main.js"></script>	
<script type="text/javascript" src="<?=$site_url?>templates/<?=$template?>/js/jquery.tweet.js"></script>
<link href="<?=$site_url?>templates/<?=$template?>/css/jquery.tweet.css"  media="all" rel="stylesheet" type="text/css"/> 

<script> 
    jQuery(document).ready(function($) {	
$(".tweet").tweet({
          join_text: "auto",
          username: "<?php echo $username; ?>",
          avatar_size: 48,
          count: 10,
          auto_join_text_default: "I said,", 
          auto_join_text_ed: "I",
          auto_join_text_ing: "I were",
          auto_join_text_reply: "I replied",
          auto_join_text_url: "I was checking out",
          loading_text: "loading tweets..."
        });
 })
  </script>	

<!-- Required CSS -->
<script type="text/javascript" src="http://twitter-friends-widget.googlecode.com/files/jquery.twitter-friends-1.0.min.js"></script>

<style type="text/css">

/* container */

div.twitter-friends{ }



/*------- Header -------*/

div.tf-header{

	border:silver 1px solid;

	overflow:hidden;

	margin:0 0 1px 0;

}

div.tf-header img{

	border:silver 1px solid;

	margin:1px;

	float:left;

	width:32px;

	height:32px;

}

div.tf-header h2{

	line-height:32px;

	font-weight:bolder;

	display:block;

	margin:3px;

	padding:0;

	float:left;

	font-size:12px;

}

/*------- Users -------*/

div.tf-users{

	/* fixed height so container will not flicker within transitions */

	height:240px;

	border:silver 1px solid;

	overflow:hidden;

	background-color:#eaeaea;

}

/* user img link*/

div.tf-users a{ 

	display:block;

	float:left;

}

/* user img */

div.tf-users img{ }



/*------- Info Link -------*/

div.tf-info{

	text-align:right;

}

div.tf-info a{

	text-decoration:none;

	font-size:9px;

	font-weight:bolder;

	color:gray;

	font-family:tahoma;

}



/*------- tweet div -------*/

div.tf-tweet{

	/* fixed height so container will not flicker with different length tweets  */

	height:56px;

	overflow:hidden;

}

/* tweet item */

div.tf-tweet div{

	border:silver 1px solid;

	position:relative;

	padding:1px;

	margin:1px 0 0 0;

	overflow:hidden;

	height:50px;

}



/* tweet author avatar */

div.tf-tweet span.tf-avatar{

	display:block;

	width:48px;

	height:48px;

	margin:0 2px 0 2px;

	left:0;

	position:absolute;

	overflow:hidden;

}

/* tweet author name */

div.tf-tweet strong a{

	margin-right:5px;

}

/* tweet body */

div.tf-tweet span.tf-body {

	display:block;

	margin-left:55px;

}

/* tweet content */

div.tf-tweet span.tf-content{

}

/* tweet date and source */

div.tf-tweet span.tf-meta {

	color:#999999;

	display:block;

	font-size:0.764em;

	margin:3px 0 0;

}

div.tf-tweet span.tf-meta a{

	color:#999999;

	text-decoration:none;

}

div.tf-tweet span.tf-meta a:hover{

	text-decoration:underline;

}

/* tweet date link */

div.tf-tweet a.tf-date { }

/* tweet source link */

div.tf-tweet a.tf-source { }

/* tweet links */

div.tf-tweet a.tf-link { }

/* tweet @user links */

div.tf-tweet a.tf-at { }

/* tweet #hashtags links */

div.tf-tweet a.tf-hashtag { }

</style>

<style type="text/css">
<!--
.infoHeader {
	background-color: #BDF;
	font-size:11px;
	font-weight:bold;
	padding:8px;
	border: #999 1px solid;
	border-bottom:none;
	width:200px;
}


.interactContainers {
	padding:8px;
	background-color:#BDF;
	border:#999 1px solid;
	display:none;
}
#add_friend_loader {
	display:none;
}
#remove_friend_loader {
	display:none;
}
#interactionResults {
	display:none;
	font-size:16px;
	padding:8px;
}
#friendTable td{
	font-size:9px;
}
#friendTable td a{
	color:#03C;
	text-decoration:none;
}
#view_all_friends {
	background-image:url(style/opaqueDark.png);
	width:270px;
	padding:20px;
	position:fixed;
	top:150px;
	display:none;
	z-index:100;
	margin-left:50px;
}
#google_map {
	background-image:url(style/opaqueDark.png);
	padding:2px;
	position:fixed;
	top:150px;
	display:none;
	z-index:100;
	margin-left:50px;
}
-->
</style>
<script type="text/javascript" src="<?=$site_url?>templates/<?=$template?>/js/tabs.js"></script> 
<link rel="stylesheet" href="<?=$site_url?>templates/<?=$template?>/css/general.css" type="text/css" media="screen" /> 
<script language="javascript" type="text/javascript">
// jQuery functionality for toggling member interaction containers
function toggleInteractContainers(x) {
		if ($('#'+x).is(":hidden")) {
			$('#'+x).slideDown(200);
		} else {
			$('#'+x).hide();
		}
		$('.interactContainers').hide();
}
function toggleViewAllFriends(x) {
		if ($('#'+x).is(":hidden")) {
			$('#'+x).fadeIn(200);
		} else {
			$('#'+x).fadeOut(200);
		}
}
function toggleViewMap(x) {
		if ($('#'+x).is(":hidden")) {
			$('#'+x).fadeIn(200);
		} else {
			$('#'+x).fadeOut(200);
		}
}
// Friend adding and accepting stuff
var thisRandNum = "<?php echo $thisRandNum; ?>";
var friendRequestURL = "scripts_for_profile/request_as_friend.php";
function addAsFriend(a,b) {
	$("#add_friend_loader").show();
	$.post(friendRequestURL,{ request: "requestFriendship", mem1: a, mem2: b, thisWipit: thisRandNum } ,function(data) {
	    $("#add_friend").html(data).show().fadeOut(12000);
    });	
}
function acceptFriendRequest (x) {
	$.post(friendRequestURL,{ request: "acceptFriend", reqID: x, thisWipit: thisRandNum } ,function(data) {
            $("#req"+x).html(data).show();
    });
}
function denyFriendRequest (x) {
	$.post(friendRequestURL,{ request: "denyFriend", reqID: x, thisWipit: thisRandNum } ,function(data) {
           $("#req"+x).html(data).show();
    });
}
// End Friend adding and accepting stuff
// Friend removal stuff
function removeAsFriend(a,b) {
	$("#remove_friend_loader").show();
	$.post(friendRequestURL,{ request: "removeFriendship", mem1: a, mem2: b, thisWipit: thisRandNum } ,function(data) {
	    $("#remove_friend").html(data).show().fadeOut(12000);
    });	
}
// End Friend removal stuff
// Start Private Messaging stuff
$('#pmForm').submit(function(){$('input[type=submit]', this).attr('disabled', 'disabled');});
function sendPM ( ) {
      var pmSubject = $("#pmSubject");
	  var pmTextArea = $("#pmTextArea");
	  var sendername = $("#pm_sender_name");
	  var senderid = $("#pm_sender_id");
	  var recName = $("#pm_rec_name");
	  var recID = $("#pm_rec_id");
	  var pm_wipit = $("#pmWipit");
	  var url = "scripts_for_profile/private_msg_parse.php";
      if (pmSubject.val() == "") {
           $("#interactionResults").html('<img src="images/round_error.png" alt="Error" width="31" height="30" /> &nbsp; Please type a subject.').show().fadeOut(6000);
      } else if (pmTextArea.val() == "") {
		   $("#interactionResults").html('<img src="images/round_error.png" alt="Error" width="31" height="30" /> &nbsp; Please type in your message.').show().fadeOut(6000);
      } else {
		   $("#pmFormProcessGif").show();
		   $.post(url,{ subject: pmSubject.val(), message: pmTextArea.val(), senderName: sendername.val(), senderID: senderid.val(), rcpntName: recName.val(), rcpntID: recID.val(), thisWipit: pm_wipit.val() } ,           function(data) {
			   $('#private_message').slideUp("fast");
			   $("#interactionResults").html(data).show().fadeOut(10000);
			   document.pmForm.pmTextArea.value='';
			   document.pmForm.pmSubject.value='';
			   $("#pmFormProcessGif").hide();
           });
	  }
}
// End Private Messaging stuff
</script>
</head>
<body>
<!--START HEADER  -->
    <div id="header">
    
      <div id="head_wrap" class="container_12">
            
           <!--START LOGO  --> 
           <div id="logo" class="grid_8">
           
           		<h2><strong><?=$site_title?></strong></h2>
        </div>
           <!-- END LOGO -->
        
          <!-- START USERPANEL --> 
          <div id="user_panel" class="grid_4">
          
            <?php include("usermenu.php"); ?>
    </div>
          <!-- END USERPANEL --> 
        
        
			<!--START NAVIGATION  -->
            <div id="nav" class="grid_12">
            
            <!-- Start .zumega -->
<div class="zumega red">
 <?php include("menu.php"); ?>	
	
</div> <!-- .zumega --> 
                
                    
        </div>
        <!-- END NAV -->       
         
          
   	 </div>
     <!-- END HEAD_WRAP (CONTAINER FOR LOGO AND NAVIGATION -->
     
    </div>
    <!--END HEADER (FULLL WIDTH WRAPPER WITH BG) -->	
	
	<div id="content" class="container_16">
 
 <div class="grid_16">
  <div class="grid_4">
  <?php echo $user_pic; ?>
  	 <br/> 
  	 <?php echo $interactionBox; ?>
	 <br/> 
		  <?php echo $locationInfo; ?>
          <?php echo $website; ?>
          <?php echo $youtube; ?>
          <?php echo $facebook; ?>
		  <hr>
		  <?php echo $friendList; ?>
  <div id="view_all_friends">
              <div align="right" style="padding:6px; background-color:#FFF; border:#666 1px solid;">
                       <div style="display:inline; font-size:14px; font-weight:bold; margin-right:150px;">All Friends</div> 
                       <a href="#" onclick="return false" onmousedown="javascript:toggleViewAllFriends('view_all_friends');">close </a>
              </div>
              <div style="background-color:#FFF; height:240px; overflow:auto;border:#666 1px solid;">
                   <?php echo $friendPopBoxList; ?>
              </div>
              
         </div>		  


  </div>
    <div class="grid_11">
	
	<h1><?php echo $mainNameLine; ?></h1>
          <?php echo $bio_body; ?>
	<div class="interactContainers" id="add_friend">
                <div align="right"><a href="#" onclick="return false" onmousedown="javascript:toggleInteractContainers('add_friend');">cancel</a> </div>
                Add <?php echo "$username"; ?> as a friend? &nbsp;
                <a href="#" onclick="return false" onmousedown="javascript:addAsFriend(<?php echo $logOptions_id; ?>, <?php echo $id; ?>);">Yes</a>
                <span id="add_friend_loader"><img src="images/loading.gif" width="28" height="10" alt="Loading" /></span>
          </div>
		  
		  <div class="interactContainers" id="remove_friend">
                <div align="right"><a href="#" onclick="return false" onmousedown="javascript:toggleInteractContainers('remove_friend');">cancel</a> </div>
                Remove <?php echo "$username"; ?> from your friend list? &nbsp;
                <a href="#" onclick="return false" onmousedown="javascript:removeAsFriend(<?php echo $logOptions_id; ?>, <?php echo $id; ?>);">Yes</a>
                <span id="remove_friend_loader"><img src="images/loading.gif" width="28" height="10" alt="Loading" /></span>
          </div>
	   <div id="interactionResults" style="font-size:15px; padding:10px;"></div>

 <!-- START DIV that contains the Private Message form -->
          <div class="interactContainers" id="private_message">
<form action="javascript:sendPM();" name="pmForm" id="pmForm" method="post">
<font size="+1">Sending Private Message to <strong><em><?php echo "$username"; ?></em></strong></font><br /><br />
Subject:
<input name="pmSubject" id="pmSubject" type="text" maxlength="64" style="width:98%;" />
Message:
<textarea name="pmTextArea" id="pmTextArea" rows="8" style="width:98%;"></textarea>
  <input name="pm_sender_id" id="pm_sender_id" type="hidden" value="<?php echo $_SESSION['id']; ?>" />
  <input name="pm_sender_name" id="pm_sender_name" type="hidden" value="<?php echo $_SESSION['username']; ?>" />
  <input name="pm_rec_id" id="pm_rec_id" type="hidden" value="<?php echo $id; ?>" />
  <input name="pm_rec_name" id="pm_rec_name" type="hidden" value="<?php echo $username; ?>" />
  <input name="pmWipit" id="pmWipit" type="hidden" value="<?php echo $thisRandNum; ?>" />
  <span id="PMStatus" style="color:#F00;"></span>
  <br /><input name="pmSubmit" type="submit" value="Submit" /> or <a href="#" onclick="return false" onmousedown="javascript:toggleInteractContainers('private_message');">Close</a>
<span id="pmFormProcessGif" style="display:none;"><img src="images/loading.gif" width="28" height="10" alt="Loading" /></span></form>
          </div>
          <!-- END DIV that contains the Private Message form -->

<div class="interactContainers" id="friend_requests" style="background-color:#FFF; height:240px; overflow:auto;">
            <div align="right"><a href="#" onclick="return false" onmousedown="javascript:toggleInteractContainers('friend_requests');">close window</a> &nbsp; &nbsp; </div>
            <h3>The following people are requesting you as a friend</h3>
    <?php 
    $sql = "SELECT * FROM friends_requests WHERE mem2='$id' ORDER BY id ASC LIMIT 50";
	$query = dbquery($sql) or die ("Sorry we had a mysql error!");
	$num_rows = mysql_num_rows($query); 
	if ($num_rows < 1) {
		echo 'You have no Friend Requests at this time.';
	} else {
        while ($row = mysql_fetch_array($query)) { 
		    $requestID = $row["id"];
		    $mem1 = $row["mem1"];
	        $sqlName = dbquery("SELECT username FROM myMembers WHERE id='$mem1' LIMIT 1") or die ("Sorry we had a mysql error!");
		    while ($row = mysql_fetch_array($sqlName)) { $requesterUserName = $row["username"]; }
		    ///////  Mechanism to Display Pic. See if they have uploaded a pic or not  //////////////////////////
		    $check_pic = 'members/' . $mem1 . '/image01.jpg';
		    if (file_exists($check_pic)) {
				$lil_pic = '<a href="profile.php?id=' . $mem1 . '"><img src="' . $check_pic . '" width="50px" border="0"/></a>';
		    } else {
				$lil_pic = '<a href="profile.php?id=' . $mem1 . '"><img src="members/0/image01.jpg" width="50px" border="0"/></a>';
		    }
		    echo	'<hr />
<table width="100%" cellpadding="5"><tr><td width="17%" align="left"><div style="overflow:hidden; height:50px;"> ' . $lil_pic . '</div></td>
                        <td width="83%"><a href="profile.php?id=' . $mem1 . '">' . $requesterUserName . '</a> wants to be your Friend!<br /><br />
					    <span id="req' . $requestID . '">
					    <a href="#" onclick="return false" onmousedown="javascript:acceptFriendRequest(' . $requestID . ');" >Accept</a>
					    &nbsp; &nbsp; OR &nbsp; &nbsp;
					    <a href="#" onclick="return false" onmousedown="javascript:denyFriendRequest(' . $requestID . ');" >Deny</a>
					    </span></td>
                        </tr>
                       </table>';
        }	 
	}
    ?>
          </div>
		  <div class="grid_11"> 
<div id="container"> 
		<ul class="menu"> 
			<li id="ucomments"><?php echo $username; ?>'s Wall</li> 
			<li id="utweets">Activity & Likes</li> 
			<?php if (!empty($twitter)) { ?> <li id="videoresp">Twitter</li><?php } ?>
		</ul> 
				<span class="clear"></span> 
				<br />
		<div class="content ucomments"> 

            <?php echo $the_blab_form; ?>
          <br />
            <div style="width:100%; overflow-x:hidden;">
              <?php echo $blabberDisplayList; ?>
             
            </div>
			
			
			</div>
			
			<div class="content utweets"> 
	<div class="grid_10"> 	
		<div class="grid_4"> 
<?php echo'<a target="_blank" href="'.$site_url.'playlist.php?id='.$id.'"><h4>'.$username.'\'s Playlist</h4></a>'; ?>
<br />
<center><?php echo'<a class="large glowbutton pink" target="_blank" href="'.$site_url.'playlist.php?id='.$id.'">Play this playlist!</a>'; ?></center>
<br />
From the playlist:<br />
<?php 
$result = dbquery("SELECT * FROM playlists WHERE pid = '".$id."' ORDER BY RAND() LIMIT 0,5");
while($row = dbarray($result)){

echo '
<a href="'.$site_url.'video/'.$row['value'].'">'.$row['title'].'</a> <br />';

}

?>	
<br />

</div>

	<div class="grid_4"> 
<h4>Likes</h4>
</div>
</div>
<?php if (!empty($youtube)) { ?>

<h3><?php echo $username; ?>'s video uploads</h3>
<?php
 echo "
            	<table style=\"width: 100%; border: 0;\" cellspacing=\"0\" cellpadding=\"0\">
          ";
$user_url='http://gdata.youtube.com/feeds/api/users/'.$ytusername.'/uploads';
$feed=simplexml_load_file($user_url);

foreach($feed->entry as $video){

$vidid = str_replace("http://www.youtube.com/watch?v=", "",$video->link['href']);
$vidid = str_replace("&feature=youtube_gdata", "",$vidid);
$title = $video->title;
$thumbnail = 'http://i1.ytimg.com/vi/'.$vidid.'/default.jpg';
$description = substr($video->content, 0, 250);

			
			
  echo "
                 <tr>
				 <td width=\"121px\">
				 <a href=\"".Friendly_URL($vidid)."\" title=\"".$title."\">
                            <img src=\"http://i4.ytimg.com/vi/".$vidid."/default.jpg\" alt=\"".SpecialChars($title)."\" width=\"120\" height=\"90\"/>
                          
						  </a>
				 </td>
				 
				 <td width=\"121px\">
				 <a href=\"".Friendly_URL($vidid)."\" title=\"".$title."\">
                            <img src=\"http://i4.ytimg.com/vi/".$vidid."/3.jpg\" alt=\"".SpecialChars($title)."\" width=\"120\" height=\"90\"/>                        
						  </a>
				 </td>
				 <td width=\"25px\">
				 </td>
				 <td>
				 <a href=\"".Friendly_URL($vidid)."\" title=\"".$title."\"><strong>".$title."</strong> </a>
				 
<br /> ".substr($description,0,90)."  <br />		
<script src=\"http://connect.facebook.net/en_US/all.js#xfbml=1\"></script><fb:like href=\"".$site_url."video/".$vidid."\" layout=\"button_count\" width=\"150\"></fb:like>
	<hr>	  
				 </td>
				
</tr>				 
            ";
			
			
			
		}


?>
</table>
</div>
			<?php } ?>
	


			</div>
			
			
			
			
			<div class="content videoresp"> 
			<?php if (!empty($twitter)) { ?>
  <div class="grid_10">
<h4><?php echo $username; ?>'s Twitter</h4>

<!-- Required HTML -->

		<div class="twitter-friends" options="{

			debug:1

			,username:'<?php echo $twitter; ?>'

			,friends:1

			,tweet:1

			,header:'<a href=\'_tp_\' title=\'follow me\'><img src=\'_ti_\'/></a><h2>_fr_ Friends / _fo_ Followers</h2>'

			,loop:1

			,users:50

			,user_animate:'height'

		}"></div>

		<!-- Required HTML -->
<h4><?php echo $username; ?>'s latest tweets</h4>
	<div class='tweet'></div> 
	</div>


<?php } ?>
	
			</div>
</div>
</div>



 <div id="google_map">
<div align="right" style="padding:4px; background-color:#D2F0D3;"><a href="#" onclick="return false" onmousedown="javascript:toggleViewMap('google_map');">close map</a></div>
<iframe width="680" height="280" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=<?php echo "$city,+$state,+$country";?>&amp;ie=UTF8&amp;hq=&amp;hnear=<?php echo "$city,+$state,+$country";?>&amp;z=12&amp;output=embed"></iframe>
<div align="left" style="padding:4px; background-color:#D2F0D3;"><a href="#" onclick="return false" onmousedown="javascript:toggleViewMap('google_map');">close map</a></div>
    </div>
  
		  
	</div>
   <div class="grid_16">
   <hr>
   &copy; 2010 <?php echo $site_title;?>
   
   	</div>
   
</div>

</body>
</html>