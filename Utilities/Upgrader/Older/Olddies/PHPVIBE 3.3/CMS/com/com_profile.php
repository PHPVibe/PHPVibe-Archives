<?php $user = token_id();
//Query this user
if($user > 0) { $profile = $db->get_row("SELECT * FROM ".DB_PREFIX."users where id = '".$user ."' limit  0,1");}
if ($profile) {
//Local thumbs
$profile->avatar = thumb_fix($profile->avatar);
$profile->cover = thumb_fix($profile->cover);
// Canonical url
$canonical = profile_url($profile->id , $profile->name);   
// SEO Filters
function modify_title( $text ) {
global $profile;
    return strip_tags(stripslashes($profile->name));
}
function modify_desc( $text ) {
global $profile;
    return _cut(strip_tags(stripslashes($profile->bio)), 160);
}
add_filter( 'phpvibe_title', 'modify_title' );
add_filter( 'phpvibe_desc', 'modify_desc' );
//Time for design
 the_header();
include_once(TPL.'/profile.php');
 the_footer(); 
 //Track this view
	
$db->query("UPDATE ".DB_PREFIX."users SET views = views+1 WHERE id = '".$profile->id."'");
} else {
//Oups, not found
layout('404');
}
?>