-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Gazda: localhost
-- Timp de generare: 26 Mai 2010 la 17:56
-- Versiune server: 5.0.90
-- Versiune PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza de date: `royalway_restante`
--

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `username` varchar(100) NOT NULL default '',
  `password` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Salvarea datelor din tabel `admin`
--

INSERT INTO `admin` (`username`, `password`) VALUES
('zubee', 'zubee');

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL auto_increment,
  `vid` varchar(15) NOT NULL,
  `uname` varchar(25) NOT NULL,
  `uwebsite` varchar(50) NOT NULL,
  `comment` text NOT NULL,
  `date` varchar(20) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Salvarea datelor din tabel `comments`
--


-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `recent`
--

CREATE TABLE IF NOT EXISTS `recent` (
  `video_id` varchar(30) NOT NULL,
  `thumb` text NOT NULL,
  `title` text NOT NULL,
  `time` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Salvarea datelor din tabel `recent`
--


-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `site_url` varchar(100) NOT NULL default '',
  `site_title` varchar(50) NOT NULL,
  `site_slogan` varchar(50) NOT NULL default '',
  `site_description` text NOT NULL,
  `site_keywords` text NOT NULL,
  `dev_id` varchar(20) NOT NULL default '',
  `default_tag` varchar(50) NOT NULL default '',
  `site_homepage` varchar(50) NOT NULL,
  `fvideo_id` varchar(15) NOT NULL,
  `fvideo_title` varchar(100) NOT NULL,
  `autoplay` varchar(3) NOT NULL,
  `template` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`site_url`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Salvarea datelor din tabel `settings`
--

INSERT INTO `settings` (`site_url`, `site_title`, `site_slogan`, `site_description`, `site_keywords`, `dev_id`, `default_tag`, `site_homepage`, `fvideo_id`, `fvideo_title`, `autoplay`, `template`) VALUES
('http://www.domain.com', 'Hot Video Tweets', 'Videos from Youtube and tweets from Twitter', 'Videos from Youtube and tweets from Twitter', 'tweets, video, video tweets', '', 'avatar', 'most_viewed', '4umc87T5UMs', 'Cheryl Cole - Fight For This Love', 'yes', 'default');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5846 ;

--
-- Salvarea datelor din tabel `tags`
--

INSERT INTO `tags` (`tagid`, `tag`, `tcount`) VALUES
(1, 'hip hop', 2),
(2, 'james bond', 1),
(3, 'royal ways', 1),
(4, 'official video', 2),
(7, 'music video', 5),
(9, 'movies', 30),
(10, 'lady gaga', 73);

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `timeline`
--

CREATE TABLE IF NOT EXISTS `timeline` (
  `tid` int(11) NOT NULL auto_increment,
  `user` varchar(250) default NULL,
  `tweets` varchar(200) default NULL,
  PRIMARY KEY  (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Salvarea datelor din tabel `timeline`
--


-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(11) NOT NULL auto_increment,
  `uname` varchar(50) default NULL,
  `passcode` varchar(50) default NULL,
  `oauth_token` varchar(90) default NULL,
  `oauth_token_secret` varchar(90) default NULL,
  `uimg` varchar(90) default NULL,
  `uloc` varchar(90) default NULL,
  `uabout` varchar(90) default NULL,
  `uweb` varchar(90) default NULL,
  `utweet` varchar(50) default NULL,
  `ufollow` varchar(50) default NULL,
  PRIMARY KEY  (`uid`),
  UNIQUE KEY `uname` (`uname`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Salvarea datelor din tabel `users`
--


-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `videos`
--

CREATE TABLE IF NOT EXISTS `videos` (
  `id` int(11) NOT NULL auto_increment,
  `video_id` varchar(30) NOT NULL,
  `thumb` varchar(500) NOT NULL,
  `title` varchar(300) NOT NULL,
  `views` int(11) NOT NULL,
  `comments` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `votes` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Salvarea datelor din tabel `videos`
--

