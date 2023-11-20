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
define( 'DB_USER', 'zubee_demo' );

/** MySQL database password */
define( 'DB_PASS', 'test0769' );

/** The name of the database */
define( 'DB_NAME', 'zubee_demo' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** MySQL tables prefix */
define( 'DB_PREFIX', 'vibe_' );

/** MySQL cache timeout */
/** For how many hours should queries be cached? **/
define( 'DB_CACHE', '1' );

/*
 ** Site options
 */
 /** License key (Can be created in the store, under "My Licenses" **/
define( 'phpVibeKey', 'V300-M6Y1-3X9I-OE9Q-PUPI' );

/** Site url (with end slash, ex: http://www.domain.com/ ) **/
define( 'SITE_URL', 'http://demo.phpvibe.com/' );

/** Admin folder, rename it and change it here **/
define( 'ADMINCP', 'moderator' );

/*
 ** Custom settings would go after here.
 */
 ?>