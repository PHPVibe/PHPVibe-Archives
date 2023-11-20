<?php
    // set URL for XML feed containing category list
    $catURL = 'http://gdata.youtube.com/schemas/2007/categories.cat';
    
    // retrieve category list using atom: namespace
    // note: you can cache this list to improve performance, 
    // as it doesn't change very often!
    $cxml = simplexml_load_file($catURL);
    $cxml->registerXPathNamespace('atom', 'http://www.w3.org/2005/Atom');
    $categories = $cxml->xpath('//atom:category');
    


include_once("header.php"); 
?>      
    <!-- start page -->
    <div class="page">
    <div class="bredcrumbs">
					<ul>
						<li><a href="<?php echo $site_url;?>"><?php echo $small_title; ?></a></li>
						<li><a href="<?php echo $site_url;?>?sk=channel"><?php echo $lang['channels']; ?></a></li>
					</ul>
					<div class="clearfix"></div>
				</div>	  
    		
            <div class="phpvibe-box">
					<div class="box-head-light"><h3><?php echo $lang['channels']; ?></h3></div>
					<div class="box-content">
					<ul class="listcontent">
                	<?php 
         // iterate over category list
    foreach ($categories as $c) {
      // for each category    
      // set feed URL
	
	  echo ' 
		 	<li><a href="'.$site_url.'?sk=channel&name='.$c['term'].'"><img src="img/bigicons/play.png" width="23" height="23" alt="icon" class="m-icon"/><b>'.$c['label'].'</b></a></li>
		 	';
      } 
?>  
          </ul>             
                </div>
      </div>
      
       <?php include_once("footer.php"); ?>       
            
            
            
            
      