<?php  error_reporting(E_ALL); 
//Vital file include
require_once("load.php");
$db->query("ALTER TABLE  `".DB_PREFIX."videos` ADD  `privacy` INT( 255 ) NOT NULL DEFAULT  '0'");
$db->query("ALTER TABLE  `".DB_PREFIX."channels` ADD  `type` INT( 255 ) NOT NULL DEFAULT  '1'");
$db->query("ALTER TABLE  `".DB_PREFIX."channels` ADD  `sub` INT NOT NULL DEFAULT  '1'");
$db->query("ALTER TABLE  `".DB_PREFIX."videos` ADD  `media` INT NOT NULL DEFAULT  '1' AFTER  `id` ");
$db->query("Update `".DB_PREFIX."videos` set media = '2' WHERE source like '%.mp3'");
$db->query("UPDATE `".DB_PREFIX."videos` set media = '3' WHERE source like 'localimage%'");
$db->query("ALTER TABLE  `".DB_PREFIX."homepage` CHANGE  `order`  `ord` INT( 11 ) NOT NULL ");
$db->query("ALTER TABLE  `".DB_PREFIX."homepage` ADD  `mtype` INT NOT NULL DEFAULT  '1'");
$db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."postcats` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `picture` varchar(150) NOT NULL,
  `cat_name` varchar(150) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `cat_desc` varchar(500) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ");
$db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."posts` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `ch` int(11) NOT NULL DEFAULT '1',
  `date` text COLLATE utf8_swedish_ci NOT NULL,
  `title` varchar(300) COLLATE utf8_swedish_ci NOT NULL,
  `pic` longtext COLLATE utf8_swedish_ci NOT NULL,
  `content` longtext COLLATE utf8_swedish_ci NOT NULL,
  `tags` varchar(500) COLLATE utf8_swedish_ci NOT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=0 ");


$db->debug();
?>