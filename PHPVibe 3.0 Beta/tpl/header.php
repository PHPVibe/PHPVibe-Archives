<!doctype html> 
<html prefix="og: http://ogp.me/ns#"> 
 <html dir="ltr" lang="en-US">  
<head>  
<meta http-equiv="content-type" content="text/html;charset=UTF-8">
<meta charset="UTF-8">  
<title><?php if( !empty($seo_title)) { echo $seo_title;} else { echo $config->site->name;}; ?></title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<base href="<?php echo $config->site->url; ?>" />  
<meta name="description" content="<?php if( !empty($seo_description)) { echo $seo_description;} else { echo $config->site->name;}; ?>">
<meta name="generator" content="<?php print $config->core->name; ?> v<?php print $config->core->version; ?> - Copyright phpVibe.com. All rights reserved." />
<meta name="author" content="phpVibe.com">
<?php if($page == "video") { ?>
 <!-- Start of Facebook Meta Tags  -->
<meta property="og:title" content="<?php echo $video_title;?>" />
<meta property="og:description" content="<?php echo $seo_description;?>" />
<meta property="og:url" content="<?php echo $canonical; ?>" />
<meta property="og:image" content="<?php echo $video_thumb; ?>" />
<link rel="image_src" href="<?php echo $video_thumb; ?>"/>
<!-- End of Facebook Meta Tags -->
<?php } ?>
<?php if(isset($canonical)) { ?>
<link rel="canonical" href="<?php echo $canonical; ?>" />
<?php } ?>
<!-- CSS -->
<link rel="stylesheet" type="text/css" href="<?php echo $config->site->url; ?>tpl/css/main.css" media="screen" />
<link id="preview-change-color" rel="stylesheet" type="text/css" href="<?php echo $config->site->url; ?>tpl/css/phpvibe.css" media="screen" />
<link rel="stylesheet" href="<?php echo $config->site->url; ?>components/lightbox/themes/default/jquery.lightbox.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $config->site->url; ?>tpl/css/formalize.css"/>
<!-- RSS -->
<link rel="alternate" type="application/rss+xml" title="phpVibe RSS Feed" href="<?php echo $config->site->url; ?>rss.php"/>	
<!-- Header Js -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js"></script>
<script type="text/javascript" src="<?php echo $config->site->url; ?>tpl/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="<?php echo $config->site->url; ?>com/comment.js"></script>
<script type='text/javascript' src='<?php echo $config->site->url; ?>components/lightbox/jquery.lightbox.min.js'></script>
<script type="text/javascript" src="<?php echo $config->site->url; ?>tpl/js/jquery.ae.image.resize.min.js"></script>
<?php if($page == "submit" || $page == "registration") { ?>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
 <script type="text/javascript" >
$(document).ready(function(){
    $(".form").validate();	
  });
  </script>
  <?php } ?>
  <?php if($page == "registration") { ?>
  <!-- CSS file -->
<link rel="stylesheet" type="text/css" href="<?php echo $config->site->url; ?>com/QapTcha.jquery.css" media="screen" />
<!-- jQuery files -->
<script type="text/javascript" src="<?php echo $config->site->url; ?>com/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo $config->site->url; ?>com/jquery.ui.touch.js"></script>
<script type="text/javascript" src="<?php echo $config->site->url; ?>com/QapTcha.jquery.js"></script>
 <script type="text/javascript" >
$(document).ready(function(){
	$('.QapTcha').QapTcha({
autoSubmit : true,
autoRevert : true,
PHPfile : 'com/Qaptcha.jquery.php'
});
  });
  </script>
    <?php } ?>
<?php if($page == "playlist" || $page == "myplay" ) { ?>
<script type="text/javascript" src="<?php echo $config->site->url; ?>com/jquery.form.js"></script>
 <script type="text/javascript" >
$(document).ready(function() {
		
            $('#photoimg').live('change', function(){ 
			$("#preview").html('');
			$("#preview").html('<img src="<?php echo $config->site->url; ?>com/loader.gif" alt="Uploading...."/>');
			$("#imageform").ajaxForm({ target: '#preview' }).submit();		
			});			
        }); 
		
</script>
<?php } ?>
<script type='text/javascript' src='<?php echo $config->site->url; ?>tpl/js/l10na17a.js?ver=20101110'></script>
<script type='text/javascript' src='<?php echo $config->site->url; ?>tpl/js/modernizr-2.0.6deae.js?ver=3.2.1'></script>
<!--[if IE]>
<script src="<?php echo $config->site->url; ?>tpl/js/html5.js"></script>
<![endif]-->

<?php //echo custom styles or codes added from admin (if any)
if(!empty($config->site->headerc)) {echo html_back($config->site->headerc); } ?>
</head>  
<body>  

  <!-- Header -->
    <header id="main-header">
    <div id="header-container">
    	<div id="logo"><a href="<?php echo $config->site->url; ?>"><img src="<?php echo $config->site->url; ?>tpl/images/logo.png" title="<?php echo $config->site->name; ?>" alt="<?php echo $config->site->name; ?>" /></a> </div>
    

	   <?php if($user->isAuthorized()) {  	$u_plink = $site_url.'user/'.$user->getId().'/'.seo_clean_url($user->getDisplayName()) .'/'; 	?>
        <div class="vibedropbox">
        	<a href="<?php echo $u_plink;?>" class="display">
            	<img src="<?php echo $site_url.'com/timthumb.php?src='.$user->getAvatar(); ?>&h=26&w=26&m=crop" width="26" height="26" alt="Profile"/>	<b>Logged in as</b>	<span><?php echo $user->getDisplayName();?></span>
            </a>
            
            <div class="vibedropmenu">
            	<ul>
				    <li><a href="<?php echo $config->site->url; ?>videos-by/<?php echo $user->getId();?>" title="">My Videos</a></li>  
                    <li><a href="<?php echo $config->site->url; ?>likes/<?php echo $user->getId();?>" title="">My Likes</a></li>
                    <li><a href="<?php echo $config->site->url; ?>myplay/" title="">Manage playlists</a></li>    
                    <li><a href="<?php echo $config->site->url; ?>myplay/&create=1" title="">Create playlist</a></li>     
				    <li><a href="<?php echo $u_plink;?>" title=""><?php echo $lang['my-profile']; ?></a></li> 					
					<li><a href="<?php echo $config->site->url; ?>messages.php?folder=inbox" title=""><?php echo $lang['inbox']; ?></a></li>
					<li><a href="<?php echo $config->site->url; ?>edit-profile.php"><?php echo $lang['edit-profile']; ?></a></li>       
					<?php echo $user->getType() === MK_RecordUser::TYPE_CORE ? '<li><a href="'.$config->site->url.'change-password.php">Change Password</a></li>' : '' ?>
                    <li><a href="<?php echo $config->site->url; ?>logout.php" title="">Logout</a></li>

                </ul>
            </div>
            
        </div>
        <?php } else { ?>
        <div class="vibedropbox">
        	<a href="<?php echo $u_plink;?>" class="display">
            	<img src="<?php echo $config->site->url; ?>tpl/images/guest.png" width="26" height="26" alt="Profile"/>	<b>Hello there! </b>	<span>Guest options</span>
            </a>            
            <div class="vibedropmenu">
            	<ul>
                	<li><a href="<?php echo $config->site->url; ?>login.php"><?php echo $lang['login']; ?></a></li>
					<li><a href="<?php echo $config->site->url; ?>register.php"><?php echo $lang['register']; ?></a></li>

                </ul>
            </div>
            
        </div>

       <?php } ?>
	  
		<div class="searchWidget">
            <form action="" method="get" id="searchform" onsubmit="location.href='<?php echo $config->site->url; ?>show/' + encodeURIComponent(this.tag.value).replace(/%20/g, '+'); return false;">
                <input type="text" name="tag" id="suggest-youtube" value="<?php echo $lang['search-desc']; ?>" onfocus="if (this.value == '<?php echo $lang['search-desc']; ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php echo $lang['search-desc']; ?>';}" />
                 <input type="submit" name="find" value="" />
            </form>
        </div>
 

    </div>
	<div class="bottom-gradient"></div>	
    </header>


  <section id="wrapper">