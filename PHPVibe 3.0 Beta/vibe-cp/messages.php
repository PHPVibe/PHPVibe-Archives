<?php include_once("header.php");
$pageNumber = MK_Request::getQuery('page', 1);	
 if(isset($_GET['delete'])){ 
	 $del = dbquery("DELETE from  users_messages WHERE id	 = '".$_GET['delete']."'");
	
	$message= 'Deleted comment # '.$_GET['delete'];
	 }

?>
	<div id="content">
<div class="box">
<div class="box-header"><h1>Private messages </h1></div>
<div class="box-content">
 <div class="searchWidget">
                    <form action="messages.php">
                        <input type="text" name="s" id="s" placeholder="Search for messages" />
                        <input type="submit" value="" />
                    </form>
                </div>
<?php
if(isset($_GET["s"])){
$nr_query = "SELECT COUNT(*) FROM  users_messages where message like '%".$_GET["s"]."%'";
$pagi_url = $admin_link.'messages.php?s='.$_GET["s"].'&page=';
$order = "WHERE message like '%".$_GET["s"]."%' order by  users_messages.sender DESC";
} else {
$nr_query = "SELECT COUNT(*) FROM  users_messages";
$order = "order by   users_messages.sender  DESC";
$pagi_url = $admin_link.'messages.php?page=';
}
$pagi_current=$pagi_url.$pageNumber;
$result = mysql_query($nr_query);
$numberofresults = mysql_result($result, 0);
$BrowsePerPage = 20;
?>
<div class="widget" style="width:100%; min-width:700px;">
                <div class="title"><img src="img/icons/pencil.png" alt="" class="titleIcon" /><h6>Messages (<?php echo $numberofresults; ?>)</h6></div>

                    <ul class="partners">

                <?php
$limit = 'LIMIT ' .($pageNumber - 1) * $BrowsePerPage .',' .$BrowsePerPage; 
$os    = dbquery("SELECT DISTINCT  users_messages . * , users.display_name, users.avatar
FROM  users_messages
LEFT JOIN users ON  users_messages.sender = users.id ".$order ." ".$limit."");
$my_u_url = "#";
while($rrow = mysql_fetch_array($os)){
if(!empty($rrow['avatar'])):
$avatar = $rrow['avatar'];
else:
$avatar = $site_url.'tpl/images/light/no_image.jpg';
endif;

?>
<li>
<a href="<?php echo $my_u_url;?>" title="" class="floatL"><img src="<?php echo $site_url.'com/timthumb.php?src='.$avatar.'&h=36&w=37&crop&q=100';?>" alt="" /></a>
<div class="pInfo">
<a href="<?php echo $my_u_url;?>" title=""><strong><?php echo $rrow['display_name'];?></strong></a>
<i><?php echo twitterify(stripslashes($rrow['message']));?> </i>	
 </div>
 <div class="pLinks">
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