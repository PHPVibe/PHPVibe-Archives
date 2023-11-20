<?php //echo $vq;
$activity = $db->get_results($vq);
if ($activity) {
$did =  array();
echo '<div class="loop-activities">
<ul id="activity">
'; 
foreach ($activity as $buzz) {
$did = get_activity($buzz);	
echo '
<li>
<div class="circleAvatar"><img src="'.thumb_fix($profile->avatar).'" alt="'.stripslashes($profile->name).'"></div>
<p class="headLine">
<span class="author">'.stripslashes($profile->name).'</span>                                                   
<span><span class="'.$did["class"].'">'.$did["what"].'</span></span>
<span class="pull-right"><i class="icon-check"></i> '.time_ago($buzz->date).'</span>                                                    
 </p>
<p>'.$did["content"].'</p>
</li>';
unset($did);
}
echo '<ul><br style="clear:both;"/></div>';
}
?>