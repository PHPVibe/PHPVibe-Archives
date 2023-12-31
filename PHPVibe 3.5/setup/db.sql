CREATE TABLE IF NOT EXISTS `#db-prefix#activity` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `type` int(11) NOT NULL,
  `object` int(11) NOT NULL,
  `extra` mediumtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;


CREATE TABLE IF NOT EXISTS `#db-prefix#channels` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `child_of` int(11) DEFAULT NULL,
  `picture` varchar(150) NOT NULL,
  `cat_name` varchar(150) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `cat_desc` varchar(500) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;
CREATE TABLE IF NOT EXISTS `#db-prefix#em_comments` (
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

CREATE TABLE IF NOT EXISTS `#db-prefix#em_likes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` int(10) unsigned NOT NULL,
  `sender_ip` bigint(20) NOT NULL,
  `vote` enum('1','-1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `comment_id` (`comment_id`),
  KEY `sender_ip` (`sender_ip`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `#db-prefix#homepage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order` int(11) NOT NULL,
  `title` longtext NOT NULL,
  `type` varchar(200) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `ident` varchar(200) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `querystring` varchar(200) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `total` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `#db-prefix#likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `vid` varchar(200) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `type` varchar(200) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `#db-prefix#options` (
  `option_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(64) NOT NULL DEFAULT '',
  `option_value` longtext NOT NULL,
  `autoload` varchar(20) NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `option_name` (`option_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `#db-prefix#playlists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner` int(11) NOT NULL,
  `picture` varchar(150) NOT NULL,
  `title` varchar(150) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `description` varchar(500) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  `views` mediumint(9) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `#db-prefix#playlist_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `playlist` int(11) NOT NULL,
  `video_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `#db-prefix#reports` (
  `r_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `vid` varchar(200) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `reason` longtext CHARACTER SET utf8 COLLATE utf8_swedish_ci,
  `motive` longtext NOT NULL,
  PRIMARY KEY (`r_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `#db-prefix#tags` (
  `tagid` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `tcount` int(11) NOT NULL,
  PRIMARY KEY (`tagid`),
  KEY `tag` (`tag`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `#db-prefix#users` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `pass` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `password` mediumtext COLLATE utf8_swedish_ci NOT NULL,
  `lastlogin` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `group_id` varchar(255) COLLATE utf8_swedish_ci NOT NULL DEFAULT '4',
  `avatar` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `cover` mediumtext COLLATE utf8_swedish_ci NOT NULL,
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

CREATE TABLE IF NOT EXISTS `#db-prefix#users_friends` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `fid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `#db-prefix#users_groups` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `default_value` tinyint(1) NOT NULL,
  `access_level` bigint(32) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=0 ;


CREATE TABLE IF NOT EXISTS `#db-prefix#videos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pub` int(11) NOT NULL DEFAULT '1',
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
  `embed` longtext COLLATE utf8_swedish_ci NOT NULL,
  `remote` longtext COLLATE utf8_swedish_ci NOT NULL,
  `srt` mediumtext COLLATE utf8_swedish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `#db-prefix#videos_tmp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `path` mediumtext CHARACTER SET utf8 COLLATE utf8_swedish_ci,
  `ext` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;


CREATE TABLE IF NOT EXISTS `#db-prefix#crons` (
  `cron_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cron_type` varchar(500) NOT NULL,
  `cron_name` varchar(64) NOT NULL DEFAULT '',
  `cron_period` mediumint(9) NOT NULL DEFAULT '86400',
  `cron_pages` int(11) NOT NULL DEFAULT '5',
  `cron_lastrun` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cron_value` longtext NOT NULL,
  PRIMARY KEY (`cron_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;


CREATE TABLE IF NOT EXISTS `#db-prefix#langs` (
  `lang_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `term` longtext NOT NULL,
  PRIMARY KEY (`lang_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;


CREATE TABLE IF NOT EXISTS `#db-prefix#languages` (
  `term_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `lang_name` varchar(204) NOT NULL DEFAULT '',
  `lang_code` varchar(64) NOT NULL DEFAULT '',
  `lang_terms` longtext NOT NULL,
  PRIMARY KEY (`term_id`),
  UNIQUE KEY `lang_code` (`lang_code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

INSERT INTO `#db-prefix#langs` (`lang_id`, `term`) VALUES
(1, 'Show sidebar'),
(2, 'Upload a file'),
(3, 'Share media by '),
(4, 'Notifications'),
(5, 'My profile'),
(6, 'Profile Management'),
(7, 'Change password'),
(8, 'Logout'),
(9, 'Search videos'),
(10, 'Browse'),
(11, 'Most Viewed'),
(12, 'Featured'),
(13, 'Most Liked'),
(14, 'My stuff'),
(15, 'Create playlist'),
(16, 'Manage playlists'),
(17, 'Manage likes'),
(18, 'Manage videos'),
(19, 'Back one level'),
(20, 'Subions'),
(21, 'My playlists'),
(22, 'Play all'),
(23, 'by'),
(24, 'views'),
(25, 'Facebook fans'),
(26, 'Top playlists'),
(27, 'Newest users'),
(28, '404'),
(29, 'oops! page not found'),
(30, 'Back to home'),
(290, 'Featured Description'),
(289, 'Waiting for upload'),
(288, 'Video details'),
(287, 'Share a video'),
(286, 'share'),
(285, 'Disliked a video'),
(284, 'liked a video'),
(283, 'in playlist '),
(282, 'collected a video'),
(281, 'on video'),
(280, 'commented'),
(279, 'shared a video'),
(278, 'Login first!'),
(277, 'Most Viewed Description'),
(275, 'watched a video'),
(276, 'Browse Description'),
(274, 'Error. Please go back'),
(273, 'Most Liked Description'),
(272, 'Sorry but there are no results.'),
(271, 'This URL is invalid or the video is removed by the provider.'),
(270, 'Unknown provider or incorrect URL. Please try again.'),
(269, 'Popular channels'),
(268, 'Buzz'),
(267, 'Subscribed to'),
(266, 'Subscribers'),
(263, 'Name'),
(264, 'About'),
(265, 'Reported by'),
(262, 'Avatar'),
(261, 'Subscriptions'),
(260, 'Share media by link'),
(259, 'Owner'),
(258, 'Playlist'),
(257, 'Create channel'),
(256, 'Channel image'),
(255, 'Description'),
(254, 'Choose a parentcategory:'),
(253, 'Child of:'),
(252, 'Your channel''s title'),
(251, 'Title'),
(248, 'Channel'),
(249, 'Delete selected'),
(250, 'Delete'),
(247, 'Details & embed'),
(246, 'Please login in order to collect videos.'),
(245, 'Please login in order to report videos.'),
(244, 'Report video'),
(243, 'Add To'),
(242, 'Dislike'),
(241, 'Like'),
(240, 'Subscribe'),
(239, 'Classic registration'),
(238, 'Google'),
(237, 'Google login'),
(236, 'Twitter'),
(235, 'Twitter login'),
(234, 'Facebook'),
(233, 'Facebook login'),
(232, 'Login'),
(231, 'Loading the player...'),
(230, 'Add video'),
(229, 'Safe'),
(228, 'Not safe'),
(225, 'Description:'),
(226, 'Tags:'),
(227, 'NSFW:'),
(224, 'Choose a category:'),
(223, 'Category:'),
(222, 'In seconds'),
(221, 'Duration:'),
(220, 'Link to web image file.'),
(217, 'Title:'),
(218, 'Thumbnail:'),
(219, 'http://www.dailymotion.com/img/x116zuj_imbroglio_shortfilms.jpg'),
(216, 'New video details'),
(214, 'Continue'),
(215, 'Share video by iframe/embed'),
(213, 'Remote file (direct link to .mp4,.flv file)'),
(211, 'OR'),
(212, 'http://www.mycustomhost.com/video/rihanna-file.mp4'),
(210, 'Link to video (Youtube, Metacafe, etc)'),
(208, 'Social video link:'),
(209, 'http://www.dailymotion.com/video/x116zuj_imbroglio_shortfilms'),
(207, 'New video'),
(206, 'Unfeature video'),
(205, 'Publish video'),
(204, 'Permanently delete video'),
(203, 'Publish selected'),
(202, 'View'),
(201, 'Feature video'),
(200, 'Edit'),
(199, 'Unpublish'),
(198, 'Unpublish selected'),
(197, 'Likes'),
(196, 'Duration'),
(195, 'Video'),
(194, 'Thumb'),
(193, 'Last'),
(192, 'First'),
(191, 'Update settings'),
(190, 'Reports'),
(189, 'Comments'),
(188, 'Playlists'),
(187, 'Video likes'),
(186, 'Video views'),
(185, 'Members'),
(184, 'Videos'),
(183, 'Username & password'),
(291, 'ilike'),
(292, 'Reason for reporting'),
(293, 'Video not playing'),
(294, 'Wrong title/description'),
(295, 'Video is offensive'),
(296, 'Video is restricted'),
(297, 'Copyrighted material'),
(298, 'Details of the report'),
(299, 'Send report'),
(300, 'You have no playlists that don''t contain this video'),
(301, 'enterComment'),
(302, 'comment'),
(303, 'Share video by link'),
(304, 'Sign in to Your Account'),
(305, 'Email'),
(306, 'Email address'),
(307, 'Password'),
(308, 'forgot your password?'),
(309, 'Your Password'),
(310, 'Sign in'),
(311, 'Join with '),
(312, 'It''s you'),
(313, 'Interesting people'),
(314, 'created successfully.'),
(315, 'Manage videos.'),
(316, 'Upload avatar'),
(317, 'Unsubscribe'),
(318, 'Collect in selected'),
(319, 'registration'),
(320, 'Create a new Account'),
(321, 'Your stage name'),
(322, 'Choose Password'),
(323, 'Repeat Password'),
(324, 'City'),
(325, 'Country'),
(326, 'Register'),
(327, 'About you'),
(328, 'Gender'),
(329, 'Male'),
(330, 'Female'),
(331, 'Social profiles can be left blank, if added they become public.'),
(332, 'Facebook page'),
(333, 'my.fan.url'),
(334, 'Without'),
(335, 'Google Plus'),
(336, 'my.google.id'),
(337, 'my.twitter.id'),
(338, 'Save changes'),
(339, 'Control panel'),
(340, 'Avatar changed.'),
(341, 'liked a comment'),
(342, 'Subscription added!'),
(343, 'You'),
(344, 'this'),
(345, 'Link to original video image file. Don''t change this to use video default (if any in left)'),
(346, 'We don''t support yet embeds from that website'),
(347, 'Videos unpublished.'),
(348, 'Video unpublished.'),
(349, 'Your playlist''s title'),
(350, 'Playlist image'),
(351, 'You and XXX'),
(352, 'You like this'),
(353, 'Liked'),
(354, 'Remove selected'),
(355, 'Remove rating'),
(356, 'Image'),
(357, 'Select only if you wish to change the image'),
(358, 'Duration (in seconds):'),
(359, 'No change'),
(360, 'Initial category is'),
(361, 'Update video'),
(362, 'Wrong username or password.'),
(363, 'Unknown provider or incorrect URL. Please try again.'),
(379, 'Facebook login'),
(380, 'Classic registration'),
(381, 'Unknown provider or incorrect URL. Please try again.'),
(382, 'Twitter login'),
(383, 'Back one level'),
(384, 'Login'),
(385, 'Back one level'),
(386, 'Video likes'),
(387, 'Twitter login'),
(388, 'Most Liked'),
(389, 'oops! page not found'),
(390, 'Back one level'),
(391, 'Sign in'),
(392, 'Join with '),
(393, 'Twitter'),
(394, 'Most Viewed'),
(395, 'Password'),
(396, 'Facebook login'),
(397, 'Featured'),
(398, 'Your Password'),
(399, 'Show sidebar'),
(400, 'Videos'),
(401, 'Most Liked'),
(402, 'This URL is invalid or the video is removed by the provider.'),
(403, 'Browse'),
(404, 'Browse'),
(405, 'Show sidebar'),
(406, 'Videos'),
(407, 'Unknown provider or incorrect URL. Please try again.'),
(408, 'Classic registration'),
(409, 'Twitter login'),
(410, 'Google '),
(411, 'Show sidebar'),
(412, 'Facebook login'),
(413, 'Most Viewed'),
(414, 'Playlists'),
(415, 'Email address'),
(416, 'Most Viewed'),
(417, 'Login'),
(418, 'Password'),
(419, 'language-name'),
(420, 'Hide'),
(421, 'Link to video'),
(422, 'Embed code'),
(423, 'Import selected'),
(424, 'Recover password');

INSERT INTO `#db-prefix#languages` (`term_id`, `lang_name`, `lang_code`, `lang_terms`) VALUES
(1, 'English', 'en', 'a:225:{s:13:"language-name";s:7:"English";s:12:"Show sidebar";s:12:"Show sidebar";s:13:"Upload a file";s:13:"Upload a file";s:15:"Share media by ";s:15:"Share media by ";s:13:"Notifications";s:13:"Notifications";s:10:"My profile";s:10:"My profile";s:18:"Profile Management";s:18:"Profile Management";s:15:"Change password";s:15:"Change password";s:6:"Logout";s:6:"Logout";s:13:"Search videos";s:13:"Search videos";s:6:"Browse";s:6:"Browse";s:11:"Most Viewed";s:11:"Most Viewed";s:8:"Featured";s:8:"Featured";s:10:"Most Liked";s:10:"Most Liked";s:8:"My stuff";s:8:"My stuff";s:15:"Create playlist";s:15:"Create playlist";s:16:"Manage playlists";s:16:"Manage playlists";s:12:"Manage likes";s:12:"Manage likes";s:13:"Manage videos";s:13:"Manage videos";s:14:"Back one level";s:14:"Back one level";s:7:"Subions";s:7:"Subions";s:12:"My playlists";s:12:"My playlists";s:8:"Play all";s:8:"Play all";s:2:"by";s:2:"by";s:5:"views";s:5:"views";s:13:"Facebook fans";s:13:"Facebook fans";s:13:"Top playlists";s:13:"Top playlists";s:12:"Newest users";s:12:"Newest users";i:404;s:3:"404";s:20:"oops! page not found";s:20:"oops! page not found";s:12:"Back to home";s:12:"Back to home";s:20:"Featured Description";s:20:"Featured Description";s:18:"Waiting for upload";s:18:"Waiting for upload";s:13:"Video details";s:13:"Video details";s:13:"Share a video";s:13:"Share a video";s:5:"share";s:5:"share";s:16:"Disliked a video";s:16:"Disliked a video";s:13:"liked a video";s:13:"liked a video";s:12:"in playlist ";s:12:"in playlist ";s:17:"collected a video";s:17:"collected a video";s:8:"on video";s:8:"on video";s:9:"commented";s:9:"commented";s:14:"shared a video";s:14:"shared a video";s:12:"Login first!";s:12:"Login first!";s:23:"Most Viewed Description";s:23:"Most Viewed Description";s:15:"watched a video";s:15:"watched a video";s:18:"Browse Description";s:18:"Browse Description";s:21:"Error. Please go back";s:21:"Error. Please go back";s:22:"Most Liked Description";s:22:"Most Liked Description";s:31:"Sorry but there are no results.";s:31:"Sorry but there are no results.";s:60:"This URL is invalid or the video is removed by the provider.";s:60:"This URL is invalid or the video is removed by the provider.";s:52:"Unknown provider or incorrect URL. Please try again.";s:52:"Unknown provider or incorrect URL. Please try again.";s:16:"Popular channels";s:16:"Popular channels";s:4:"Buzz";s:4:"Buzz";s:13:"Subscribed to";s:13:"Subscribed to";s:11:"Subscribers";s:11:"Subscribers";s:4:"Name";s:4:"Name";s:5:"About";s:5:"About";s:11:"Reported by";s:11:"Reported by";s:6:"Avatar";s:6:"Avatar";s:13:"Subscriptions";s:13:"Subscriptions";s:19:"Share media by link";s:19:"Share media by link";s:5:"Owner";s:5:"Owner";s:8:"Playlist";s:8:"Playlist";s:14:"Create channel";s:14:"Create channel";s:13:"Channel image";s:13:"Channel image";s:11:"Description";s:11:"Description";s:24:"Choose a parentcategory:";s:24:"Choose a parentcategory:";s:9:"Child of:";s:9:"Child of:";s:20:"Your channel''s title";s:20:"Your channel''s title";s:5:"Title";s:5:"Title";s:7:"Channel";s:7:"Channel";s:15:"Delete selected";s:15:"Delete selected";s:6:"Delete";s:6:"Delete";s:15:"Details & embed";s:15:"Details & embed";s:40:"Please login in order to collect videos.";s:40:"Please login in order to collect videos.";s:39:"Please login in order to report videos.";s:39:"Please login in order to report videos.";s:12:"Report video";s:12:"Report video";s:6:"Add To";s:6:"Add To";s:7:"Dislike";s:7:"Dislike";s:4:"Like";s:4:"Like";s:9:"Subscribe";s:9:"Subscribe";s:20:"Classic registration";s:20:"Classic registration";s:6:"Google";s:6:"Google";s:12:"Google login";s:12:"Google login";s:7:"Twitter";s:7:"Twitter";s:13:"Twitter login";s:13:"Twitter login";s:8:"Facebook";s:8:"Facebook";s:14:"Facebook login";s:14:"Facebook login";s:5:"Login";s:5:"Login";s:21:"Loading the player...";s:21:"Loading the player...";s:9:"Add video";s:9:"Add video";s:4:"Safe";s:4:"Safe";s:8:"Not safe";s:8:"Not safe";s:12:"Description:";s:12:"Description:";s:5:"Tags:";s:5:"Tags:";s:5:"NSFW:";s:5:"NSFW:";s:18:"Choose a category:";s:18:"Choose a category:";s:9:"Category:";s:9:"Category:";s:10:"In seconds";s:10:"In seconds";s:9:"Duration:";s:9:"Duration:";s:23:"Link to web image file.";s:23:"Link to web image file.";s:6:"Title:";s:6:"Title:";s:10:"Thumbnail:";s:10:"Thumbnail:";s:63:"http://www.dailymotion.com/img/x116zuj_imbroglio_shortfilms.jpg";s:63:"http://www.dailymotion.com/img/x116zuj_imbroglio_shortfilms.jpg";s:17:"New video details";s:17:"New video details";s:8:"Continue";s:8:"Continue";s:27:"Share video by iframe/embed";s:27:"Share video by iframe/embed";s:43:"Remote file (direct link to .mp4,.flv file)";s:43:"Remote file (direct link to .mp4,.flv file)";s:2:"OR";s:2:"OR";s:50:"http://www.mycustomhost.com/video/rihanna-file.mp4";s:50:"http://www.mycustomhost.com/video/rihanna-file.mp4";s:38:"Link to video (Youtube, Metacafe, etc)";s:38:"Link to video (Youtube, Metacafe, etc)";s:18:"Social video link:";s:18:"Social video link:";s:61:"http://www.dailymotion.com/video/x116zuj_imbroglio_shortfilms";s:61:"http://www.dailymotion.com/video/x116zuj_imbroglio_shortfilms";s:9:"New video";s:9:"New video";s:15:"Unfeature video";s:15:"Unfeature video";s:13:"Publish video";s:13:"Publish video";s:24:"Permanently delete video";s:24:"Permanently delete video";s:16:"Publish selected";s:16:"Publish selected";s:4:"View";s:4:"View";s:13:"Feature video";s:13:"Feature video";s:4:"Edit";s:4:"Edit";s:9:"Unpublish";s:9:"Unpublish";s:18:"Unpublish selected";s:18:"Unpublish selected";s:5:"Likes";s:5:"Likes";s:8:"Duration";s:8:"Duration";s:5:"Video";s:5:"Video";s:5:"Thumb";s:5:"Thumb";s:4:"Last";s:4:"Last";s:5:"First";s:5:"First";s:15:"Update settings";s:15:"Update settings";s:7:"Reports";s:7:"Reports";s:8:"Comments";s:8:"Comments";s:9:"Playlists";s:9:"Playlists";s:11:"Video likes";s:11:"Video likes";s:11:"Video views";s:11:"Video views";s:7:"Members";s:7:"Members";s:6:"Videos";s:6:"Videos";s:19:"Username & password";s:19:"Username & password";s:5:"ilike";s:5:"ilike";s:20:"Reason for reporting";s:20:"Reason for reporting";s:17:"Video not playing";s:17:"Video not playing";s:23:"Wrong title/description";s:23:"Wrong title/description";s:18:"Video is offensive";s:18:"Video is offensive";s:19:"Video is restricted";s:19:"Video is restricted";s:20:"Copyrighted material";s:20:"Copyrighted material";s:21:"Details of the report";s:21:"Details of the report";s:11:"Send report";s:11:"Send report";s:51:"You have no playlists that don''t contain this video";s:51:"You have no playlists that don''t contain this video";s:12:"enterComment";s:12:"enterComment";s:7:"comment";s:7:"comment";s:19:"Share video by link";s:19:"Share video by link";s:23:"Sign in to Your Account";s:23:"Sign in to Your Account";s:5:"Email";s:5:"Email";s:13:"Email address";s:13:"Email address";s:8:"Password";s:8:"Password";s:21:"forgot your password?";s:21:"forgot your password?";s:13:"Your Password";s:13:"Your Password";s:7:"Sign in";s:7:"Sign in";s:10:"Join with ";s:10:"Join with ";s:8:"It''s you";s:8:"It''s you";s:18:"Interesting people";s:18:"Interesting people";s:21:"created successfully.";s:21:"created successfully.";s:14:"Manage videos.";s:14:"Manage videos.";s:13:"Upload avatar";s:13:"Upload avatar";s:11:"Unsubscribe";s:11:"Unsubscribe";s:19:"Collect in selected";s:19:"Collect in selected";s:12:"registration";s:12:"registration";s:20:"Create a new Account";s:20:"Create a new Account";s:15:"Your stage name";s:15:"Your stage name";s:15:"Choose Password";s:15:"Choose Password";s:15:"Repeat Password";s:15:"Repeat Password";s:4:"City";s:4:"City";s:7:"Country";s:7:"Country";s:8:"Register";s:8:"Register";s:9:"About you";s:9:"About you";s:6:"Gender";s:6:"Gender";s:4:"Male";s:4:"Male";s:6:"Female";s:6:"Female";s:63:"Social profiles can be left blank, if added they become public.";s:63:"Social profiles can be left blank, if added they become public.";s:13:"Facebook page";s:13:"Facebook page";s:10:"my.fan.url";s:10:"my.fan.url";s:7:"Without";s:7:"Without";s:11:"Google Plus";s:11:"Google Plus";s:12:"my.google.id";s:12:"my.google.id";s:13:"my.twitter.id";s:13:"my.twitter.id";s:12:"Save changes";s:12:"Save changes";s:13:"Control panel";s:13:"Control panel";s:15:"Avatar changed.";s:15:"Avatar changed.";s:15:"liked a comment";s:15:"liked a comment";s:19:"Subscription added!";s:19:"Subscription added!";s:3:"You";s:3:"You";s:4:"this";s:4:"this";s:90:"Link to original video image file. Don''t change this to use video default (if any in left)";s:90:"Link to original video image file. Don''t change this to use video default (if any in left)";s:45:"We don''t support yet embeds from that website";s:45:"We don''t support yet embeds from that website";s:19:"Videos unpublished.";s:19:"Videos unpublished.";s:18:"Video unpublished.";s:18:"Video unpublished.";s:21:"Your playlist''s title";s:21:"Your playlist''s title";s:14:"Playlist image";s:14:"Playlist image";s:11:"You and XXX";s:11:"You and XXX";s:13:"You like this";s:13:"You like this";s:5:"Liked";s:5:"Liked";s:15:"Remove selected";s:15:"Remove selected";s:13:"Remove rating";s:13:"Remove rating";s:5:"Image";s:5:"Image";s:43:"Select only if you wish to change the image";s:43:"Select only if you wish to change the image";s:22:"Duration (in seconds):";s:22:"Duration (in seconds):";s:9:"No change";s:9:"No change";s:19:"Initial category is";s:19:"Initial category is";s:12:"Update video";s:12:"Update video";s:27:"Wrong username or password.";s:27:"Wrong username or password.";s:4:"Hide";s:4:"Hide";s:13:"Link to video";s:13:"Link to video";s:10:"Embed code";s:10:"Embed code";s:15:"Import selected";s:15:"Import selected";s:16:"Recover password";s:16:"Recover password";s:7:"Recover";s:7:"Recover";s:13:"Video edited.";s:13:"Video edited.";s:9:" updated.";s:9:" updated.";s:15:"Change language";s:15:"Change language";}');


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

CREATE TABLE IF NOT EXISTS `#db-prefix#postcats` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `picture` varchar(150) NOT NULL,
  `cat_name` varchar(150) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `cat_desc` varchar(500) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;
CREATE TABLE IF NOT EXISTS `#db-prefix#posts` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `ch` int(11) NOT NULL DEFAULT '1',
  `date` text COLLATE utf8_swedish_ci NOT NULL,
  `title` varchar(300) COLLATE utf8_swedish_ci NOT NULL,
  `pic` longtext COLLATE utf8_swedish_ci NOT NULL,
  `content` longtext COLLATE utf8_swedish_ci NOT NULL,
  `tags` varchar(500) COLLATE utf8_swedish_ci NOT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=0 ;
ALTER TABLE  `#db-prefix#videos` ADD  `privacy` INT( 255 ) NOT NULL DEFAULT  '0';
ALTER TABLE  `#db-prefix#channels` ADD  `type` INT( 255 ) NOT NULL DEFAULT  '1';
ALTER TABLE  `#db-prefix#channels` ADD  `sub` INT NOT NULL DEFAULT  '1';
ALTER TABLE  `#db-prefix#videos` ADD  `media` INT NOT NULL DEFAULT  '1' AFTER  `id` ;
Update `#db-prefix#videos` set media = '2' WHERE source like '%.mp3';
UPDATE `#db-prefix#videos` set media = '3' WHERE source like 'localimage%';
ALTER TABLE  `#db-prefix#homepage` CHANGE  `order`  `ord` INT( 11 ) NOT NULL ;
ALTER TABLE  `#db-prefix#homepage` ADD  `mtype` INT NOT NULL DEFAULT  '1';