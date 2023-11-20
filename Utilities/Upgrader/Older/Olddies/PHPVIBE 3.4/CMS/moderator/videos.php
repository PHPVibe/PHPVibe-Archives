<?php
if(isset($_GET['delete-video'])) {
unpublish_video(intval($_GET['delete-video']));
} 
if(isset($_GET['feature-video'])) {
$id = intval($_GET['feature-video']);
if($id){
$db->query("UPDATE ".DB_PREFIX."videos set featured = '1' where id='".intval($id)."'");
echo '<div class="msg-info">Video #'.$id.' was featured.</div>';
}
} 
if(isset($_POST['checkRow'])) {
foreach ($_POST['checkRow'] as $del) {
unpublish_video(intval($del));
}
echo '<div class="msg-info">Videos #'.implode(',', $_POST['checkRow']).' unpublished.</div>';
}
if(isset($_GET['sort']) && ($_GET['sort'] == "featured") ) {
$count = $db->get_row("Select count(*) as nr from ".DB_PREFIX."videos where pub > 0 and featured > 0 ");
$videos = $db->get_results("select id,title,thumb, views, liked,featured, duration from ".DB_PREFIX."videos where pub > 0 and featured > 0 ORDER BY ".DB_PREFIX."videos.id DESC ".this_limit()."");

} else {
$count = $db->get_row("Select count(*) as nr from ".DB_PREFIX."videos where pub > 0 ");
$videos = $db->get_results("select id,title,thumb, views, liked,featured, duration from ".DB_PREFIX."videos where pub > 0 ORDER BY ".DB_PREFIX."videos.id DESC ".this_limit()."");
}
?>
<div class="row-fluid">
		    	<form class="search widget" action="" method="get" onsubmit="location.href='<?php echo admin_url('search-videos'); ?>&key=' + encodeURIComponent(this.key.value); return false;">
		    		<div class="autocomplete-append">			   
			    		<input type="text" name="key" placeholder="Search video..." id="key" />
			    		<input type="submit" class="btn btn-info" value="Search" />
			    	</div>
		    	</form>
<h3>Video management</h3>				
</div>
<?php
if($videos) {
if(isset($_GET['sort']) ) {
$ps = admin_url('videos').'&sort='.$_GET['sort'].'&p=';
} else {
$ps = admin_url('videos').'&p=';
}
$a = new pagination;	
$a->set_current(this_page());
$a->set_first_page(true);
$a->set_pages_items(7);
$a->set_per_page(bpp());
$a->set_values($count->nr);
$a->show_pages($ps);
?>
<form class="form-horizontal styled" action="<?php echo admin_url('videos');?>&p=<?php echo this_page();?>" enctype="multipart/form-data" method="post">

<div class="cleafix full"></div>
<fieldset>
<div class="table-overflow top10">
                        <table class="table table-bordered table-checks">
                          <thead>
                              <tr>
                                  <th><input type="checkbox" name="checkRows" class="styled check-all" /></th>
                                  <th width="130px"><?php echo _lang("Thumb"); ?></th>
                                  <th width="35%"><?php echo _lang("Video"); ?></th>
                                  <th><?php echo _lang("Duration"); ?></th>
                                  <th><?php echo _lang("Likes"); ?></th>
                                  <th><?php echo _lang("Views"); ?></th>
								  <th><button class="btn btn-large btn-danger" type="submit"><?php echo _lang("Unpublish selected"); ?></button></th>
                              </tr>
                          </thead>
                          <tbody>
						  <?php foreach ($videos as $video) { ?>
                              <tr>
                                  <td><input type="checkbox" name="checkRow[]" value="<?php echo $video->id; ?>" class="styled" /></td>
                                  <td><img src="<?php echo thumb_fix($video->thumb); ?>" style="width:130px; height:90px;"></td>
                                  <td><?php echo stripslashes($video->title); ?></td>
                                  <td><?php echo video_time($video->duration); ?></td>
                                  <td><?php echo stripslashes($video->liked); ?></td>
                                  <td><?php echo stripslashes($video->views); ?></td>
								  <td>
								  <p><a href="<?php echo admin_url('videos');?>&p=<?php echo this_page();?>&delete-video=<?php echo $video->id;?>"><i class="icon-trash" style="margin-right:5px;"></i><?php echo _lang("Unpublish"); ?></a></p>
								  <p><a href="<?php echo admin_url('edit-video');?>&vid=<?php echo $video->id;?>"><i class="icon-edit" style="margin-right:5px;"></i><?php echo _lang("Edit"); ?></a></p>
								  <?php if($video->featured < 1) { ?>
								  <p><a href="<?php echo admin_url('videos');?>&p=<?php echo this_page();?>&feature-video=<?php echo $video->id;?>"><i class="icon-star" style="margin-right:5px;"></i><?php echo _lang("Feature video"); ?></a></p>
								 <?php } else { ?>
								  <p><a href="<?php echo admin_url('videos');?>&p=<?php echo this_page();?>&feature-video=<?php echo $video->id;?>"><i class="icon-remove-sign" style="margin-right:5px;"></i><?php echo _lang("Unfeature video"); ?></a></p>
								 <?php } ?>
								 <p> <a target="_blank" href="<?php echo video_url($video->id, $video->title);?>"><i class="icon-check" style="margin-right:5px;"></i><?php echo _lang("View"); ?></a></p>
								  </td>
                              </tr>
							  <?php } ?>
						</tbody>  
</table>
</div>						
</fieldset>					
</form>
<?php  $a->show_pages($ps); 
}else {
echo '<div class="msg-note">Nothing here yet.</div>';
}

 ?>