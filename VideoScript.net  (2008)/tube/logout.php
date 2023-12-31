<?php
/* Web Intersect Social Network Template System and CMS v1.33
 * Copyright (c) 2010 Adam Khoury
 * Licensed under the GNU General Public License version 3.0 (GPLv3)
 * http://www.webintersect.com/license.php
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 * See the GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Date: October 7, 2010
 *------------------------------------------------------------------------------------------------*/
session_start();
// Force script errors and warnings to show on page in case php.ini file is set to not display them
error_reporting(E_ALL);
ini_set('display_errors', '1');
//-----------------------------------------------------------------------------------------------------------------------------------
// Unset all of the session variables
$_SESSION = array();
// If it's desired to kill the session, also delete the session cookie
if (isset($_COOKIE['idCookie'])) {
    setcookie("idCookie", '', time()-42000, '/');
	setcookie("passCookie", '', time()-42000, '/');
}
// Destroy the session variables
session_destroy();
// Check to see if their session is in fact destroyed
if(!session_is_registered('firstname')){ 
header("location: index.php"); // << makes the script send them to any page we set
} else {
print "<h2>Could not log you out, sorry the system encountered an error.</h2>";
exit();
} 
?> 