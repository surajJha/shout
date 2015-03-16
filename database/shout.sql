-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 03, 2015 at 12:41 PM
-- Server version: 5.5.40-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `shout`
--

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

CREATE TABLE IF NOT EXISTS `area` (
  `area_id` int(11) NOT NULL AUTO_INCREMENT,
  `area_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`area_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=24 ;

--
-- Dumping data for table `area`
--

INSERT INTO `area` (`area_id`, `area_name`) VALUES
(1, 'Malad'),
(2, 'Goregaon'),
(3, 'Jogeshwari'),
(4, 'Andheri'),
(5, 'Vile Parle'),
(6, 'Santacruz'),
(7, 'Khar'),
(8, 'Bandra'),
(9, 'Mahim'),
(10, 'Matunga'),
(11, 'Dadar'),
(12, 'Elphinstone'),
(13, 'Lower Parel'),
(14, 'Mahalakshmi'),
(15, 'Mumbai Central'),
(16, 'Grant Road'),
(17, 'Charni Road'),
(18, 'Marine Lines'),
(19, 'Churchgate'),
(20, 'Kandivali'),
(21, 'Oshiwara'),
(22, 'Versova'),
(23, 'Juhu');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, 'Comedy'),
(2, 'Culture'),
(3, 'Food + Drinks'),
(4, 'Music'),
(5, 'Nightlife'),
(6, 'Sports'),
(7, 'Theatre');

-- --------------------------------------------------------

--
-- Table structure for table `event_detail`
--

CREATE TABLE IF NOT EXISTS `event_detail` (
  `event_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `venue_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `event_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `event_overview` text COLLATE utf8_unicode_ci NOT NULL,
  `event_hashtags` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_location` text COLLATE utf8_unicode_ci NOT NULL,
  `event_area` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `event_cost` int(11) NOT NULL,
  `viewer_count` int(11) NOT NULL DEFAULT '0',
  `priority_count` int(11) NOT NULL DEFAULT '0',
  `category_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `event_organizer_id` int(11) NOT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`event_detail_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=18 ;

--
-- Dumping data for table `event_detail`
--

INSERT INTO `event_detail` (`event_detail_id`, `venue_name`, `event_name`, `event_overview`, `event_hashtags`, `event_location`, `event_area`, `event_cost`, `viewer_count`, `priority_count`, `category_name`, `event_organizer_id`, `approved`, `is_active`) VALUES
(15, 'fghjkl', 'testing', 'dfghjkl;''', 'fghjkl gthjkl; ghjkl;', 'fghjkl', 'Dadar', 12345, 0, 0, 'Comedy', 1, 0, 1),
(16, 'ertyuiop', 'testing', 'ertyu', 'qwerty  ', 'ertyu', 'Andheri', 411, 0, 0, 'Comedy', 1, 0, 1),
(17, 'andheri', 'final testing', 'wedfgh', 'qwerty  ', 'andheri', 'Andheri', 1234, 0, 0, 'Culture', 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `event_image`
--

CREATE TABLE IF NOT EXISTS `event_image` (
  `event_image_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_detail_id` int(11) NOT NULL,
  `event_image_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `primary_image` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`event_image_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=19 ;

--
-- Dumping data for table `event_image`
--

INSERT INTO `event_image` (`event_image_id`, `event_detail_id`, `event_image_name`, `primary_image`) VALUES
(1, 4, '/var/www/html/shout/server/client_images/1/download.0.69788800 1421330789.png', 0),
(2, 4, '/var/www/html/shout/server/client_images/1/rsz_screenshot_from_2014-12-22_173354.0.70302200 1421330789.jpg', 1),
(3, 4, '/var/www/html/shout/server/client_images/1/rsz_screenshot_from_2014-12-22_180830.0.71521000 1421330789.jpg', 0),
(4, 5, '/var/www/html/shout/server/client_images/1/download.0.95761500 1421331164.png', 0),
(5, 5, '/var/www/html/shout/server/client_images/1/rsz_screenshot_from_2014-12-22_173354.0.96686000 1421331164.jpg', 0),
(6, 5, '/var/www/html/shout/server/client_images/1/rsz_screenshot_from_2014-12-22_180830.0.96686200 1421331164.jpg', 1),
(7, 13, '/var/www/html/shout/server/client_images/1/mockup_AdTag_Admin.0.83411400 1421763505.png', 0),
(8, 13, '/var/www/html/shout/server/client_images/1/mockup_1.0.83592200 1421763505.png', 1),
(9, 13, '/var/www/html/shout/server/client_images/1/Angular.0.83394400 1421763505.png', 0),
(10, 15, '/var/www/html/shout/server/client_images/1/Angular.0.75520800 1421986885.png', 1),
(11, 15, '/var/www/html/shout/server/client_images/1/mockup_AdTag_Admin.0.75988400 1421986885.png', 0),
(12, 15, '/var/www/html/shout/server/client_images/1/mockup_1.0.76073700 1421986885.png', 0),
(13, 16, '/var/www/html/shout/server/client_images/1/Angular.0.78638900 1422356352.png', 1),
(14, 16, '/var/www/html/shout/server/client_images/1/new.0.68501200 1422356302.jpg', 0),
(15, 16, '/var/www/html/shout/server/client_images/1/mockup_1.0.42970200 1422336981.png', 0),
(16, 17, '/var/www/html/shout/server/client_images/1/Angular.0.87174500 1422426051.png', 1),
(17, 17, '/var/www/html/shout/server/client_images/1/mockup_1.0.16293900 1422427375.png', 0),
(18, 17, '/var/www/html/shout/server/client_images/1/mockup_AdTag_Admin.0.87247800 1422426051.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `event_organizer`
--

CREATE TABLE IF NOT EXISTS `event_organizer` (
  `event_organizer_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_organizer_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `event_organizer_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `event_organizer_password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `event_organizer_phone` int(11) NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`event_organizer_id`),
  UNIQUE KEY `event_organizer_email` (`event_organizer_email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `event_organizer`
--

INSERT INTO `event_organizer` (`event_organizer_id`, `event_organizer_name`, `event_organizer_email`, `event_organizer_password`, `event_organizer_phone`, `verified`) VALUES
(1, 'Arun', 'arun@gmail.com', '123456', 1234567890, 1),
(2, 'Rishabh', 'rishabh@gmail.com', '123456', 1234567890, 1),
(3, 'Vishal', 'vishal@gmail.com', '123456', 1234567890, 1);

-- --------------------------------------------------------

--
-- Table structure for table `event_schedule`
--

CREATE TABLE IF NOT EXISTS `event_schedule` (
  `event_schedule_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_detail_id` int(11) NOT NULL,
  `event_date` date NOT NULL,
  `event_start_time` time NOT NULL,
  `event_end_time` time DEFAULT NULL,
  PRIMARY KEY (`event_schedule_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `event_schedule`
--

INSERT INTO `event_schedule` (`event_schedule_id`, `event_detail_id`, `event_date`, `event_start_time`, `event_end_time`) VALUES
(1, 1, '2015-01-16', '03:34:00', '03:34:00'),
(2, 1, '2015-02-16', '03:34:00', '03:34:00'),
(3, 1, '2015-01-19', '03:34:00', '03:34:00'),
(4, 1, '2015-02-19', '03:34:00', '03:34:00'),
(5, 2, '2015-01-20', '03:36:00', '03:36:00'),
(6, 2, '2015-01-27', '03:36:00', '03:36:00'),
(7, 2, '2015-02-03', '03:36:00', '03:36:00'),
(8, 2, '2015-02-10', '03:36:00', '03:36:00'),
(9, 2, '2015-02-17', '03:36:00', '03:36:00'),
(10, 4, '2015-01-05', '03:42:00', '03:42:00'),
(11, 4, '2015-01-09', '07:36:00', '07:36:00'),
(12, 5, '2015-01-23', '00:00:00', '00:00:00'),
(13, 7, '2015-01-28', '16:15:00', '00:00:00'),
(14, 9, '2015-01-21', '20:45:00', '20:00:00'),
(15, 11, '2015-01-21', '20:45:00', '20:00:00'),
(16, 11, '2015-01-21', '20:45:00', '20:00:00'),
(17, 13, '2015-01-22', '05:30:00', '19:48:00'),
(18, 15, '2015-01-28', '05:30:00', '09:51:00'),
(19, 16, '2015-01-29', '05:30:00', '11:06:00'),
(20, 17, '2015-01-30', '05:30:00', '11:50:00'),
(21, 17, '2015-01-29', '05:30:00', '11:50:00');

-- --------------------------------------------------------

--
-- Table structure for table `hashtag`
--

CREATE TABLE IF NOT EXISTS `hashtag` (
  `hashtag_id` int(11) NOT NULL AUTO_INCREMENT,
  `hashtag_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `hashtag_count` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`hashtag_id`),
  UNIQUE KEY `hashtag_name` (`hashtag_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=20 ;

--
-- Dumping data for table `hashtag`
--

INSERT INTO `hashtag` (`hashtag_id`, `hashtag_name`, `hashtag_count`) VALUES
(1, 'music', 1),
(2, 'karaoke', 1),
(3, 'newyears', 1),
(4, 'party', 2),
(5, 'hot', 1),
(6, 'drinks', 1),
(7, '', 1),
(8, 'oghjkl', 1),
(9, 'fghjkfghjk', 1),
(10, 'ghjkl;''', 1),
(11, 'vbn', 2),
(12, 'fghj', 2),
(13, 'ghj', 1),
(14, 'fvgbnjh', 1),
(15, 'dfghj', 1),
(16, 'fghjkl', 1),
(17, 'gthjkl;', 1),
(18, 'ghjkl;', 1),
(19, 'qwerty', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
