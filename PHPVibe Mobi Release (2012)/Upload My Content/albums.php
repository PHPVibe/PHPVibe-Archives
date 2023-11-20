<?php require_once('settings.php'); 
$page="album";
if(isset($_GET['album'])) { 
$title = $lang['pictures']." : ".str_replace("-", " " ,$_GET['album']);
} else {
$title = $lang['allalbums'];
}
require_once('tpl/header.php'); 
?>
 <!-- start page -->
    <div class="page">
    <div class="bredcrumbs">
					<ul>
						<li><a href="<?php echo $site_url;?>"><?php echo $small_title; ?></a></li>
						<li><a href="<?php echo $site_url;?>albums.php"><?php echo  $lang['allalbums'];?></a></li>
						<?php if(isset($_GET['album'])) { ?>
						<li><a href="<?php echo $site_url;?>albums.php?album=<?php echo $_GET['album']; ?>"><?php echo str_replace("-", " " ,$_GET['album']);?></a></li>
						<?php }?>
						
						
					</ul>
					<div class="clearfix"></div>
				</div>	
<?php
if(!isset($_GET['album'])){
echo ' 
<div class="phpvibe-box">
<div class="box-head-light"><h3>'.$lang['allalbums'].'</h3></div>
<div class="box-content">
<ul class="listcontent">
';
	$files = array_slice(scandir('albums'), 2);
	if(count($files)){
		natcasesort($files);
		foreach($files as $file){
			if($file != '.' && $file != '..'){
				echo '<li><a href="'.$site_url.'albums.php?album='.$file.'"><img src="img/bigicons/photos.png" width="23" height="23" alt="icon" class="m-icon"/><b>'.str_replace("-", " " ,$file).'</b></a></li>';
			}
		}
	}
echo '</ul></div></div>';	
} else {
		$album	= $_GET['album'];
echo ' 
<div class="phpvibe-box">
<div class="box-head-light"><h3>'.str_replace("-", " " ,$album).'</h3></div>
<div class="box-content">
<ul id="Gallery" class="gallery">
';

	

	if(file_exists('albums/'.$album)){
		$files = array_slice(scandir('albums/'.$album), 2);
		if(count($files)){
			foreach($files as $file){
							
				echo '<li><a href="'.$site_url.'albums/'.$album.'/'.$file.'"><img src="'.$site_url.'thumb.php?src=/albums/'.$album.'/'.$file.'&h=100&w=100&crop&q=100" alt="'.$file.'"/></a></li>';
				
				}
			}
		}
	}
echo ' </ul></div></div>';	
?>
<script type="text/javascript">
$(document).ready(function(){

	var myPhotoSwipe = $("#Gallery a").photoSwipe({ enableMouseWheel: false , enableKeyboard: false });

});
</script>
<?php
require_once('tpl/footer.php'); 	
?>
