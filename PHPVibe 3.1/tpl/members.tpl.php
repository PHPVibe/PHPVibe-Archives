<?php include("sidebar.tpl.php"); 
 echo '<div class="main"><div class="box_title">
<h2>'.stripslashes($seo_title).' </h2> </div>
<div class="loop-actions">
<span class="orderby"> 
<a href="'.$config->site->url.'members/" class="views"><i>Last Online</i></a>
<span class="order-desc"></span>
<a href="'.$config->site->url,'members/registration/"class="likes"><i>Registration</i></a>
<span class="order-desc"></span>
</span>
</div><!-- end .loop-actions -->	
';

$limit = 'LIMIT ' .($pageNumber - 1) * $BrowsePerPage .',' .$BrowsePerPage; 
$usersq = "select * from users ".$order." ".$limit;
$qt = 0;
if ($result = $dbi->query($usersq, $qt)) {
echo '<div class="list-video" style="margin:20px 15px; width:auto;float:left;display:block;">';

	foreach ($result as $video) {
if(empty($video['avatar'])) {$video['avatar'] = $site_url.'tpl/images/userPic.png';}
			$title = stripslashes(substr($video["display_name"], 0, 109));
			$full_title = stripslashes(str_replace("\"", "",$video["display_name"]));			
			$url = $site_url.'user/'.$video['id'].'/'.seo_clean_url($video['display_name']) .'/';

			$numberofvideos = dbcount("*","videos","user_id = '".$video['id']."'");
		   $numberoflikes = dbcount("*","likes","uid = '".$video['id']."'");
		
echo '
<div id="video-'.$video["id"].'" class="video">
<div class="thumb">
		<a class="clip-link" data-id="'.$video["id"].'" title="'.$full_title.'" href="'.$url.'">
			<span class="clip">
				<img src="'.$video['avatar'].'" alt="'.$full_title.'" /><span class="vertical-align"></span>
			</span>
							
			
		</a>
		
	</div>	
	<div class="data">
			<h2 class="title"><a href="'.$url.'" title="'.$full_title.'">'.$title.'</a></h2>	
<p class="meta">
				<span class="author">Has shared '.$numberofvideos.' videos</span> |
				<span class="time">'.$numberoflikes.' videos liked</span>
			</p>			
			
			<div class="desc">Last seen '.time_ago($video["lastlogin"]).' <br /> Joined '.time_ago($video["date_registered"]).'</div></div>';
			echo '
		
	</div>
';
//unset
$numberofvideos = 0;
$numberoflikes = 0;

}
}

 ?>	


 </div>

    <div class="clear"></div>			
<?php
$a->show_pages($pagi_url);
?>		
