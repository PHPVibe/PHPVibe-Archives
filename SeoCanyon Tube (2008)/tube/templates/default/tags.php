<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

	<head>
	
		<title><? if($overall_tag != ""){ echo ucwords($overall_tag).' !'.$after_tag; } else { echo $site_title." - ".$site_slogan; }?></title>
		
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		
		<meta name="keywords" content="<? if($overall_tag != ""){ echo $overall_tag.', '; }?><?=$site_keywords?>">
		<meta name="description" content="Video for <? if($overall_tag != ""){ echo $overall_tag.', '; }?>. Videos containing <? if($overall_tag != ""){ echo $overall_tag.', '; }?>">
		
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
          
            <p><a href="#">John Doe</a> &nbsp; <a href="#info" rel="facebox">Messages (<strong>2</strong>)</a>&nbsp; <a href="#">My Settings </a>&nbsp; <a href="#">Log Out</a></p>
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
	<!-- Left Side Content -->
 <div id="content" class="container_16">
 <div class="grid_16">
 <div class="grid_11">
		<!-- Search Results & Random Videos -->
		<?
				
        if ($overall_tag != ""):
          echo "
            	<h1>Videos for \"".$overall_tag."\"</h1>
				<hr>
          ";
        else:
          echo "
            	<h2>There is an error! Search again!</h2><br />
          ";
        endif;
           ?>
		   <p id="pages">
			<?php
			
				echo $standard_feed_pagination;
			
			?>	  
		 </p>
		   <?php
		   
        if ($total < 2):
          echo "
            	<div style=\"text-align:center;\">No result, try other keyword!</div>
          ";
        else:
          echo "
            	<table style=\"width: 100%; border: 0;\" cellspacing=\"0\" cellpadding=\"0\">
          ";
		
          $i=0;
         
		  $video = $source[1];
          
          while ($i<20):
          
          $video_id = $video[$i]['id'];
          
          if (empty($video_id)): $i++; elseif (empty($video[$i]['thumbnail'])): $i++; else:
          
            echo "
                 <tr>
				 <td width=\"121px\">
				 <a href=\"".Friendly_URL($video_id)."\" title=\"".$video[$i]['title']."\">
                            <img src=\"http://i4.ytimg.com/vi/".$video_id."/default.jpg\" alt=\"".SpecialChars($video[$i]['title'])."\" width=\"120\" height=\"90\"/>
                          
						  </a>
				 </td>
				 
				 <td width=\"121px\">
				 <a href=\"".Friendly_URL($video_id)."\" title=\"".$video[$i]['title']."\">
                            <img src=\"http://i4.ytimg.com/vi/".$video_id."/3.jpg\" alt=\"".SpecialChars($video[$i]['title'])."\" width=\"120\" height=\"90\"/>                        
						  </a>
				 </td>
				 <td width=\"25px\">
				 </td>
				 <td>
				 <a href=\"".Friendly_URL($video_id)."\" title=\"".$video[$i]['title']."\"><strong>".$video[$i]['title']."</strong> </a>
				 
<br /> ".substr($video[$i]['description'],0,90)."  <br />		
<script src=\"http://connect.facebook.net/en_US/all.js#xfbml=1\"></script><fb:like href=\"".$site_url."video/".$video_id."\" layout=\"button_count\" width=\"150\"></fb:like>
		  
				 </td>
</tr>				 
            ";
                                     
            $i++;
            endif;
            endwhile;
          echo "</table>";
         endif; 
		
        ?>
		
	
			
		<!-- Pages -->
		
		 <p id="pages">
			<?php
			
				echo $standard_feed_pagination;
			
			?>	  
		 </p>
		
		<!-- Pages / END -->
			
	</div>
		<!-- Search Results  / END-->
	
	<!-- Right Side Content -->
		 <div class="grid_4">
	
        
        <?php include("sidebar.php"); ?>	
		
		</div>
		</div>
	<!-- Right Side Content / END -->
<div class="grid_16">
	  <hr>
      <center><h3 class="alt">Videos for <? if($overall_tag != ""){ echo $overall_tag.', '; }?></h3></center>

      <p>
        &copy; 2010 <a href="<?=$site_url?>">   <?php echo $site_title ?>
        </a> </p>
</div>	
 
 
 </div>	
	
</body>
</html>