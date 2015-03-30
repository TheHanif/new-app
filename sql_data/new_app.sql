-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 30, 2015 at 07:16 PM
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `objects`
--

CREATE TABLE IF NOT EXISTS `objects` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(256) NOT NULL,
  `content` longtext NOT NULL,
  `excerpt` longtext NOT NULL,
  `name` varchar(256) NOT NULL,
  `mimetype` varchar(16) NOT NULL,
  `type` varchar(16) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`role_id`, `role_title`, `role_description`, `role_object`, `role_ts`) VALUES
(2, 'Administrator', 'This role has all the capabilities.', '{"Site":{"manage-pages":"1","create-pages":"1","publish-pages":"1","edit-pages":"1","delete-pages":"1","manage-themes":"1"},"Catalog":{"manage-catalog":"1","add-products":"1","edit-products":"1","delete-products":"1","manage-reviews":"1","manage-payment-methods":"1","manage-shipping-methods":"1","manage-orders":"1","edit-orders":"1","delete-orders":"1","manage-customers":"1"},"Users":{"manage-users":"1","create-users":"1","delete-users":"1","manage-roles":"1"},"Plugins":{"manage-plugins":"1"},"Settings":{"manage-settings":"1"},"blog":{"manage":"1","create":"1"},"services":{"manage":"1","create":"1"}}', '2015-03-14 16:53:29');
