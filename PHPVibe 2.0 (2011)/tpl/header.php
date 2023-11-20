<!doctype html>  
<html dir="ltr" lang="en-US">  
<meta http-equiv="content-type" content="text/html;charset=UTF-8">
<head>  
<meta charset="UTF-8">  
<title><?php if( !empty($seo_title)) { print $seo_title;} else { print $config->site->name;}; ?></title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<base href="<?php print $config->site->url; ?>" />  
<meta name="description" content="<?php if( !empty($seo_description)) { print $seo_description;} else { print $config->site->name;}; ?>">
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
<?php if(isset($content)) { ?>
<link rel="stylesheet" href="<?php print $config->site->url; ?>components/niceforms/niceforms-default.css" type="text/css"/>
<?php } ?>
<?php if($page == "video" || $page == "user" || $page == "videolist") { ?>
<link rel="stylesheet" href="<?php print $config->site->url; ?>tpl/css/comments.css" type="text/css"/>
<?php } ?>
<!-- RSS -->
<link rel="alternate" type="application/rss+xml" title="Minimal Desire RSS Feed" href="indexd784.html?feed=rss2"/>	
<!-- Header Js -->
<script type='text/javascript' src='http://code.jquery.com/jquery-1.6.4.min.js'></script>
<?php if(isset($content)) { ?>
<script language="javascript" type="text/javascript" src="<?php print $config->site->url; ?>components/niceforms/niceforms.js"></script>
<?php } ?>
<script type='text/javascript' src='<?php print $config->site->url; ?>tpl/js/l10na17a.js?ver=20101110'></script>
<script type='text/javascript' src='<?php print $config->site->url; ?>tpl/js/modernizr-2.0.6deae.js?ver=3.2.1'></script>
<script type='text/javascript' src='<?php print $config->site->url; ?>tpl/js/jquery.easing.1.3deae.js?ver=3.2.1'></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js"></script>
<?php if($page == "home" ) { ?>
<script type='text/javascript' src='<?php print $config->site->url; ?>tpl/js/contentslider.js'></script>
<?php } ?>
<?php if($page == "video" || $page == "user" || $page == "videolist") { ?>
<script type="text/javascript" src="<?php print $config->site->url; ?>js/comment.js"></script>
<?php } ?>

<script type='text/javascript' src='<?php print $config->site->url; ?>tpl/js/jquery.googleSuggest.js'></script>
<script type='text/javascript' src='<?php print $config->site->url; ?>components/lightbox/jquery.lightbox.js'></script>

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
	 
    $("#suggest-youtube").googleSuggest({service: "youtube"});
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
<!-- the mousewheel plugin -->
		<script type="text/javascript" src="<?php print $config->site->url; ?>tpl/js/jquery.mousewheel.js"></script>
		<?php if($page == "video") { ?>
		<!-- the jScrollPane script -->
		<script type="text/javascript" src="<?php print $config->site->url; ?>tpl/js/jquery.jscrollpane.min.js"></script>
		<script type="text/javascript" src="<?php print $config->site->url; ?>tpl/js/scroll-startstop.events.jquery.js"></script>
 <?php } ?>
  	
</head>  
<body>  
    
    <!-- Header -->
    <header id="main-header" class="whitex">
    	<div id="header-container">
    	<!-- Logo -->
    	<div id="logo"><a href="<?php print $config->site->url; ?>"><img src="<?php print $config->site->url; ?>tpl/images/light/logo.png" title="Minimal Desire" alt="Minimal Desire" /></a> 
    	</div>
		<div id="main-search">

<div class="searchform b w_530">
 <form action="" method="get" id="searchform" onsubmit="location.href='<?php print $config->site->url; ?>show/' + encodeURIComponent(this.tag.value).replace(/%20/g, '+'); return false;">

    <fieldset>

        <div id="searchbox">

            <input class="input" name="tag" type="text" id="suggest-youtube" value="to search, type and hit enter" onfocus="if (this.value == 'to search, type and hit enter') {this.value = '';}" onblur="if (this.value == '') {this.value = 'to search, type and hit enter';}">

		</div>

		<p class="gbutton">

            <input type="submit" name="search" value="Search">

		</p>

	</fieldset>

</form>	
</div>
</div>

</div>
<div class="user-screen">
<?php
if($user->isAuthorized())
	{
	$u_plink = $site_url.'user/'.$user->getId().'/'.seo_clean_url($user->getDisplayName()) .'/';
echo'
<div class="button-group">
<a href="'.$u_plink.'" class="button red icon man">'.$user->getName().'</a> 
<a href="edit-profile.php" class="button red icon preferences">Profile</a>'; ?>
<a href="logout.php" class="button blue icon eject">Eject</a>
</div>
	<?php } else {?>
<a href='<?php print $config->site->url; ?>login.php?platform=facebook'><img src="<?php print $config->site->url; ?>tpl/images/fblogin.png" alt="Connect with Fb" /></a>
<a href='<?php print $config->site->url; ?>login.php?platform=twitter'><img src="<?php print $config->site->url; ?>tpl/images/twlogin.png" alt="Connect with Twitter"/></a>
<?php } ?>
</div>
    	<div class="clear"></div>
 </header>
  <div class="clear"></div>