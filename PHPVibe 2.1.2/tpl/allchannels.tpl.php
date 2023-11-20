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
 <div id="channel-boxes">
<?php


$nr_query = "SELECT COUNT(*) FROM channels";
$result = mysql_query($nr_query);
$numberofresults = mysql_result($result, 0);
$BrowsePerPage = 24;

$limit = 'LIMIT ' .($pageNumber - 1) * $BrowsePerPage .',' .$BrowsePerPage; 
$result=mysql_query("select picture,yt_slug,cat_name from channels order by cat_id DESC $limit");
while($rrow = mysql_fetch_array($result)){
 
	$cat_url = $site_url.'channel/'.$rrow['yt_slug'].'/';
	$channels_output.= ' <div class="channel-box">';
	$channels_output.= '<div class="overflow-hidden"><a href="'.$cat_url.'"  title="'.$rrow['cat_name'].'">
<span class="channel-box-hover"><span class="hover-video"></span></span>
</a><img src="'.$site_url.'com/timthumb.php?src='.$rrow['picture'].'&h=150&w=220&crop&q=100" alt="'.$rrow['cat_name'].'"/>
</div>
<div class="box-body">
<h2 class="box-title"><a href="<?php echo $cat_url;?>" rel="bookmark" title="'.$rrow['cat_name'].'">'.$rrow['cat_name'].'</a></h2>
</div>
</div>';
		
	}
	
	print $channels_output;
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
