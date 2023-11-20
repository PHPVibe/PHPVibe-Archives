
CREATE TABLE IF NOT EXISTS `vibe_activity` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `type` int(11) NOT NULL,
  `object` int(11) NOT NULL,
  `extra` mediumtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `vibe_ads` (
  `ad_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ad_spot` varchar(64) NOT NULL DEFAULT '',
  `ad_type` varchar(64) NOT NULL DEFAULT '0',
  `ad_content` longtext NOT NULL,
  `ad_title` varchar(64) NOT NULL,
  `ad_pos` varchar(64) NOT NULL,
  PRIMARY KEY (`ad_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `vibe_channels` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `child_of` int(11) DEFAULT NULL,
  `picture` varchar(150) NOT NULL,
  `cat_name` varchar(150) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `cat_desc` varchar(500) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  `type` int(255) NOT NULL DEFAULT '1',
  `sub` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `vibe_crons` (
  `cron_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cron_type` varchar(500) NOT NULL,
  `cron_name` varchar(64) NOT NULL DEFAULT '',
  `cron_period` mediumint(9) NOT NULL DEFAULT '86400',
  `cron_pages` int(11) NOT NULL DEFAULT '5',
  `cron_lastrun` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cron_value` longtext NOT NULL,
  PRIMARY KEY (`cron_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `vibe_em_comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `object_id` varchar(64) NOT NULL,
  `created` varchar(50) NOT NULL,
  `sender_id` varchar(128) DEFAULT NULL,
  `comment_text` text,
  `admin_reply` enum('0','1') NOT NULL DEFAULT '0',
  `rating_cache` int(11) NOT NULL DEFAULT '0',
  `access_key` varchar(100) DEFAULT NULL,
  `visible` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `object_id` (`object_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `vibe_em_likes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` int(10) unsigned NOT NULL,
  `sender_ip` bigint(20) NOT NULL,
  `vote` enum('1','-1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `comment_id` (`comment_id`),
  KEY `sender_ip` (`sender_ip`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `vibe_homepage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ord` int(11) NOT NULL,
  `title` longtext NOT NULL,
  `type` varchar(200) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `ident` varchar(200) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `querystring` varchar(200) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `total` int(11) NOT NULL,
  `mtype` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `vibe_langs` (
  `lang_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `term` longtext NOT NULL,
  PRIMARY KEY (`lang_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `vibe_languages` (
  `term_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `lang_name` varchar(204) NOT NULL DEFAULT '',
  `lang_code` varchar(64) NOT NULL DEFAULT '',
  `lang_terms` longtext NOT NULL,
  PRIMARY KEY (`term_id`),
  UNIQUE KEY `lang_code` (`lang_code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `vibe_likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `vid` varchar(200) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `type` varchar(200) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `vibe_options` (
  `option_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(64) NOT NULL DEFAULT '',
  `option_value` longtext NOT NULL,
  `autoload` varchar(20) NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `option_name` (`option_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `vibe_pages` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `menu` int(11) NOT NULL DEFAULT '0',
  `date` text COLLATE utf8_swedish_ci NOT NULL,
  `title` varchar(300) COLLATE utf8_swedish_ci NOT NULL,
  `pic` longtext COLLATE utf8_swedish_ci NOT NULL,
  `content` longtext COLLATE utf8_swedish_ci NOT NULL,
  `tags` varchar(500) COLLATE utf8_swedish_ci NOT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=4 ;

CREATE TABLE IF NOT EXISTS `vibe_playlists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner` int(11) NOT NULL,
  `picture` varchar(150) NOT NULL,
  `title` varchar(150) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `description` varchar(500) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  `views` mediumint(9) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `vibe_playlist_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `playlist` int(11) NOT NULL,
  `video_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=40 ;

CREATE TABLE IF NOT EXISTS `vibe_postcats` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `picture` varchar(150) NOT NULL,
  `cat_name` varchar(150) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `cat_desc` varchar(500) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `vibe_posts` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `ch` int(11) NOT NULL DEFAULT '1',
  `date` text COLLATE utf8_swedish_ci NOT NULL,
  `title` varchar(300) COLLATE utf8_swedish_ci NOT NULL,
  `pic` longtext COLLATE utf8_swedish_ci NOT NULL,
  `content` longtext COLLATE utf8_swedish_ci NOT NULL,
  `tags` varchar(500) COLLATE utf8_swedish_ci NOT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=3 ;

CREATE TABLE IF NOT EXISTS `vibe_reports` (
  `r_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `vid` varchar(200) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `reason` longtext CHARACTER SET utf8 COLLATE utf8_swedish_ci,
  `motive` longtext NOT NULL,
  PRIMARY KEY (`r_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `vibe_tags` (
  `tagid` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `tcount` int(11) NOT NULL,
  PRIMARY KEY (`tagid`),
  KEY `tag` (`tag`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `vibe_users` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `pass` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `password` mediumtext COLLATE utf8_swedish_ci NOT NULL,
  `lastlogin` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `group_id` varchar(255) COLLATE utf8_swedish_ci NOT NULL DEFAULT '4',
  `avatar` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `cover` mediumtext COLLATE utf8_swedish_ci,
  `date_registered` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `name` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `gid` mediumtext COLLATE utf8_swedish_ci NOT NULL,
  `fid` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `oauth_token` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `local` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `country` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `bio` longtext COLLATE utf8_swedish_ci NOT NULL,
  `views` mediumint(9) NOT NULL DEFAULT '0',
  `fblink` text COLLATE utf8_swedish_ci NOT NULL,
  `twlink` text COLLATE utf8_swedish_ci NOT NULL,
  `glink` text COLLATE utf8_swedish_ci NOT NULL,
  `gender` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `vibe_users_friends` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `fid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `vibe_users_groups` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `default_value` tinyint(1) NOT NULL,
  `access_level` bigint(32) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `vibe_videos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `media` int(11) NOT NULL DEFAULT '1',
  `token` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `pub` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `date` text COLLATE utf8_swedish_ci NOT NULL,
  `featured` int(11) NOT NULL,
  `source` longtext COLLATE utf8_swedish_ci NOT NULL,
  `tmp_source` mediumtext COLLATE utf8_swedish_ci NOT NULL,
  `title` varchar(300) COLLATE utf8_swedish_ci NOT NULL,
  `thumb` longtext COLLATE utf8_swedish_ci NOT NULL,
  `duration` int(10) NOT NULL,
  `description` longtext COLLATE utf8_swedish_ci NOT NULL,
  `tags` varchar(500) COLLATE utf8_swedish_ci NOT NULL,
  `category` int(11) NOT NULL,
  `views` int(11) NOT NULL,
  `liked` int(11) NOT NULL,
  `disliked` int(11) NOT NULL,
  `nsfw` int(11) NOT NULL,
  `embed` longtext COLLATE utf8_swedish_ci NOT NULL,
  `remote` longtext COLLATE utf8_swedish_ci NOT NULL,
  `srt` mediumtext COLLATE utf8_swedish_ci NOT NULL,
  `privacy` int(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=5765 ;

CREATE TABLE IF NOT EXISTS `vibe_videos_tmp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `path` mediumtext CHARACTER SET utf8 COLLATE utf8_swedish_ci,
  `ext` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

INSERT INTO `#db-prefix#options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
(3, 'mediafolder', 'media', 'yes'),
(20, 'youtube-player', '2', 'yes'),
(5, 'jwkey', 'enaSseHIwj6O/Zpf3GPStcqpF6Ff2hjP8jRx/3GgYA8NY5k0ysqUuBQSlxRMJ4/p', 'yes'),
(6, 'choosen-player', '1', 'yes'),
(7, 'seo_desc', 'phpVibe 3.3 change me', 'yes'),
(8, 'seo_title', 'phpVibe 3.3', 'yes'),
(9, 'site-logo', '', 'yes'),
(10, 'site-logo-mobi', 'Vibe', 'yes'),
(11, 'fb-fans', '0', 'yes'),
(12, 'fb-fans-checked', '0', 'yes'),
(13, 'fb-fanpage', '', 'yes'),
(14, 'video-width', '640', 'yes'),
(15, 'video-height', '390', 'yes'),
(16, 'video-coms', '0', 'yes'),
(17, 'related-nr', '20', 'yes'),
(18, 'bpp', '25', 'yes'),
(19, 'googletracking', '', 'yes'),
(21, 'site-logo-text', 'phpVibe', 'yes'),
(22, 'videos-initial', '1', 'yes'),
(24, 'testing', 'testing good', 'yes'),
(25, 'update_options_now', '1', 'yes'),
(26, 'site-copyright', 'Â© 2013', 'yes'),
(27, 'tt', '1', 'yes'),
(28, 'cachedx', 'test', 'yes'),
(29, 'efe', 'efswef', 'yes'),
(30, 'def_lang', 'en', 'yes'),
(35, 'addthis', '1', 'yes'),
(36, 'googleanalitycs', '', 'yes'),
(37, 'uploadrule', '1', 'yes'),
(38, 'editrule', '1', 'yes'),
(39, 'soft', 'phpvibe', 'yes'),
(40, 'licto', 'Licensed to...', 'yes'),
(41, 'softc', 'UG93ZXJlZCBieSA8YSByZWw9Im5vZm9sbG93IiBocmVmPSJodHRwOi8vd3d3LnBocHZpYmUuY29tIiB0YXJnZXQ9Il9ibGFuayIgdGl0bGU9InBocFZpYmUgVmlkZW8gQ01TIj5waHBWaWJlJnRyYWRlOzwvYT4uIA==', 'yes'),
(42, 'Tw_Key', '', 'yes'),
(43, 'Tw_Secret', '', 'yes'),
(44, 'Fb_Key', '', 'yes'),
(45, 'Fb_Secret', '', 'yes'),
(46, 'allowfb', '0', 'yes'),
(47, 'allowtw', '0', 'yes'),
(48, 'allowlocalreg', '1', 'yes'),
(49, 'allowg', '1', 'yes'),
(50, 'COOKIEKEY', '', 'yes'),
(51, 'SECRETSALT', '', 'yes'),
(52, 'COOKIESPLIT', '-phpv-', 'yes'),
(53, 'jwp_version', '6', 'yes'),
(54, 'cron_lastrun', '0', 'yes'),
(55, 'cron_interval', '90000', 'yes'),
(56, 'thumb-width', '260', 'yes'),
(58, 'lecheck', '', 'yes'),
(57, 'thumb-height', '240', 'yes');

INSERT INTO `#db-prefix#users_groups` (`id`, `name`, `admin`, `default_value`, `access_level`) VALUES
(1, 'Administrators', 1, 0, 3),
(4, 'Members', 0, 1, 1),
(3, 'Author', 0, 2, 2),
(2, 'Moderators', 0, 2, 2);