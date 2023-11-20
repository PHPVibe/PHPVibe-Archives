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
// This script was put in place early on in the lessons for usage when we want to change our tables through script instead of PHPMyAdmin
// connect to your MySQL database here using the 
// script we made in the previous step of this lesson
include_once "connect_to_mysql.php";
// create the query string
$sql = 'ALTER TABLE `myMembers` CHANGE `phone` `style_sheet` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL'; 

if (dbquery($sql)){
print "Success in table field manipulation!";
} else {
print "Script Failure!";
}

?>