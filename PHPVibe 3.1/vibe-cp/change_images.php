<?php include_once("header.php");

if(isset( $_GET['change']) && isset($_GET['s']))	{
$change = $_GET['change'];
if($change == "thumbs"):
$sql = dbquery("update videos set thumb = replace(thumb, '".$_GET['s']."', '".$config->site->mediafolder."/".$config->site->thumbsfolder."/')");
$msg = "Thumbs path updated";
elseif ($change == "pictures"):
$sql = dbquery("update user_wall set picture = replace(picture, '".$_GET['s']."', '".$config->site->mediafolder."/".$config->site->picsfolder."/')");
$msg = "Pictures path updated";
endif;

}
?>
	<div id="content">
<div class="box">
<div class="box-header"><h1>Image path changer </h1></div>
<div class="box-content">
<?php if (isset($msg)) {echo "<div class=\"hMsg hSuccess\">    <p>".$msg."<p></div>";} ?>
<p>If you have changed and moved the images from a folder to another. Use this function to change the linked thumbnails to the new folder (make sure you change the folder in config first)</p>
 <div class="searchWidget combined">
                    <form action="change_images.php?change=thumbs">
                        <input type="text" name="s" id="s" placeholder="Change video thumbs: Input old path"/>
						<select name="new"> <?php				
echo '			
<option value="'.$config->site->mediafolder."/".$config->site->thumbsfolder.'/'.'" />'.$config->site->mediafolder."/".$config->site->thumbsfolder.'/'.' </option>';		
 ?>			
	</select>
	 <input type="hidden" value="thumbs" name="change"/>
                        <input type="submit" value="" />
                    </form>
                </div>
	 <div class="searchWidget combined">
                    <form action="change_images.php">
                        <input type="text" name="s" id="s" placeholder="Change uploaded images: Input old path"/>
						<select name="new"> <?php				

echo '			
<option value="'.$config->site->mediafolder."/".$config->site->picsfolder.'/'.'" />'.$config->site->mediafolder."/".$config->site->picsfolder.'/'.' </option>';		
 ?>			
	</select>
	 <input type="hidden" value="pictures" name="change"/>
                        <input type="submit" value="" />
                    </form>
                </div>					
		
	
</div>


<br style="clear:both;">

		
	
</div>	

	</div>
	
<?php include_once("footer.php");?>