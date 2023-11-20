<?php //echo $vq;
$activity = $db->get_results($vq);
if ($activity) {
$did =  array();
echo '<div class="row-fluid">
<ul class="user-activity list-unstyled">
'; 
$licon = array();
$licon["1"] = "icon-heart";
$licon["2"] = "icon-share";
$licon["3"] = "icon-eye-open";
$licon["4"] = "icon-play";
$licon["5"] = "icon-rss";
$licon["6"] = "icon-comments";
$licon["7"] = "icon-thumbs-up";
foreach ($activity as $buzz) {
$did = get_activity($buzz);	
if(isset($did["content"]) && !nullval($did["content"])) {
echo '
<li class="cul-'.$buzz->type.'">
<i class="list-icon '.$licon[$buzz->type].'"></i>
<div class="block block-inline">
			<div class="caret"></div>
<div class="box-generic">
<div class="timeline-top-info">
<i class="icon-user"></i> <a href="'.profile_url($buzz->pid,$buzz->name).'">'._html($buzz->name).'</a> '.$did["what"].'
</div>			
<div class="media innerAll margin-none">
'.$did["content"].'
</div></div>
<div class="timeline-bottom innerT half">
				<i class="icon-calendar"></i> '.time_ago($buzz->date).'
			</div>
</div></li>';
unset($did);
}
}
echo '<ul><br style="clear:both;"/></div>';
}

?>