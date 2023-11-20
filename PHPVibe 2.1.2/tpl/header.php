<!doctype html> 
<html prefix="og: http://ogp.me/ns#"> 
 <html dir="ltr" lang="en-US">  
<head>  
<meta http-equiv="content-type" content="text/html;charset=UTF-8">
<meta charset="UTF-8">  
<title><?php if( !empty($seo_title)) { print $seo_title;} else { print $config->site->name;}; ?></title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<base href="<?php print $config->site->url; ?>" />  
<meta name="description" content="<?php if( !empty($seo_description)) { print $seo_description;} else { print $config->site->name;}; ?>">
<?php if($page == "video") { ?>
 <!-- Start of Facebook Meta Tags  -->
    <meta name="medium" content="video" />
	<meta property="og:title" content="<?php echo $video_title;?>" />
	<meta property="og:description" content="<?php echo $seo_description;?>" />
    <meta property="og:url" content="<?php echo $canonical; ?>" />
	<meta property="og:image" content="http://i2.ytimg.com/vi/<?php echo $video_id; ?>/0.jpg" />
	<meta property="og:video" content="<?php echo $site_url;?>components/player/player.swf?file=http://www.youtube.com/watch?v=<?php echo $video_id; ?>&autostart=true&logo.file=<?php echo $site_url;?>components/player/playerlogo.png&logo.link=<?php echo $canonical; ?>&logo.hide=false&logo.position=bottom-left&skin=<?php print $config->site->url; ?>components/player/stormtrooper.zip&stretching=fill" />
    <meta property="og:video:type" content="application/x-shockwave-flash" />    
    <meta property="og:video:height" content="340" />
    <meta property="og:video:width" content="385" />
<!-- End of Facebook Meta Tags -->
<?php } ?>
<?php if(isset($canonical)) { ?>
<link rel="canonical" href="<?php echo $canonical; ?>" />
<?php } ?>
<?php if($page == "video") { ?>
<link rel="image_src" href="http://i2.ytimg.com/vi/<?php echo $video_id; ?>/0.jpg"/>
<link rel="video_src" href="<?php echo $site_url;?>components/player/player.swf?file=http://www.youtube.com/watch?v=<?php echo $video_id; ?>&autostart=true&logo.file=<?php echo $site_url;?>components/player/playerlogo.png&logo.link=<?php echo $canonical; ?>&logo.hide=false&logo.position=bottom-left&skin=<?php print $config->site->url; ?>components/player/stormtrooper.zip&stretching=fill" />
<?php } ?>

<!-- CSS -->
<link rel="stylesheet" type="text/css" href="<?php print $config->site->url; ?>tpl/css/main.css" media="screen" />
<link id="preview-change-color" rel="stylesheet" type="text/css" href="<?php print $config->site->url; ?>tpl/css/phpvibe.css" media="screen" />
<link rel="stylesheet" href="<?php print $config->site->url; ?>components/lightbox/themes/default/jquery.lightbox.css"/>
<link rel="stylesheet" href="<?php print $config->site->url; ?>tpl/css/buttons.css" type="text/css"/>
<link rel="stylesheet" href="<?php print $config->site->url; ?>components/sherpa/styles/960_fluid.css" />
<link rel="stylesheet" href="<?php print $config->site->url; ?>components/sherpa/styles/main.css" />
<link rel="stylesheet" href="<?php print $config->site->url; ?>components/sherpa/styles/bar_nav.css" />
<link rel="stylesheet" href="<?php print $config->site->url; ?>components/sherpa/styles/skins/theme_red.css" />
<?php if($page == "video" || $page == "user" || $page == "videolist" || $page == "playlist") { ?>
<link rel="stylesheet" href="<?php print $config->site->url; ?>tpl/css/comments.css" type="text/css"/>
<?php } ?>
<!-- RSS -->
<link rel="alternate" type="application/rss+xml" title="phpVibe RSS Feed" href="<?php print $config->site->url; ?>rss.php"/>	
<!-- Header Js -->
<?php if($page == "home" ) { ?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
<script type="text/javascript" src="<?php print $config->site->url; ?>tpl/js/jquery.eislideshow.js"></script>
<script type="text/javascript" src="<?php print $config->site->url; ?>tpl/js/jquery.easing.1.3.js"></script>
<script type="text/javascript">
           jQuery(function() {
                $('#ei-slider').eislideshow({
					animation			: 'center',
					autoplay			: true,
					slideshow_interval	: 5000,
					titlesFactor		: 0
                });				
				
            });
  
	</script>
<?php } else { ?>
<script type='text/javascript' src='http://code.jquery.com/jquery-1.6.4.min.js'></script>
<script type="text/javascript" src="<?php print $config->site->url; ?>tpl/js/jquery.easing.1.3.js"></script>

<?php } ?>
<?php if($page == "video" || $page == "playlist") { ?>
<script type="text/javascript" src="<?php print $config->site->url; ?>com/jquery.form.js"></script>
<?php } ?>
<?php if($page == "video") { ?>
 <script type="text/javascript" >
$(document).ready(function() {
		
            $('#playlistform').live('change', function()			{ 
			           $("#preview").html('');
			    $("#preview").html('<img src="<?php print $config->site->url; ?>com/loader.gif" alt="Uploading...."/>');
			$("#playlistform").ajaxForm({
						target: '#preview'
		}).submit();
		
			});
			
        }); 
		
</script>
<?php } ?>
<?php if($page == "playlist") { ?>
 <script type="text/javascript" >
$(document).ready(function() {
		
            $('#photoimg').live('change', function()			{ 
			           $("#preview").html('');
			    $("#preview").html('<img src="<?php print $config->site->url; ?>com/loader.gif" alt="Uploading...."/>');
			$("#imageform").ajaxForm({
						target: '#preview'
		}).submit();
		
			});
			
        }); 
		
</script>
<?php } ?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php print $config->site->url; ?>tpl/js/hoverIntent.js"></script>
<script type='text/javascript' src='<?php print $config->site->url; ?>tpl/js/jquery.googleSuggest.js'></script>
<script type='text/javascript' src='<?php print $config->site->url; ?>tpl/js/l10na17a.js?ver=20101110'></script>
<script type='text/javascript' src='<?php print $config->site->url; ?>tpl/js/modernizr-2.0.6deae.js?ver=3.2.1'></script>
<!--[if IE]>
<script src="<?php print $config->site->url; ?>tpl/js/html5.js"></script>
<![endif]-->
<?php if($page == "video" || $page == "user" || $page == "videolist" || $page == "playlist") { ?>
<script type="text/javascript" src="<?php print $config->site->url; ?>com/comment.js"></script>
<?php } ?>

<script type='text/javascript' src='<?php print $config->site->url; ?>components/lightbox/jquery.lightbox.js'></script>

<?php 
//print custom styles or codes added from admin (if any)
if(!empty($config->site->headerc)) {print html_back($config->site->headerc); }
?>
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
            <div class="welcome"><a href="<?php echo $u_plink;?>" title=""><img src="<?php echo $site_url.'com/timthumb.php?src='.$user->getAvatar(); ?>&h=20&w=22&m=crop" alt="" /></a><span>Howdy, <?php echo $user->getDisplayName();?>!</span></div>
            <div class="userNav">
                <ul>
                    <li><a href="<?php echo $u_plink;?>" title=""><img src="<?php print $config->site->url; ?>tpl/images/icons/profile.png" alt="" /><span><?php print $lang['my-profile']; ?></span></a></li>
                    <li><a href="<?php echo $u_plink;?>&sk=likes&page=1" title=""><img src="<?php print $config->site->url; ?>tpl/images/icons/tasks.png" alt="" /><span><?php print $lang['my-likes']; ?></span></a></li>
                    <li class="dd"><img src="<?php print $config->site->url; ?>tpl/images/icons/messages.png" alt="" /><span><?php print $lang['messages']; ?></span><span class="numberTop"><?php echo $user_messages_drafts_total;?></span>
                        <ul class="menu_body">
                            <li><a href="<?php print $config->site->url; ?>messages.php?folder=inbox" title=""><?php print $lang['inbox']; ?></a></li>
                            <li><a href="<?php print $config->site->url; ?>messages.php?folder=sent" title=""><?php print $lang['outbox']; ?></a></li>
                            <li><a href="<?php print $config->site->url; ?>messages.php?folder=drafts" title=""><?php print $lang['drafts']; ?></a></li>
                        </ul>
                    </li>
                    <li><a href="<?php print $config->site->url; ?>edit-profile.php" title=""><img src="<?php print $config->site->url; ?>tpl/images/icons/settings.png" alt="" /><span><?php print $lang['edit-profile']; ?></span></a></li>
                    <?php print $user->getType() === MK_RecordUser::TYPE_CORE ? '<li><a href="'.$config->site->url.'change-password.php"><img src="'.$config->site->url.'tpl/images/icons/register.png" alt="" /><span>Change Password</a></span></li>' : '' ?>
					<li><a href="<?php print $config->site->url; ?>logout.php" title=""><img src="<?php print $config->site->url; ?>tpl/images/icons/logout.png" alt="" /><span>Logout</span></a></li>
                </ul>
            </div>
            <div class="fix"></div>
        </div>
    </div>
</div>   
<?php } ?>

    <!-- Header -->
    <header id="main-header" class="whitex clearfix">
    	<div id="header-container">
    	<!-- Logo -->
    	<div id="logo"><a href="<?php print $config->site->url; ?>"><img src="<?php print $config->site->url; ?>tpl/images/light/logo.png" title="<?php print $config->site->name; ?>" alt="<?php print $config->site->name; ?>" /></a> 
    	</div>
		<div id="main-search">

 <div class="searchWidget">
                	<form action="" method="get" id="searchform" onsubmit="location.href='<?php print $config->site->url; ?>show/' + encodeURIComponent(this.tag.value).replace(/%20/g, '+'); return false;">
                    	<input type="text" name="tag" id="suggest-youtube" value="<?php print $lang['search-desc']; ?>" onfocus="if (this.value == '<?php print $lang['search-desc']; ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php print $lang['search-desc']; ?>';}" />
                        <input type="submit" name="find" value="" />
                    </form>
                </div>
</div>
<div id="header-login">

<?php
if(!$user->isAuthorized())
	{ ?>
<a class="get-in" href='<?php print $config->site->url; ?>login.php'><img src="<?php print $config->site->url; ?>tpl/images/light/t-button.png"/></a>
<a class="get-in" href='<?php print $config->site->url; ?>login.php'><img src="<?php print $config->site->url; ?>tpl/images/light/fb-button.png"/></a>


<?php } else { ?>
<div class="button-group" style="margin-top:9px!important;">
<a href="<?php print $config->site->url; ?>create-playlist.php" class="button red big on icon fire">New playlist</a>
<a href="<?php print $config->site->url; ?>manage-playlists.php" class="button red big icon folder">Manage playlists</a>
</div>
<?php }  ?>
	
	</div>	
</div>
 </header>
 <div class="clear"></div>