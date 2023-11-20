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
require_once "../scripts/connect_to_mysql.php"; // Connect to the database
$messageid = preg_replace('#[^0-9]#i', '', $_POST['messageid']); 
$ownerid = preg_replace('#[^0-9]#i', '', $_POST['ownerid']);
// Decode the Session IDX variable and extract the user's ID from it
$decryptedID = base64_decode($_SESSION['idx']);
$id_array = explode("p3h9xfn8sq03hs2234", $decryptedID);
$my_id = $id_array[1];
if ($ownerid != $my_id) {
	exit(); // Exit because either there is malicious activity or the user's session has expired from inactivity on the site
} else {
    dbquery("UPDATE private_messages SET opened='1' WHERE id='$messageid' LIMIT 1"); 
}
?>