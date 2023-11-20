<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php if($page == "video") { ?>
<title><?php echo  $lang['video'];?> : <?php echo $youtube['title'];?></title>
<?php } elseif($page == "videos") { ?>
<title><?php echo  $lang[$feed]; ?> <?php if(!empty($_GET["time"])) : echo  $lang[$_GET["time"]]; endif; ?></title>
<?php } elseif($page == "album") { ?>
<title><?php echo  $title; ?></title>
<?php } else { ?>
<title><?php echo $seo_title; ?></title>
<?php } ?>
<meta name="viewport" content="width=device-width,initial-scale=1" />
<meta name="generator" content="phpVibe Mobile 1.0" />
<meta name="description" content="<?php echo $seo_description; ?>">
<link rel="stylesheet" type="text/css" href="<?php echo $site_url;?>style/reset.css" /> 
<link rel="stylesheet" type="text/css" href="<?php echo $site_url;?>style/main.css" /> 
<link rel="stylesheet" type="text/css" href="<?php echo $site_url;?>style/photoswipe.css" /> 
<script type="text/javascript" src="<?php echo $site_url;?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $site_url;?>js/toogle.js"></script>
<script type="text/javascript" src="<?php echo $site_url;?>js/klass.min.js"></script>
<script type="text/javascript" src="<?php echo $site_url;?>js/code.photoswipe-3.0.4.min.js"></script>    
</head>
<body>
    <!-- start header -->
<div id="header">
         <a href="<?php echo $site_url;?>"><img src="<?php echo $site_url;?>img/logo.png" width="77" height="24" alt="logo" class="logo" /></a>
        <?php if($page != "home") { ?> <a href="<?php echo $site_url;?>" class="button back"><img src="<?php echo $site_url;?>img/home_white.png" width="17" height="16" alt="icon" /></a><?php } ?>
         <a href="#" class="button search"><img src="<?php echo $site_url;?>img/btn_search.png" width="15" height="16" alt="icon"/></a>
        <div class="clear"></div>
</div>
    <!-- end header -->
    
 <!-- start searchbox -->
<div id="navigation-search">	 
	 <form action="<?php echo $site_url;?>search.php" method="get" id="search_form">
     <div class="field">  <input type="text" name="s" id="s" title="<?php echo  $lang['search']; ?>" value="<?php echo  $lang['search']; ?>" onfocus="if (this.value == '<?php echo  $lang['search']; ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php echo  $lang['search']; ?>';}" /></div>
     <div class="button_search">   <input type="submit" class="button" value="Search" /> </div>
     <div class="clear"></div>
     </form>

	  <div class="clear"></div>			
 </div>
    <!-- end searchbox -->