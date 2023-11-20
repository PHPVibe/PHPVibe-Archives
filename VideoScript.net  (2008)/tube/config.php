<?php 
if (eregi("config.php", $_SERVER['PHP_SELF'])) { die(); }

// Site Url
// Example how to enter website adress : $site_url            = 'http://www.seocanyon.com/';
//

$site_url            = 'http://tube.seocanyon.com/';

// Database connect details

$DB_USER  = 'Database user';
$DB_PASS  = 'Db password';

$DB_NAME  = 'Db name';

$DB_HOST  = 'localhost';

// Custom settings YOU NEED TO EDIT THIS!

// Titles, meta 
$site_title          = 'SEO Canyon\'s Free Tube';
$site_slogan         = 'Tube Canyon Free';
$site_description    = 'Check out the best Youtube video collection!';
$site_keywords       = 'zubee tube, video, youtube video';

// SEO data! IMPORTANT: Leave blank if you don;t want them, but NEVER remove them unless you remove them from template file to!

$before_title = 'Video:'; // Appears in video page title befoure the video name!
$after_title ='! Free Videos'; // Appears in video page title after the video name!
$after_tag ='Cool videos!'; // Appears in tag/searched title after seached word!

// Index videos
//The time parameter restricts the search to videos uploaded within the specified time. 
//Valid values for this parameter are today (1 day), this_week (7 days), this_month (1 month) and all_time. 
$index_time ='this_week';
// The following values are valid for this parameter:
// published – Entries are returned in reverse chronological order.
// viewCount – Entries are ordered from most views to least views.
// rating – Entries are ordered from highest rating to lowest rating.
$index_orderby ='viewCount';

// Player options
$autoplay = 'no';
$repeatplay = 'no';
// Zubee Tube skin directory name 
$template  = 'default'; 
// Number of "Videos Being Watched Right Now"
$recent_videos_limit = 30;

// Misc settings	(only keeped for transition to PRO version of Zubee Tube)
$site_homepage = "most_popular"; 
$feautured_video_id    = 'coqbx4C8z0o'; 
$feautured_video_title = 'Miley Cyrus - Who Owns My Heart'; 

//FACEBOOK SDK - APPLICATION ID

$fbappis ="Enter here";

?>
