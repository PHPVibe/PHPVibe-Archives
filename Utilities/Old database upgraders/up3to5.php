<?php  error_reporting(E_ALL); 
//Vital file include
require_once("load.php");


$db->query("ALTER TABLE  `".DB_PREFIX."videos` ADD  `token` VARCHAR( 255 ) NOT NULL AFTER  `id`");
$db->query("ALTER TABLE  `".DB_PREFIX."videos` ADD  `tmp_source` MEDIUMTEXT NOT NULL AFTER  `source`");
$db->query("ALTER TABLE  `".DB_PREFIX."videos` CHANGE  `pub`  `pub` INT( 11 ) NOT NULL DEFAULT  '0'");
$db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."ads` (
  `ad_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ad_spot` varchar(64) NOT NULL DEFAULT '',
  `ad_type` varchar(64) NOT NULL DEFAULT '0',
  `ad_content` longtext NOT NULL,
  `ad_title` varchar(64) NOT NULL,
  `ad_pos` varchar(64) NOT NULL,
  PRIMARY KEY (`ad_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ");




$db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."pages` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `menu` int(11) NOT NULL DEFAULT '0',
  `date` text COLLATE utf8_swedish_ci NOT NULL,
  `title` varchar(300) COLLATE utf8_swedish_ci NOT NULL,
  `pic` longtext COLLATE utf8_swedish_ci NOT NULL,
  `content` longtext COLLATE utf8_swedish_ci NOT NULL,
  `tags` varchar(500) COLLATE utf8_swedish_ci NOT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=0 ");

include_once('up4to5.php');
$db->debug();
?>