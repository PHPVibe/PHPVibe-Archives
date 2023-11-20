<div id="home-content" class="main-holder pad-holder span8 top10">

<?php 

$options = DB_PREFIX."videos.id,".DB_PREFIX."videos.title,".DB_PREFIX."videos.media,".DB_PREFIX."videos.user_id,".DB_PREFIX."videos.thumb,".DB_PREFIX."videos.views,".DB_PREFIX."videos.liked,".DB_PREFIX."videos.duration,".DB_PREFIX."videos.nsfw";
if(is_ajax_call()) {
$boxes = $db->get_results("SELECT * FROM ".DB_PREFIX."homepage ORDER BY `ord` DESC limit 0,1");
} else {
$boxes = $db->get_results("SELECT * FROM ".DB_PREFIX."homepage ORDER BY `ord`,`id` ASC");
}
if ($boxes) {
$bnr = $db->num_rows;
$i= 1;
foreach ($boxes as $box) {
$query = $box->querystring;
$c_add="";
$limit =  $box->total;
$heading = $box->title;
if(!empty($box->ident)){ $c_add .="AND category = '".intval($box->ident)."'"; }
if(!empty($box->mtype) && ($box->mtype > 0)){ $c_add .="AND media = '".intval($box->mtype)."'"; }
if($query == "most_viewed"):
$vq = "select ".$options.", ".DB_PREFIX."users.name as owner FROM ".DB_PREFIX."videos LEFT JOIN ".DB_PREFIX."users ON ".DB_PREFIX."videos.user_id = ".DB_PREFIX."users.id WHERE ".DB_PREFIX."videos.views > 0 and pub > 0 $c_add ORDER BY ".DB_PREFIX."videos.views DESC ".this_offset($limit);
elseif($query == "top_rated"):
$vq = "select ".$options.", ".DB_PREFIX."users.name as owner FROM ".DB_PREFIX."videos LEFT JOIN ".DB_PREFIX."users ON ".DB_PREFIX."videos.user_id = ".DB_PREFIX."users.id WHERE ".DB_PREFIX."videos.liked > 0 and pub > 0 $c_add ORDER BY ".DB_PREFIX."videos.liked DESC ".this_offset($limit);
elseif($query == "random"):
$vq = "select ".$options.", ".DB_PREFIX."users.name as owner FROM ".DB_PREFIX."videos LEFT JOIN ".DB_PREFIX."users ON ".DB_PREFIX."videos.user_id = ".DB_PREFIX."users.id WHERE ".DB_PREFIX."videos.views >= 0 and pub > 0 $c_add ORDER BY rand() ".this_offset($limit);
elseif($query == "featured"):
$vq = "select ".$options.", ".DB_PREFIX."users.name as owner FROM ".DB_PREFIX."videos LEFT JOIN ".DB_PREFIX."users ON ".DB_PREFIX."videos.user_id = ".DB_PREFIX."users.id WHERE ".DB_PREFIX."videos.featured = '1' and pub > 0 $c_add ORDER BY ".DB_PREFIX."videos.id DESC ".this_offset($limit);
else:
$vq = "select ".$options.", ".DB_PREFIX."users.name as owner FROM ".DB_PREFIX."videos LEFT JOIN ".DB_PREFIX."users ON ".DB_PREFIX."videos.user_id = ".DB_PREFIX."users.id WHERE ".DB_PREFIX."videos.views >= 0 and pub > 0 $c_add ORDER BY ".DB_PREFIX."videos.id DESC ".this_offset($limit);
endif;
if($i < $bnr) { $kill_infinite = true; } else { $kill_infinite = false; }
include(TPL.'/video-loop.php');
$i++;
}
} else {
echo _lang('No homeblocks defined by administrator.');
}
?>
</div>
<?php if (!is_ajax_call()) { right_sidebar();  } ?>