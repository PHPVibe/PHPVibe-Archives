-- phpMyAdmin SQL Dump
-- version 3.3.8.1
-- http://www.phpmyadmin.net
--
-- Gazda: localhost
-- Timp de generare: 04 Ian 2011 la 18:25
-- Versiune server: 5.0.91
-- Versiune PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza de date: `seocanyo_tube`
--

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `blabbing`
--

CREATE TABLE IF NOT EXISTS `blabbing` (
  `id` int(11) NOT NULL auto_increment,
  `mem_id` int(11) NOT NULL,
  `the_blab` varchar(255) NOT NULL,
  `blab_date` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Salvarea datelor din tabel `blabbing`
--


-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `friends_requests`
--

CREATE TABLE IF NOT EXISTS `friends_requests` (
  `id` int(11) NOT NULL auto_increment,
  `mem1` int(11) NOT NULL,
  `mem2` int(11) NOT NULL,
  `timedate` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Salvarea datelor din tabel `friends_requests`
--


-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `msg_id` int(11) NOT NULL auto_increment,
  `message` varchar(200) default NULL,
  PRIMARY KEY  (`msg_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Salvarea datelor din tabel `messages`
--


-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `myMembers`
--

CREATE TABLE IF NOT EXISTS `myMembers` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `gender` enum('m','f') NOT NULL default 'm',
  `birthday` date NOT NULL default '0000-00-00',
  `country` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `ipaddress` varchar(255) NOT NULL,
  `sign_up_date` date NOT NULL default '0000-00-00',
  `last_log_date` date NOT NULL default '0000-00-00',
  `bio_body` text,
  `website` varchar(255) default NULL,
  `youtube` varchar(255) default NULL,
  `facebook` varchar(255) default NULL,
  `twitter` varchar(255) default NULL,
  `friend_array` text,
  `account_type` enum('a','b','c') NOT NULL default 'a',
  `email_activated` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Salvarea datelor din tabel `myMembers`
--


-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `playlists`
--

CREATE TABLE IF NOT EXISTS `playlists` (
  `ID` int(10) NOT NULL auto_increment,
  `pid` int(10) NOT NULL,
  `value` varchar(20) NOT NULL,
  `title` varchar(500) NOT NULL,
  `desc` varchar(150) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Salvarea datelor din tabel `playlists`
--


-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `private_messages`
--

CREATE TABLE IF NOT EXISTS `private_messages` (
  `id` int(11) NOT NULL auto_increment,
  `to_id` int(11) NOT NULL,
  `from_id` int(11) NOT NULL,
  `time_sent` datetime NOT NULL,
  `subject` varchar(255) default NULL,
  `message` text,
  `opened` enum('0','1') NOT NULL,
  `recipientDelete` enum('0','1') NOT NULL,
  `senderDelete` enum('0','1') NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Salvarea datelor din tabel `private_messages`
--


-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `recent`
--

CREATE TABLE IF NOT EXISTS `recent` (
  `video_id` varchar(30) NOT NULL,
  `thumb` text NOT NULL,
  `title` text NOT NULL,
  `time` varchar(20) NOT NULL,
  `duration` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Salvarea datelor din tabel `recent`
--

INSERT INTO `recent` (`video_id`, `thumb`, `title`, `time`, `duration`) VALUES
('yk2xlcJPUhE', 'http://i.ytimg.com/vi/yk2xlcJPUhE/2.jpg', 'XXXO [Darren Glen Remix] - MIA.mp4', '1294157970', '5.85'),
('iJpY0czBC_k', 'http://i.ytimg.com/vi/iJpY0czBC_k/2.jpg', 'Tobenai Tori FanMade VOCALOID Dai-Ouji', '1294157697', '4.60');

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `ID` int(10) NOT NULL,
  `variable` varchar(32) NOT NULL,
  `value` text NOT NULL,
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Salvarea datelor din tabel `settings`
--

INSERT INTO `settings` (`ID`, `variable`, `value`) VALUES
(1, 'title', 'Zubee Tubee PRO 2 Version');

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `tagid` int(11) NOT NULL auto_increment,
  `tag` varchar(50) NOT NULL,
  `tcount` int(11) NOT NULL,
  PRIMARY KEY  (`tagid`),
  KEY `tag` (`tag`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Salvarea datelor din tabel `tags`
--


-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `videos`
--

CREATE TABLE IF NOT EXISTS `videos` (
  `id` int(11) NOT NULL auto_increment,
  `video_id` varchar(30) NOT NULL,
  `description` varchar(500) NOT NULL,
  `title` varchar(300) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Salvarea datelor din tabel `videos`
--


-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `youtube_ip`
--

CREATE TABLE IF NOT EXISTS `youtube_ip` (
  `id` int(11) NOT NULL auto_increment,
  `userip` varchar(100) NOT NULL,
  `videoid` varchar(20) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Salvarea datelor din tabel `youtube_ip`
--


-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `zu_ratings`
--

CREATE TABLE IF NOT EXISTS `zu_ratings` (
  `id` int(11) NOT NULL auto_increment,
  `vid` varchar(20) NOT NULL,
  `liked` int(11) NOT NULL,
  `dislike` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Salvarea datelor din tabel `zu_ratings`
--

