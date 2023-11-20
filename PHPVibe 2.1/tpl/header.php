<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:og="http://ogp.me/ns#"
      xmlns:fb="http://www.facebook.com/2008/fbml">
<html dir="ltr" lang="en-US">  
<meta http-equiv="content-type" content="text/html;charset=UTF-8">
<head>  
<meta charset="UTF-8">  
<title><?php if( !empty($seo_title)) { print $seo_title;} else { print $config->site->name;}; ?></title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<base href="<?php print $config->site->url; ?>" />  
<meta name="description" content="<?php if( !empty($seo_description)) { print $seo_description;} else { print $config->site->name;}; ?>">
<?php if($page == "video") { ?>
 <!-- Start of Facebook Meta Tags  -->
    <meta name="medium" content="video" />
	<meta property="og:title" content="<?php echo $video_title;?>" />
	<meta property="og:description" content="<?php echo $video_description;?>" />
    <meta property="og:url" content="<?php echo $canonical; ?>" />
	<meta property="og:image" content="http://i2.ytimg.com/vi/<?php echo $video_id; ?>/0.jpg" />
	<meta property="og:video" content="<?php echo $site_url;?>components/player/player.swf?file=http://www.youtube.com/watch?v=<?php echo $video_id; ?>&autostart=true&logo.file=<?php echo $site_url;?>components/player/playerlogo.png&logo.link=<?php echo $canonical; ?>&logo.hide=false&logo.position=bottom-left&stretching=fill" />
    <meta property="og:video:type" content="application/x-shockwave-flash" />    
    <meta property="og:video:height" content="640" />
    <meta property="og:video:width" content="385" />
<!-- End of Facebook Meta Tags -->
<?php } ?>
<?php if(isset($canonical)) { ?>
<link rel="canonical" href="<?php echo $canonical; ?>" />
<?php } ?>
<?php if($page == "video") { ?>
<link rel="image_src" href="http://i2.ytimg.com/vi/<?php echo $video_id; ?>/0.jpg"/>
<link rel="video_src" href="<?php echo $site_url;?>components/player/player.swf?file=http://www.youtube.com/watch?v=<?php echo $video_id; ?>&autostart=true&logo.file=<?php echo $site_url;?>components/player/playerlogo.png&logo.link=<?php echo $canonical; ?>&logo.hide=false&logo.position=bottom-left&stretching=fill" />
<?php } ?>
<SCRIPT>
function clearDefault(el) {
if (el.defaultValue==el.value) el.value = ""
}
</SCRIPT>

<!-- CSS -->
<link rel="stylesheet" type="text/css" href="<?php print $config->site->url; ?>tpl/css/main.css" media="screen" />
<link id="preview-change-color" rel="stylesheet" type="text/css" href="<?php print $config->site->url; ?>tpl/css/phpvibe.css" media="screen" />
<link rel="stylesheet" href="<?php print $config->site->url; ?>components/lightbox/themes/default/jquery.lightbox.css"/>
<link rel="stylesheet" href="<?php print $config->site->url; ?>tpl/css/buttons.css" type="text/css"/>
<link rel="stylesheet" href="<?php print $config->site->url; ?>components/sherpa/styles/960_fluid.css" />
<link rel="stylesheet" href="<?php print $config->site->url; ?>components/sherpa/styles/main.css" />
<link rel="stylesheet" href="<?php print $config->site->url; ?>components/sherpa/styles/bar_nav.css" />

<?php if(isset($content)) { ?>
<link rel="stylesheet" href="<?php print $config->site->url; ?>components/niceforms/niceforms-default.css" type="text/css"/>
<?php } ?>
<?php if($page == "video" || $page == "user" || $page == "videolist") { ?>
<link rel="stylesheet" href="<?php print $config->site->url; ?>tpl/css/comments.css" type="text/css"/>
<?php } ?>
<!-- RSS -->
<link rel="alternate" type="application/rss+xml" title="phpVibe RSS Feed" href=""/>	
<!-- Header Js -->
<script type='text/javascript' src='http://code.jquery.com/jquery-1.6.4.min.js'></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js"></script>
<script type='text/javascript' src='<?php print $config->site->url; ?>tpl/js/jquery.googleSuggest.js'></script>
<?php if(isset($content)) { ?>
<script language="javascript" type="text/javascript" src="<?php print $config->site->url; ?>components/niceforms/niceforms.js"></script>
<?php } ?>
<script type='text/javascript' src='<?php print $config->site->url; ?>tpl/js/l10na17a.js?ver=20101110'></script>
<script type='text/javascript' src='<?php print $config->site->url; ?>tpl/js/modernizr-2.0.6deae.js?ver=3.2.1'></script>
<script type='text/javascript' src='<?php print $config->site->url; ?>tpl/js/jquery.easing.1.3deae.js?ver=3.2.1'></script>

<script type="text/javascript" src="<?php print $config->site->url; ?>tpl/js/jquery.leanmodal.min.js"></script>
<?php if($page == "home" ) { ?>
<script type='text/javascript' src='<?php print $config->site->url; ?>tpl/js/contentslider.js'></script>
<?php } ?>
<?php if($page == "video" || $page == "user" || $page == "videolist") { ?>
<script type="text/javascript" src="<?php print $config->site->url; ?>js/comment.js"></script>
<?php } ?>

<script type='text/javascript' src='<?php print $config->site->url; ?>components/lightbox/jquery.lightbox.js'></script>
 <!-- the mousewheel plugin -->
<script type="text/javascript" src="<?php print $config->site->url; ?>tpl/js/jquery.mousewheel.js"></script>
<?php if($page == "video") { ?>
<!-- the jScrollPane script -->
<script type="text/javascript" src="<?php print $config->site->url; ?>tpl/js/jquery.jscrollpane.min.js"></script>
<script type="text/javascript" src="<?php print $config->site->url; ?>tpl/js/scroll-startstop.events.jquery.js"></script>
 <?php } ?>
<?php if($page == "video") { ?>
<script type="text/javascript">
jQuery(document).ready(function(){	
	$('#like').click(function(){
		var b = "<?php echo $video_id;?>";
		var dataString = 'val=' + b;
		$.post("components/voting.php?"+ dataString, {
		}, function(response){
			$('#voting_result').fadeIn();
			$('#voting_result').html($(response).fadeIn('slow').delay(2500).fadeOut());
});
	});	
});	
</script>
<?php } ?>
<script type="text/javascript">
  jQuery(document).ready(function($){
     $("#suggest-youtube").googleSuggest({service: "news"});
	$("a[rel*=leanModal]").leanModal();
	$('#embed').lightbox();
	$('#reqfriend').lightbox();
	$('.lightbox').lightbox();
    $('.repeat,#repeat').live('click', function(ev) {
    var video = $(this).attr('href');
    $.lightbox('<?php print $config->site->url; ?>components/player/player.swf', {
	    width: 640,
        height: 360,		
        force: 'flash',	
        flashvars: 'file='+video+'&autostart=true&repeat=always&logo.file=<?php print $config->site->url; ?>components/player/playerlogo.png&logo.link=<?php print $config->site->url; ?>&logo.hide=false&logo.position=bottom-left&stretching=fill'
      });
      
      ev.preventDefault();
    
    });
  });
  </script>

  <?php if(($page == "user" ) && ($user_profile->getId() == $user->getId())) { ?>
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

  url: "components/update_status.php",

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

  url: "components/delete_update.php",

   data: dataString,

  cache: false,

  success: function(html){
    alert("Done! Your status has been deleted!");
 
  }
 });
}
});
});
</script>
<?php } ?>
       
  	
</head>  
<body>  
<?php
if($user->isAuthorized())
	{ 
	$u_plink = $site_url.'user/'.$user->getId().'/'.seo_clean_url($user->getDisplayName()) .'/';
	
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
	?>
 <div id="topNav">
    <div class="fixed">
        <div class="wrapper">
            <div class="welcome"><a href="<?php echo $u_plink;?>" title=""><img src="<?php echo $site_url.'components/thumb.php?f='.$user->getAvatar(); ?>&h=20&w=22&m=crop" alt="" /></a><span>Howdy, <?php echo $user->getDisplayName();?>!</span></div>
            <div class="userNav">
                <ul>
                    <li><a href="<?php echo $u_plink;?>" title=""><img src="<?php print $config->site->url; ?>tpl/images/icons/profile.png" alt="" /><span>Profile</span></a></li>
                    <li><a href="<?php echo $u_plink;?>&sk=likes&page=1" title=""><img src="<?php print $config->site->url; ?>tpl/images/icons/tasks.png" alt="" /><span>My likes</span></a></li>
                    <li class="dd"><img src="<?php print $config->site->url; ?>tpl/images/icons/messages.png" alt="" /><span>Messages</span><span class="numberTop"><?php echo $user_messages_drafts_total;?></span>
                        <ul class="menu_body">
                            <li><a href="<?php print $config->site->url; ?>messages.php?folder=inbox" title="">inbox</a></li>
                            <li><a href="<?php print $config->site->url; ?>messages.php?folder=sent" title="">outbox</a></li>
                            <li><a href="<?php print $config->site->url; ?>messages.php?folder=drafts" title="">drafts</a></li>
                        </ul>
                    </li>
                    <li><a href="<?php print $config->site->url; ?>edit-profile.php" title=""><img src="<?php print $config->site->url; ?>tpl/images/icons/settings.png" alt="" /><span>Edit Profile</span></a></li>
                    <li><a href="<?php print $config->site->url; ?>logout.php" title=""><img src="<?php print $config->site->url; ?>tpl/images/icons/logout.png" alt="" /><span>Logout</span></a></li>
                </ul>
            </div>
            <div class="fix"></div>
        </div>
    </div>
</div>   
<?php } ?>
    <!-- Header -->
    <header id="main-header" class="whitex">
    	<div id="header-container">
    	<!-- Logo -->
    	<div id="logo"><a href="<?php print $config->site->url; ?>"><img src="<?php print $config->site->url; ?>tpl/images/light/logo.png" title="Minimal Desire" alt="Minimal Desire" /></a> 
    	</div>
		<div id="main-search">

 <div class="searchWidget">
                	<form action="" method="get" id="searchform" onsubmit="location.href='<?php print $config->site->url; ?>show/' + encodeURIComponent(this.tag.value).replace(/%20/g, '+'); return false;">
                    	<input type="text" name="tag" id="suggest-youtube" value="to search videos, type and hit enter" onfocus="if (this.value == 'to search videos, type and hit enter') {this.value = '';}" onblur="if (this.value == '') {this.value = 'to search videos, type and hit enter';}" />
                        <input type="submit" name="find" value="" />
                    </form>
                </div>
</div>
<?php
if(!$user->isAuthorized())
	{ ?>
<div id="head-bar-container">
<a href='#loginup' rel="leanModal">Login</a>
<a href='#signup' rel="leanModal">Register</a>

</div>
<?php } ?>
</div>
<div class="clear"></div>
 </header>
  <div class="clear"></div>