<?php
if(isset($_GET['del-ad'])) {
$db->query("DELETE from ".DB_PREFIX."ads where ad_id = '".intval($_GET['del-ad'])."' ");
echo '<div class="msg-info">Page deleted</div>';
} 
$menux = array("0" => "Normal","1" => "Video overlay" );
$count = $db->get_row("Select count(*) as nr from ".DB_PREFIX."ads ");
$ads = $db->get_results("select * from ".DB_PREFIX."ads ORDER BY ".DB_PREFIX."ads.ad_id DESC ".this_limit()."");

?>
<div class="row-fluid">
<h3>Ads</h3>				
</div>
<?php
if($ads) {
$ps = admin_url('ads').'&p=';
$a = new pagination;	
$a->set_current(this_page());
$a->set_first_page(true);
$a->set_pages_items(7);
$a->set_per_page(bpp());
$a->set_values($count->nr);

?><div class="table-overflow top10">
                        <table class="table table-bordered table-checks">
                          <thead>
                              <tr>
                                  <th>Ad</th>
                                  <th>Spot</th>
							      <th>Type</th>
								  <th>Spot call code</th>
								   <th>Options</th>
                                  </tr>
                          </thead>
                          <tbody>
						  <?php foreach ($ads as $ad) { ?>
                              <tr>
                                  <td><?php echo _html($ad->ad_title); ?></td>
								   <td><?php echo _html($ad->ad_spot); ?></td>								
                                  <td><?php echo $menux[$ad->ad_type]; ?></td>
								  <td>
								  <?php
								  if($ad->ad_type == 0) {
								  echo "<pre>_ad('".$ad->ad_type."','".$ad->ad_spot."')</pre>";
								  } else {
								   echo "<pre>_ad('".$ad->ad_type."')</pre>";
								  }
								  ?>
								  </td>
								  <td>
								  <div class="btn-group">
								  <a class="btn btn-danger tipS" href="<?php echo $ps;?>&del-ad=<?php echo $ad->ad_id;?>" title="Delete"><i class="icon-trash" style=""></i></a>
                                 </div>
								</td>
                              </tr>
							   <?php } ?>
						</tbody>  
</table>
</div>						

<?php  $a->show_pages($ps);
}else {
echo '<div class="msg-note">Nothing here yet.</div>';
}

 ?>