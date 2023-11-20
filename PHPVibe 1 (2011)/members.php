<?php
require_once '_inc.php';
$head_title = array();
$head_title[] = 'Our Members';
$head_extra = '';
$head_extra = '
<style type="text/css">	
			
			a{ color:#C8DCE5; }
			h3{ margin: 10px 10px 0 10px; color:#FFF; font:18pt Arial, sans-serif; letter-spacing:-1px; font-weight: bold;  }
			
			.boxgrid{ 
				width: 225px; 
				height: 160px; 
				margin:10px; 
				float:left; 
				background:#D5D5D5; 
				border: solid 2px #8399AF; 
				overflow: hidden; 
				position: relative; 
			}
				.boxgrid img{ 
					position: absolute; 
					top: 0; 
					left: 0; 
					border: 0; 
				}
				.boxgrid p{ 
					padding: 0 10px; 
					color:#afafaf; 
					font-weight:bold; 
					font:15pt "Lucida Grande", Arial, sans-serif; 
				}
				
			.boxcaption{ 
				float: left; 
				position: absolute; 
				background: #000; 
				height: 100px; 
				width: 100%; 
				opacity: .8; 
				/* For IE 5-7 */
				filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=80);
				/* For IE 8 */
				-MS-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=80)";
 			}
 				.captionfull .boxcaption {
 					top: 260;
 					left: 0;
 				}
 				.caption .boxcaption {
 					top: 220;
 					left: 0;
 				}
				
		</style>

<script type="text/javascript">
			$(document).ready(function(){
				//To switch directions up/down and left/right just place a "-" in front of the top/left attribute
				//Vertical Sliding
				$(\'.boxgrid.slidedown\').hover(function(){
					$(".cover", this).stop().animate({top:\'-160px\'},{queue:false,duration:300});
				}, function() {
					$(".cover", this).stop().animate({top:\'0px\'},{queue:false,duration:300});
				});
				//Horizontal Sliding
				$(\'.boxgrid.slideright\').hover(function(){
					$(".cover", this).stop().animate({left:\'225px\'},{queue:false,duration:300});
				}, function() {
					$(".cover", this).stop().animate({left:\'0px\'},{queue:false,duration:300});
				});
				//Diagnal Sliding
				$(\'.boxgrid.thecombo\').hover(function(){
					$(".cover", this).stop().animate({top:\'160px\', left:\'225px\'},{queue:false,duration:300});
				}, function() {
					$(".cover", this).stop().animate({top:\'0px\', left:\'0px\'},{queue:false,duration:300});
				});
				//Partial Sliding (Only show some of background)
				$(\'.boxgrid.peek\').hover(function(){
					$(".cover", this).stop().animate({top:\'90px\'},{queue:false,duration:160});
				}, function() {
					$(".cover", this).stop().animate({top:\'0px\'},{queue:false,duration:160});
				});
				//Full Caption Sliding (Hidden to Visible)
				$(\'.boxgrid.captionfull\').hover(function(){
					$(".cover", this).stop().animate({top:\'80px\'},{queue:false,duration:160});
				}, function() {
					$(".cover", this).stop().animate({top:\'130px\'},{queue:false,duration:160});
				});
				//Caption Sliding (Partially Hidden to Visible)
				$(\'.boxgrid.caption\').hover(function(){
					$(".cover", this).stop().animate({top:\'80px\'},{queue:false,duration:160});
				}, function() {
					$(".cover", this).stop().animate({top:\'130px\'},{queue:false,duration:160});
				});
			});
		</script>
';
include_once("tpl/php/global_header.php");
// We get an instance of the users module
$user_module = MK_RecordModuleManager::getFromType('user');

	// We don't want ALL of the users so we create a MK_Paginator
	$paginator = new MK_Paginator();
	
	// If no page is defined we default to the first page and 16 users per page
	$page = MK_Request::getQuery('page', 1);
	
	$paginator
		->setPage($page)
		->setPerPage(16);
	
	// Get users
	$users = $user_module->getRecords($paginator);
	
	
	foreach($users as $current_user)
	{
		$output.= '<div class="boxgrid captionfull">';
		if($avatar = $current_user->getAvatar())
		{
			$output.= '<img class="border_shadow" src="library/thumb.php?f='.$avatar.'&h=160&w=225&m=crop" />';
		}
		$output.= '<div class="cover boxcaption"><h3>'.$current_user->getDisplayName().'</h3>';
		$output.= '<p><a href="user.php?id='.$current_user->getId().'">'.__("View profile").'</a></p>';
		$output.= '</div></div>';
	}
	
	
	

	?>
	
<div class="clearfix" id="main-content">
<div class="col col12">
  <div class="col-bkg clearfix">
	<?php

print $output;
?>
        </div>
 </div>
 <div class="col col8">
  <div class="col-bkg clearfix">
 <?php
	// Show pagination
	echo '<div class="clear-fix" style="width:100%; float:right;">'.$paginator->render('members.php?page={page}').'</div>';
	?>
    </div>
 </div>   
	  </div>
 </div>
</div>
<div class="clearfix"></div>
<?php
include_once("tpl/php/footer.php");
?>