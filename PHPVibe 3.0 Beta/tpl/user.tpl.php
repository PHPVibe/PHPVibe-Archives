<?php include("usidebar.tpl.php");?>
 
 <div class="main">
 
<?php
if ($pageNumber < 2) {
$vbox_result=mysql_query("select * from videos WHERE user_id ='".$user_profile->getId()."' ORDER BY id DESC limit 0, 4");
if (mysql_num_rows($vbox_result) > 0) {
$more = "<a href=\"".$site_url."videos-by/".$user_profile->getId()."\">View all </a>";
$box_title = ucfirst($more.$lang['videos']);
include("video_box.tpl.php"); 
}

}
?>
<div class="phpvibe-box">
<div class="box-head-light"><h3> Timeline</h3></div>
<div class="box-content">
    
<div class="timeline">
<div class="grid-view">
 <?php
$nr_query = "SELECT COUNT(*) FROM user_wall where u_id = '".$user_profile->getId()."'";
$result = mysql_query($nr_query);
$numberofresults = mysql_result($result, 0);
$BrowsePerPage = 20;

if($numberofresults > $BrowsePerPage) {
$break_nr = $BrowsePerPage / 2;
} else {
$break_nr = $numberofresults  / 2;
}

$limit = 'LIMIT ' .($pageNumber - 1) * $BrowsePerPage .',' .$BrowsePerPage; 
$result=mysql_query("select * from user_wall where u_id = '".$user_profile->getId()."' order by msg_id desc $limit");
$i = 1;
 while($row = mysql_fetch_array($result)){
$id=$row['msg_id'];
$msg=$row['message'];
$user_id=$row['u_id'];
$user_time=$row['time'];
$user_video=$row['att'];
$msg= twitterify($msg);
$action = "Said :";

$tmp_div ='';
$tmp_div .='<article>
                          <div class="user white"> <a href="'.$u_canonical.'"><img src="'.$site_url.'com/timthumb.php?src='.$user_profile->getAvatar().'&h=30&w=30&crop&q=100" alt="">
                            <p>'.$user_profile->getDisplayName().'</p>
                            </a><a href="'.$site_url.'status/'.$id.'"><span>'.time_ago($user_time).'</span></a></div>';
                        if ($vid->getEmbedCode($user_video) != "This URL is invalid or the video is removed by the provider.") {

$details = $vid->get_data();
$tmp_div .='<div class="hovermore"><center><a href="'.$user_video.'" class="lightbox"><img src="'.$details['thumbnail'].'"/ style="width:92%;"></a></center> 
                            <div class="corner">&nbsp;</div>
                          </div>'; 
	$action = "Shared this video :";					  
 }

                           
     $tmp_div .=' <footer class="entry-footer">   <h2><a href="'.$site_url.'status/'.$id.'">'.$action.'</a></h2>
                
                               <div class="excerpt" style="width:100%;">
                              <p>'.twitterify($msg).'</p> ';
							  $object_id = "status_".$id; //identify the object which is being commented
$tmp_div .= show_comments($object_id);  //load the comments and display  
						
							  if( is_owner($user_profile->getId())) {
							    $tmp_div .='<a href="#" class="deletebox" id="'.$id.'">Remove</a>';
							  }
							  $tmp_div .='  </p>
                            </div>
                          </footer>
                          <div class="arrow"><span></span></div>
                          <div class="point"><span></span></div> </article> ';
if ($i % 2 !== 0) {
$first_div .= $tmp_div;
} else { $second_div .= $tmp_div; }
						 
$i++;						
	}
						  ?>
						  
		 <div class="firstdiv">
		 <?php if( is_owner($user_profile->getId()) ) { ?>
					  <article>
                                                 
                          <footer class="entry-footer">
                            <h2>What's Up?</h2>
                            <div class="excerpt" style="width:100%;"> 
							<div class="emAddComment">
							<form  method="post" name="form" action="">
		<textarea id='update'></textarea>
		<input type='submit' value=' Update ' id='update_button'/>
		</form>
  </div>

                            </div>
                          </footer>
                       </article>
					   	<?php } ?>	
		
		 <?php echo $first_div; ?>
</div>	
<div class="timeline_bg"></div>
                      <div class="seconddiv">				  
				   <?php if ($pageNumber < 2) { ?>
		   <article class="">
                       <div class="user white"> <a href="'.$u_canonical.'"><img src="<?php echo $site_url.'com/timthumb.php?src='.$user_profile->getAvatar(); ?>&h=30&w=30&crop&q=100" alt="">
                            <p><?php echo $user_profile->getDisplayName(); ?></p>
                            </a><a href=""><span><?php echo $lang['laston']." : ".$user_profile->renderLastlogin(); ?></span></a></div>
                          <footer class="entry-footer">
                            <h2><?php echo $lang['aboutme']; ?></span></h2>
                            <div class="excerpt">
                              <p>
							  <?php

if( $name = $user_profile->getName() )
		{
			echo '<strong>'.$lang['rname'].':</strong> ';
			echo $name;
		}
		
		echo '<br /><strong>'.$lang['membersince'].' :</strong> ';
		echo $user_profile->renderDateRegistered();
		
		if( $location = $user_profile->getNowCity() )
		{
			echo '<br /><strong>'.$lang['ccity'].' :</strong> ';
			echo $location;
		}
		if( $from_location = $user_profile->getFromCity() )
		{
			echo '<br /><strong>'.$lang['fromcity'].' :</strong> ';
			echo $from_location;
		}
		if( $gender = $user_profile->getGender() )
		{
			echo '<br /><strong>'.$lang['gender'].' :</strong> ';
			echo $gender;
		}
		/*if( $date_of_birth = $user_profile->getDateOfBirth() )
		{
			$date_of_birth = date($config->site->date_format, strtotime($date_of_birth));
			echo '<br /><strong>'.$lang['birthdate'].' :</strong> ';
			echo $date_of_birth;
		}		
		echo '<br /><strong>'.$lang['laston'].' :</strong>
		'.$user_profile->renderLastlogin();
		*/
		if( $rel = $user_profile->getRelation() )
		{
			echo '<br /><strong>'.$lang['relation'].' :</strong> ';
			echo $rel;
		}
		if( $ab = $user_profile->getAbout() )
		{
			echo '<br /><strong>'.$lang['aboutme'].' :</strong> ';
			echo $ab;
		}
    ?>	
							  </p>
                            </div>
                          </footer>		
</article>			
<?php } ?>
						<?php echo $second_div; ?>  
					  </div>

</div>			  
  </div>

   <br style="clear:both;"/>
  </div>  
    </div>

	  
	<?php
$a = new pagination;	
$a->set_current($pageNumber);
$a->set_first_page(true);
$a->set_pages_items(12);
$a->set_per_page(20);
$a->set_values($numberofresults);
$a->show_pages($pagi_url);
?>	
  </div>
