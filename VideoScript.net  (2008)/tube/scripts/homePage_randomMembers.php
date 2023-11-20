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
////////////////////        GET 10 RANDOM MEMBERS FOR HOMEPAGE       ///////////////////////////
//     I changed this script in v1.3 to show any member whether they have a pic uploaded or not
//     People running the system will see an empty list for a while until people start joining
//     that upload a picture of themselves. To get the script that checks if the member has
//     an image or not, use the script with same name supplied in Web Intersect v1.2

$MemberDisplayList = '<table border="0" align="center" cellpadding="6">
              <tr>  ';
// Mysql connection is already made in the file this one gets included into
// So we can run queries here without having to connect again
$sql = dbquery("SELECT id, username, firstname FROM myMembers WHERE email_activated='1' ORDER BY RAND() LIMIT 9");
while($row = mysql_fetch_array($sql)){
	$id = $row["id"];
	$username = $row["username"];
	$firstname = $row["firstname"];
	if (!$firstname) {
		$firstname = $username;
	}
    $firstnameCut = substr($firstname, 0, 10);
	$check_pic = "members/$id/image01.jpg";
	if (file_exists($check_pic)) {
	    $user_pic = "<img src=\"members/$id/image01.jpg\" width=\"64px\" border=\"0\" />";
	} else {
		$user_pic = "<img src=\"members/0/image01.jpg\" width=\"64px\" border=\"0\" />";
	}
	$MemberDisplayList .= '<td><a href="profile.php?id=' . $id . '" title="' . $firstname . '"><font size="-2">' . $firstnameCut . '</font></a><br />
	<div style=" height:64px; overflow:hidden;"><a href="profile.php?id=' . $id . '"  title="' . $firstname . '">' . $user_pic . '</a></div></td>';

} // close while loop

$MemberDisplayList .= '              </tr>
            </table>  ';
?>