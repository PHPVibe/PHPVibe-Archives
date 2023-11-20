CREATE TABLE IF NOT EXISTS `backups` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `file` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;


CREATE TABLE IF NOT EXISTS `channels` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `picture` varchar(150) NOT NULL,
  `cat_name` varchar(150) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `yt_slug` varchar(150) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `cat_desc` varchar(500) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;


CREATE TABLE IF NOT EXISTS `em_comments` (
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


CREATE TABLE IF NOT EXISTS `em_likes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` int(10) unsigned NOT NULL,
  `sender_ip` bigint(20) NOT NULL,
  `vote` enum('1','-1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `comment_id` (`comment_id`),
  KEY `sender_ip` (`sender_ip`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;


CREATE TABLE IF NOT EXISTS `homepage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` longtext NOT NULL,
  `type` varchar(200) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `ident` varchar(200) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `querystring` varchar(200) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `total` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;



CREATE TABLE IF NOT EXISTS `likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `vid` varchar(200) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `type` varchar(200) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;



CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8_swedish_ci NOT NULL,
  `table` varchar(32) COLLATE utf8_swedish_ci NOT NULL,
  `slug` varchar(32) COLLATE utf8_swedish_ci NOT NULL,
  `parent_module_id` int(16) NOT NULL,
  `field_uid` int(16) NOT NULL,
  `field_slug` int(16) NOT NULL,
  `field_parent` int(16) NOT NULL,
  `field_orderby` int(16) NOT NULL,
  `orderby_direction` enum('DESC','ASC') COLLATE utf8_swedish_ci NOT NULL DEFAULT 'DESC',
  `management_width` varchar(8) COLLATE utf8_swedish_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `locked` tinyint(1) NOT NULL,
  `lock_records` tinyint(1) NOT NULL,
  `core_module` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=0 ;



CREATE TABLE IF NOT EXISTS `modules_fields` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `order` tinyint(2) NOT NULL,
  `module_id` int(32) NOT NULL,
  `name` varchar(32) COLLATE utf8_swedish_ci NOT NULL,
  `label` varchar(32) COLLATE utf8_swedish_ci NOT NULL,
  `type` varchar(32) COLLATE utf8_swedish_ci NOT NULL,
  `editable` tinyint(1) NOT NULL,
  `display_width` varchar(8) COLLATE utf8_swedish_ci NOT NULL,
  `tooltip` text COLLATE utf8_swedish_ci NOT NULL,
  `fieldset` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `specific_search` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=0 ;



CREATE TABLE IF NOT EXISTS `modules_fields_validation` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `field_id` int(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=0 ;



CREATE TABLE IF NOT EXISTS `modules_fields_validation_arguments` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `validation_id` int(32) NOT NULL,
  `index` int(2) NOT NULL,
  `value` varchar(32) COLLATE utf8_swedish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=0 ;



CREATE TABLE IF NOT EXISTS `playlists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner` int(11) NOT NULL,
  `picture` varchar(150) NOT NULL,
  `title` varchar(150) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `permalink` varchar(150) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `description` varchar(500) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  `views` mediumint(9) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;



CREATE TABLE IF NOT EXISTS `playlist_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `playlist` int(11) NOT NULL,
  `video_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;



CREATE TABLE IF NOT EXISTS `slider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `h3` longtext NOT NULL,
  `h2` longtext NOT NULL,
  `image` longtext NOT NULL,
  `link` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;



CREATE TABLE IF NOT EXISTS `tags` (
  `tagid` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `tcount` int(11) NOT NULL,
  PRIMARY KEY (`tagid`),
  KEY `tag` (`tag`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=0 ;



CREATE TABLE IF NOT EXISTS `users` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `lastlogin` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lastip` varchar(0) COLLATE utf8_swedish_ci NOT NULL,
  `group_id` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `date_registered` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `display_name` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `temporary_password` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `facebook_id` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `twitter_id` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=0 ;



CREATE TABLE IF NOT EXISTS `users_friends` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `fid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;


CREATE TABLE IF NOT EXISTS `users_groups` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `default_value` tinyint(1) NOT NULL,
  `access_level` bigint(32) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=0 ;



CREATE TABLE IF NOT EXISTS `users_messages` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `date_sent` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `recipient` bigint(32) unsigned NOT NULL,
  `sender` bigint(32) unsigned NOT NULL,
  `type` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `message` mediumtext COLLATE utf8_swedish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=0 ;



CREATE TABLE IF NOT EXISTS `users_meta` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `value` mediumtext COLLATE utf8_swedish_ci NOT NULL,
  `user` bigint(32) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=0 ;



CREATE TABLE IF NOT EXISTS `user_wall` (
  `msg_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_id` int(16) NOT NULL,
  `message` varchar(200) COLLATE utf8_swedish_ci DEFAULT NULL,
  `att` varchar(280) COLLATE utf8_swedish_ci NOT NULL,
  `time` varchar(200) COLLATE utf8_swedish_ci NOT NULL,
  PRIMARY KEY (`msg_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=0 ;


CREATE TABLE IF NOT EXISTS `videos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `date` text COLLATE utf8_swedish_ci NOT NULL,
  `featured` int(11) NOT NULL,
  `source` longtext COLLATE utf8_swedish_ci NOT NULL,
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
  PRIMARY KEY (`id`),
  FULLTEXT KEY `search` (`title`,`description`,`tags`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=0 ;


INSERT INTO `modules` (`id`, `name`, `table`, `slug`, `parent_module_id`, `field_uid`, `field_slug`, `field_parent`, `field_orderby`, `orderby_direction`, `management_width`, `type`, `locked`, `lock_records`, `core_module`) VALUES
(3, 'Modules', 'modules', 'modules', 0, 6, 14, 10, 14, 'ASC', '30%', 'module', 1, 1, 1),
(4, 'Fields', 'modules_fields', 'fields', 3, 17, 20, 0, 19, 'DESC', '30%', 'module_field', 1, 1, 1),
(5, 'Validation', 'modules_fields_validation', 'validation', 3, 39, 40, 0, 39, 'DESC', '30%', 'module_field_validation', 1, 1, 1),
(62, 'Users', 'users', 'users', 0, 362, 370, 0, 0, 'DESC', '20%', 'user', 0, 0, 0),
(63, 'Groups', 'users_groups', 'groups', 62, 375, 376, 0, 0, 'ASC', '20%', 'user_group', 0, 0, 0),
(64, 'Meta', 'users_meta', 'meta', 62, 380, 381, 0, 0, 'DESC', '20%', 'user_meta', 0, 0, 0),
(65, 'Backup', 'backups', 'backups', 0, 384, 386, 0, 0, 'DESC', '20%', 'backup', 0, 0, 0),
(66, 'Messages', 'users_messages', 'messages', 62, 387, 388, 0, 389, 'DESC', '20%', 'user_message', 0, 0, 0);



INSERT INTO `modules_fields` (`id`, `order`, `module_id`, `name`, `label`, `type`, `editable`, `display_width`, `tooltip`, `fieldset`, `specific_search`) VALUES
(6, 1, 3, 'id', 'Id', 'id', 0, '10%', '', '', 0),
(8, 3, 3, 'table', 'Table', '', 1, '', '', '', 0),
(9, 6, 3, 'slug', 'Slug', '', 1, '', '', '', 0),
(10, 7, 3, 'parent_module_id', 'Module Parent', 'module', 1, '', '', '', 0),
(11, 8, 3, 'field_uid', 'Id field', 'module_field_current', 1, '', '', '', 0),
(12, 12, 3, 'orderby_direction', 'Default order direction', 'orderby_direction', 1, '', '', '', 0),
(13, 13, 3, 'management_width', 'Options field width', 'text_small', 1, '', '', '', 0),
(14, 2, 3, 'name', 'Name', '', 1, '55%', '', '', 0),
(15, 10, 3, 'field_parent', 'Parent field', 'module_field_current', 1, '', '', '', 0),
(16, 9, 3, 'field_slug', 'Slug field', 'module_field_current', 1, '', '', '', 0),
(25, 11, 3, 'field_orderby', 'Default order by field', 'module_field_current', 1, '', '', '', 0),
(35, 9, 3, 'type', 'Type definition', '', 1, '', '', '', 0),
(50, 10, 3, 'locked', 'Locked', 'yes_no', 1, '', '', '', 0),
(94, 10, 3, 'core_module', 'Core module', 'yes_no', 1, '', '', '', 0),
(91, 9, 3, 'lock_records', 'Lock Records', 'yes_no', 1, '', '', '', 0),
(17, 1, 4, 'id', 'ID', 'id', 0, '10%', '', '', 0),
(18, 3, 4, 'name', 'Name', '', 1, '', '', '', 0),
(19, 6, 4, 'module_id', 'Module', 'module', 1, '30%', '', '', 1),
(20, 2, 4, 'label', 'Label', '', 1, '30%', '', '', 0),
(21, 5, 4, 'type', 'Type', 'type', 1, '', '', '', 0),
(22, 8, 4, 'editable', 'Editable?', 'yes_no', 1, '', '', '', 0),
(23, 7, 4, 'display_width', 'Display width', 'text_small', 1, '', '', '', 0),
(34, 4, 4, 'order', 'Order', 'text_small', 1, '', '', '', 0),
(312, 2, 4, 'tooltip', 'Tooltip', 'textarea_small', 1, '', '', '', 0),
(321, 3, 4, 'fieldset', 'Fieldset', '', 1, '', 'Fields of the same fieldset will be grouped together', '', 0),
(327, 10, 4, 'specific_search', 'Specific search', 'yes_no', 1, '', 'If selected this column will be given it''s own search field in forms', '', 0),
(39, 1, 5, 'id', 'ID', 'id', 0, '10%', '', '', 0),
(40, 2, 5, 'name', 'Rule Name', 'module_validation_rule', 1, '30%', '', '', 0),
(43, 4, 5, 'field_id', 'Field', 'module_field', 1, '30%', '', '', 0),
(362, 1, 62, 'id', 'ID', 'id', 0, '', '', '', 0),
(363, 1, 62, 'email', 'Email', '', 1, '30%', '', '', 0),
(364, 4, 62, 'password', 'Password', 'password', 1, '', '', '', 0),
(365, 8, 62, 'lastlogin', 'Last login', 'datetime_static', 1, '', '', '', 0),
(366, 12, 62, 'lastip', 'Last IP used', 'static', 1, '', '', '', 0),
(367, 5, 62, 'group_id', 'User Group', 'user_group', 1, '', '', '', 0),
(368, 11, 62, 'avatar', 'Profile image', 'file_image', 1, '', '', '', 0),
(369, 7, 62, 'date_registered', 'Date registered', 'datetime_static', 1, '', '', '', 0),
(370, 1, 62, 'display_name', 'Display name', '', 1, '', '', '', 0),
(371, 5, 62, 'temporary_password', 'Temporary password', '', 0, '', '', '', 0),
(372, 12, 62, 'facebook_id', 'Facebook ID', 'static', 1, '', 'If the user has linked their account with Facebook or uses Facebook to login, this is their Facebook account ID.', '', 0),
(373, 13, 62, 'twitter_id', 'Twitter ID', 'static', 1, '', 'If the user has linked their account with Twitter or uses Twitter to login, this is their Twitter account ID.', '', 0),
(374, 3, 62, 'type', 'Type', 'user_type', 1, '', '', '', 0),
(375, 1, 63, 'id', 'ID', 'id', 0, '', '', '', 0),
(376, 2, 63, 'name', 'Name', '', 1, '30%', '', '', 0),
(377, 3, 63, 'admin', 'Users are Admins?', 'yes_no', 1, '', '', '', 0),
(378, 4, 63, 'default_value', 'Default group', 'yes_no', 1, '', '', '', 0),
(379, 5, 63, 'access_level', 'Access Level', 'integer', 1, '', '', '', 0),
(380, 1, 64, 'id', 'ID', 'id', 0, '', '', '', 0),
(381, 2, 64, 'key', 'Key', '', 1, '20%', '', '', 0),
(382, 3, 64, 'value', 'Value', 'textarea_small', 1, '', '', '', 0),
(383, 4, 64, 'user', 'User', 'user', 1, '30%', '', '', 0),
(384, 1, 65, 'id', 'ID', 'id', 0, '', '', '', 0),
(385, 2, 65, 'date_time', 'Date & Time', 'datetime_now', 1, '40%', '', '', 0),
(386, 3, 65, 'file', 'File', 'file', 1, '', '', '', 0),
(387, 1, 66, 'id', 'ID', 'id', 0, '', '', '', 0),
(388, 2, 66, 'subject', 'Subject', '', 1, '20%', '', '', 0),
(389, 3, 66, 'date_sent', 'Date Sent', 'datetime_now', 1, '25%', '', '', 0),
(390, 4, 66, 'recipient', 'Recipient', 'user', 1, '20%', '', '', 0),
(391, 5, 66, 'sender', 'Sender', 'user', 1, '', '', '', 0),
(392, 6, 66, 'type', 'Type', 'user_message_type', 1, '', '', '', 1),
(393, 7, 66, 'message', 'Message', 'rich_text_large', 1, '', '', '', 0);


INSERT INTO `modules_fields_validation` (`id`, `name`, `field_id`) VALUES
(16, 'instance', 19),
(17, 'instance', 18),
(18, 'instance', 20),
(19, 'unique_current', 18),
(20, 'unique', 8),
(21, 'instance', 8),
(22, 'instance', 14),
(23, 'unique', 35),
(24, 'instance', 35),
(25, 'instance', 9),
(26, 'boolean_true', 19),
(27, 'email', 363),
(28, 'instance', 363),
(29, 'unique', 363),
(30, 'instance', 370),
(31, 'instance', 376),
(32, 'instance', 388);

INSERT INTO `users_groups` (`id`, `name`, `admin`, `default_value`, `access_level`) VALUES
(1, 'Administrators', 1, 0, 3),
(2, 'Members', 0, 1, 1),
(3, 'Author', 0, 2, 2);

