<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $site_title." - ".$site_slogan; ?></title>
<meta name="keywords" content="<?php echo $site_keywords?>">
<meta name="description" content="<?php echo $site_description?>">
<base href="<?=$site_url?>" />		
<!-- Zubee's STYLESHEET --> 
<link href="<?=$site_url?>templates/<?=$template?>/style.css" rel="stylesheet" type="text/css" />
<!-- Zubee's Javascripts --> 
<script type="text/javascript" src="<?=$site_url?>templates/<?=$template?>/js/iepngfix_tilebg.js"></script>
	<!--[if IE 7]>	
	<link rel="stylesheet" href="<?=$site_url?>templates/<?=$template?>/css/ie7.css" type="text/css" media="screen" title="ie8" charset="utf-8" />
	<![endif]-->
<!--[if IE 6]>
<script src="<?=$site_url?>templates/<?=$template?>/js/DD_belatedPNG_0.0.8a-min.js"></script>
<script>
  
  DD_belatedPNG.fix('#header'); 
  DD_belatedPNG.fix('.pngfix'); 
 
</script>
<![endif]--> 
<link rel="shortcut icon" href="<?=$site_url?>templates/<?=$template?>/images/favicon.ico">
<link rel="alternate" type="application/rss+xml" title="<?php echo $site_title; ?> Feed" href="<?php echo $site_url; ?>rss" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script>!window.jQuery && document.write('<script src="<?=$site_url?>templates/<?=$template?>/js/jquery/jquery-1.4.2.min.js"><\/script>')</script>
	<script type="text/javascript" src="<?=$site_url?>templates/<?=$template?>/js/cufon/cufon-yui.js"></script>
	<script type="text/javascript" src="<?=$site_url?>templates/<?=$template?>/js/cufon/TitilliumText22L_300.font.js"></script>	
		<script type="text/javascript" src="<?=$site_url?>templates/<?=$template?>/js/main.js"></script>		
</head>

<body>
	<!--START HEADER  -->
    <div id="header">
    
      <div id="head_wrap" class="container_12">
            
           <!--START LOGO  --> 
           <div id="logo" class="grid_8">
           
           		<h2><strong><?php echo $site_title ?></strong></h2>
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
	      

	<div class="clearfix">&nbsp;</div>
	 <div id="content" class="container_16">
	  		 
		 	  <div class="grid_16">
	<?php 
	if (isset($_REQUEST['bad'])) {
    echo "<h3>Don't use bad words on this website!</h3>";
}
	
	?> 
	<div class="grid_8">
	<h3>Welcome to <?php echo $site_title ?>!</h3>
	<strong><?php echo $site_title." - ".$site_slogan; ?></strong>
	</div>
      <div class="grid_7">
		  <h3>They already joined</h3>
	<?php $MemberDisplayList = '<table border="0" align="center" cellpadding="6">
              <tr>  ';
// Mysql connection is already made in the file this one gets included into
// So we can run queries here without having to connect again
$sql = dbquery("SELECT id, username, firstname FROM myMembers WHERE email_activated='1' ORDER BY RAND() LIMIT 7");
while($row = mysql_fetch_array($sql)){
	$id = $row["id"];
	$username = $row["username"];
	$firstname = $row["firstname"];
	if (!$firstname) {
		$firstname = $username;
	}
    $firstnameCut = substr($firstname, 0, 10);
	$check_pic = "members/$id/image01.jpg";
	if (file_exists($check_pic)) {
	    $user_pic = "<img src=\"members/$id/image01.jpg\" width=\"64px\" border=\"0\" />";
	} else {
		$user_pic = "<img src=\"members/0/image01.jpg\" width=\"64px\" border=\"0\" />";
	}
	$MemberDisplayList .= '<td><a href="profile.php?id=' . $id . '" title="' . $firstname . '"><font size="-2">' . $firstnameCut . '</font></a><br />
	<div style=" height:64px; overflow:hidden;"><a href="profile.php?id=' . $id . '"  title="' . $firstname . '">' . $user_pic . '</a></div></td><td width="5px"></td>';

} // close while loop

$MemberDisplayList .= '              </tr>
            </table>  ';
			echo $MemberDisplayList;
?>
		</div>
		 
	  </div>	
	   
   <div class="grid_16">
  
   <div class="grid_12">
       <h3>Crazy and cool videos</h3>
   <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="501" height="100" id="recently viewed videos" align="middle">
<param name="allowScriptAccess" value="sameDomain" />
<param name="movie" value="<? echo $site_url?>recentplayer.swf?x=recent.php&t=" />
<param name="quality" value="high" /><param name="bgcolor" value="#FFFFFF" />
<param name="wmode" value="opaque" />
<embed src="<? echo $site_url?>recentplayer.swf?x=recent.php" quality="high" bgcolor="#FFFFFF" width="601" height="125" name="recently viewed videos" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>
<br />

          <?php include("alltime.php"); ?>	
	</div>
	 <div class="grid_3">
         <h3>Top searches</h3>
	<table width="100%"><? TopVideos() ?></table>
	 <h3>Latest activity</h3>
	 <?php include("i_activity.php"); ?>	
		  <h3>Video Tags</h3>
		 <? TagCloud(60); ?>
		 
	</div>
	</div>
	   <div class="grid_16">
	  <hr>
      <h2 class="alt"><?php echo $site_title." - ".$site_slogan; ?>.</h2>
      <hr>
      <p>
        &copy; 2010 <a href="<?=$site_url?>">   <?php echo $site_title ?>
        </a> </p>
		  </div>	
	</div>	
	</body>
	</html>