-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 10, 2015 at 09:33 PM
-- Server version: 5.5.20
-- PHP Version: 5.3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `category_slug`, `category_description`, `category_media`, `category_parent`, `category_item_count`, `category_order`, `category_type`, `category_ts`) VALUES
(12, 'Category 1', 'category-1-2', '', 0, 0, NULL, 0, 'services', '2015-04-03 08:35:03'),
(26, 'Sample category 4', 'sample-category-4', '', 0, 24, NULL, 0, 'blog', '2015-04-06 18:42:52'),
(25, 'Sample category 3', 'sample-category-3', '', 0, 0, NULL, 0, 'blog', '2015-04-06 18:42:41'),
(17, 'ferqr3232', 'ferqr3232', '', 0, 15, NULL, 0, 'blog', '2015-04-03 12:40:06'),
(24, 'Sample category 2', 'sample-category-2', '', 0, 23, NULL, 0, 'blog', '2015-04-06 18:42:31'),
(23, 'Sample category 1', 'sample-category-1', '', 0, 0, NULL, 0, 'blog', '2015-04-06 18:42:21'),
(27, 'Sample category 5', 'sample-category-5', '', 0, 0, NULL, 0, 'blog', '2015-04-06 18:42:59'),
(28, 'Sample category 6', 'sample-category-6', '', 0, 23, NULL, 0, 'blog', '2015-04-06 18:43:45'),
(29, 'Sample category 7', 'sample-category-7', '', 0, 0, NULL, 0, 'blog', '2015-04-06 18:44:51'),
(30, 'Sample category 8', 'sample-category-8', '', 0, 0, NULL, 0, 'blog', '2015-04-06 18:44:56');

-- --------------------------------------------------------

--
-- Table structure for table `meta`
--

CREATE TABLE IF NOT EXISTS `meta` (
  `meta_id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` int(11) NOT NULL,
  `key` varchar(100) NOT NULL,
  `value` longtext NOT NULL,
  PRIMARY KEY (`meta_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `objects`
--

CREATE TABLE IF NOT EXISTS `objects` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `authod` int(11) NOT NULL,
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=80 ;

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
(2, 'Administrator', 'This role has all the capabilities.', '{"Site":{"manage-pages":"1","create-pages":"1","publish-pages":"1","edit-pages":"1","delete-pages":"1","manage-themes":"1"},"Catalog":{"manage-catalog":"1","add-products":"1","edit-products":"1","delete-products":"1","manage-reviews":"1","manage-payment-methods":"1","manage-shipping-methods":"1","manage-orders":"1","edit-orders":"1","delete-orders":"1","manage-customers":"1"},"Users":{"manage-users":"1","create-users":"1","delete-users":"1","manage-roles":"1"},"Plugins":{"manage-plugins":"1"},"Settings":{"manage-settings":"1"},"blog":{"manage":"1","create":"1"},"services":{"manage":"1","create":"1"}}', '2015-03-14 16:53:29'),
(3, 'Test', '', 'null', '2015-04-03 14:08:05');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
