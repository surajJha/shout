-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 16, 2015 at 07:55 PM
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
  PRIMARY KEY (`event_detail_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Dumping data for table `event_detail`
--

INSERT INTO `event_detail` (`event_detail_id`, `venue_name`, `event_name`, `event_overview`, `event_hashtags`, `event_location`, `event_area`, `event_cost`, `viewer_count`, `priority_count`, `category_name`, `event_organizer_id`, `approved`) VALUES
(1, 'asd', 'sdfs', 'sfs', 'asdf asd asd', 'asd', 'Goregaon', 0, 0, 0, 'Culture', 1, 0),
(2, 'q', 'qqqq', 'qqq', 'qq qqqq qqqqqq', 'q', 'Goregaon', 0, 0, 0, 'Culture', 1, 0),
(3, 'ghj', 'ujhjo', 'fghj', 'ghj ghj fghj', 'ghjk', 'Dadar', 500, 0, 0, 'Comedy', 1, 0),
(4, 'fghju', 'ghjkl', 'fghjk', 'fghjk ghjkl fghjk', 'hnjml,', 'Dadar', 50, 0, 0, 'Comedy', 1, 0),
(5, '', '', '', '  ', '', '', 0, 0, 0, '', 1, 0),
(6, '', '', '', '  ', '', '', 0, 0, 0, '', 1, 0),
(7, '', '', '', '  ', '', '', 0, 0, 0, '', 1, 0),
(8, 'asd', 'dsfas', 'asf', 'as as as', 'as', 'Andheri', 0, 0, 0, 'Comedy', 1, 0),
(9, '', '', '', '  ', '', '', 0, 0, 0, '', 1, 0),
(10, 'sdf', 'sdfs', 'sdf', 'sdf sdf sfd', 'sfd', 'Santacruz', 0, 0, 0, 'Culture', 1, 0),
(11, '', '', '', '  ', '', '', 0, 0, 0, '', 1, 0),
(12, 'asfas', 'sdfsf', 'sdfsdf', 'saf asf asf', 'afaf', 'Jogeshwari', 0, 0, 0, 'Culture', 2, 0);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Dumping data for table `event_image`
--

INSERT INTO `event_image` (`event_image_id`, `event_detail_id`, `event_image_name`, `primary_image`) VALUES
(1, 5, '/var/www/html/shout/server/client_images/1/rsz_screenshot_from_2014-12-22_174046.0.63414200 1421394839.jpg', 0),
(2, 5, '/var/www/html/shout/server/client_images/1/rsz_screenshot_from_2014-12-22_180830.0.63627600 1421394839.jpg', 1),
(3, 5, '/var/www/html/shout/server/client_images/1/rsz_screenshot_from_2014-12-22_174046.0.63911400 1421394839.jpg', 0),
(4, 4, '/var/www/html/shout/server/client_images/1/rsz_screenshot_from_2014-12-22_173354.0.83041600 1421395711.jpg', 1),
(5, 4, '/var/www/html/shout/server/client_images/1/rsz_screenshot_from_2014-12-22_174046.0.83094900 1421395711.jpg', 0),
(6, 4, '/var/www/html/shout/server/client_images/1/rsz_screenshot_from_2014-12-22_180830.0.83740100 1421395711.jpg', 0),
(7, 10, '/var/www/html/shout/server/client_images/1/download.0.61134300 1421407951.png', 1),
(8, 10, '/var/www/html/shout/server/client_images/1/713.0.61319500 1421407951.GIF', 0),
(9, 10, '/var/www/html/shout/server/client_images/1/rsz_screenshot_from_2014-12-22_173354.0.61678900 1421407951.jpg', 0),
(10, 12, '/var/www/html/shout/server/client_images/1/rsz_screenshot_from_2014-12-22_180830.0.67139500 1421408315.jpg', 1),
(11, 12, '/var/www/html/shout/server/client_images/1/download.0.67523900 1421408315.png', 0),
(12, 12, '/var/www/html/shout/server/client_images/1/rsz_screenshot_from_2014-12-22_173354.0.67417500 1421408315.jpg', 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `event_schedule`
--

INSERT INTO `event_schedule` (`event_schedule_id`, `event_detail_id`, `event_date`, `event_start_time`, `event_end_time`) VALUES
(1, 0, '2015-01-23', '00:00:00', '00:00:00'),
(2, 0, '2015-01-29', '00:00:00', '00:00:00'),
(3, 5, '2015-01-22', '00:00:00', '00:00:00'),
(4, 5, '2015-01-29', '00:00:00', '00:00:00'),
(5, 5, '2015-01-19', '00:00:00', '00:00:00'),
(6, 7, '2015-01-23', '00:00:00', '00:00:00'),
(7, 7, '2015-01-20', '00:00:00', '00:00:00'),
(8, 4, '2015-01-16', '00:00:00', '00:00:00'),
(9, 4, '2015-01-23', '00:00:00', '00:00:00'),
(10, 8, '2015-01-22', '00:00:00', '00:00:00'),
(11, 10, '2015-01-29', '00:00:00', '00:00:00'),
(12, 12, '2015-01-08', '00:00:00', '00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `hashtag`
--

CREATE TABLE IF NOT EXISTS `hashtag` (
  `hashtag_id` int(11) NOT NULL AUTO_INCREMENT,
  `hashtag_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `hashtag_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`hashtag_id`),
  UNIQUE KEY `hashtag_name` (`hashtag_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- Dumping data for table `hashtag`
--

INSERT INTO `hashtag` (`hashtag_id`, `hashtag_name`, `hashtag_count`) VALUES
(1, 'asdf', 0),
(2, 'asd', 1),
(3, 'qq', 0),
(4, 'qqqq', 0),
(5, 'qqqqqq', 0),
(6, 'ghj', 1),
(7, 'fghj', 0),
(8, 'fghjk', 1),
(9, 'ghjkl', 0),
(10, '', 1),
(11, 'as', 1),
(12, 'sdf', 1),
(13, 'sfd', 0),
(14, 'saf', 0),
(15, 'asf', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
