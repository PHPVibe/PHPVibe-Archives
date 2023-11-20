    <!-- Main Content -->
    <section id="wrapper">		
    	<!-- Featured -->

		<br />
		               <div class="pager-description">

                    <p class="title"><?php echo ucfirst($Info->Get("list")); ?> Members</p>
                    <span class="accent-line goright"></span>
                
               
                </div>
		<br/>
<div id="box-filter">
    			<ul>
    				<li class="active"><a href="<?php print $config->site->url; ?>members/newest/" class="all">Newest Members</a></li>
					<li><a href="<?php print $config->site->url; ?>members/oldest/" class="logo">Oldest Members</a></li>
                 </ul>
					</div>
 
 <div id="channel-boxes">
 <?php
$limit = 'LIMIT ' .($pageNumber - 1) * $BrowsePerPage .',' .$BrowsePerPage; 
$qqquery = "select display_name,id,avatar from users ".$order." ".$limit;
$os = mysql_query($qqquery) or die(mysql_error());
while($rrow = mysql_fetch_array($os)){
$my_u_url = $site_url.'user/'.$rrow['id'].'/'.seo_clean_url($rrow['display_name']) .'/';
if(!empty($rrow['avatar'])):
$avatar = $rrow['avatar'];
else:
$avatar = $site_url.'tpl/images/light/no_image.jpg';
endif;
?>
 <div class="channel-box">
<div class="overflow-hidden"><a href="<?php echo $my_u_url;?>"  title="<?php echo $rrow['display_name'];?>">
<span class="channel-box-hover"><span class="hover-link"></span></span>
</a><img src="<?php echo $site_url.'com/timthumb.php?src='.$avatar.'&h=150&w=220&crop&q=100';?>" alt="<?php echo $rrow['display_name'];?>"/>
</div>
<div class="box-body">
<h2 class="box-title"><a href="<?php echo $my_u_url;?>" rel="bookmark" title="<?php echo $rrow['display_name'];?>"><?php echo $rrow['display_name'];?></a></h2>
</div>
</div>
<?php } ?>	


 </div>
 

	
	
    <div class="clear"></div>			
<?php
$a->show_pages($pagi_url);
?>		
