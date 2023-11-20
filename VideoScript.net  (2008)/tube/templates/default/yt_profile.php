<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

	<head>
	
		<title><?php echo $ytusername ?>'s Video Channel</title>
		
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		
		<meta name="keywords" content="<?php echo $ytusername ?>">
		<meta name="description" content="<?php echo $ytusername ?> ! Video profile of user <?php echo $ytusername ?>">
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
        <div class="grid_11">
<h1><?php echo $ytusername ?>'s video channel</h1>
<h3><?php  echo 'Views: '.$viewCount.' &nbsp; &nbsp; &nbsp; Subscribers: '.$subscriberCount;?></h3>
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
 <div class="grid_4">

<?php  
$media = $authorFeed->children('http://search.yahoo.com/mrss/');
	$attrs = $media->thumbnail[0]->attributes();
    $athumbnail = $attrs['url']; 
	
   echo '<h4>Profile</h4>';
   echo '<hr>'; 
   echo '<img src="'.$athumbnail.'"/>';
    echo '<h2> '.$ytusername.'</h2>';
	echo '<br />';
	if (!empty($authorData->age)){
    echo 'Age: '.$authorData->age;
	echo '<br />';
	}
	if (!empty($authorData->gender)) {
    echo 'Gender: '.strtoupper($authorData->gender);
	echo '<br />';
	}
	if (!empty($authorData->location)) {
    echo 'Location: '.$authorData->location;	
    echo '<br />';
	}
	if (!empty($authorData->occupation)) {
    echo 'Occupation: '.$authorData->occupation;
	 echo '<br />';
	 }
    echo 'Views Count: '.$viewCount;
	echo '<br />';
    echo 'Subscribers: '.$subscriberCount;
	echo '<br />';
	
	
   
	
?>	 
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


<!-- Page Content / END -->
</body>
</html>