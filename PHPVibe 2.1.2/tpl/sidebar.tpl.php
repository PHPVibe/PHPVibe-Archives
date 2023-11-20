<div class="page_sidebox box_alignfull">
<!-- BEGIN WIDGET -->	

<div class="follow_us">
<div class="follow_social">
           <div class="iconBox">
           <a href="<?php print $lang['tw-page-link']; ?>" target="_blank"><div class="twitter" title="<?php print $lang['tw-page-desc']; ?>"></div></a>
 <span>
 <div class="follow-text"><?php print $lang['tw-page-connect']; ?></div>

 </span>
 </div>
 <div class="iconBox">
<a href="<?php print $lang['fb-page-link']; ?>" target="_blank"><div class="facebook" title="<?php print $lang['fb-page-desc']; ?>"></div></a>
 <span>
<div class="follow-text"><?php print $lang['fb-page-connect']; ?></div>

 </span>
 </div>
<div class="iconBox">
 <a href="<?php print $site_url; ?>rss.php" target="_blank"><div class="feedburner" title="<?php print $lang['rss-page-desc']; ?>"></div></a>
 <span>
<div class="follow-text"><?php print $lang['rss-page-connect']; ?></div>

 </span>
 </div>
</div>
</div>

<h2 class="title-line"><?php print $lang['channels']; ?></h2>
		
	<?php
	 //channels box
$channel_query = "select picture,yt_slug,cat_name, cat_desc from channels order by cat_id DESC";
$oc = mysql_query($channel_query) or die(mysql_error());
while($rrow = mysql_fetch_array($oc)){
 
	$cat_url = $site_url.'channel/'.$rrow['yt_slug'].'/';
	
		if($picture = $rrow['picture'])
		{
		$chlistnew.= '<div class="social-box">';
		
			$chlistnew.= '<a href="'.$cat_url.'" title = "'.$rrow['cat_name'].' : '.$rrow['cat_desc'].'"><img  src="'.$site_url.'com/timthumb.php?src='.$picture.'&h=48&w=48&crop&q=100" alt = "'.$rrow['cat_name'].'"/></a>';
		$chlistnew.= '<div class="social-box-text">
				<span class="social-arrow"></span>
				<span class="social-box-descrip"><a href="'.$cat_url.'" title = "'.$rrow['cat_name'].' : '.$rrow['cat_desc'].'">'.$rrow['cat_name'].'</a></span>
				<span class="social-box-count">'.$rrow['cat_desc'].'</span>
				</div>';
		
		$chlistnew.= 	'</div>';
		}
		
	}
	
	print $chlistnew;
	

	?>
<center><?php echo $side_ads; ?><br /></center>
<h2 class="title-line"><?php print $lang['playlists']; ?></h2>
<?php
$playlist_result = dbquery("SELECT picture,title,id,description FROM `playlists` where videos IS NOT NULL order by id DESC limit 0,12");
while($rrow = mysql_fetch_array($playlist_result)){
 if (!empty($rrow['permalink'])) :
	$p_url = $site_url.'playlist/'.$rrow['id'].'/'.seo_clean_url($rrow['permalink']).'/';
 else : 	
 $p_url = $site_url.'playlist/'.$rrow['id'].'/'.seo_clean_url($rrow['title']).'/';
 endif;


	$playlists_output.= '<div class="social-box"><a href="'.$p_url.'"  title="'.$rrow['title'].'">

</a><img src="'.$site_url.'com/timthumb.php?src='.$rrow['picture'].'&h=48&w=48&crop&q=100" alt="'.$rrow['title'].'"/>
<div class="social-box-text">
				<span class="social-arrow"></span>
				<span class="social-box-descrip">
<a href="'.$p_url.'" rel="bookmark" title="'.$rrow['title'].'">'.$rrow['title'].'</a></span>
<span class="social-box-count">'.$rrow['description'].'</span></div></div>
';
	$iup++;	
	}
	
print $playlists_output;
?>
<h2 class="title-line"><?php print $lang['members']; ?></h2>
<?php
 //users box start
$qqquery = "select display_name,id,avatar,lastlogin from users where avatar !=\"\" order by rand() limit 0,8";
$os = mysql_query($qqquery) or die(mysql_error());

while($userrow = mysql_fetch_array($os)){
 
	$my_u_url = $site_url.'user/'.$userrow['id'].'/'.seo_clean_url($userrow['display_name']) .'/';
		
		if($avatar = $userrow['avatar'])
		{
		$userlistnew.= '<div class="social-box">';
		$userlistnew.= '<a href="'.$my_u_url.'"  title = "'.$userrow['display_name'].'" ><img src="'.$site_url.'com/timthumb.php?src='.$avatar.'&h=48&w=48&crop&q=100" alt = "'.$userrow['display_name'].'"/></a>';

		$userlistnew.= '<div class="social-box-text">
				<span class="social-arrow"></span>
				<span class="social-box-descrip"><a href="'.$my_u_url.'"  title = "'.$userrow['display_name'].'" >'.$userrow['display_name'].'</a></span>';
		$userlistnew.= '<span class="social-box-count">Last on : '.$userrow['lastlogin'].'</span></div></div>';
		}
		
	}
	
	print $userlistnew;
	

	?>

</div>
<!-- end pv-sidebox -->