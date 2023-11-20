<?php include_once("header.php");
$pageNumber = MK_Request::getQuery('page', 1);	
 if(isset($_GET['delete'])){ 
	 $del = dbquery("DELETE from user_wall WHERE msg_id	 = '".$_GET['delete']."'");
	
	$message= 'Deleted comment # '.$_GET['delete'];
	 }

?>
	<div id="content">
<div class="box">
<div class="box-header"><h1>Sitewide member statuses </h1></div>
<div class="box-content">
 <div class="searchWidget">
                    <form action="walls.php">
                        <input type="text" name="s" id="s" placeholder="Search statuses" />
                        <input type="submit" value="" />
                    </form>
                </div>
<?php
if(isset($_GET["s"])){
$nr_query = "SELECT COUNT(*) FROM user_wall where message like '%".$_GET["s"]."%'";
$pagi_url = $admin_link.'walls.php?s='.$_GET["s"].'&page=';
$order = "WHERE message like '%".$_GET["s"]."%' order by user_wall.u_id DESC";
} else {
$nr_query = "SELECT COUNT(*) FROM user_wall";
$order = "order by  user_wall.u_id  DESC";
$pagi_url = $admin_link.'walls.php?page=';
}
$pagi_current=$pagi_url.$pageNumber;
$result = mysql_query($nr_query);
$numberofresults = mysql_result($result, 0);
$BrowsePerPage = 20;
?>
<div class="widget" style="width:100%; min-width:700px;">
                <div class="title"><img src="img/icons/pencil.png" alt="" class="titleIcon" /><h6>Statuses (<?php echo $numberofresults; ?>)</h6></div>

                    <ul class="partners">

                <?php
$limit = 'LIMIT ' .($pageNumber - 1) * $BrowsePerPage .',' .$BrowsePerPage; 
$os    = dbquery("SELECT DISTINCT user_wall . * , users.id,users.display_name, users.avatar
FROM user_wall
LEFT JOIN users ON user_wall.u_id = users.id ".$order ." ".$limit."");

while($rrow = mysql_fetch_array($os)){
$my_u_url = $site_url.'user/'.$rrow['id'].'/'.seo_clean_url($rrow['display_name']) .'/';
if(!empty($rrow['avatar'])):
$avatar = $rrow['avatar'];
else:
$avatar = $site_url.'tpl/images/light/no_image.jpg';
endif;
$part = "status/".$rrow['msg_id'];
$url =$site_url.$part;

?>
<li>
<a href="<?php echo $my_u_url;?>" title="" class="floatL"><img src="<?php echo $site_url.'com/timthumb.php?src='.$avatar.'&h=36&w=37&crop&q=100';?>" alt="" /></a>
<div class="pInfo">
<a href="<?php echo $my_u_url;?>" title=""><strong><?php echo $rrow['display_name'];?></strong></a>
<i><?php echo twitterify(stripslashes($rrow['message']));?> </i>	
 </div>
 <div class="pLinks">
<a href="<?php echo $url; ?>" title="View comments" class="tipW" target="_blank"><i class="icon-comment"></i></a>
<a href="<?php echo $pagi_current; ?>&delete=<?php echo $rrow['msg_id']; ?>" title="Remove" class="tipW"><i class="icon-trash"></i></a>
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