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
<meta name="generator" content="<?php print $config->core->name; ?> v<?php print $config->core->version; ?> ." />
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
<link id="icons" rel="stylesheet" type="text/css" href="<?php echo $config->site->url; ?>tpl/css/icon.css" media="screen" />
<link id="iconsandbuttons" rel="stylesheet" type="text/css" href="<?php echo $config->site->url; ?>tpl/css/css3-buttons.css" media="screen" />

<!-- CSS Media Queries for Standard Devices -->
    <!--[if !IE]><!-->
        <link rel="stylesheet" href="<?php echo $config->site->url; ?>tpl/css/ipad.css" media="only screen and (min-width : 768px) and (max-width : 1024px)"> 
    <!--<![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
  <link rel="stylesheet" href="<?php echo $config->site->url; ?>tpl/css/slide.css" type="text/css" media="screen">
<!--<![endif]-->
<link rel="stylesheet" href="<?php echo $config->site->url; ?>components/lightbox/themes/default/jquery.lightbox.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $config->site->url; ?>tpl/css/icons.css"/>
<!-- RSS -->
<link rel="alternate" type="application/rss+xml" title="phpVibe RSS Feed" href="<?php echo $config->site->url; ?>rss.php"/>	
<!-- Header Js -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js"></script>
<script type="text/javascript" src="<?php echo $config->site->url; ?>tpl/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="<?php echo $config->site->url; ?>tpl/js/jquery.uniform.js"></script>
<script type="text/javascript" src="<?php echo $config->site->url; ?>tpl/js/jquery.tagsinput.min.js"></script>
<script type="text/javascript" src="<?php echo $config->site->url; ?>tpl/js/jquery.cookie.js"></script>
<script type="text/javascript" src="<?php echo $config->site->url; ?>com/comment.js"></script>
<script type="text/javascript" src="<?php echo $config->site->url; ?>com/maxupload.js"></script>
<script type='text/javascript' src='<?php echo $config->site->url; ?>components/lightbox/jquery.lightbox.min.js'></script>
<script type="text/javascript" src="<?php echo $config->site->url; ?>tpl/js/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="<?php echo $config->site->url; ?>tpl/js/jquery.validationEngine.js"></script>
<script type="text/javascript" src="<?php echo $config->site->url; ?>com/jquery.form.js"></script>
<script type="text/javascript" src="<?php echo $config->site->url; ?>tpl/js/jcarousel.min.js"></script>
<script type="text/javascript" src="<?php echo $config->site->url; ?>tpl/js/jquery.lazyload.min.js"></script>
 <?php if($page == "upload" && $config->video->allowupload) { 
 $myvids = dbcount("*","videos_tmp","uid = '".$user->getId()."'");
 if ($myvids < $config->video->maxlibrary) {
 ?>
 <script type="text/javascript" >
$(document).ready(function(){
	$('#dumpvideo').MaxUpload({
		maxFileSize:<?php echo $config->video->size; ?>,
		maxFileCount: <?php echo $config->video->maxuploads; ?>,
		allowedExtensions:['.flv','.mp4','.mp3'],
        onComplete: function () {  $(window.location).attr('href', '<?php echo $config->site->url; ?>manage/'); },
		onError: function () { alert('Upload Error'); }		
	});
  });
  </script>
  <?php } } ?>
   <?php if($page == "wall") { ?>
 <script type="text/javascript" >
$(document).ready(function(){
	$('.picsShare').MaxUpload({
		maxFileSize:314572800,
		maxFileCount: 10,
		target:'upload-image.php',
		allowedExtensions:['.jpg','.png','.gif'],
		 onComplete: function () {  $(window.location).attr('href', '<?php echo $config->site->url; ?>wall/'); },
        onError: function () { alert('Upload Error'); }		
	});
  });
  </script>
  <?php } ?>


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
		<div class="iconBox"> <a href="<?php echo $config->site->url; ?>members/" title="People">  <div class="fs1 iconb" data-icon="&#xe1e1;"></div> </a></div>
	<?php if( $user->isAuthorized() && $user->getGroup()->getAccessLevel() >= $config->video->submit) { ?>
	<div class="iconBox"> <a href="<?php echo $config->site->url; ?>upload/" title="Video Upload"><div class="fs1 iconb" data-icon="&#xe263;"></div> </a></div>
<?php } ?>

		<div class="hide-mobile">
            <form action="" method="get" id="searchform" onsubmit="location.href='<?php echo $config->site->url; ?>show/' + encodeURIComponent(this.tag.value).replace(/%20/g, '+'); return false;">
                <input type="text" name="tag" id="suggest-youtube" value="<?php echo $lang['search-desc']; ?>" onfocus="if (this.value == '<?php echo $lang['search-desc']; ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php echo $lang['search-desc']; ?>';}" />
                 <input type="submit" name="find" value="" />
            </form>
        </div>
 

    </div>
    </header>
<ul id="mainmenu" class="menu blackmenu slide">
<li><a href="<?php echo $config->site->url; ?>videos/browse/" title="Videos">  <?php echo $lang['videos']; ?> </a>	</li>
		
			<li><a href="<?php echo $config->site->url; ?>videos/most-viewed/"><?php echo $lang['most-viewed']; ?></a></li>
			<li><a href="<?php echo $config->site->url; ?>videos/most-liked/"><?php echo $lang['most-liked']; ?></a></li> 	
			<li><a href="<?php echo $config->site->url; ?>videos/featured/"><?php echo $lang['featured']; ?></a></li> 	
			<li> <a href="<?php echo $config->site->url; ?>playlists/"><?php echo $lang['playlists']; ?></a></li>
			
	<?php if($user->isAuthorized()) 	{ ?>	
	<li><a href="<?php echo $config->site->url; ?>messages.php?folder=inbox"><?php echo $lang['inbox']; ?></a></li>
	<?php } ?>	
	<li><a href="<?php echo $config->site->url; ?>wall/"><?php echo $lang['timeline']; ?></a></li>
<?php if($user->isAuthorized()) 	{ ?>	
	<li class="floatr"><a href="<?php echo $site_url.'user/'.$user->getId().'/'.seo_clean_url($user->getDisplayName()).'/'; ?>"><?php echo $lang['my-profile']; ?></a>
		<!-- start mega menu -->
		<div class="cols2" id="styles">
			<div class="col2"><h4>Pick a section</h4></div>
			<div class="col1">
				<h5>Videos</h5>
				<ol>
				    <li><a href="<?php echo $config->site->url; ?>myplay/"><?php echo $lang['myplaylists']; ?></a></li>
					<li><a href="<?php echo $config->site->url; ?>myplay/&create=1"><?php echo $lang['doplaylist']; ?></a></li>
					<li><a href="<?php echo $config->site->url; ?>manage/"><?php echo $lang['pendingmedia']; ?></a></li>
					
				</ol>
			</div>
			<div class="col1">
				<h5>Account</h5>
				<ol>
				    <li><a href="<?php echo $config->site->url; ?>edit-profile.php"><?php echo $lang['edit-profile']; ?></a></li>
					  <?php print $user->getType() === MK_RecordUser::TYPE_CORE ? '<li><a href="'.$config->site->url.'change-password.php">Password</a></li>' : '' ?>
					<li><a href="<?php print $config->site->url; ?>logout.php" title="">Logout</a></li>

				</ol>
			</div>
		
		</div>
		<!-- end mega menu -->
	</li>
	<?php } else	{ ?>	
	<li class="floatr"><a href="<?php echo $config->site->url; ?>login.php"><?php echo $lang['login']; ?></a>	</li>
	<?php } ?>	
	
		
</ul>

  <section id="wrapper" >