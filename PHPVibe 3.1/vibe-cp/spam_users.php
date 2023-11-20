<?php include_once("header.php");
$pageNumber = MK_Request::getQuery('page', 1);	
 if(isset($_GET['delete'])){ 
	 $del = dbquery("DELETE from users WHERE id = '".$_GET['delete']."'");
	  $del2 = dbquery("DELETE from users_meta WHERE user = '".$_GET['delete']."'");
	$message= 'Deleted user # '.$_GET['delete'];
	 }
 if(isset($_GET['deleteall'])){ 
	$vbox_result=mysql_query("SELECT DISTINCT user FROM  `users_meta` WHERE  `value` LIKE  '%[url=%' or `value` LIKE  '%ANTISPAM%' LIMIT 0 , 30000000");
while($group = mysql_fetch_array($vbox_result))
{
 $del = dbquery("DELETE from users WHERE id = '".$group["user"]."'");
	  $del2 = dbquery("DELETE from users_meta WHERE user = '".$group["user"]."'");
	$message= 'Deleted all spam';
	}
 }
?>
	<div id="content">
<div class="box">
<div class="box-header"><h1>A custom algorithm which searches for links BB code to select posible spam users</h1></div>
<div class="box-content">
<p>  <a href="spam_users.php?deleteall=true" title="" class="button redB" style="float:right;margin: 5px;"><span>Delete all</span></a></p>
<div class="widget" style="width:100%; min-width:700px;">
                <div class="title"><img src="img/icons/users.png" alt="" class="titleIcon" /><h6>Members which seem spam</h6></div>

                    <ul class="partners">

                <?php
$os =mysql_query("SELECT DISTINCT  users_meta.user , users.id, users.display_name, users.avatar, users.email, users.lastlogin
FROM users_meta
LEFT JOIN users ON users_meta.user = users.id
WHERE users_meta.value LIKE  '%[url=%'
OR  `value` LIKE  '%ANTISPAM%'
LIMIT 0 , 30000000");

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
<a href="<?php echo admin_panel(); ?>spam_users.php?&delete=<?php echo $rrow['id']; ?>" title="Remove" class="tipW"><i class="icon-trash"></i></a>
 </div>
<div class="clear"></div>
 </li>
  <?php }  ?>
 </ul>
 </div>

</div>
</div>


<br style="clear:both;">
</div>	

	</div>
	
<?php include_once("footer.php");?>