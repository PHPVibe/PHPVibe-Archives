<?php  //Global query options
$key = toDb(token());
$heading = ('Searching for ').$key;	
$heading_plus = ('Video search results for ').$key;
if(!nullval($key)) {	
$options = DB_PREFIX."videos.id,".DB_PREFIX."videos.title,".DB_PREFIX."videos.user_id,".DB_PREFIX."videos.thumb,".DB_PREFIX."videos.views,".DB_PREFIX."videos.liked,".DB_PREFIX."videos.duration,".DB_PREFIX."videos.nsfw";
       $vq = "select ".$options.", ".DB_PREFIX."users.name as owner FROM ".DB_PREFIX."videos LEFT JOIN ".DB_PREFIX."users ON ".DB_PREFIX."videos.user_id = ".DB_PREFIX."users.id 
	WHERE ".DB_PREFIX."videos.pub > 0 and ( ".DB_PREFIX."videos.title like '%".$key."%' or ".DB_PREFIX."videos.description like '%".$key."%' or ".DB_PREFIX."videos.tags like '%".$key."%' )
	   ORDER BY CASE WHEN ".DB_PREFIX."videos.title like '" .$key. "%' THEN 0
	           WHEN ".DB_PREFIX."videos.title like '%" .$key. "%' THEN 1
	           WHEN ".DB_PREFIX."videos.tags like '" .$key. "%' THEN 2
               WHEN ".DB_PREFIX."videos.tags like '%" .$key. "%' THEN 3		   
               WHEN ".DB_PREFIX."videos.description like '%" .$key. "%' THEN 4
			   WHEN ".DB_PREFIX."videos.tags like '%" .$key. "%' THEN 5
               ELSE 6
          END, title ".this_limit();
} else {
$vq = '';
}	
// Canonical url
$canonical = site_url().show.url_split.token(); 
// SEO Filters
function modify_title( $text ) {
global $heading;
    return strip_tags(stripslashes($heading));
}
function modify_desc( $text ) {
global $heading_plus;
    return _cut(strip_tags(stripslashes($heading_plus)), 160);
}
add_filter( 'phpvibe_title', 'modify_title' );
add_filter( 'phpvibe_desc', 'modify_desc' );
//Time for design
if (!is_ajax_call()) {  the_header(); the_sidebar(); }
include_once(TPL.'/videolist.php');
if (!is_ajax_call()) { the_footer(); }
?>