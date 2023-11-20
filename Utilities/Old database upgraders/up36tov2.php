<?php  error_reporting(E_ALL); 
//Vital file include
require_once("load.php");
$db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."jads` (
   `jad_id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `jad_type` varchar(64) NOT NULL DEFAULT '0',
  `jad_box` varchar(64) NOT NULL DEFAULT '0',
  `jad_start` varchar(64) NOT NULL DEFAULT '0',
  `jad_end` varchar(64) NOT NULL DEFAULT '0',
  `jad_body` longtext NOT NULL,
  `jad_title` varchar(64) NOT NULL,
  `jad_pos` varchar(64) NOT NULL,
  `jad_extra` text NOT NULL,
  PRIMARY KEY (`jad_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ");

$db->debug();
?>