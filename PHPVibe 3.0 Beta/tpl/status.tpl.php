<?php include("usidebar.tpl.php"); ?>

<div class="main">

<div class="phpvibe-box">
<div class="box-head-light"><h3> <?php echo $seo_title; ?></h3></div>
<div class="box-content">
    
<div class="timeline">
<div class="grid-view">
 <div class="firstdiv">	
 <?php
 echo'<article>
                          <div class="user white"> <a href="'.$u_canonical.'"><img src="'.$site_url.'com/timthumb.php?src='.$user_profile->getAvatar().'&h=30&w=30&crop&q=100" alt="">
                            <p>'.$user_profile->getDisplayName().'</p>
                            </a><a href="'.$site_url.'status/'.$sts["msg_id"].'"><span>'.time_ago($sts["time"]).'</span></a></div>';
                        if ($vid->getEmbedCode($sts["att"]) != "This URL is invalid or the video is removed by the provider.") {

echo'<div class="hovermore"><center>'.$vid->getEmbedCode($sts["att"]).'</center> 
                            <div class="corner">&nbsp;</div>
                          </div>'; 
					  
 }

                           
     echo' <footer class="entry-footer">                  
                               <div class="excerpt">
                              <p>'.twitterify($sts["message"]).'</p> ';
							  if( is_owner($user_profile->getId())) {
							    echo'<a href="#" class="deletebox" id="'.$sts["msg_id"].'">Remove</a>';
							  }
							  echo'  </p>
                            </div>
                          </footer>
                          <div class="arrow"><span></span></div>
                          <div class="point"><span></span></div> </article> ';
 ?>
</div>	
<div class="timeline_bg"></div>
         <div class="seconddiv">				  
				
		   <article class="">
                          <footer class="entry-footer">
                         
                            <div class="excerpt" style="width:100%;">
                             
<?php 
$object_id = 'status_'.$this_id; //identify the object which is being commented
echo show_comments($object_id);  //load the comments and display    
?>

                            </div>
                          </footer>		
</article>			

					
					  </div>
</div>
</div>

   <br style="clear:both;"/>
</div>
</div>
</div>