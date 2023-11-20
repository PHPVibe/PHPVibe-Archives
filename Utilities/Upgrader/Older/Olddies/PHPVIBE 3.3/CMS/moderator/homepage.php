<?php
 if(isset($_GET['delete'])){ 
    $db->query("DELETE from ".DB_PREFIX."homepage WHERE id = '".intval($_GET['delete'])."'");
	echo '<div class="msg-info">You deleted the home box with id : '.$_GET['delete'].'</div>';
	 }
if(isset($_POST['queries'])){ 
$insertvideo = $db->query("INSERT INTO ".DB_PREFIX."homepage (`title`, `type`, `ident`, `querystring`, `total`, `order` ) VALUES ('".toDb($_POST['title'])."', '2', '".toDb($_POST['ident'])."', '".toDb($_POST['queries'])."', '".toDb($_POST['number'])."', '1')");		
}

?>
<div class="row-fluid">

<div class="box-element span6">
					<div class="box-head-light"><i class="icon-plus"></i><h3>Create a block</h3></div>
					<div class="box-content">
<form id="validate" class="form-horizontal styled" action="<?php echo admin_url('homepage'); ?>" enctype="multipart/form-data" method="post">
		
	<div class="control-group">
	<label class="control-label">Block title</label>
	<div class="controls">
	<input type="text" id="title" name="title" class="span12" value="">
	</div>
	</div>	
	<div class="control-group">
	<label class="control-label">Videos limit</label>
	<div class="controls">
	<input type="text" id="number" name="number" class="span4 validate[required]" value="24">
	<span class="help-block" id="limit-text">Number of videos per block. If you have 1 block, it will be the number of videos to load per scroll.</span>
	</div>
	</div>	
	<div class="control-group">
	<label class="control-label">Video query:</label>
	<div class="controls">
	<select data-placeholder="Select type" name="queries" id="queris" class="select validate[required]" tabindex="2">
	<option value="most_viewed" selected>Most viewed videos</option>
<option value="top_rated">Most liked videos</option>
<option value="viral">New videos </option>
<option value="featured">Featured videos</option>
<option value="random">Random videos</option>

	</select>

	</div>
	</div>	
<?php echo '
<div class="control-group">
	<label class="control-label">'._lang("Category:").'</label>
	<div class="controls">
	<select data-placeholder="'._lang("Choose a category:").'" name="ident" id="ident clear-results" class="select" tabindex="2">
	';
$categories = $db->get_results("SELECT cat_id as id, cat_name as name FROM  ".DB_PREFIX."channels order by cat_name asc limit 0,10000");
if($categories) {
foreach ($categories as $cat) {	
echo '<option value="'.intval($cat->id).'">'.stripslashes($cat->name).'</option>';
}
}  echo '<option value="" selected>-- None --</option>'; 
echo '	  
	  </select>
	  	<span class="help-block" id="limit-text"> Optional: Restrict video in block to a category.</span>
	  </div>             
	  </div>
';
?>	
 <div class="box-bottom clearfix"> <button class="btn btn-primary btn-mini pull-right">Add block</button>  </div>

</form>
</div>

				</div>
<div class="box-element span6">	
<div class="box-head-light"><i class="icon-list-ol"></i><h3>Blocks</h3></div>
					<div class="box-content">	
	 <div id="easyhome">
                    <ul id="sortable" class="droptrue">

                <?php
$boxes_sql = $db->get_results("SELECT * FROM ".DB_PREFIX."homepage order by `order` ASC limit 0,1000000");
if($boxes_sql) {
foreach($boxes_sql as $box){ 
?>
<li id="recordsArray_<?php echo $box->id;?>" class="sortable clearfix">
<div class="ns-row pull-left"><div class="ns-title"><i class="icon-sort" style="margin-right:8px;"></i><?php echo stripslashes($box->title);?></div>
<a href="<?php echo admin_url('homepage'); ?>&delete=<?php echo $box->id; ?>" class="delete-menu pull-right" title="Delete"><i class="icon-trash"></i></a></div>
 </li>
  <?php }
}  ?>
 </ul>
</div>	
<div id="respo" style="display:none;"></div>	
				</div>	
</div>				
<?php //End ?>