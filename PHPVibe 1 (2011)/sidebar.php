<div class="col col4 col-last">
<div class="sidecol-bkg">
<div class="sidebare">

<div class="sidebare-content">
<div class="slashc-two-tier-menu clearfix">	
<ul>	
		<li>			
				<a href="#"><span><?php echo __("Channels");?></span></a>	
		<ul>
<?php 
$csql = dbquery("SELECT cat_id, cat_name FROM `channels` LIMIT 0, 300 ");
while($row = mysql_fetch_array($csql)){
$category =  $row["cat_name"];
$catid =  $row["cat_id"];
?>

<li><a href="<?php print $config->site->url; ?>category/<?php echo $catid; ?>/<?php echo seo_clean_url($category); ?>/"><?php echo $category; ?></a></li>

<?php
}


 ?>		
		</ul>	
	</li>	
	
			<li>			
				<a href="#"><span><?php echo __("Most searched");?></span></a>	
		<ul>
 <?php TagCloud(20) ?>
		</ul>	
	</li>
	<li>			
				<a href="#"><span><?php echo __("Tags");?></span></a>	
		<ul>
 <?php VideoTagCloud(2) ?>
		</ul>	
	</li>
		</ul>
		
	</div>
 </div> 
  </div>
      <div class="sidebare clearfix">
         <div class="header clearfix">
           <h4 class="button black icon clapboard rounded"><?php echo __("Trending Videos");?></h4>
         </div>
<div class="sidekeep clearfix">

<ul class="clearfix">
<?php 
$trending = $cur_user_lang.'_trending';
 if(!$vtrend = $Cache->Load("$trending")){
$vtrend = '';			 
$sql = dbquery("SELECT id,youtube_id,title,views,duration,liked FROM videos WHERE views > 5 ORDER BY id DESC LIMIT 0,18 ");
while($row = mysql_fetch_array($sql)){
	$new_id = $row["id"];	
	$new_yt = $row["youtube_id"];
	$new_title = $row["title"];
	$small_title = substr($new_title, 0, 50);  
	$new_seo_url = $site_url.'video/'.$new_id.'/'.seo_clean_url($new_title) .'/';	
	$new_views = $row["views"];
	$new_duration = $row["duration"];
	$new_liked = $row["liked"];
	
	
  $vtrend .='
<li class="clearfix">
<div class="thumb clearfix">
<a href="'.$new_seo_url.'"><img src="'.Get_Thumb($new_yt).'"  width="122" height="84" alt="'.$new_title.'" />
<span class="time">'.sec2hms($new_duration).'</span>
</a>
</div>
<div class="description clearfix">
<p><a href="'.$new_seo_url.'"> '.$small_title.'...</a></p>
<p class="viewcounts">'.$new_views.'  '.__("views").'</p>
<p class="stat">'.__("Liked by").' '.$new_liked.' '.__("persons").'</p> 
</div>
</li>';

}
 $Cache->Save($vtrend, "$trending");
}
echo $vtrend;
?>
</ul> 	
</div>
</div>


 </div>
        </div>
      
    </div>
    
    </div>