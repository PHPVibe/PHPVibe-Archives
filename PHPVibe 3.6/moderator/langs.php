<?php
if(isset($_GET['delete-lang'])) {
$lang = $_GET['delete-lang'];
if($lang) {
delete_language($lang);
echo '<div class="msg-info">Language #'.$lang.' deleted.</div>';
} 
}
if(isset($_POST['checkRow'])) {
foreach ($_POST['checkRow'] as $del) {
if($del !== "en") {
delete_language($del);
} 
}
echo '<div class="msg-info">Languages #'.implode(',', $_POST['checkRow']).' deleted.</div>';
}

$count = $db->get_row("Select count(lang_code) as nr from ".DB_PREFIX."languages");
$langs = $db->get_results("select * from ".DB_PREFIX."languages order by lang_code ASC ".this_limit()."");
if($langs) {

$ps = admin_url('langs').'&p=';

$a = new pagination;	
$a->set_current(this_page());
$a->set_first_page(true);
$a->set_pages_items(7);
$a->set_per_page(bpp());
$a->set_values($count->nr);
$a->show_pages($ps);
?>
<form class="form-horizontal styled" action="<?php echo admin_url('langs');?>&p=<?php echo this_page();?>" enctype="multipart/form-data" method="post">
<h3>Languages management</h3>
<div class="cleafix full"></div>
<fieldset>
<div class="table-overflow top10">
                        <table class="table table-bordered table-checks">
                          <thead>
                              <tr>
                                  <th><input type="checkbox" name="checkRows" class="styled check-all" /></th>
                                 
                                  <th>Language</th>
								   
                                    <th>Code</th>                           
								  <th><button class="btn btn-large btn-danger" type="submit"><?php echo _lang("Delete selected"); ?></button></th>
                              </tr>
                          </thead>
                          <tbody>
						  <?php foreach ($langs as $language) { ?>
                              <tr>
                                  <td><input type="checkbox" name="checkRow[]" value="<?php echo $language->lang_code; ?>" class="styled" /></td>
                                 
                                  <td><strong><?php echo stripslashes($language->lang_name);?></strong>
								 <td><strong><?php echo stripslashes($language->lang_code); ?></strong>
								 
								  </td>
								  
                                 <td>
								 
								  <p><a href="<?php echo admin_url('langs');?>&p=<?php echo this_page();?>&delete-lang=<?php echo $language->lang_code;?>"><i class="icon-trash" style="margin-right:5px;"></i><?php echo _lang("Delete"); ?></a></p>
								  <p><a href="<?php echo admin_url('edit-lang');?>&id=<?php echo $language->lang_code;?>"><i class="icon-edit" style="margin-right:5px;"></i><?php echo _lang("Edit"); ?></a></p>
								  
								  </td>
                              </tr>
							  <?php } ?>
						</tbody>  
</table>
</div>						
</fieldset>					
</form>

<?php  $a->show_pages($ps); } ?>
<div class="row-fluid" style="padding: 20px 0">
<a class="btn btn-large btn-success pull-right" href="<?php echo admin_url('create-lang');?>" >Create new</a>
</div>