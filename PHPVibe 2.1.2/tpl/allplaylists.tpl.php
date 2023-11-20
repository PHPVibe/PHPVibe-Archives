    <!-- Main Content -->
    <section id="wrapper">		
    	<!-- Featured -->

<br />
 <!--BEGIN .pager description -->
                <div class="pager-description">

                    <p class="title"><?php print $seo_title; ?></p>
                    <span class="accent-line goright"></span>
                
               
                </div>
				 <!--END .pager-description -->
<br />
<div class="one">
 <div id="channel-box">
<?php


$nr_query = "SELECT COUNT(*) FROM playlists";
$result = mysql_query($nr_query);
$numberofresults = mysql_result($result, 0);
$BrowsePerPage = 24;

$limit = 'LIMIT ' .($pageNumber - 1) * $BrowsePerPage .',' .$BrowsePerPage; 
$result=mysql_query("select * from playlists order by id DESC $limit");
while($rrow = mysql_fetch_array($result)){
 if (!empty($rrow['permalink'])) :
	$p_url = $site_url.'playlist/'.$rrow['id'].'/'.seo_clean_url($rrow['permalink']).'/';
 else : 	
 $p_url = $site_url.'playlist/'.$rrow['id'].'/'.seo_clean_url($rrow['title']).'/';
 endif;
 $vid_array = explode(',', $rrow['videos']);
 $playlist_count = count($vid_array);
  $playlist_count =  $playlist_count - 1; /* for some reason the first element is returned null but counted, so we use -1 */
	$playlists_output.= ' <div class="channel-box">';
	$playlists_output.= '<div class="overflow-hidden"><a href="'.$p_url.'"  title="'.$rrow['title'].'">
<span class="channel-box-hover"><span class="hover-video"></span></span>
</a><img src="'.$site_url.'com/timthumb.php?src='.$rrow['picture'].'&h=150&w=220&crop&q=100" alt="'.$rrow['title'].'"/>
</div>
<div class="box-body">
<h2 class="box-title"><a href="'.$p_url.'" rel="bookmark" title="'.$rrow['title'].'">'.$rrow['title'].'
</a> <span class="numbervids" >'.$playlist_count.'</span></h2>
</div>
</div>';
		
	}
	
	print $playlists_output;
?>

 

</div>
 


<?php
echo '<div class="clear"></div>';
$a = new pagination;	
$a->set_current($pageNumber);
$a->set_first_page(true);
$a->set_pages_items(12);
$a->set_per_page($BrowsePerPage);
$a->set_values($numberofresults);
$a->show_pages($pagi_url);
?>

</div>
