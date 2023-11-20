<?php the_sidebar(); ?>
<div id="profile-content" class="main-holder pad-holder span8 nomargin">
<h3 class="loop-heading"><span><?php echo $heading;?></span></h3>
<?php 
$posts = $db->get_results($vq);
if ($posts) {
?>
<div class="row-fluid">
<ul class="user-activity blog-list list-unstyled">
<?php foreach ($posts as $ar) {
echo '
<li>
<i class="list-icon icon-bookmark"></i>
<div class="block block-inline">
			<div class="caret"></div>
<div class="box-generic">
	
<div class="media innerAll margin-none">
<div class="media margin-none">
					<div class="row-fluid innerLR innerB">
						<div class="span4">
							
								<div class="text-center ">
										<a href="'.article_url($ar->pid, $ar->title).'" title="'._html($ar->title).'"><img src="'.thumb_fix($ar->pic, true, 200, 110).'"></a>
								</div>
							
						</div>
						<div class="span8">
							
								<a class="text-primary" href="'.article_url($ar->pid, $ar->title).'" title="'._html($ar->title).'"><h5 class="strong">'._html($ar->title).'</h5></a>
								<p>'._html(strip_tags(_cut($ar->content,360))).'...</p>
							
						</div>
					</div>
				</div>
</div></div>
</div></li>';

}
?>


</ul>

</div>

<?php
}

$a->show_pages($pagestructure);

?>
</div>
<div class="span2 nomargin popular-channels">
<?php $populars = $db->get_results("select * from ".DB_PREFIX."postcats order by cat_id DESC limit 0,10000");;
if($populars) {
echo '<h3>'._lang("Blog categories").'</h3>';
foreach ($populars as $popular) {
echo '
<div class="populars">
<a class="tipE pull-left" title="'.$popular->cat_name.'" href="'.bc_url($popular->cat_id , $popular->cat_name).'"><img src="'.thumb_fix($popular->picture).'" alt="'.$popular->cat_name.'" /></a>
<span class="pop-title"><a title="'.$popular->cat_name.'" href="'.bc_url($popular->cat_id , $popular->cat_name).'">'._cut(_html($popular->cat_name), 16).'</a></span>';
echo '
<div class="clearfix"></div>
</div>';
}
}
?>
</div>