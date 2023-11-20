SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `site_url` varchar(100) NOT NULL default '',
  `site_title` varchar(50) NOT NULL,
  `site_slogan` varchar(50) NOT NULL default '',
  `site_description` text NOT NULL,
  `site_keywords` text NOT NULL,
  `dev_id` varchar(20) NOT NULL default '',
  `default_tag` varchar(50) NOT NULL default '',
  `fvideo_id` varchar(15) NOT NULL,
  `fvideo_title` varchar(100) NOT NULL,
  `autoplay` varchar(3) NOT NULL,
  `template` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`site_url`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings`
(`site_url`, `site_title`, `site_slogan`, `site_description`, `site_keywords`, `dev_id`, `default_tag`, `fvideo_id`, `fvideo_title`, `autoplay`, `template`) VALUES
('http://yourdomain.com', 'Zubee Tube RC 1', 'YouTube videos like Zuuuu...', 'Get al the buzz in Youtube', 'videos, youtube', '', 'funny+videos', 'p8X-fSPPuIw', 'Rihanna - Disturbia', 'yes', 'default');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `username` varchar(100) NOT NULL default '',
  `password` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `admin` (`username`, `password`) VALUES
('zubee', 'zubee');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
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


-- --------------------------------------------------------

--
-- Table structure for table `recent`
--

CREATE TABLE IF NOT EXISTS `recent` (
  `video_id` varchar(30) NOT NULL,
  `thumb` text NOT NULL,
  `title` text NOT NULL,
  `time` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `tagid` int(11) NOT NULL auto_increment,
  `tag` varchar(20) NOT NULL default '',
  `tcount` int(11) NOT NULL,
  PRIMARY KEY  (`tagid`),
  KEY `tag` (`tag`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `videos`
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