SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(32) NOT NULL,
  `category_slug` varchar(64) NOT NULL,
  `category_description` longtext,
  `category_media` int(11) DEFAULT NULL,
  `category_parent` int(11) DEFAULT NULL,
  `category_item_count` int(11) DEFAULT NULL,
  `category_order` int(11) DEFAULT NULL,
  `category_type` varchar(32) NOT NULL,
  `category_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`category_id`),
  KEY `category_slug` (`category_slug`),
  FULLTEXT KEY `category_name` (`category_name`,`category_description`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

INSERT INTO `categories` (`category_id`, `category_name`, `category_slug`, `category_description`, `category_media`, `category_parent`, `category_item_count`, `category_order`, `category_type`, `category_ts`) VALUES
(1, 'Sample category 1', 'sample-category-1', '', 0, 0, 1, 0, 'blog', '2015-04-25 09:38:33'),
(2, 'Sample category 2', 'sample-category-2', '', 0, 0, 0, 0, 'blog', '2015-04-28 18:51:06'),
(4, 'Test', 'test', 'ad<br>', 0, 0, NULL, 0, 'catalog', '2015-05-22 10:45:43'),
(14, 'abc', 'abc', '', 0, 0, NULL, 0, 'catalog_catagories', '2015-11-17 17:54:43'),
(17, 'master', 'master-2', '', 36, 0, NULL, 0, 'catalog_catagories', '2015-11-17 17:55:51');

CREATE TABLE `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `items_count` int(11) NOT NULL,
  `structure` longtext NOT NULL,
  `raw` longtext NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ts_modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

INSERT INTO `menus` (`id`, `name`, `items_count`, `structure`, `raw`, `ts`, `ts_modified`) VALUES
(1, 'Test', 0, '[{"parent":"0","objectid":"","url":"","type":"","label":"","title":"","css":"","description":"","image":"","children":[]},{"parent":"0","objectid":"48","url":"test-page","type":"page","label":"Test page","title":"","css":"","description":"","image":"","children":[{"parent":"2","objectid":"48","url":"test-page","type":"page","label":"Test page","title":"","css":"","description":"","image":"","children":[{"parent":"3","objectid":"48","url":"test-page","type":"page","label":"Test page","title":"","css":"","description":"","image":"","children":[]}]}]},{"parent":"0","objectid":"48","url":"test-page","type":"page","label":"Test page","title":"","css":"","description":"","image":"","children":[]},{"parent":"0","objectid":"48","url":"test-page","type":"page","label":"Test page","title":"","css":"","description":"","image":"","children":[]}]', '{"1":{"parent":"0","objectid":"","url":"","type":"","label":"","title":"","css":"","description":"","image":""},"2":{"parent":"0","objectid":"48","url":"test-page","type":"page","label":"Test page","title":"","css":"","description":"","image":""},"3":{"parent":"2","objectid":"48","url":"test-page","type":"page","label":"Test page","title":"","css":"","description":"","image":""},"4":{"parent":"3","objectid":"48","url":"test-page","type":"page","label":"Test page","title":"","css":"","description":"","image":""},"5":{"parent":"0","objectid":"48","url":"test-page","type":"page","label":"Test page","title":"","css":"","description":"","image":""},"6":{"parent":"0","objectid":"48","url":"test-page","type":"page","label":"Test page","title":"","css":"","description":"","image":""}}', '2016-03-22 19:40:59', '0000-00-00 00:00:00'),
(2, 'Test', 0, '', '', '2016-03-22 20:06:41', '0000-00-00 00:00:00');

CREATE TABLE `meta` (
  `meta_id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` int(11) NOT NULL,
  `meta_key` varchar(100) NOT NULL,
  `meta_value` longtext NOT NULL,
  PRIMARY KEY (`meta_id`),
  KEY `meta` (`object_id`,`meta_key`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

INSERT INTO `meta` (`meta_id`, `object_id`, `meta_key`, `meta_value`) VALUES
(1, 35, 'template', '*none'),
(2, 35, 'sidebar', '0'),
(3, 35, 'featured_image', '[""]'),
(5, 48, 'template', 'default'),
(6, 48, 'sidebar', '0'),
(7, 48, 'featured_image', '["53"]'),
(8, 35, 'category', '1');

CREATE TABLE `objects` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `author` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `content` longtext NOT NULL,
  `excerpt` longtext NOT NULL,
  `name` varchar(256) NOT NULL,
  `parent` int(11) NOT NULL,
  `status` varchar(16) NOT NULL DEFAULT 'punlished',
  `comments` int(11) NOT NULL,
  `mimetype` varchar(16) NOT NULL,
  `type` varchar(16) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `name` (`name`),
  KEY `name_2` (`name`,`status`),
  FULLTEXT KEY `title` (`title`,`content`,`excerpt`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=55 ;

INSERT INTO `objects` (`ID`, `author`, `title`, `content`, `excerpt`, `name`, `parent`, `status`, `comments`, `mimetype`, `type`, `ts`, `modified_ts`) VALUES
(48, 1, 'Test page', '', '', 'test-page', 0, 'published', 0, '', 'page', '2016-03-16 17:59:05', '0000-00-00 00:00:00'),
(52, 0, '', '', '', 'test', 0, 'on', 0, '', 'plugin', '2016-03-16 19:22:57', '0000-00-00 00:00:00'),
(35, 1, 'Test Post', '', 'aa', 'test-post', 0, 'published', 0, '', 'blog', '2015-09-10 07:24:20', '0000-00-00 00:00:00');

CREATE TABLE `settings` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_name` varchar(32) NOT NULL,
  `setting_value` longtext NOT NULL,
  `setting_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`setting_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

INSERT INTO `settings` (`setting_id`, `setting_name`, `setting_value`, `setting_ts`) VALUES
(1, 'language', 'en-US', '2015-03-08 08:07:49'),
(36, 'media', '{"thumbnail":{"w":"150","h":"150","c":"1"},"small":{"w":"300","h":"250"},"medium":{"w":"400","h":"350"},"large":{"w":"700","h":"700"},"photo":{"w":"120","h":"120","c":"1"}}', '2015-03-22 08:52:34'),
(37, 'site_title', 'Test title', '2015-03-22 08:56:06'),
(38, 'site_description', 'Test desctiotion', '2015-03-22 08:58:37'),
(39, 'site_url', 'http://google.com', '2015-03-22 08:58:37'),
(40, 'site_email', 'thehanif@msn.com', '2015-03-22 08:58:37'),
(42, 'theme', 'test', '2016-01-26 16:32:54');

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_username` varchar(32) NOT NULL,
  `user_password` varchar(256) NOT NULL,
  `user_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

INSERT INTO `users` (`user_id`, `user_username`, `user_password`, `user_ts`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', '2015-03-09 05:31:08'),
(2, 'test', '098f6bcd4621d373cade4e832627b4f6', '2015-09-10 07:16:13');

CREATE TABLE `user_profiles` (
  `user_profile_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(128) NOT NULL,
  `user_display_name` varchar(128) NOT NULL,
  `user_email` varchar(128) NOT NULL,
  `user_image` varchar(128) NOT NULL,
  `user_role` int(11) NOT NULL,
  PRIMARY KEY (`user_profile_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

INSERT INTO `user_profiles` (`user_profile_id`, `user_id`, `user_name`, `user_display_name`, `user_email`, `user_image`, `user_role`) VALUES
(3, 1, 'Muhammd Hanif', 'Muhammad Hanif', 'hanif@imagiacian.com', 'image', 2),
(4, 2, 'test', 'test', 'test@test.com', 'image', 2);

CREATE TABLE `user_roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_title` varchar(32) NOT NULL,
  `role_description` varchar(250) NOT NULL,
  `role_object` longtext NOT NULL,
  `role_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

INSERT INTO `user_roles` (`role_id`, `role_title`, `role_description`, `role_object`, `role_ts`) VALUES
(2, 'Administrator', 'This role has all the capabilities.', '{"Site":{"manage-appearance":"1","manage-themes":"1","manage-menus":"1"},"Catalog":{"manage-catalog":"1","manage-products":"1","add-products":"1","edit-products":"1","delete-products":"1","manage-reviews":"1","manage-payment-methods":"1","manage-shipping-methods":"1","manage-orders":"1","edit-orders":"1","delete-orders":"1","manage-customers":"1"},"Users":{"manage-users":"1","create-users":"1","delete-users":"1","manage-roles":"1"},"Plugins":{"manage-plugins":"1"},"Settings":{"manage-settings":"1"},"page":{"manage":"1","create":"1","publish":"1","edit":"1","delete":"1"},"blog":{"manage":"1","create":"1","publish":"1","edit":"1","delete":"1"}}', '2015-03-14 16:53:29'),
(3, 'Test', '', 'null', '2015-04-03 14:08:05');
