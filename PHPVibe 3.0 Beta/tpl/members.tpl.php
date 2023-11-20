<?php include("sidebar.tpl.php"); 
 echo '<div class="main"><div class="phpvibe-box">
<div class="box-head-light"><h3>'.stripslashes($seo_title).' | <a href="'.$config->site->url.'members/newest/" class="all">Newest Members</a> | <a href="'.$config->site->url,'members/oldest/" >Oldest Members</a></h3></div>
<div class="box-content">';
echo '<div class="viboxes">
<ul>';
$limit = 'LIMIT ' .($pageNumber - 1) * $BrowsePerPage .',' .$BrowsePerPage; 
$qqquery = "select display_name,id,avatar from users ".$order." ".$limit;
$os = mysql_query($qqquery) or die(mysql_error());
while($rrow = mysql_fetch_array($os)){
$my_u_url = $site_url.'user/'.$rrow['id'].'/'.seo_clean_url($rrow['display_name']) .'/';
if(!empty($rrow['avatar'])):
$avatar = $rrow['avatar'];
else:
$avatar = $site_url.'tpl/images/no_image.jpg';
endif;
$full_title = $rrow['display_name'];
	echo '<li>
      <div class="content">	
	 <div class="vibox-thumb">
<a href="'.$my_u_url.'" title="'.$full_title.'"><img src="'.$site_url.'com/timthumb.php?src='.$avatar.'&h=150&w=220&crop&q=100" alt="'.$full_title.'" class="vibox-img"/></a>
 </div>
<div class="pluswrap">
 <div class="topline"><a href="'.$my_u_url.'" title="'.$full_title.'">'.$full_title.'</a></div>
</div>
</div>
	
</li>';
} ?>	


 </div>
 

	
	
    <div class="clear"></div>			
<?php
$a->show_pages($pagi_url);
?>		
