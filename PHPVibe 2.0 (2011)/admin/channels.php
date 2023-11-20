<?php include_once("security.php");
if (!$user->getGroup()->isAdmin()) {
die("Login first!");
}
include_once("head.php");
	
	 ?>
 <div id="content" class="clear-fix">	 


 <div class="block">

 <h2>Upload the pictures needed for the slider</h2> 

<div class="inner-block" style="width:95%;padding-left:20px;">
					

<div id="content">

			<div id="dropable"></div>

		</div>

</div>	 
     </div><!-- end of right content-->

 <?php 
  include_once("foot.php");
 ?>