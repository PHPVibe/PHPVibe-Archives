<?php //security check
if( !defined( 'in_phpvibe' ) || (in_phpvibe !== true) ) {
die();
}
/* This is your phpVibe config file.
 * Edit this file with your own settings following the comments next to each line
 */

/*
 ** MySQL settings - You can get this info from your web host
 */

/** MySQL database username */
define( 'DB_USER', 'Your database user' );

/** MySQL database password */
define( 'DB_PASS', 'Your database pass' );

/** The name of the database */
define( 'DB_NAME', 'Your database name' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** MySQL tables prefix */
define( 'DB_PREFIX', 'vibe_' );

/*
 ** Site options
 */
 /** License key (Can be created in the store, under "licenses" **/
define( 'phpVibeKey', 'LICENSE KEY' );

/** Site url (with end slash, ex: http://www.domain.com/ ) **/
define( 'SITE_URL', 'http://www.yourdomain.com/' );

/** Admin folder, rename it and change it here **/
define( 'ADMINCP', 'moderator' );

/** Timezone (set your own) **/
date_default_timezone_set('Europe/Bucharest');

/** Arrays with options for logins **/
$conf_twitter = array();
$conf_facebook = array();
$conf_google = array();
//Callback url for twitter
$conf_twitter['oauth_callback'] = SITE_URL.'callback.php?type=twitter';
//Callback url for facebook
$conf_facebook['redirect_uri'] = SITE_URL.'callback.php?type=facebook';
//Callback url for google
$conf_google['return_url'] = SITE_URL.'callback.php?type=google';
//Facebook callback fields(default values, it can be empty)
$conf_facebook['fields'] = 'id,name,first_name,last_name,email';
//Facebook permissions(default values)
$conf_facebook['permissions'] = 'email,publish_stream,user_status,read_stream,read_friendlists';


// URL RULE for phpVibe
/* You can change the url format here:
Examples: 
/ => http://playviralvideos.com/video/58212/kid-coconutz-she-contemplates-the-beach/ (normal phpVibe url)
-- => http://playviralvideos.com/video--58212--kid-coconutz-she-contemplates-the-beach/
*/
define( 'url_split', '/' );

// SEO url structure
define( 'page', 'read' );
define( 'embedcode', 'embed' );
define( 'video', 'video' );
define( 'videos', 'videos' );
define( 'channel', 'channel' );
define( 'channels', 'channels' );
define( 'playlist', 'playlist' );
define( 'note', 'note' );
define( 'profile', 'profile' );
define( 'show', 'show' );
define( 'members', 'members' );
define( 'share', 'share' );
define( 'subscriptions', 'subscriptions' );
define( 'manage', 'manage' );
define( 'me', 'me' );
define( 'buzz', 'buzz' );
// Mini video seo excerpts
define( 'mostliked', 'most-liked' );
define( 'mostviewed', 'most-viewed' );
define( 'promoted', 'featured' );
define( 'browse', 'browse' );
/*
 ** Custom settings would go after here.
 */
 ?>