<?php /* -- Config settings (Edit as needed)-- */

// Please keep ending slash on site url
$site_url = "http://domain.com/";

//Google/Youtube developer key (leave blank for none)

$devkey = "";

//used in breadcumps menu
$small_title ="phpVibe.Mobi";
//First page and global added to seo titles
$seo_title ="phpVibe.Mobi";
$seo_desc = "A Youtube mobile browser powered by phpVibe";

//Facebook page/profile link
$fb = "http://www.facebook.com/your_page";
$fb_txt = "Fan Us";

//Twitter link
$tw = "https://twitter.com/your_id";
$tw_txt = "Follow";

//Rss/Feedburner link
// could be $rss = "http://feedburner.com/your_id/";
$rss = $site_url."rss.php";
$rss_txt = "Feed";
//Up button
$up_txt = "Up";

//global number of videos per page
$nb_display = 10;
//global number of videos returned from Youtube (used in pagination. your choice!)
$nb_total = 420;


//Enable albums? true/false
$enable_albums = true;
//Pic a featured album on homepage! true/false
$show_featured = true;
//Folder name for the album
$featuredalbum = "Celebrities";

/* -- Language Settings (Translate as needed)-- */


    $lang['welcome']          = 'Hi! Browse videos via mobile';
	$lang['search']          = 'Search videos...';
	$lang['browsechannels']          = 'Browse Channels';
	$lang['new']          = 'New';
	$lang['hot']          = 'Hot!';
	$lang['today']          = 'today';
	$lang['this_week']          = 'this week';
	$lang['this_month']          = 'this month';
	$lang['all_time']          = 'all time';
    $lang['video']           = 'Video';
    $lang['channels']          = 'Channels';
	$lang['channel']          = 'Channel';
	$lang['showmore']          = 'Show more';
	$lang['relatedvideos']          = 'Related Videos';
	$lang['most_recent']          = 'New Videos';
	$lang['top_rated']          = 'Top rated videos';
	$lang['most_viewed']          = 'Most viewed videos';
	$lang['top_favorites']          = 'Most voted videos';
	$lang['most_popular']          = 'Trending videos';
	$lang['most_discussed']          = 'Most viral videos';
	
	//Images lang (if images are enabled)
	$lang['pictures']          = 'Images';
	$lang['allalbums']          = 'All albums';
	
   
/* -- Global functions and variables --
This are php FUNCTIONS (Please edit only of you know what you are doing)  */
//variables
//please leave blank this values
$q = "";
$username = "";
$feed = "";
$time = "";
//functions

function sec2hms($sec, $padHours = false) {

    $hms = "";
    
    // there are 3600 seconds in an hour, so if we
    // divide total seconds by 3600 and throw away
    // the remainder, we've got the number of hours
    $hours = intval(intval($sec) / 3600); 
 if ($hours > 0):
    // add to $hms, with a leading 0 if asked for
    $hms .= ($padHours) 
          ? str_pad($hours, 2, "0", STR_PAD_LEFT). ':'
          : $hours. ':';
     endif;
    // dividing the total seconds by 60 will give us
    // the number of minutes, but we're interested in 
    // minutes past the hour: to get that, we need to 
    // divide by 60 again and keep the remainder
    $minutes = intval(($sec / 60) % 60); 

    // then add to $hms (with a leading 0 if needed)
    $hms .= str_pad($minutes, 2, "0", STR_PAD_LEFT). ':';

    // seconds are simple - just divide the total
    // seconds by 60 and keep the remainder
    $seconds = intval($sec % 60); 

    // add to $hms, again with a leading 0 if needed
    $hms .= str_pad($seconds, 2, "0", STR_PAD_LEFT);

    return $hms;
}

?>