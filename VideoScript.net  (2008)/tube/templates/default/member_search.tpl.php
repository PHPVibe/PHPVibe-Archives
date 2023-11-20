<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.ohtml4/strict.dtd">
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="Description" content="Member Browsing" />
<meta name="Keywords" content="" />
<meta name="rating" content="General" />
<meta name="ROBOTS" content="All" />
<title>Browse Members</title>
<!-- Zubee's STYLESHEET --> 
<link href="<?=$site_url?>templates/<?=$template?>/style.css" rel="stylesheet" type="text/css" />
<link href="<?=$site_url?>templates/<?=$template?>/like/css.css" rel="stylesheet" type="text/css" />
<link href="<?=$site_url?>templates/<?=$template?>/css/jquery.tweet.css"  media="all" rel="stylesheet" type="text/css"/>
<!-- Zubee's Javascripts --> 
<script type="text/javascript" src="<?=$site_url?>templates/<?=$template?>/js/iepngfix_tilebg.js"></script>
	<!--[if IE 7]>	
	<link rel="stylesheet" href="<?=$site_url?>templates/<?=$template?>/css/ie7.css" type="text/css" media="screen" title="ie8" charset="utf-8" />
	<![endif]-->
<!--[if IE 6]>
<script src="<?=$site_url?>templates/<?=$template?>/js/DD_belatedPNG_0.0.8a-min.js"></script>
<link rel="stylesheet" href="css/ie6.css" type="text/css" media="screen," />
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
<style type="text/css">
<!--
.pagNumActive {
	color: #000;
	border:#060 1px solid; background-color: #D2FFD2; padding-left:3px; padding-right:3px;
}
.paginationNumbers a:link {
	color: #000;
	text-decoration: none;
	border:#999 1px solid; background-color:#F0F0F0; padding-left:3px; padding-right:3px;
}
.paginationNumbers a:visited {
	color: #000;
	text-decoration: none;
	border:#999 1px solid; background-color:#F0F0F0; padding-left:3px; padding-right:3px;
}
.paginationNumbers a:hover {
	color: #000;
	text-decoration: none;
	border:#060 1px solid; background-color: #D2FFD2; padding-left:3px; padding-right:3px;
}
.paginationNumbers a:active {
	color: #000;
	text-decoration: none;
	border:#999 1px solid; background-color:#F0F0F0; padding-left:3px; padding-right:3px;
}
-->
</style>
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
<?php	
// Build the Output Section Here
$outputList = '';
while($row = mysql_fetch_array($sql2)) { 

	$id = $row["id"];
	$username = $row["username"];
	$firstname = $row["firstname"];
	if (!$firstname) {
		$firstname = $username;
	}
	$country = $row["country"];
	$website = $row["website"];
    $about = $row["bio_body"];
	$city = $row["city"];
	$laston = $row["last_log_date"];
	///////  Mechanism to Display Pic. See if they have uploaded a pic or not  //////////////////////////
	$check_pic = "members/$id/image01.jpg";
	$default_pic = "members/0/image01.jpg";
	if (file_exists($check_pic)) {
    $user_pic = "<img src=\"$check_pic\" width=\"50px\" border=\"0\" />"; // forces picture to be 120px wide and no more
	} else {
	$user_pic = "<img src=\"$default_pic\" width=\"50px\"  border=\"0\" />"; // forces default picture to be 120px wide and no more
	}
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$outputList .= '
<table width="100%">
                  <tr>
                    <td width="13%" rowspan="2"><div style=" height:50px; overflow:hidden;"><a href="profile.php?id=' . $id . '" target="_self">' . $user_pic . '</a></div></td>
                    
                    <td width="73%"><a href="profile.php?id=' . $id . '" target="_self">' . $firstname . '</a> from ' .$city.' ,' .$country .'</td>
                  </tr>
                  
                    <td width="14%"><strong>About</strong> : ' . $about . ' <strong>Last Online</strong> : '. $laston .'</td>       
</tr>					
                  </table>
				  <hr />
';
	
	
} // close while 

?>
	

      <div class="grid_16">
        <h3>Our <?php echo $nr; ?> Members    
      </h3>
</div>
      <table width="100%" align="center" cellpadding="6">
        <tr>
          <td>
<?php echo $outputList; ?></td>
        </tr>
      </table>
     <div class="grid_16"><?php echo $paginationDisplay; ?></div>


</div>
</div>
</body>
</html>