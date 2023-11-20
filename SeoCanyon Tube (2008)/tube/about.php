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
// Start_session, check if user is logged in or not, and connect to the database all in one included file
include_once("scripts/checkuserlog.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="Description" content="Web Intersect is a free open source social network website template system, and webmaster training series all in one sweet little package. Get handy website software and learn how to build every bit of it from the creators who produce it. " />
<meta name="Keywords" content="about web intersect, webintersect creator, how to build community, build social network, how to build website, learn free online, php and mysql, internet crossroads, directory, friend, business, update, profile, connect, all, website, blog, social network, connecting people, youtube, myspace, facebook, twitter, dynamic, portal" />
<meta name="rating" content="General" />
<meta name="ROBOTS" content="All" />
<title>About Web Intersect PHP MySQL Social Network Web Site Tutorials</title>
<link href="style/main.css" rel="stylesheet" type="text/css" />
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
</head>

<body>
<?php include_once "header_template.php"; ?>
<table class="mainBodyTable" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="740" valign="top"><div><?php include_once "leaderBoardAd.php"; ?></div><br />
      <table width="90%" align="center" cellpadding="6">
        <tr>
          <td style="line-height:1.7em;"><h2>About Web Intersect</h2>
            <p>Web Intersect is a deft combination of  free open source social web site software, and a free education in webmastery.<br />
              <br />
              <a href="http://www.webintersect.com/profile.php?id=1">Adam Khoury</a> is teaching interested parties how to design and program as this software is being created so you may not see it evolve as quickly as other software until he feels he has instructed enough aspects of the programming fundamentals to where most webmasters would be adept programmers if they were paying attention well throughout the series. Adam's primary function is teaching online. You can come away from this software and the training videos with a Grade-A education in General Programming for the web. Most software programmers hide their secrets, not this one... he is spilling all the beans for free.<br />
              <br />
              Web Intersect is undergoing production and applications for it will be added over the Fall and Winter. It may be currently missing some applications that you want your web site to have. We are sharing the raw form  source package so people can learn from and adapt the source in case they are eager to develop it.<br />
  <br />
              Web Intersect is a  free open source social network web site template system. It is geared for people that want to own and operate a social network or custom community, and have hands on control over it. Its user base ranges from  beginners to serious webmasters and programmers producing web sites for clients. It is currently being used as a core in over 200 social networks live online, and countless web programmers have gained beneficial skills from the lessons and video training that goes all through the system production.<br />
  <br />
              It is also an in depth webmaster training series all in one sweet  package. Get handy website software that you can use free and learn how to build every bit of it for free from the creators who produce the programming that goes into the system. Much of the software has been programmed and designed live on video giving it maximum usability and adaptability properties., More lessons are going to be made and the system will grow. Some instruction may come in the form of text tutorials, but thus far it has all been HD video training.<br />
  <br />
              It  was  conceived by <a href="http://www.webintersect.com/profile.php?id=1">Adam Khoury</a> in March of 2009. It is now a growing open source social networking and community website template system that you can join to test it out, download and use as web site for yourself or clients, and also learn how to build from scratch using PHP and MySQL by viewing clear HD video tutorials made while the system was initially being produced by the creator. This way you get the skills needed to understand programming, and how to adapt a system of this kind for your needs.</p>
            <h2>Web Intersect's Programming</h2>
            <p>Web Intersect has been built using <strong><a href="http://www.developphp.com/list_php.php" target="_blank">PHP</a></strong> for logic and dynamics, <strong><a href="http://www.developphp.com/list_mysql.php">MySQL</a></strong> Databases for data storage and quick data access, <strong><a href="http://www.developphp.com/list_html.php">HTML</a></strong> and <strong><a href="http://www.developphp.com/list_css.php">CSS</a></strong> for rendering things to page, and a touch of <strong><a href="http://www.developphp.com/list_javascript.php">Javascript</a></strong> and <strong><a href="http://www.developphp.com/list_jQuery.php">jQuery</a></strong> where needed. All of those are open source non-proprietory technologies.<br />
              <br />
              Versions prior to 1.3 contain a <strong>Flash Actionscript 3.0</strong> header in place that had the same logic as the HTML header. This was before Adam decided to make Web Intersect an official open source project.</p>
            <h2>All of the Source Code and Tutorials are Free!</h2>
            <p>Free free free... yes everything is free... just keep the copyrights and licenses in place. A cool application and a high dollar education all for free. This will never happen again in human history folks.</p>
            <h2>Your Skill Level</h2>
            <p>Individuals that would like to use the base system as it is do not have to know much about programming at all, they just need FTP access to their website server online and know how to create MySQL databases on their server. Those that have some experience with HTML, CSS, PHP, and MySQL will have an easier time adding to and altering things.<br />
            </p>
            <h2>Your Server and Testing Ground</h2>
            <p>&bull; Build and test online  using FTP on the live server the site is to operate on. Don't test in WAMP, LAMP, or XAMPP.<br />
  &bull; Host it on a  Apache Linux PHP Enabled server. <br />
  <em>You can build and test locally using WAMP, LAMP, or XAMPP, but some things may not work or complications may arise when you finally place the full application onto the live server online to go live. Just do it all live online.</em></p>
            <h2>Tools You Will Need To Modify Your System</h2>
            <p> &bull; A good HTML text editor. Adam  recommends using <strong>Dreamweaver 8 or higher</strong>.<br />
  &bull; A tested <strong>PHP enabled server</strong>(PHP 4.2 or higher) <br />
  &bull; One  free <strong>MySQL database</strong>(MySQL 4.0 or higher)created on the PHP enabled server.<br />
  <em>If using the Flash Header Version: You will need Flash Authoring CS3 or higher. </em><br />
            </p>
            <h2>A Note About Web Intersect In Production</h2>
            <p> This system is a production website. Meaning it is in production and not optimized for live website usage. Much of the source code has a lot of whitespace for human reading and allowing people to change things more easily. There may  be security holes and bugs that surface as the system is used and tested. In new versions that are released we will tend to fix bugs that have appeared in earlier versions.</p>
            <p>Web Intersect is a system that is now fueled by contributors and always being added to.</p>
            <h2><br />
            </h2></td>
        </tr>
      </table></td>
    <td width="160" valign="top"><?php include_once "right_AD_template.php"; ?></td>
  </tr>
</table>
<?php include_once "footer_template.php"; ?>
</body>
</html>
