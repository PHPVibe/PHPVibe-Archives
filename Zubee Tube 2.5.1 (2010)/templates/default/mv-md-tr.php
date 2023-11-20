<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

	<head>
	
		<title><?=$site_title?> - <? if($what=="mv"){ echo "Most Viewed"; } elseif($what=="md"){ echo "Most Discussed"; } elseif($what=="tr"){ echo "Top Rated"; } ?></title>
		
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		
		<meta name="keywords" content="<?=$site_keywords?>">
		<meta name="description" content="<?=$site_description?>">
		
		<base href="<?=$site_url?>" />
		
		<link href="<?=$site_url?>templates/<?=$template?>/style.css" rel="stylesheet" type="text/css" />
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
	
	
	<!-- Left Side Content -->
	<div id="left">
			
		<!-- Search Results & Random Videos -->
		<div class="left_articles"><?
				
        if ($what == "mv"): echo "<h2>Most Viewed Videos</h2><br />";
        elseif ($what == "md"): echo "<h2>Most Discussed Videos</h2><br />";
        elseif ($what == "tr"): echo "<h2>Top Rated Videos</h2><br />";
        endif;
        
          echo "
            	<table style=\"width: 100%; border: 0;\" cellspacing=\"0\" cellpadding=\"0\"><tr>
          ";

        $perline=1;
        while($row = dbarray($result))
        {
          
            echo "
                    <td style=\"width: 50%;\">
                      <table style=\"border: 0;\" cellspacing=\"0\" cellpadding=\"0\"><tr>
                        <td valign=\"top\">
                          <a href=\"".$site_url.$row['video_id']."/".Friendly_URL($row['title']).".html\" title=\"".$row['title']."\">                           
                          <img src=\"".SpecialChars($row['thumb'])."\" alt=\"".SpecialChars($row['title'])."\" class=\"thumb\"  />
						  </a>
                        <br/>
                          <a href=\"".$site_url.$row['video_id']."/".Friendly_URL($row['title']).".html\">".$row['title']."</a>
                          <div style='padding-top: 10px;'>
                            <strong>".Stats('views', $row['video_id'])."</strong> Views, <strong>".Stats('comments', $row['video_id'])."</strong> Comments<br />".Stats('rating', $row['video_id'])."
                          </div>
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
        }
        
          echo "</tr></table>";
         
        ?>
		</div>
		<!-- Search Results & Random Videos / END-->
			
		<!-- Pages -->
		<div class="left_articles">
		 <p id="pages"><?

            if ($count > 0) {
                  $i=0;
                  $l=1;
                  for($i=0;$i < $count;$i=$i+$limit)
                  {
				  if($l <=20){
                    if($i <> $eu){
                      echo " <strong><a href='".$site_url.$whati."/nr-".$i."'>".$l."</a></strong> ";
                    } else {
                      echo " <strong>".$l."</strong> ";
                    }
					}
                    $l=$l+1;
					
                  }
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
	</div>
	<!-- Right Side Content / END -->
	
	<!-- Footer -->
	<?php include("footer.php"); ?>
	<!-- Footer / END -->
		
</div>
<!-- Page Content / END -->
</body>
</html>