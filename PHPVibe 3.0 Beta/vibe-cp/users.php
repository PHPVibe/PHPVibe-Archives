<?php include_once("header.php");
$pageNumber = MK_Request::getQuery('page', 1);	
 if(isset($_GET['delete'])){ 
	 $del = dbquery("DELETE from users WHERE id = '".$_GET['delete']."'");
	  $del2 = dbquery("DELETE from users_meta WHERE user = '".$_GET['delete']."'");
	$message= 'Deleted user # '.$_GET['delete'];
	 }

?>
	<div id="content">
<div class="box">
<div class="box-header"><h1>Members area </h1></div>
<div class="box-content">
 <div class="searchWidget">
                    <form action="users.php">
                        <input type="text" name="s" id="s" placeholder="Search members by (display)name" />
                        <input type="submit" value="" />
                    </form>
                </div>
				<div class="widget" style="width:100%; min-width:700px;">
				  <div class="title"><img src="img/icons/users.png" alt="" class="titleIcon" /><h6>Member Groups</h6></div>
				   <div class="uGroups">

				 <ul>
<?php
$vbox_result=mysql_query("SELECT users_groups.*, (SELECT COUNT(*) FROM users WHERE users.group_id = users_groups.id) AS number FROM users_groups");
while($group = mysql_fetch_array($vbox_result))
{
if($group["access_level"] < 2) {
$class ="green";
}elseif($group["access_level"] > 2){
$class ="red";
} else {
$class ="blue";
}
?>
       <li><h4 class="<?php echo $class;?>"><?php echo $group["name"];?></h4><span><?php echo $group["number"];?> users</span></li>
                     
<?php } ?>
                        </ul>
						</div>
 </div>
<?php
if(isset($_GET["s"])){
$nr_query = "SELECT COUNT(*) FROM users where display_name like '%".$_GET["s"]."%'";
$pagi_url = $admin_link.'users.php?s='.$_GET["s"].'&page=';
$order = "WHERE display_name like '%".$_GET["s"]."%' order by id DESC";
} else {
$nr_query = "SELECT COUNT(*) FROM users";
$order = "order by id DESC";
$pagi_url = $admin_link.'users.php?page=';
}
$pagi_current=$pagi_url.$pageNumber;
$result = mysql_query($nr_query);
$numberofresults = mysql_result($result, 0);
$BrowsePerPage = 80;
?>
<div class="widget" style="width:100%; min-width:700px;">
                <div class="title"><img src="img/icons/users.png" alt="" class="titleIcon" /><h6>Members (<?php echo $numberofresults; ?>)</h6></div>

                    <ul class="partners">

                <?php
$limit = 'LIMIT ' .($pageNumber - 1) * $BrowsePerPage .',' .$BrowsePerPage; 
$qqquery = "select * from users ".$order." ".$limit;
$os = mysql_query($qqquery) or die(mysql_error());
while($rrow = mysql_fetch_array($os)){
$my_u_url = $site_url.'user/'.$rrow['id'].'/'.seo_clean_url($rrow['display_name']) .'/';
if(!empty($rrow['avatar'])):
$avatar = $rrow['avatar'];
else:
$avatar = $site_url.'tpl/images/light/no_image.jpg';
endif;
if($rrow["group_id"] == "2") {
$uclass ="green";
}elseif($rrow["group_id"] == "1"){
$uclass ="red";
} else {
$uclass ="blue";
}
?>
<li>
<a href="<?php echo $my_u_url;?>" title="" class="floatL"><img src="<?php echo $site_url.'com/timthumb.php?src='.$avatar.'&h=36&w=37&crop&q=100';?>" alt="" /></a>
<div class="pInfo">
<a href="<?php echo $my_u_url;?>" title="" class="<?php echo $uclass; ?>"><strong><?php echo $rrow['display_name'];?></strong></a>
<i>E-mail: <?php echo $rrow['email'];?> ; Last on : <?php echo $rrow['lastlogin'];?></i>	
 </div>
 <div class="pLinks">
<a href="<?php echo admin_panel(); ?>user.php?id=<?php echo $rrow['id']; ?>" title="Edit" class="tipW"><i class="icon-pencil"></i></a>
<a href="<?php echo $pagi_current; ?>&delete=<?php echo $rrow['id']; ?>" title="Remove" class="tipW"><i class="icon-trash"></i></a>
 </div>
<div class="clear"></div>
 </li>
  <?php }  ?>
 </ul>
 </div>

</div>
</div>


<br style="clear:both;">

<?php
echo '<div class="clear"></div>';
$a = new pagination;	
$a->set_current($pageNumber);
$a->set_first_page(true);
$a->set_last_page(true);
$a->set_pages_items(12);
$a->set_per_page($BrowsePerPage);
$a->set_values($numberofresults);
$a->show_pages($pagi_url);
?>		
	
</div>	

	</div>
	
<?php include_once("footer.php");?>