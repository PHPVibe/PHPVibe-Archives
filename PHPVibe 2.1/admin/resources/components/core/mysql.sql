CREATE TABLE `modules` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `table` varchar(32) NOT NULL,
  `slug` varchar(32) NOT NULL,
  `parent_module_id` int(16) NOT NULL,
  `field_uid` int(16) NOT NULL,
  `field_slug` int(16) NOT NULL,
  `field_parent` int(16) NOT NULL,
  `field_orderby` int(16) NOT NULL,
  `orderby_direction` enum('DESC','ASC') NOT NULL DEFAULT 'DESC',
  `management_width` varchar(8) NOT NULL,
  `type` varchar(255) NOT NULL,
  `locked` tinyint(1) NOT NULL,
  `lock_records` tinyint(1) NOT NULL,
  `core_module` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=62 ;

INSERT INTO `modules` VALUES (3, 'Modules', 'modules', 'modules', 0, 6, 14, 10, 14, 'ASC', '30%', 'module', 1, 1, 1);
INSERT INTO `modules` VALUES (4, 'Fields', 'modules_fields', 'fields', 3, 17, 20, 0, 19, 'DESC', '30%', 'module_field', 1, 1, 1);
INSERT INTO `modules` VALUES (5, 'Validation', 'modules_fields_validation', 'validation', 3, 39, 40, 0, 39, 'DESC', '30%', 'module_field_validation', 1, 1, 1);

CREATE TABLE `modules_fields` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `order` tinyint(2) NOT NULL,
  `module_id` int(32) NOT NULL,
  `name` varchar(32) NOT NULL,
  `label` varchar(32) NOT NULL,
  `type` varchar(32) NOT NULL,
  `editable` tinyint(1) NOT NULL,
  `display_width` varchar(8) NOT NULL,
  `tooltip` text NOT NULL,
  `fieldset` varchar(255) NOT NULL,
  `specific_search` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=362 DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=362 ;

INSERT INTO `modules_fields` VALUES (6, 1, 3, 'id', 'Id', 'id', 0, '10%', '', '', 0);
INSERT INTO `modules_fields` VALUES (8, 3, 3, 'table', 'Table', '', 1, '', '', '', 0);
INSERT INTO `modules_fields` VALUES (9, 6, 3, 'slug', 'Slug', '', 1, '', '', '', 0);
INSERT INTO `modules_fields` VALUES (10, 7, 3, 'parent_module_id', 'Module Parent', 'module', 1, '', '', '', 0);
INSERT INTO `modules_fields` VALUES (11, 8, 3, 'field_uid', 'Id field', 'module_field_current', 1, '', '', '', 0);
INSERT INTO `modules_fields` VALUES (12, 12, 3, 'orderby_direction', 'Default order direction', 'orderby_direction', 1, '', '', '', 0);
INSERT INTO `modules_fields` VALUES (13, 13, 3, 'management_width', 'Options field width', 'text_small', 1, '', '', '', 0);
INSERT INTO `modules_fields` VALUES (14, 2, 3, 'name', 'Name', '', 1, '55%', '', '', 0);
INSERT INTO `modules_fields` VALUES (15, 10, 3, 'field_parent', 'Parent field', 'module_field_current', 1, '', '', '', 0);
INSERT INTO `modules_fields` VALUES (16, 9, 3, 'field_slug', 'Slug field', 'module_field_current', 1, '', '', '', 0);
INSERT INTO `modules_fields` VALUES (25, 11, 3, 'field_orderby', 'Default order by field', 'module_field_current', 1, '', '', '', 0);
INSERT INTO `modules_fields` VALUES (35, 9, 3, 'type', 'Type definition', '', 1, '', '', '', 0);
INSERT INTO `modules_fields` VALUES (50, 10, 3, 'locked', 'Locked', 'yes_no', 1, '', '', '', 0);
INSERT INTO `modules_fields` VALUES (94, 10, 3, 'core_module', 'Core module', 'yes_no', 1, '', '', '', 0);
INSERT INTO `modules_fields` VALUES (91, 9, 3, 'lock_records', 'Lock Records', 'yes_no', 1, '', '', '', 0);
INSERT INTO `modules_fields` VALUES (17, 1, 4, 'id', 'ID', 'id', 0, '10%', '', '', 0);
INSERT INTO `modules_fields` VALUES (18, 3, 4, 'name', 'Name', '', 1, '', '', '', 0);
INSERT INTO `modules_fields` VALUES (19, 6, 4, 'module_id', 'Module', 'module', 1, '30%', '', '', 1);
INSERT INTO `modules_fields` VALUES (20, 2, 4, 'label', 'Label', '', 1, '30%', '', '', 0);
INSERT INTO `modules_fields` VALUES (21, 5, 4, 'type', 'Type', 'type', 1, '', '', '', 0);
INSERT INTO `modules_fields` VALUES (22, 8, 4, 'editable', 'Editable?', 'yes_no', 1, '', '', '', 0);
INSERT INTO `modules_fields` VALUES (23, 7, 4, 'display_width', 'Display width', 'text_small', 1, '', '', '', 0);
INSERT INTO `modules_fields` VALUES (34, 4, 4, 'order', 'Order', 'text_small', 1, '', '', '', 0);
INSERT INTO `modules_fields` VALUES (312, 2, 4, 'tooltip', 'Tooltip', 'textarea_small', 1, '', '', '', 0);
INSERT INTO `modules_fields` VALUES (321, 3, 4, 'fieldset', 'Fieldset', '', 1, '', 'Fields of the same fieldset will be grouped together', '', 0);
INSERT INTO `modules_fields` VALUES (327, 10, 4, 'specific_search', 'Specific search', 'yes_no', 1, '', 'If selected this column will be given it''s own search field in forms', '', 0);
INSERT INTO `modules_fields` VALUES (39, 1, 5, 'id', 'ID', 'id', 0, '10%', '', '', 0);
INSERT INTO `modules_fields` VALUES (40, 2, 5, 'name', 'Rule Name', 'module_validation_rule', 1, '30%', '', '', 0);
INSERT INTO `modules_fields` VALUES (43, 4, 5, 'field_id', 'Field', 'module_field', 1, '30%', '', '', 0);

CREATE TABLE `modules_fields_validation` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `field_id` int(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=27 ;

INSERT INTO `modules_fields_validation` VALUES (16, 'instance', 19);
INSERT INTO `modules_fields_validation` VALUES (17, 'instance', 18);
INSERT INTO `modules_fields_validation` VALUES (18, 'instance', 20);
INSERT INTO `modules_fields_validation` VALUES (19, 'unique_current', 18);
INSERT INTO `modules_fields_validation` VALUES (20, 'unique', 8);
INSERT INTO `modules_fields_validation` VALUES (21, 'instance', 8);
INSERT INTO `modules_fields_validation` VALUES (22, 'instance', 14);
INSERT INTO `modules_fields_validation` VALUES (23, 'unique', 35);
INSERT INTO `modules_fields_validation` VALUES (24, 'instance', 35);
INSERT INTO `modules_fields_validation` VALUES (25, 'instance', 9);
INSERT INTO `modules_fields_validation` VALUES (26, 'boolean_true', 19);

CREATE TABLE `modules_fields_validation_arguments` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `validation_id` int(32) NOT NULL,
  `index` int(2) NOT NULL,
  `value` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=21 ;


CREATE TABLE IF NOT EXISTS `categories` (
  `cat_id` int(11) NOT NULL auto_increment,
  `cat_name` varchar(150) collate utf8_swedish_ci NOT NULL,
  `yt_slug` varchar(150) collate utf8_swedish_ci NOT NULL,
  `cat_desc` varchar(500) collate utf8_swedish_ci default NULL,
  PRIMARY KEY  (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `channels` (
  `cat_id` int(11) NOT NULL auto_increment,
  `child_of` int(11) NOT NULL,
  `cat_name` varchar(150) collate utf8_swedish_ci NOT NULL,
  `yt_slug` varchar(150) collate utf8_swedish_ci NOT NULL,
  `cat_desc` varchar(500) collate utf8_swedish_ci default NULL,
  PRIMARY KEY  (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;


CREATE TABLE IF NOT EXISTS `follow` (
  `id` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL,
  `fid` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `likes` (
  `id` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL,
  `vid` varchar(200) collate utf8_swedish_ci NOT NULL,
  `type` varchar(200) collate utf8_swedish_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;


CREATE TABLE IF NOT EXISTS `tags` (
  `tagid` int(11) NOT NULL auto_increment,
  `tag` varchar(50) collate utf8_swedish_ci NOT NULL,
  `tcount` int(11) NOT NULL,
  PRIMARY KEY  (`tagid`),
  KEY `tag` (`tag`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=0 ;


CREATE TABLE IF NOT EXISTS `user_wall` (
  `msg_id` int(11) NOT NULL auto_increment,
  `u_id` int(16) NOT NULL,
  `message` varchar(200) default NULL,
  `att` varchar(280) NOT NULL,
  `time` varchar(200) NOT NULL,
  PRIMARY KEY  (`msg_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `videos` (
  `id` int(11) NOT NULL auto_increment,
  `youtube_id` varchar(30) collate utf8_swedish_ci NOT NULL,
  `title` varchar(300) collate utf8_swedish_ci NOT NULL,
  `duration` int(10) NOT NULL,
  `description` varchar(500) collate utf8_swedish_ci NOT NULL,
  `tags` varchar(500) collate utf8_swedish_ci NOT NULL,
  `category` varchar(500) collate utf8_swedish_ci NOT NULL,
  `views` int(11) NOT NULL,
  `liked` int(11) NOT NULL,
  `disliked` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=0 ;


INSERT INTO `categories` (`cat_id`, `cat_name`, `yt_slug`, `cat_desc`) VALUES
(18486, 'Trailers', 'Trailers', NULL),
(18485, 'Movies - Thriller', 'Movies_Thriller', NULL),
(18484, 'Sci-Fi/Fantasy Movies ', 'Movies_Sci_fi_fantasy', 'Sci-Fi/Fantasy Movies '),
(18483, 'Shows', 'Shows', NULL),
(18482, 'Movies - Shorts', 'Movies_Shorts', NULL),
(18481, 'Movies - Family', 'Movies_Family', NULL),
(18480, 'Movies - Drama', 'Movies_Drama', NULL),
(18479, 'Movies - Horror', 'Movies_Horror', NULL),
(18478, 'Movies - Foreign', 'Movies_Foreign', NULL),
(18477, 'Classic Movies ', 'Movies_Classics', 'Classic Movies '),
(18476, 'Adventure Movies ', 'Movies_Action_adventure', 'Adventure Movies, Adventure Movies trailers'),
(18475, 'Documentary Movies ', 'Movies_Documentary', 'Documentary Movies '),
(18474, 'Comedy Movies ', 'Movies_Comedy', 'Comedy Movies '),
(18473, 'Movies', 'Movies', NULL),
(18472, 'Anime Movies', 'Movies_Anime_animation', 'Anime Movies and Animation Movies'),
(18471, 'Science', 'Tech', 'Science Technology'),
(18470, 'Nonprofit or Activism', 'Nonprofit', 'Nonprofit or Activism'),
(18469, 'Howto & Style', 'Howto', NULL),
(18468, 'Education', 'Education', NULL),
(18467, 'Entertainment', 'Entertainment', NULL),
(18466, 'News & Politics', 'News', NULL),
(18465, 'People & Blogs', 'People', NULL),
(18464, 'Comedy', 'Comedy', 'Comedy videos and Comedy Movies'),
(18463, 'Gaming', 'Games', NULL),
(18462, 'Videoblogging', 'Videoblog', NULL),
(18461, 'Short Movies', 'Shortmov', NULL),
(18460, 'Travel & Events', 'Travel', NULL),
(18459, 'Sports', 'Sports', NULL),
(18458, 'Pets & Animals', 'Animals', NULL),
(18457, 'Music', 'Music', NULL),
(18456, 'Autos : Auto Videos', 'Autos', 'Video of cars and autos!'),
(18455, 'Film & Animation', 'Film', NULL);


CREATE TABLE IF NOT EXISTS `em_comments` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `object_id` varchar(64) NOT NULL,
  `created` datetime NOT NULL,
  `sender_name` varchar(128) default NULL,
  `sender_id` varchar(128) default NULL,
  `sender_ip` varchar(128) default NULL,
  `comment_text` text,
  `admin_reply` enum('0','1') NOT NULL default '0',
  `rating_cache` int(11) NOT NULL default '0',
  `access_key` varchar(100) default NULL,
  `visible` enum('0','1') NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `object_id` (`object_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



CREATE TABLE IF NOT EXISTS `em_likes` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `comment_id` int(10) unsigned NOT NULL,
  `sender_ip` bigint(20) NOT NULL,
  `vote` enum('1','-1') NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `comment_id` (`comment_id`),
  KEY `sender_ip` (`sender_ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
