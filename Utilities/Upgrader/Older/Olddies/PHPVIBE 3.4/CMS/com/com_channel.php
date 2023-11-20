<?php $id = token_id();
if(intval($id) > 0) {
$channel = $db->get_row("SELECT * FROM ".DB_PREFIX."channels where cat_id = '".$id ."' limit  0,1");
}
if ($channel) {
$subchannels = $db->get_results("SELECT cat_name, cat_id,picture FROM ".DB_PREFIX."channels where child_of = '".$id ."' limit  0,50");
// Canonical url
$canonical = channel_url($channel->cat_id , $channel->cat_name);   
// SEO Filters
function modify_title( $text ) {
global $channel;
    return strip_tags(stripslashes($channel->cat_name));
}
function modify_desc( $text ) {
global $channel;
    return _cut(strip_tags(stripslashes($channel->cat_desc)), 160);
}
add_filter( 'phpvibe_title', 'modify_title' );
add_filter( 'phpvibe_desc', 'modify_desc' );
/*Now to the actual channel page */
if (!is_ajax_call()) { 
the_header();
the_sidebar();
}
include_once(TPL.'/channel.php');
the_footer();
} else {
//Oups, not found
layout('404');
}
?>