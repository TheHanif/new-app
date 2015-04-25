-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 25, 2015 at 10:07 AM
-- Server version: 5.5.20
-- PHP Version: 5.3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `new_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
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
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `category_slug`, `category_description`, `category_media`, `category_parent`, `category_item_count`, `category_order`, `category_type`, `category_ts`) VALUES
(1, 'Sample category 1', 'sample-category-1', '', 0, 0, 5, 0, 'blog', '2015-04-25 09:38:33');

-- --------------------------------------------------------

--
-- Table structure for table `meta`
--

CREATE TABLE IF NOT EXISTS `meta` (
  `meta_id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` int(11) NOT NULL,
  `meta_key` varchar(100) NOT NULL,
  `meta_value` longtext NOT NULL,
  PRIMARY KEY (`meta_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `meta`
--

INSERT INTO `meta` (`meta_id`, `object_id`, `meta_key`, `meta_value`) VALUES
(1, 23, 'category', '1'),
(2, 23, 'template', '*none'),
(3, 23, 'sidebar', '*none'),
(4, 23, 'featured_image', '["","",""]'),
(5, 24, 'category', '1'),
(6, 24, 'template', '*none'),
(7, 24, 'sidebar', '*none'),
(8, 24, 'featured_image', '["","",""]'),
(10, 25, 'template', 'default'),
(11, 25, 'sidebar', 'left'),
(12, 25, 'featured_image', '["","",""]'),
(13, 25, 'category', '1'),
(15, 26, 'template', 'default'),
(16, 26, 'sidebar', 'left'),
(17, 26, 'featured_image', '["","",""]'),
(18, 26, 'category', '1'),
(19, 27, 'category', '1'),
(20, 27, 'template', 'default'),
(21, 27, 'sidebar', 'left'),
(22, 27, 'featured_image', '["","",""]');

-- --------------------------------------------------------

--
-- Table structure for table `objects`
--

CREATE TABLE IF NOT EXISTS `objects` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `author` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `content` longtext NOT NULL,
  `excerpt` longtext NOT NULL,
  `name` varchar(256) NOT NULL,
  `parent` int(11) NOT NULL,
  `status` varchar(16) NOT NULL DEFAULT 'punlished',
  `mimetype` varchar(16) NOT NULL,
  `type` varchar(16) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `objects`
--

INSERT INTO `objects` (`ID`, `author`, `title`, `content`, `excerpt`, `name`, `parent`, `status`, `mimetype`, `type`, `ts`, `modified_ts`) VALUES
(27, 1, 'Sample post 5', '', '', 'sample-post-5', 24, 'published', '', 'blog', '2015-04-25 10:00:57', '0000-00-00 00:00:00'),
(26, 1, 'Sample post 4', '', '', 'sample-post-4', 25, 'published', '', 'blog', '2015-04-25 10:00:39', '0000-00-00 00:00:00'),
(25, 1, 'Sample post 3', '', '', 'sample-post-3', 24, 'published', '', 'blog', '2015-04-25 10:00:24', '0000-00-00 00:00:00'),
(24, 1, 'Sample post 2', '', '', 'sample-post-2', 23, 'published', '', 'blog', '2015-04-25 10:00:12', '0000-00-00 00:00:00'),
(23, 1, 'Sample post 1', 'contents', '', 'sample-post-1', 0, 'published', '', 'blog', '2015-04-25 09:48:45', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_name` varchar(32) NOT NULL,
  `setting_value` longtext NOT NULL,
  `setting_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`setting_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`setting_id`, `setting_name`, `setting_value`, `setting_ts`) VALUES
(1, 'language', 'en-US', '2015-03-08 08:07:49'),
(36, 'media', '{"thumbnail":{"w":"150","h":"150","c":"1"},"small":{"w":"300","h":"250"},"medium":{"w":"400","h":"350"},"large":{"w":"700","h":"700"}}', '2015-03-22 08:52:34'),
(37, 'site_title', 'Test title', '2015-03-22 08:56:06'),
(38, 'site_description', 'Test desctiotion', '2015-03-22 08:58:37'),
(39, 'site_url', 'google.com', '2015-03-22 08:58:37'),
(40, 'site_email', 'hanig@hanif.com', '2015-03-22 08:58:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_username` varchar(32) NOT NULL,
  `user_password` varchar(256) NOT NULL,
  `user_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_username`, `user_password`, `user_ts`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', '2015-03-09 05:31:08');

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE IF NOT EXISTS `user_profiles` (
  `user_profile_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(128) NOT NULL,
  `user_display_name` varchar(128) NOT NULL,
  `user_email` varchar(128) NOT NULL,
  `user_image` varchar(128) NOT NULL,
  `user_role` int(11) NOT NULL,
  PRIMARY KEY (`user_profile_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user_profiles`
--

INSERT INTO `user_profiles` (`user_profile_id`, `user_id`, `user_name`, `user_display_name`, `user_email`, `user_image`, `user_role`) VALUES
(3, 1, 'Muhammd Hanif', 'Muhammad Hanif', 'hanif@imagiacian.com', 'image', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE IF NOT EXISTS `user_roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_title` varchar(32) NOT NULL,
  `role_description` varchar(250) NOT NULL,
  `role_object` longtext NOT NULL,
  `role_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`role_id`, `role_title`, `role_description`, `role_object`, `role_ts`) VALUES
(2, 'Administrator', 'This role has all the capabilities.', '{"Site":{"manage-pages":"1","create-pages":"1","publish-pages":"1","edit-pages":"1","delete-pages":"1","manage-themes":"1"},"Catalog":{"manage-catalog":"1","add-products":"1","edit-products":"1","delete-products":"1","manage-reviews":"1","manage-payment-methods":"1","manage-shipping-methods":"1","manage-orders":"1","edit-orders":"1","delete-orders":"1","manage-customers":"1"},"Users":{"manage-users":"1","create-users":"1","delete-users":"1","manage-roles":"1"},"Plugins":{"manage-plugins":"1"},"Settings":{"manage-settings":"1"},"blog":{"manage":"1","create":"1"},"services":{"manage":"1"}}', '2015-03-14 16:53:29'),
(3, 'Test', '', 'null', '2015-04-03 14:08:05');
