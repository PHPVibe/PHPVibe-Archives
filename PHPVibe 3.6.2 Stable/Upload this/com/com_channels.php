<?php $channels = $cachedb->get_results("SELECT * FROM ".DB_PREFIX."channels where `child_of` IS NULL  or `child_of` < 1 order by type asc, cat_name limit  0,1000");
// Canonical url
$canonical = site_url().channels;   
// SEO Filters
function modify_title( $text ) {
global $channel;
    return _lang("channels");
}
function modify_desc( $text ) {
global $channel;
    return _lang("Channels seo description");
}
add_filter( 'phpvibe_title', 'modify_title' );
add_filter( 'phpvibe_desc', 'modify_desc' );
/*Now to the actual channels page */
if (!is_ajax_call()) { 
the_header();
the_sidebar();
}
include_once(TPL.'/channels.php');
the_footer();
?>