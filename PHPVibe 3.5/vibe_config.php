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
define( 'DB_USER', 'playme_vibe' );

/** MySQL database password */
define( 'DB_PASS', 'seo0721' );

/** The name of the database */
define( 'DB_NAME', 'playme_vibe' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** MySQL tables prefix */
define( 'DB_PREFIX', 'vibe_' );

/** MySQL cache timeout */
/** For how many hours should queries be cached? **/
define( 'DB_CACHE', '5' );

/*
 ** Site options
 */
 /** License key (Can be created in the store, under "My Licenses" **/
define( 'phpVibeKey', 'V300-UKL0-BZV9-9DEP-Z6M1-Z910' );

/** Site url (with end slash, ex: http://www.domain.com/ ) **/
define( 'SITE_URL', 'http://www.playviralvideos.com/' );

/** Admin folder, rename it and change it here **/
define( 'ADMINCP', 'moderator' );

/*
 ** Custom settings would go after here.
 */
 ?>