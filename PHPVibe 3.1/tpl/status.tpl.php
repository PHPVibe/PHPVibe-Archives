<?php include("usidebar.tpl.php"); ?>

<div class="main">

<?php echo '<div class="block_title"><h2>'.stripslashes(ucfirst($seo_title)).' | '.time_ago($sts["time"]).'</h2></div>';
echo '<div class="single_status">';
 echo'
                          <div class="status_user"> '.$lang["by"].' <a href="'.$u_canonical.'">'.$user_profile->getDisplayName().'</a>
                          </div>';
if(!empty($sts["att"]) && $vid->isValid($sts["att"])) {
			  echo '<div class="single_media">'.shutAutoplay($vid->getEmbedCode($sts["att"])).'</div>';
			}
			if(!empty($sts["picture"])) {
			  echo '<div class="single_media"><a href="'.$sts["picture"].'" class="lightbox"><img src="'.$sts["picture"].'"/></a></div>';
			}

                           
     echo'                 
                               <div class="excerpt">
                              <p>'.twitterify($sts["message"]).'</p> ';

							  echo' 
                            </div>
                          ';
$object_id = 'status_'.$this_id; //identify the object which is being commented
echo show_comments($object_id);  //load the comments and display    
?>


   <br style="clear:both;"/>

</div>