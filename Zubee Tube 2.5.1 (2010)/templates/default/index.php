<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

	<head>
	
		<title><? if($overall_tag != ""){ echo ucwords($overall_tag).' Videos - '.$site_title; } else { echo $site_title." - ".$site_slogan; }?></title>
		
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		
		<meta name="keywords" content="<? if($overall_tag != ""){ echo $overall_tag.', '; }?><?=$site_keywords?>">
		<meta name="description" content="<?=$site_description?>">
		
		<base href="<?=$site_url?>" />
		
		<link href="<?=$site_url?>templates/<?=$template?>/style.css" rel="stylesheet" type="text/css" />
		<link rel="alternate" type="application/rss+xml" title="<?php echo $site_title; ?> Feed" href="<?php echo $site_url; ?>rss" />
		<link rel="shortcut icon" href="<?=$site_url?>templates/<?=$template?>/images/favicon.ico">
		
<link href="<?=$site_url?>templates/<?=$template?>/dropdown/dropdown.css" media="all" rel="stylesheet" type="text/css" />
<link href="<?=$site_url?>templates/<?=$template?>/dropdown/themes/mainmenu/default.ultimate.css" media="all" rel="stylesheet" type="text/css" />

<!--[if lt IE 7]>
<script type="text/javascript" src="js/jquery/jquery.js"></script>
<script type="text/javascript" src="js/jquery/jquery.dropdown.js"></script>
<![endif]-->

	</head>
	
<body>

<!-- Page Content -->
<div id="content">
	<?php include("header.php"); ?>
	<div id="featured">
	<script type='text/javascript' src='embed/swfobject.js'></script>
 
<div id='mediaspace'>Pls update your Flash Player!</div>
 
<script type='text/javascript'>
  var so = new SWFObject('embed/player.swf','mpl','960','350','9');
  so.addParam('allowfullscreen','true');
  so.addParam('allowscriptaccess','always');
  so.addParam('wmode','opaque');
  so.addVariable('playlistfile','http://gdata.youtube.com/feeds/api/standardfeeds/top_rated?time=today');
  so.addVariable('playlistsize','300');
  so.addVariable('playlist','right');
  so.addVariable('stretching','fill');
  so.write('mediaspace');
</script>
</div>
	<!-- Left Side Content -->
	<div id="left">
<?php	
if (!empty($_REQUEST['msg'])) {
$message =$_REQUEST['msg'];
echo '<font size="3" color="red">'.$message.'</font>'; 
};
?>
	
		<? if ($overall_tag == ""):
         $recent_videos_limit = 30;
         $result = dbquery("SELECT * FROM recent LIMIT ".$recent_videos_limit."");  $check = dbrows($result);
         if ($check > 0) {
        ?>
		<!-- Videos Being Watched Right Now -->
		<div class="left_articles">
		<h2>Videos Being Watched Right Now</h2><br />
              <marquee direction="left" onmouseover="this.stop()" onmouseout="this.start()"><?
                    while($row = dbarray($result)){
                      echo "
                      <a href=\"".$site_url.$row['video_id']."/".Friendly_URL($row['title']).".html\" title=\"".$row['title']."\">
                      <img src=\"".$row['thumb']."\" style=\"margin-right: 10px; border: 0; width: 100px; height: 70px;\" alt=\"".$row['title']."\"/>
                      </a>";
                    }
              ?></marquee>
		</div>
		<!-- Videos Being Watched Right Now / END -->
        <?
          }endif; ?>
			
		

		<!-- Search Results & Random Videos -->
		<div class="left_articles"><?
				
        if ($overall_tag != ""):
          echo "
            	<h2><i>".$overall_tag."</i> Search Results</h2><br />
          ";
        else:
          echo "
            	<h2>TV Videos</h2><br />
          ";
        endif;
           
		   
        if ($total < 2):
          echo "
            	<div style=\"text-align:center;\">No result, try other keyword!</div>
          ";
        else:
          echo "
            	<table style=\"width: 100%; border: 0;\" cellspacing=\"0\" cellpadding=\"0\"><tr>
          ";
		
          $i=0;
          $perline=1;
		  $video = $source[1];
          
          while ($i<10):
          
          $video_id = $video[$i]['id'];
          
          if (empty($video_id)): $i++; elseif (empty($video[$i]['thumbnail'])): $i++; else:
          
            echo "
                    <td style=\"width: 50%;\">
                      <table style=\"border: 0;\" cellspacing=\"0\" cellpadding=\"0\"><tr>
                        <td valign=\"top\">
                          <a href=\"".$site_url.$video_id."/".Friendly_URL($video[$i]['title']).".html\" title=\"".$video[$i]['title']."\">
                            <img src=\"http://i4.ytimg.com/vi/".$video_id."/0.jpg\" alt=\"".SpecialChars($video[$i]['title'])."\" class=\"thumb\"/>
                          
						  </a>
                        <br />
                          <a href=\"".$site_url.$video_id."/".Friendly_URL($video[$i]['title']).".html\"><strong>".$video[$i]['title']."</strong></a> 
                          
                        </td>
                       </tr></table>
                    </td>
            ";
           
              if ($perline==2):
                  $perline=1;
                   echo "
                        </tr><tr><td colspan=\"2\">&nbsp;</td></tr>
                        ";
              else:
                  $perline=$perline+1;
              endif;
            
            $i++;
            endif;
            endwhile;
          echo "</tr></table>";
         endif; 
		
        ?>
		</div>
		<!-- Search Results & Random Videos / END-->
			
		<!-- Pages -->
		<div class="left_articles">
		 <p id="pages">
			<?php
			if($site_homepage == 'random_tag' || $_GET['tag']) {
				echo $random_tag_pagination;
			} else {
				echo $standard_feed_pagination;
			}
			?>	  
		 </p>
		</div>
		<!-- Pages / END -->
			
	</div>
	<!-- Left Side Content / END -->
	
	<!-- Right Side Content -->
	<div id="right">
	
        
        <?php include("sidebar.php"); ?>	
		
		<div class="right_articles">
		[Featured Video]
		 <h2><?=$feautured_video_title?></h2>
	 <script type='text/javascript' src='embed/swfobject.js'></script>
<div id='feat'>Enable javascript.</div>
<script type='text/javascript'>
var s1 = new SWFObject('embed/player.swf','ply','290','200','9','#ffffff');
s1.addParam('allowfullscreen','true');
s1.addParam('allowscriptaccess','always');
s1.addParam('wmode','opaque');
s1.addVariable('file','http://www.youtube.com/watch?v=<?=$feautured_video_id?>');
s1.addVariable('image','http://i4.ytimg.com/vi/<?=$feautured_video_id?>/0.jpg');
s1.addVariable('stretching','exactfit');
s1.write('feat');
</script>
</div>
	</div>
	<!-- Right Side Content / END -->
	
	<!-- Footer -->
	<?php include("footer.php"); ?>
	<!-- Footer / END -->
		
</div>
<!-- Page Content / END -->
</body>
</html>