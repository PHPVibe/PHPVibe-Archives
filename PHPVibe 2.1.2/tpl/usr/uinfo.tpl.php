<div class="box one">

 		<div class="header">

 			<h2><?php print $lang['aboutme']; ?></h2>

    <!--Toggle-->

    <span class="toggle"></span>

 		</div>

 		<div class="content padding">
		<div class="one">
		
<?php if( $about = $user_profile->getAbout() )
		{
			echo '<p>'.$about.'</p><br />';
		} 
		echo '<div class="one_half">';
if( $name = $user_profile->getName() )
		{
			echo '<p><strong>'.$lang['rname'].':</strong> ';
			echo $name.'</p>';
		}
		echo '<p><strong>'.$lang['dname'].' :</strong> ';
		echo $user_profile->getDisplayName().'</p>';
		echo '<p><strong>'.$lang['membersince'].' :</strong> ';
		echo $user_profile->renderDateRegistered().'</p>';
		
		if( $location = $user_profile->getNowCity() )
		{
			echo '<p><strong>'.$lang['ccity'].' :</strong> ';
			echo $location.'</p>';
		}
		if( $from_location = $user_profile->getFromCity() )
		{
			echo '<p><strong>'.$lang['fromcity'].' :</strong> ';
			echo $from_location.'</p>';
		}
		if( $gender = $user_profile->getGender() )
		{
			echo '<p><strong>'.$lang['gender'].' :</strong> ';
			echo $gender.'</p>';
		}
		if( $date_of_birth = $user_profile->getDateOfBirth() )
		{
			$date_of_birth = date($config->site->date_format, strtotime($date_of_birth));
			echo '<p><strong>'.$lang['birthdate'].' :</strong> ';
			echo $date_of_birth.'</p>';
		}		
		echo '<p><strong>'.$lang['laston'].' :</strong>
		'.$user_profile->renderLastlogin().'</p>';
		if( $rel = $user_profile->getRelation() )
		{
			echo '<p><strong>'.$lang['relation'].' :</strong> ';
			echo $rel.'</p>';
		}
		echo '</div><div class="one_half last">';
		if( $quote = $user_profile->getQuote() )
		{
			echo '<p><strong>'.$lang['favquote'].' :</strong> ';
			echo $quote.'</p>';
		}
		if( $music = $user_profile->getMusic() )
		{
			echo '<p><strong>'.$lang['favmusic'].' :</strong> ';
			//echo $music;
			$keywords_array = explode(', ', $music);
			foreach ($keywords_array as $keyword):
if ($keyword != ""):
$qterm = str_replace(" ", "+",$keyword);
$k_url = $site_url.'show/'.$qterm.'/';
echo "<a href='".$k_url."'>".$keyword."</a> , ";
endif;
endforeach;
echo '</p>';
		}
		if( $movies = $user_profile->getMovies() )
		{
			echo '<p><strong>'.$lang['favmovies'].' :</strong> ';
			//echo $movies;
			$keywords_array = explode(', ', $movies);
			foreach ($keywords_array as $keyword):
if ($keyword != ""):
$qterm = str_replace(" ", "+",$keyword);
$k_url = $site_url.'show/'.$qterm.'/';
echo "<a href='".$k_url."'>".$keyword."</a> , ";
endif;
endforeach;
			echo '</p>';
		}
		if( $tv = $user_profile->getTv() )
		{
			echo '<p><strong>'.$lang['favtv'].' :</strong> ';
			//echo $tv.'</p>';
			//echo $movies;
			$keywords_array = explode(', ', $tv);
			foreach ($keywords_array as $keyword):
if ($keyword != ""):
$qterm = str_replace(" ", "+",$keyword);
$k_url = $site_url.'show/'.$qterm.'/';
echo "<a href='".$k_url."'>".$keyword."</a> , ";
endif;
endforeach;
			echo '</p>';
		}
		echo '</div>';	
		
?>	
		</div>
		
		<div class="clear" style="height:15px;"/></div>
		<h2 class="title-line alignright"><?php echo $user_profile->getDisplayName(); ?> 's <?php print $lang['playlists']; ?></h2>
		<div class="clear" style="height:10px;"/></div>
		 <div id="channel-box">
		<?php
$playlist_result = dbquery("SELECT * FROM `playlists` where owner = '".$user_profile->getId()."' order by id DESC");
$iup = 1; 
while($rrow = mysql_fetch_array($playlist_result)){
 if (!empty($rrow['permalink'])) :
	$p_url = $site_url.'playlist/'.$rrow['id'].'/'.seo_clean_url($rrow['permalink']).'/';
 else : 	
 $p_url = $site_url.'playlist/'.$rrow['id'].'/'.seo_clean_url($rrow['title']).'/';
 endif;
 if (($iup % 3 == 0)) { $the_float ="last";} else { $the_float ="";}
	$playlists_output.= ' <div class="channel-box '.$the_float.'">';
	$playlists_output.= '<div class="overflow-hidden"><a href="'.$p_url.'"  title="'.$rrow['title'].'">
<span class="channel-box-hover"><span class="hover-video"></span></span>
</a><img src="'.$site_url.'com/timthumb.php?src='.$rrow['picture'].'&h=150&w=220&crop&q=100" alt="'.$rrow['title'].'"/>
</div>
<div class="box-body">
<h2 class="box-title"><a href="'.$p_url.'" rel="bookmark" title="'.$rrow['title'].'">'.$rrow['title'].'</a></h2>
</div>
</div>';
	$iup++;	
	}
	
	print $playlists_output;
 
 ?>

</div>
    </div>	
 