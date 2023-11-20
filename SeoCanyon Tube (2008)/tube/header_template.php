 <!-- Zubee's STYLESHEET --> 
<link href="<?=$site_url?>templates/<?=$template?>/style.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="<?=$site_url?>templates/<?=$template?>/images/favicon.ico">
<link rel="alternate" type="application/rss+xml" title="<?php echo $site_title; ?> Feed" href="<?php echo $site_url; ?>rss" />
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
           
           		<h2><strong><?php echo $site_title; ?></strong></h2>
        </div>
           <!-- END LOGO -->
        
          <!-- START USERPANEL --> 
          <div id="user_panel" class="grid_4">
           
<?php include('templates/'.$template.'/usermenu.php'); ?>		   
            
    </div>
          <!-- END USERPANEL --> 
        
        
			<!--START NAVIGATION  -->
            <div id="nav" class="grid_12">
            
            <!-- Start .zumega -->
<div class="zumega red">
<?php include('templates/'.$template.'/menu.php'); ?>
	
</div> <!-- .zumega --> 
                
                    
        </div>
        <!-- END NAV -->       
         
          
   	 </div>
     <!-- END HEAD_WRAP (CONTAINER FOR LOGO AND NAVIGATION -->
     
    </div>
    <!--END HEADER (FULLL WIDTH WRAPPER WITH BG) -->
	
	 <div id="content" class="container_16">
 
 <div class="grid_16">